<?php

namespace App\Services;

use App\Exceptions\WrongOrderTypeException;
use App\Http\Resources\PaymentResource;
use App\Order;
use App\Repositories\PaymentRepository;
use bigfood\grid\BaseModelService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Payment;
use Illuminate\Support\Facades\DB;


class PaymentService extends BaseModelService
{

    protected $repository;
    private   $orderService;
    /**
     * @var SubsidizedMenuCategoriesService
     */
    private $subsidizedMenuCategoriesService;

    /**
     * PaymentService constructor.
     *
     * @param PaymentRepository               $repository
     * @param OrderService                    $orderService
     * @param SubsidizedMenuCategoriesService $subsidizedMenuCategoriesService
     */
    public function __construct(PaymentRepository $repository, OrderService $orderService, SubsidizedMenuCategoriesService $subsidizedMenuCategoriesService)
    {
        $this->repository                      = $repository;
        $this->orderService                    = $orderService;
        $this->subsidizedMenuCategoriesService = $subsidizedMenuCategoriesService;
    }


    /**
     * Returns all payments
     *
     * @return mixed
     */
    public function all()
    {
        return $this->repository->all();
    }

    /**
     * Returns single product
     *
     * @param $id
     * @return PaymentResource
     * @throws ModelNotFoundException
     */
    public function getOne($id): PaymentResource
    {
        return $this->repository->get($id);
    }

