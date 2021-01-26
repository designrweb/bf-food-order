<?php

namespace App\QueryBuilders;

use bigfood\grid\BaseSearch;
use Closure;
use Illuminate\Database\Eloquent\Builder;

class OrderSearch extends BaseSearch
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

        $this->builder->select(['orders.*', 'menu_items.name as menu_item_name'])
            ->leftJoin('menu_items', 'menu_items.id', '=', 'orders.menuitem_id')
            ->leftJoin('consumers', 'consumers.id', '=', 'orders.consumer_id');

        // filters
        $this->builder->when(request('filters.quantity'), function (Builder $query) {
            $query->where('orders.quantity', request('filters.quantity'));
        });

        $this->builder->when(request('filters.day'), function (Builder $query) {
            $query->where('orders.day', date('Y-m-d', strtotime(request('filters.day'))));
        });

        $this->builder->when(request('filters.menu_item.name'), function (Builder $query) {
            $query->where('menu_items.name', 'like', '%' . request('filters.menu_item.name') . '%');
        });

        if (!empty(request('filters.consumer.full_name'))) {
            $this->builder->whereRaw("CONCAT_WS(' ', consumers.firstname, consumers.lastname) like '%" . request('filters.consumer.full_name') . "%' ");
        }

        // sort
        $this->applySort('orders.quantity', request('sort.quantity'));
        $this->applySort('orders.day', request('sort.day'));

        $this->builder->when(request('sort.menu_item.name'), function (Builder $query) {
            return $query->orderBy('menu_items.name', request('sort.menu_item.name'));
        });

        $this->builder->when(request('sort.consumer.full_name'), function (Builder $query) {
            return $query->orderByRaw("CONCAT_WS(' ', consumers.firstname, consumers.lastname) " . request('sort.consumer.full_name'));
        });

        return $this->builder;
    }
}
