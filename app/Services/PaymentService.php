<?php

namespace App\Services;

use App\Exceptions\WrongOrderTypeException;
use App\Order;
use App\Repositories\PaymentRepository;
use bigfood\grid\BaseModelService;
use Illuminate\Database\Eloquent\Model;
use App\Payment;
use Illuminate\Support\Facades\DB;

class PaymentService extends BaseModelService
{
    /** @var PaymentRepository */
    protected $repository;

    /** @var SubsidizedMenuCategoriesService */
    private $subsidizedMenuCategoriesService;

    /** @var ConsumerService */
    private $consumerService;

    /**
     * PaymentService constructor.
     *
     * @param PaymentRepository               $repository
     * @param SubsidizedMenuCategoriesService $subsidizedMenuCategoriesService
     * @param ConsumerService                 $consumerService
     */
    public function __construct(
        PaymentRepository $repository,
        SubsidizedMenuCategoriesService $subsidizedMenuCategoriesService,
        ConsumerService $consumerService
    )
    {
        $this->repository                      = $repository;
        $this->consumerService                 = $consumerService;
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
     * @param $id
     * @return mixed
     */
    public function getOne($id)
    {
        return $this->repository->get($id);
    }

    /**
     * Creates and returns the payments model. Updates consumer balance
     *
     * @param $data
     * @return false|mixed
     * @throws \Throwable
     */
    public function create($data)
    {
        DB::beginTransaction();
        try {
            $payment = $this->repository->add($data);

            $consumer = $payment->consumer;

            if ($consumer) {
                $consumer->balance += $payment->amount;
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
     * @param $data
     * @param $id
     * @return mixed
     */
    public function update($data, $id)
    {
        DB::beginTransaction();
        try {
            $data['amount'] = str_replace(',', '.', $data['amount_locale']);

            //current state
            $paymentData = $this->repository->get($id);

            //updated state
            $payment = $this->repository->update($data, $id);

            if ($data['consumer_id'] !== $paymentData->consumer->id) {
                //subtract amount for new consumer
                $consumer = $payment->consumer;

                if (!empty($consumer)) {
                    $consumer->balance += $payment->amount;
                    $consumer->update();
                }


                //return amount for previous consumer
                $oldConsumer = $paymentData->consumer;

                if (!empty($oldConsumer)) {
                    $oldConsumer->balance -= $payment->amount;
                    $oldConsumer->update();
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }

        return $payment;
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
     * Creates payment for meal order
     *
     * @param Order $order
     * @param Order $originalOrder
     */
    public function createPaymentBasedOnOrder(Order $order, Order $originalOrder)
    {
        $orderQuantity = $order->quantity;
        $orderType     = $order->type;

        //special workaround to prevent payment with zero quantity for created orders
        // @TODO: check if it possible to create an order with zero quantity
        if ($orderQuantity == 0) return;

        $amount = $this->getPaymentAmount($orderType, $order->menuItem->menuCategory->price, $order->menuItem->menuCategory->presaleprice, $orderQuantity);

        $paymentMessage = sprintf('Bestellen %s (Menge: %s)', $order->menuItem->name, $orderQuantity);

        $canBeSubsidized = $this->canBeSubsidized($order, $originalOrder->quantity) && $amount != 0;

        $payment              = new Payment;
        $payment->consumer_id = $order->consumer_id;
        $payment->type        = $this->getPaymentType($orderType, $amount, $canBeSubsidized);
        $payment->order_id    = $order->id;
        $payment->amount      = -$amount;
        $payment->comment     = $paymentMessage;
        $payment->save();

        $consumer = $payment->consumer;

        if ($consumer) {
            $consumer->balance -= $amount;
            $consumer->save();
        }

        if ($canBeSubsidized) {
            $this->createReversePayment($payment, $order);
        }
    }

    /**
     * Creates payment for meal order
     *
     * @param Order $order
     * @param Order $originalOrder
     */
    public function createPaymentBasedOnQuantity(Order $order, Order $originalOrder)
    {
        $orderQuantity = $order->quantity - $originalOrder->quantity;
        $orderType     = $order->type;

        //special workaround to prevent payment with zero quantity for created orders
        // @TODO: check if it possible to create an order with zero quantity
        if ($orderQuantity == 0) return;

        $amount = $this->getPaymentAmount($orderType, $order->menuItem->menuCategory->price, $order->menuItem->menuCategory->presaleprice, $orderQuantity);

        $paymentMessage = sprintf('Bestellen %s (Menge: %s)', $order->menuItem->name, $orderQuantity);

        $canBeSubsidized = $this->canBeSubsidized($order, $originalOrder->quantity) && $amount != 0;

        $payment = $this->repository->add([
            'consumer_id' => $order->consumer_id,
            'type'        => $this->getPaymentType($orderType, $amount, $canBeSubsidized),
            'order_id'    => $order->id,
            'amount'      => -$amount,
            'comment'     => $paymentMessage
        ]);

        $consumer = $payment->consumer;

        if ($consumer) {
            $consumer->balance -= $amount;
            $consumer->save();
        }

        if ($canBeSubsidized) {
            $this->createReversePayment($payment, $order);
        }
    }

    /**
     * Creates payment for meal order
     *
     * @param Order $order
     */
    public function createCanceledPaymentBasedOnOrder(Order $order)
    {
        $orderQuantity = $order->quantity;

        $amount = $order->menuItem->menuCategory->presaleprice * $orderQuantity;
        $paymentMessage = sprintf('Abgebrochen "%s"', $order->menuItem->name);

        $payment = $this->repository->add([
            'consumer_id' => $order->consumer_id,
            'type'        => $order->is_subsidized ? Payment::TYPE_PRE_ORDER_SUBSIDIZED_CANCELLATION : Payment::TYPE_PRE_ORDER_CANCELLATION,
            'order_id'    => $order->id,
            'amount'      => $amount,
            'comment'     => $paymentMessage
        ]);

        $consumer = $payment->consumer;

        if ($consumer) {
            $consumer = $consumer->fresh();
            $consumer->balance += $amount;
            $consumer->save();
        }

        if ($order->is_subsidized == Order::IS_SUBSIDIZED && $amount != 0) {
            // special workaround to create a reverse payment for 1 item
            $payment->amount = $order->menuItem->menuCategory->presaleprice;
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

        $ordersWithSubsidizationCount = $this->repository->countOrdersWithSubsidizationByDateForConsumer($order);

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
        $amount = $this->getReversePaymentAmount($order->quantity, $payment->amount, $subsidizedMenuCategory->percent, $order->type);

        $reversePayment           = $payment->replicate();
        $reversePayment->amount   = $amount;
        $reversePayment->comment  = sprintf('Subventionierung “%s”', $order->menuItem->name);
        $reversePayment->order_id = $order->id;
        $reversePayment->type     = $this->getReversePaymentType($order->type, $payment->type);
        $reversePayment->save();

        if ($order->consumer) {
            $consumer = $order->consumer->fresh();
            $consumer->balance += $amount;
            $consumer->save();
        }

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
     * @param $orderType
     * @return float|int
     */
    // todo make this function protected
    public function getReversePaymentAmount($orderQuantity, $paymentAmount, $percent, $orderType)
    {
        switch ($orderType) {
            case Order::TYPE_PRE_ORDER:
                $amount = $paymentAmount * $percent / -100;
                break;
            case Order::TYPE_POS_ORDER:
                $amount = ($paymentAmount / $orderQuantity) * $percent / -100;
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
     * @param float $price
     * @param float $preSalePrice
     * @param int   $quantity
     * @return float|int
     */
    // todo make this function protected
    public function getPaymentAmount(int $orderType, float $price, float $preSalePrice, int $quantity)
    {
        switch ($orderType) {
            case Order::TYPE_PRE_ORDER:
                $amount = $preSalePrice * $quantity;
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
