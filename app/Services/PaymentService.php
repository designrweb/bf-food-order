<?php
namespace App\Services;

use App\Http\Resources\PaymentCollection;
use App\Http\Resources\PaymentResource;
use App\Order;
use App\Repositories\PaymentRepository;
use App\SubsidizedMenuCategories;
use bigfood\grid\BaseModelService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Payment;


class PaymentService extends BaseModelService
{

    protected $repository;
    private $orderService;

    public function __construct(PaymentRepository $repository, OrderService $orderService)
    {
        $this->repository = $repository;
        $this->orderService = $orderService;
    }

    /**
     * Returns all payments transformed to resource
     *
     * @return PaymentCollection
     */
    public function all(): PaymentCollection
    {
         return $this->repository->all();
    }

    /**
     * Returns single product transformed to resource
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
     * Creates and returns the payments model
     *
     * @param $data
     * @return PaymentResource
     */
    public function create($data): PaymentResource
    {
        return $this->repository->add($data);
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
                'key' => 'consumer.user.email',
                'label' => ucwords('user email')
            ],
            [
                'key' => 'amount',
                'label' => ucwords('amount')
            ],
            [
                'key' => 'comment',
                'label' => ucwords('comment')
            ],
            [
                'key' => 'created_at',
                'label' => ucwords('created at')
            ],
        ];
    }

    public function createPaymentBasedOnOrder(Order $order)
    {

        $r = $order;
        //special workaround to prevent payment with zero quantity for created orders
        // @TODO: check if it possible to create an order with zero quantity
        if ($order->quantity == 0) return;

        switch ($order->type) {
            case Order::TYPE_PRE_ORDER:
                $amount = $order->menuItem->menuCategory->presaleprice * $order->quantity;
                break;
            case Order::TYPE_POS_ORDER:
                $amount = $order->menuItem->menuCategory->price * $order->quantity;
                break;
            case Order::TYPE_VOUCHER_ORDER:
                $amount = 0;
                break;
            default:
                throw new HttpException(403, 'It was not possible to change the balance! Please check.');
        }
        $paymentMessage = sprintf('Order %s (Quantity: %s)', $order->menuItem->name, $order->quantity);

        $canBeSubsidized      = $this->canBeSubsidized($order, $order->getOriginal('quantity')) && $amount != 0;
        $payment              = new Payment;
        $payment->consumer_id = $order->consumer_id;

        switch ($order->type):
            case Order::TYPE_PRE_ORDER:
                $payment->type = $canBeSubsidized
                    ? ($amount < 0 ? Payment::TYPE_PRE_ORDER_SUBSIDIZED_CANCELLATION : Payment::TYPE_PRE_ORDER_SUBSIDIZED)
                    : ($amount < 0 ? Payment::TYPE_PRE_ORDER_CANCELLATION : Payment::TYPE_PRE_ORDER);
                break;
            case Order::TYPE_POS_ORDER:
                $payment->type = $canBeSubsidized
                    ? ($amount < 0 ? Payment::TYPE_POS_ORDER_SUBSIDIZED_REFUND : Payment::TYPE_POS_ORDER_SUBSIDIZED)
                    : Payment::TYPE_POS_ORDER;
                break;
            default:
                $payment->type = Payment::TYPE_VOUCHER;
        endswitch;

        $payment->order_id = $order->id;
        $payment->amount   = -$amount;
        $payment->comment  = $paymentMessage;

        if (!$payment->save()) {
            throw new HttpException(404, 'It was not possible to save the payment after the Order.');
        }

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
    protected function canBeSubsidized(Order $order, $oldQuantityValue): bool
    {
        // create a reverse order (should be available only for 1 item)
        $isFirstItem = $order->quantity == 1 && ($oldQuantityValue == null || $oldQuantityValue == 0);

        $ordersWithSubsidizationCount = $this->orderService->countOrdersWithSubsidization($order);
//        $ordersWithSubsidizationCount = Order::find()
//            ->where(['consumer_id' => $order->consumer_id])
//            ->andWhere(['day' => $order->day])
//            ->andWhere(['is_subsidized' => Order::IS_SUBSIDIZED])
//            ->andWhere(['NOT', ['foodorder_id' => $order->foodorder_id]])
//            ->andWhere(['deleted_at' => null])
//            ->count();

        if($order->type === Order::TYPE_POS_ORDER) {
            if(isset($order->is_subsidized) && $order->is_subsidized) {
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
     * @param Payment   $payment
     * @param Order $order
     */
    protected function createReversePayment(Payment $payment, Order $order)
    {

        // clone object
        // $reversePayment = new Payment();
        // $reversePayment->setAttributes($payment->attributes);
        $reversePayment = $payment->replicate();

        $r = $payment->consumer->subsidizationRule;

        $subsidizedMenuCategory = SubsidizedMenuCategories::where('subsidization_rule_id', $r->id)
            ->where('menu_category_id', $order->menuItem->menuCategory->id)
            ->first();

//        $subsidizedMenuCategory = SubsidizedMenuCategories::find()
//            ->select('percent')
//            ->andWhere(['subsidization_rule_id' => $r->id])
//            ->andWhere(['menu_category_id' => $order->menuCategory->id])
//            ->one();

        $reversePayment->amount   = $payment->amount * $subsidizedMenuCategory->percent / -100;

        if($order->isPosOrder()) {
            $reversePayment->amount   = ($payment->amount / $order->quantity) * $subsidizedMenuCategory->percent / -100;
        }
        $reversePayment->comment  = sprintf('Subsidization “%s”', $order->menuItem->name);
        $reversePayment->order_id = $order->id;
        $reversePayment->type     = $order->type == Order::TYPE_PRE_ORDER
            ? ($payment->type == Payment::TYPE_PRE_ORDER_SUBSIDIZED_CANCELLATION
                ? Payment::TYPE_PRE_ORDER_SUBSIDIZED_CANCELLATION_REFUND
                : Payment::TYPE_PRE_ORDER_SUBSIDIZED_REFUND)
            : Payment::TYPE_POS_ORDER_SUBSIDIZED_REFUND;

        $reversePayment->save();
//        TempHelper::savePaymentJson($order, $reversePayment);

        return;
    }
}
