<?php

namespace App\Services;

use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Notifications\CancelOrderNotification;
use App\Repositories\OrderRepository;
use App\User;
use bigfood\grid\BaseModelService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Order;


class OrderService extends BaseModelService
{
    /** @var OrderRepository */
    protected $repository;

    /** @var LocationService */
    protected $locationService;

    /** @var PaymentService */
    private $paymentService;

    /**
     * OrderService constructor.
     *
     * @param OrderRepository $repository
     * @param LocationService $locationService
     * @param PaymentService  $paymentService
     */
    public function __construct(OrderRepository $repository, LocationService $locationService, PaymentService $paymentService)
    {
        $this->repository      = $repository;
        $this->locationService = $locationService;
        $this->paymentService  = $paymentService;
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
     * @return Order
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
        $originalOrder = new Order();
        //add created_by current user
        $data['created_by'] = request()->user()->id;
        $order              = $this->repository->add($data);
        $this->paymentService->createPaymentBasedOnOrder($order, $originalOrder);

        //update is order subsidized after order creations
        $updateData = [
            'is_subsidized' => $this->paymentService->canBeSubsidized($order, $originalOrder->quantity)
        ];
        $this->repository->update($updateData, $order->id);

        return $order;
    }

    /**
     * @param $data
     * @param $price
     * @return mixed
     */
    public function createCashRegisterOrder($data, $price)
    {
        $order = $this->repository->add($data);

        $this->paymentService->createCashRegisterPayment($order, $price);

        return $order;
    }

    /**
     * @param $data
     * @param $id
     * @return mixed
     */
    public function update($data, $id)
    {
        $originalOrder = $this->getOne($id);
        //add updated_by current user
        $data['updated_by'] = request()->user()->id;
        $order              = $this->repository->update($data, $id);
        $this->paymentService->createPaymentBasedOnQuantity($order, $originalOrder);

        return $order;
    }

    /**
     * @param $id
     * @return bool
     */
    public function remove($id): bool
    {
        $this->paymentService->createCanceledPaymentBasedOnOrder($this->getOne($id));

        return $this->repository->delete($id);
    }

    /**
     * @param $startDate
     * @param $endDate
     * @param $locationGroup
     * @return mixed
     */
    public function getPreOrdersByDateRangeAndLocationGroup($startDate, $endDate, $locationGroup)
    {
        return $this->repository->getPreOrdersByDateRangeAndLocationGroup($startDate, $endDate, $locationGroup);
    }

    /**
     * @param $startDate
     * @param $endDate
     * @param $locationGroup
     * @return bool
     */
    public function cancelOrders($startDate, $endDate, $locationGroup)
    {
        $canceledOrders = $this->repository->getPreOrdersByDateRangeAndLocationGroup($startDate, $endDate, $locationGroup);

        $users = collect();
        $dates = collect();
        foreach ($canceledOrders as $canceledOrder) {
            $users->push($canceledOrder->consumer->user);
            $dates->push($canceledOrder->day);

            //create payment and refund money
            $this->remove($canceledOrder->id);
        }

        $dates = $dates->sort();
        if ($dates->count() === 1) {
            $vacationPeriod = date('d.m.Y', strtotime($dates[0]));
        } else {
            $vacationPeriod = sprintf('%s - %s', date('d.m.Y', strtotime($dates[0])), date('d.m.Y', strtotime($dates[$dates->count() - 1])));
        }

        //send cancel order email to each user
        foreach ($users->unique() as $user) {
            /** @var User $user */
            $user->notify(new CancelOrderNotification($vacationPeriod));
        }
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
    public function getIndexStructureForUser(): array
    {
        return $this->getFullStructureForUser((new Order()));
    }

    /**
     * @return array
     */
    public function getViewStructure(): array
    {
        return $this->getSimpleStructure((new Order()));
    }

    /**
     * @param $consumerId
     * @return mixed
     */
    public function getOrdersForConsumer($consumerId)
    {
        return $this->repository->getOrdersForConsumers($consumerId);
    }

    /**
     * Returns allowed actions for the front-end part
     *
     * @return array
     */
    protected function getAllowActions(): array
    {
        return [
            'all'    => true,
            'create' => false,
            'view'   => false,
            'edit'   => false,
            'delete' => true,
        ];
    }

    /**
     * @param Model $model
     * @return array
     * @todo - need to think how to add condition by order type here
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
                'label' => __('menu-item.Menuitem')
            ],
            [
                'key'   => 'quantity',
                'label' => __('order.Quantity')
            ],
            [
                'key'   => 'translated_day',
                'label' => __('app.Day')
            ],
            [
                'key'   => 'menu_item.menu_category.location.name',
                'label' => __('order.Location')
            ],
        ];
    }

    /**
     * @param Model $model
     * @return array
     */
    public function getIndexFieldsForUser(Model $model): array
    {
        return [
            [
                'key'   => 'menu_item.name',
                'label' => __('menu-item.Menuitem')
            ],
            [
                'key'   => 'quantity',
                'label' => __('order.Quantity')
            ],
            [
                'key'   => 'translated_day',
                'label' => __('app.Day')
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
            'consumer.full_name'                    => '',
            'menu_item.name'                        => '',
            'quantity'                              => '',
            'translated_day'                        => '',
            'menu_item.menu_category.location.name' => '',
        ];
    }

    /**
     * @param Model $model
     * @return array
     */
    protected function getSortFieldsForUser(Model $model): array
    {
        return [
            'menu_item.name' => '',
            'quantity'       => '',
            'translated_day' => '',
        ];
    }

    /**
     * @param Model $model
     * @return array
     */
    protected function getFilters(Model $model): array
    {
        return [
            'consumer.full_name'                    => '',
            'menu_item.name'                        => '',
            'quantity'                              => '',
            'translated_day'                        => '',
            'menu_item.menu_category.location.name' => [
                'values' => $this->locationService->getList(),
                'filter' => '',
                'type'   => 'select',
            ],
        ];
    }

    /**
     * @param Model $model
     * @return array
     */
    protected function getFiltersForUser(Model $model): array
    {
        return [
            'menu_item.name' => '',
            'quantity'       => '',
            'translated_day' => '',
        ];
    }

    /**
     * Returns main model full structure
     *
     * @param Model $model
     * @return array
     */
    public function getFullStructureForUser(Model $model): array
    {
        return [
            'filters'      => $this->getFiltersForUser($model),
            'sort'         => $this->getSortFieldsForUser($model),
            'fields'       => $this->getIndexFieldsForUser($model),
            'allowActions' => $this->getAllowActions(),
        ];
    }

    /**
     * Returns all orders for current day
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getOrdersForToday()
    {
        return $this->repository->getOrdersForToday();
    }

    /**
     * Returns all orders for current day
     *
     * @param $consumerId
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getOrdersOverviewForConsumers($consumerId)
    {
        return $this->repository->getOrdersOverviewForConsumers($consumerId);
    }
}
