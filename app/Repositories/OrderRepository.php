<?php

namespace App\Repositories;

use App\Order;
use App\QueryBuilders\OrderSearch;
use Illuminate\Pipeline\Pipeline;

class OrderRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model(): string
    {
        return Order::class;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                OrderSearch::class,
            ])
            ->thenReturn()
            ->with('menuItem')
            ->paginate(request('itemsPerPage') ?? 10);
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
            ->whereRaw('DATE_FORMAT(day, "%Y-%m-%d") BETWEEN "' . $startDate . '" AND "' . $endDate . '" ')
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

    /**
     * @param Order $order
     * @return mixed
     */
    public function countOrdersWithSubsidizationByDateForConsumer(Order $order)
    {
        return Order::hasSubsidization()
            ->where('consumer_id', $order->consumer_id)
            ->where('day', $order->day)
            ->where('id', '<>', $order->id)
            ->count();
    }
}
