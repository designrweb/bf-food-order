<?php
namespace App\Services;

use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Repositories\OrderRepository;
use bigfood\grid\BaseModelService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Order;


class OrderService extends BaseModelService
{

    protected $repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Returns all orders transformed to resource
     *
     * @return OrderCollection
     */
    public function all(): OrderCollection
    {
         return $this->repository->all();
    }

    /**
     * Returns single product transformed to resource
     *
     * @param $id
     * @return OrderResource
     * @throws ModelNotFoundException
     */
    public function getOne($id): OrderResource
    {
        return $this->repository->get($id);
    }

    /**
     * Creates and returns the orders model
     *
     * @param $data
     * @return OrderResource
     */
    public function create($data): OrderResource
    {
        return $this->repository->add($data);
    }

    /**
     * Updates and returns the orders model
     *
     * @param $data
     * @param $id
     * @return OrderResource
     * @throws ModelNotFoundException
     */
    public function update($data, $id): OrderResource
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
        return $this->getFullStructure((new Order()));
    }

     /**
     * @return array
     */
    public function getViewStructure(): array
    {
        return $this->getSimpleStructure((new Order()));
    }

    /**
     * @param $startDate
     * @param $endDate
     * @param $locationGroup
     * @return mixed
     */
    public static function getPreOrdersByDateRangeAndLocationGroup($startDate, $endDate, $locationGroup)
    {
        return OrderRepository::getPreOrdersByDateRangeAndLocationGroup($startDate, $endDate, $locationGroup);
    }

    /**
     * @param $startDate
     * @param $endDate
     * @param $locationGroup
     * @return bool
     */
    public static function cancelOrders($startDate, $endDate, $locationGroup)
    {
        return OrderRepository::cancelOrders($startDate, $endDate, $locationGroup);
    }
}
