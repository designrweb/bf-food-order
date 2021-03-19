<?php

namespace App\Repositories;

use App\Order;
use App\Payment;
use App\QueryBuilders\MealOrderSearch;
use App\QueryBuilders\PaymentSearch;
use App\QueryBuilders\UserPaymentSearch;
use Illuminate\Pipeline\Pipeline;

class PaymentRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model(): string
    {
        return Payment::class;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return (app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                PaymentSearch::class,
                UserPaymentSearch::class
            ])
            ->thenReturn()
            ->with('consumer.user')
            ->paginate(request('itemsPerPage') ?? 10));
    }

    /**
     * @return mixed
     */
    public function allMealOrders()
    {
        return (app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                PaymentSearch::class,
                MealOrderSearch::class
            ])
            ->thenReturn()
            ->with('consumer.user')
            ->paginate(request('itemsPerPage') ?? 10));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return $this->model->with('consumer.user')->findOrFail($id);
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

    public function allByUsersConsumers(array $consumersIds)
    {
        return (app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                PaymentSearch::class,
            ])
            ->thenReturn()
            ->with('consumer.user')
            ->paginate(request('itemsPerPage') ?? 10));
        return $this->model->whereIn('consumer_id', $consumersIds)->get();
    }
}
