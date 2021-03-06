<?php

namespace App\QueryBuilders;

use App\Payment;
use App\Services\ConsumerService;
use App\User;
use bigfood\grid\BaseSearch;
use Closure;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class PaymentSearch
 *
 * @package App\QueryBuilders
 */
class PaymentSearch extends BaseSearch
{
    /**
     * @param         $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var Builder $builder */
        $this->builder = $next($request);

        $this->builder->select([
            'payments.*',
            'consumers.account_id as consumer_account',
            'users.email as user_email',
            'orders.is_subsidized as is_subsidized',
            'orders.day as order_day'
        ])
            ->leftJoin('consumers', 'payments.consumer_id', '=', 'consumers.id')
            ->leftJoin('users', 'users.id', '=', 'consumers.user_id')
            ->leftJoin('orders', 'payments.order_id', '=', 'orders.id');

        // filters
        $this->builder->when(request('filters.consumer_account'), function (Builder $q) {
            $q->where('consumers.account_id', 'like', '%' . request('filters.consumer_account') . '%');
        });

        $this->builder->when(request('filters.user_email'), function (Builder $q) {
            $q->where('users.email', 'like', '%' . request('filters.user_email') . '%');
        });

        $this->applyFilter('payments.amount', str_replace(',', '.', request('filters.amount_locale')));
        $this->applyFilter('payments.comment', request('filters.comment'));

        $this->builder->when(request('filters.created_at_human'), function (Builder $q) {
            $q->where('payments.created_at', 'like', date('Y-m-d', strtotime(request('filters.created_at_human'))) . '%');
        });

        // sort
        $this->applySort('payments.amount', request('sort.amount_locale'));
        $this->applySort('payments.comment', request('sort.comment'));
        $this->applySort('payments.created_at', request('sort.created_at_human', 'desc'));

        $this->builder->when(request('sort.consumer_account'), function (Builder $q) {
            return $q->orderBy('consumers.account_id', request('sort.consumer_account'));
        });

        $this->builder->when(request('sort.order_day'), function (Builder $q) {
            return $q->orderBy('orders.day', request('sort.order_day'));
        });

        $this->builder->when(request('sort.user_email'), function (Builder $q) {
            return $q->orderBy('users.email', request('sort.user_email'));
        });

        return $this->builder;
    }
}