    /**
     * Creates and returns the payments model. Updates consumer balance
     *
     * @param $data
     */
    public function create($data)
    {
        DB::beginTransaction();
        try {
            $payment = $this->repository->add($data);

            $consumer = $payment->consumer;
            if ($consumer) {
                $consumer->balance -= $payment->amount;
                $consumer->save();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }

        return $payment;
    }

    /**
     * Updates and returns the payments model
     *
     * @param $data
     * @param $id
     * @return PaymentResource
     * @throws ModelNotFoundException
     */
    public function update($data, $id): PaymentResource
    {
        return $this->repository->update($data, $id);
    }

    /**
     * @param $id
     * @return bool
     */
    public function remove($id): bool
    {
        return $this->repository->delete($id);
    }

    /**
     * @return array
     */
    public function getIndexStructure(): array
    {
        return $this->getFullStructure((new Payment()));
    }

    /**
     * @return array
     */
    public function getViewStructure(): array
    {
        return $this->getSimpleStructure((new Payment()));
    }

    /**
     * @param Model $model
     * @return array[]
     */
    protected function getFieldsLabels(Model $model): array
    {
        return [
            [
                'key'   => 'consumer.user.email',
                'label' => ucwords('user email')
            ],
            [
                'key'   => 'amount',
                'label' => ucwords('amount')
            ],
            [
                'key'   => 'comment',
                'label' => ucwords('comment')
            ],
            [
                'key'   => 'created_at',
                'label' => ucwords('created at')
            ],
        ];
    }

    public function createPaymentBasedOnOrder(Order $order)
    {
        $orderQuantity = $order->quantity;
        $orderType     = $order->type;

        //special workaround to prevent payment with zero quantity for created orders
        // @TODO: check if it possible to create an order with zero quantity
        if ($orderQuantity == 0) return;

        $amount = $this->getPaymentAmount($orderType, $order->menuItem->menuCategory->price, $order->menuItem->menuCategory->presaleprice, $orderQuantity);

        $paymentMessage = sprintf('Order %s (Quantity: %s)', $order->menuItem->name, $orderQuantity);

        $canBeSubsidized = $this->canBeSubsidized($order, $order->getOriginal('quantity')) && $amount != 0;

        $payment              = new Payment;
        $payment->consumer_id = $order->consumer_id;
        $payment->type        = $this->getPaymentType($orderType, $amount, $canBeSubsidized);
        $payment->order_id    = $order->id;
        $payment->amount      = -$amount;
        $payment->comment     = $paymentMessage;
        $payment->save();

        // TODO: remove this logging after DB refactoring
        // TempHelper::savePaymentJson($this, $payment);

        if ($canBeSubsidized) {
            $this->createReversePayment($payment, $order);
        }
    }

    /**
     * Check if current order can be subsidized
     *
     * @param Order $order
     * @param       $oldQuantityValue
     * @return bool
     */
    // todo make this function protected
    public function canBeSubsidized(Order $order, $oldQuantityValue): bool
    {
        // create a reverse order (should be available only for 1 item)
        $isFirstItem = $order->quantity == 1 && ($oldQuantityValue == null || $oldQuantityValue == 0);

        $ordersWithSubsidizationCount = $this->orderService->countOrdersWithSubsidization($order);

        if ($order->type === Order::TYPE_POS_ORDER) {
            if (isset($order->is_subsidized) && $order->is_subsidized) {
                $isFirstItem = true;
            } else {
                $isFirstItem = false;
            }
        }

        return $ordersWithSubsidizationCount == 0
            && $isFirstItem
            && $order->consumer
            && $order->consumer->isSubsidized($order->day)
            && $order->menuCategory->isAllowSubsidization($order->consumer);
    }

    /**
     * Create a reverse order for consumers with subsidization
     *
     * @param Payment $payment
     * @param Order   $order
     */
    // todo make this function protected
    public function createReversePayment(Payment $payment, Order $order)
    {
        $subsidizationRule = $payment->consumer->subsidization->subsidizationRule;

        $subsidizedMenuCategory = $this->subsidizedMenuCategoriesService->getMenuCategoryWithSubsidization($order->menuItem->menuCategory->id, $subsidizationRule->id);

        $reversePayment           = $payment->replicate();
        $reversePayment->amount   = $this->getReversePaymentAmount($order->quantity, $payment->amount, $subsidizedMenuCategory->percent);
        $reversePayment->comment  = sprintf('Subsidization “%s”', $order->menuItem->name);
        $reversePayment->order_id = $order->id;
        $reversePayment->type     = $this->getReversePaymentType($order->type, $payment->type);
        $reversePayment->save();

        // todo do we need this?
        // TempHelper::savePaymentJson($order, $reversePayment);
    }


    /**
     * Returns type for reverse payment
     *
     * @param $orderType
     * @param $paymentType
     * @return int
     */
    // todo make this function protected
    public function getReversePaymentType($orderType, $paymentType): int
    {
        return $orderType == Order::TYPE_PRE_ORDER
            ? ($paymentType == Payment::TYPE_PRE_ORDER_SUBSIDIZED_CANCELLATION
                ? Payment::TYPE_PRE_ORDER_SUBSIDIZED_CANCELLATION_REFUND
                : Payment::TYPE_PRE_ORDER_SUBSIDIZED_REFUND)
            : Payment::TYPE_POS_ORDER_SUBSIDIZED_REFUND;
    }


    /**
     * @param $orderQuantity
     * @param $paymentAmount
     * @param $percent
     * @return float|int
     */
    // todo make this function protected
    public function getReversePaymentAmount($orderQuantity, $paymentAmount, $percent)
    {
        return ($paymentAmount / $orderQuantity) * $percent / -100;
    }

    /**
     * @param int   $orderType
     * @param float $price
     * @param float $presaleprice
     * @param int   $quantity
     * @return float|int
     */
    // todo make this function protected
    public function getPaymentAmount(int $orderType, float $price, float $presaleprice, int $quantity)
    {
        switch ($orderType) {
            case Order::TYPE_PRE_ORDER:
                $amount = $presaleprice * $quantity;
                break;
            case Order::TYPE_POS_ORDER:
                $amount = $price * $quantity;
                break;
            case Order::TYPE_VOUCHER_ORDER:
                $amount = 0;
                break;
            default:
                throw new WrongOrderTypeException('It was not possible to change the balance! Please check order type.');
        }

        return $amount;
    }

    /**
     * @param int   $orderType
     * @param float $amount
     * @param bool  $canBeSubsidized
     * @return int
     */
    // todo make this function protected
    public function getPaymentType(int $orderType, float $amount, bool $canBeSubsidized): int
    {
        switch ($orderType) {
            case Order::TYPE_PRE_ORDER:
                $paymentType = $canBeSubsidized
                    ? ($amount < 0 ? Payment::TYPE_PRE_ORDER_SUBSIDIZED_CANCELLATION : Payment::TYPE_PRE_ORDER_SUBSIDIZED)
                    : ($amount < 0 ? Payment::TYPE_PRE_ORDER_CANCELLATION : Payment::TYPE_PRE_ORDER);
                break;
            case Order::TYPE_POS_ORDER:
                $paymentType = $canBeSubsidized
                    ? ($amount < 0 ? Payment::TYPE_POS_ORDER_SUBSIDIZED_REFUND : Payment::TYPE_POS_ORDER_SUBSIDIZED)
                    : Payment::TYPE_POS_ORDER;
                break;
            default:
                $paymentType = Payment::TYPE_VOUCHER;
        }

        return $paymentType;
    }
}
