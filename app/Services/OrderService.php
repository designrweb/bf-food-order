<?php

namespace App\Services;

use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Repositories\OrderRepository;
use bigfood\grid\BaseModelService;
use Illuminate\Database\Eloquent\Model;
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
     * @return mixed
     */
    public function all()
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
    public function getOne($id)
    {
        return $this->repository->get($id);
    }

    /**
     * Creates and returns the orders model
     *
     * @param $data
     * @return OrderResource
     */
    public function create($data)
    {
        return $this->repository->add($data);
    }

    /**
     * @param $data
     * @param $id
     * @return mixed
     */
    public function update($data, $id)
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
     * Returns allowed actions for the front-end part
     *
     * @return array
     */
    protected function getAllowActions(): array
    {
        return [
            'all'    => false,
            'create' => false,
            'view'   => false,
            'edit'   => false,
            'delete' => false,
        ];
    }

    /**
     * @param Model $model
     * @return array
     */
    public function getIndexFieldsLabels(Model $model): array
    {
        return [
            [
                'key'   => 'consumer.full_name',
                'label' => __('order.Child Full Name')
            ],
            [
                'key'   => 'menu_item.name',
                'label' => __('order.Menu')
            ],
            [
                'key'   => 'quantity',
                'label' => __('order.Quantity')
            ],
            [
                'key'   => 'day',
                'label' => __('order.Day At')
            ],
        ];
    }

    /**
     * @param Model $model
     * @return array
     */
    protected function getSortFields(Model $model): array
    {
        return [
            'consumer.full_name' => '',
            'menu_item.name'     => '',
            'quantity'           => '',
            'day'                => '',
        ];
    }

    /**
     * @param Model $model
     * @return array
     */
    protected function getFilters(Model $model): array
    {
        return [
            'consumer.full_name' => '',
            'menu_item.name'     => '',
            'quantity'           => '',
            'day'                => '',
        ];
    }

    /**
     * @param Order $order
     * @return mixed
     */
    public function countOrdersWithSubsidization(Order $order)
    {
        return $this->repository->countOrdersWithSubsidizationByDateForConsumer($order);
    }
}
