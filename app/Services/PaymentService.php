<?php
namespace App\Services;

use App\Http\Resources\PaymentCollection;
use App\Http\Resources\PaymentResource;
use App\Repositories\PaymentRepository;
use bigfood\grid\BaseModelService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Payment;


class PaymentService extends BaseModelService
{

    protected $repository;

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
}
