<?php

namespace App\Repositories;

use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Order;
use App\QueryBuilders\OrderSearch;
use Illuminate\Pipeline\Pipeline;
use bigfood\grid\RepositoryInterface;

class OrderRepository implements RepositoryInterface
{
    /** @var Order */
    protected $model;

    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    /**
     * @return OrderCollection
     */
    public function all()
    {
        return new OrderCollection(app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                OrderSearch::class,
            ])
            ->thenReturn()
            ->paginate(request('itemsPerPage') ?? 10));
    }

    /**
     * @param array $data
     * @return OrderResource
     */
    public function add(array $data)
    {
        return new OrderResource($this->model->create($data));
    }

    /**
     * @param array $data
     * @param       $id
     * @return OrderResource
     */
    public function update(array $data, $id)
    {
        $model = $this->model->findOrFail($id);
        $model->update($data);

        return new OrderResource($model);
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * @param       $id
     * @return OrderResource
     */
    public function get($id)
    {
        return new OrderResource($this->model->findOrFail($id));
    }

    /**
     * @param $startDate
     * @param $endDate
     * @param $locationGroup
     * @return mixed
     */
    public static function getPreOrdersByDateRangeAndLocationGroup($startDate, $endDate, $locationGroup)
    {
        $orders = Order::whereHas('consumer', function ($query) use ($locationGroup) {
            $query->whereIn('consumers.location_group_id', $locationGroup);
        })
            ->whereRaw('DATE_FORMAT(day, "%Y-%m") BETWEEN "' . $startDate . '" AND "' . $endDate . '" ')
            ->where('type', Order::TYPE_PRE_ORDER)
            ->whereNull('deleted_at')
            ->get();

        return $orders;
    }

    /**
     * @param $startDate
     * @param $endDate
     * @param $locationGroup
     * @return bool
     */
    public static function cancelOrders($startDate, $endDate, $locationGroup)
    {
        $orders = self::getPreOrdersByDateRangeAndLocationGroup($startDate, $endDate, $locationGroup);

        foreach ($orders as $order) {
            $order->delete();
        }

        return true;
    }
}
