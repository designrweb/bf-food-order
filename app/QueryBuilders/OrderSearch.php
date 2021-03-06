<?php

namespace App\QueryBuilders;

use App\Order;
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

        $this->builder->select(['orders.*'])
            ->selectRaw('IF(`orders`.`type` = ' . Order::TYPE_CASH_REGISTER . ', "' . Order::TYPES[Order::TYPE_CASH_REGISTER] . '", menu_items.name) as menu_item_name')
            ->selectRaw('IF(`orders`.`type` = ' . Order::TYPE_CASH_REGISTER . ', cl.name, locations.name) as location_name')
            ->leftJoin('menu_items', 'menu_items.id', '=', 'orders.menuitem_id')
            ->leftJoin('menu_categories', 'menu_categories.id', '=', 'menu_items.menu_category_id')
            ->leftJoin('locations', 'locations.id', '=', 'menu_categories.location_id')
            ->leftJoin('consumers', 'consumers.id', '=', 'orders.consumer_id')
            ->leftJoin('location_groups as lg_c', 'lg_c.id', '=', 'consumers.location_group_id')
            ->leftJoin('locations as cl', 'cl.id', '=', 'lg_c.location_id');

        // filters
        $this->builder->when(request('filters.quantity'), function (Builder $query) {
            $query->where('orders.quantity', request('filters.quantity'));
        });

        $this->builder->when(request('filters.day'), function (Builder $query) {
            $query->where('orders.day', date('Y-m-d', strtotime(request('filters.day'))));
        });

        $this->builder->when(request('filters.translated_day'), function (Builder $query) {
            $query->where('orders.day', date('Y-m-d', strtotime(request('filters.translated_day'))));
        });

        if (!empty(request('filters.location_name'))) {
            $this->builder->whereRaw("IF(`orders`.`type` = " . Order::TYPE_CASH_REGISTER . ", cl.id, locations.id) = " . request('filters.location_name') . " ");
        }

        $this->builder->when(request('filters.menu_item_name'), function (Builder $query) {
            $this->builder->whereRaw("IF(`orders`.`type` = " . Order::TYPE_CASH_REGISTER . ", '" . Order::TYPES[Order::TYPE_CASH_REGISTER] . "', menu_items.name) like '%" . request('filters.menu_item_name') . "%' ");
        });

        if (!empty(request('filters.consumer.full_name'))) {
            $this->builder->whereRaw("CONCAT_WS(' ', consumers.firstname, consumers.lastname) like '%" . request('filters.consumer.full_name') . "%' ");
        }

        // sort
        $this->applySort('orders.created_at', 'desc');
        $this->applySort('orders.quantity', request('sort.quantity'));
        $this->applySort('orders.day', request('sort.day'));

        $this->builder->when(request('sort.menu_item.name'), function (Builder $query) {
            return $query->orderBy('menu_items.name', request('sort.menu_item.name'));
        });

        $this->builder->when(request('sort.translated_day'), function (Builder $query) {
            return $query->orderBy('orders.day', request('sort.translated_day'));
        });

        $this->builder->when(request('sort.consumer.full_name'), function (Builder $query) {
            return $query->orderByRaw("CONCAT_WS(' ', consumers.firstname, consumers.lastname) " . request('sort.consumer.full_name'));
        });

        $this->builder->when(request('sort.menu_item.menu_category.location.name'), function (Builder $q) {
            return $q->orderBy('locations.name', request('sort.menu_item.menu_category.location.name'));
        });

        return $this->builder;
    }
}
