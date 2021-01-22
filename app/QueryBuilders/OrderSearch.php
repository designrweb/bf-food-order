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
            ->leftJoin('menu_items', 'menu_items.id', '=', 'orders.menuitem_id');

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

        // sort
        $this->applySort('orders.quantity', request('sort.quantity'));
        $this->applySort('orders.day', request('sort.day'));

        $this->builder->when(request('sort.menu_item.name'), function (Builder $query) {
            return $query->orderBy('menu_items.name', request('sort.menu_item.name'));
        });

        return $this->builder;
    }
}
