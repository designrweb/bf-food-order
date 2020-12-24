<?php
namespace App\Services;

use App\Http\Resources\PaymentCollection;
use App\Http\Resources\PaymentResource;
use App\Repositories\PaymentRepository;
use bigfood\grid\BaseModelService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Payment;


class PaymentService extends BaseModelService
{

    protected $repository;

    const TYPE_BANK_TRANSACTION                         = 1; //positive
    const TYPE_MANUAL_TRANSACTION                       = 2; //positive or negative
    const TYPE_VOUCHER                                  = 3; //negative
    const TYPE_PRE_ORDER                                = 4; //negative
    const TYPE_PRE_ORDER_CANCELLATION                   = 5; //positive
    const TYPE_PRE_ORDER_SUBSIDIZED                     = 6; //negative
    const TYPE_PRE_ORDER_SUBSIDIZED_REFUND              = 7; //positive
    const TYPE_PRE_ORDER_SUBSIDIZED_CANCELLATION        = 8; //positive
    const TYPE_PRE_ORDER_SUBSIDIZED_CANCELLATION_REFUND = 9; //negative
    const TYPE_POS_ORDER                                = 10; //negative
    const TYPE_POS_ORDER_SUBSIDIZED                     = 11; //negative
    const TYPE_POS_ORDER_SUBSIDIZED_REFUND              = 12; //positive

    public function __construct(PaymentRepository $repository)
    {
        $this->repository = $repository;
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
}
