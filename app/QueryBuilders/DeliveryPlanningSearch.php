<?php

namespace App\QueryBuilders;

use bigfood\grid\BaseSearch;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

/**
 * Class DeliveryPlanningSearch
 *
 * @package App\QueryBuilders
 */
class DeliveryPlanningSearch extends BaseSearch
{

    /**
     * @param         $request
     * @param Closure $next
     * @return \Illuminate\Database\Eloquent\Builder|mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var Builder $builder */
        $this->builder = $next($request);

        $this->builder->select([
            'locations.id AS location_id',
            'locations.name AS location_name',
            'menu_categories.id AS menu_category_id',
            'menu_categories.name AS menu_category_name',
            'orders.day AS day',
            'orders.deleted_at AS deleted_at',
            'orders.quantity AS amount',
        ])
            ->addSelect(DB::raw('FLOOR((orders.quantity * voucher_limits.percentage / 100)) AS `voucher_percentage`'))
            ->leftJoin('menu_items', 'orders.menuitem_id', '=', 'menu_items.id')
            ->leftJoin('menu_categories', 'menu_items.menu_category_id', '=', 'menu_categories.id')
            ->leftJoin('consumers', 'orders.consumer_id', '=', 'consumers.id')
            ->leftJoin('location_groups', 'consumers.location_group_id', '=', 'location_groups.id')
            ->leftJoin('locations', 'location_groups.location_id', '=', 'locations.id')
            ->leftJoin('voucher_limits', function ($query) {
                $query->on('menu_categories.id', '=', 'voucher_limits.menu_category_id');
                $query->whereRaw('WEEKDAY(`orders`.`day`) = voucher_limits.weekday');
            })
            ->whereNull('orders.deleted_at')
            ->having('day', '>=', date('Y-m-d'))
            ->having('amount', '>', 0)
            ->groupBy(['location_id', 'location_name', 'menu_category_id', 'menu_category_name', 'day']);

        // filters

        $locationName = json_decode(request('filters.location_name'), true);

        if ($locationName['filter'] !== '' && $locationName['filter'] !== null) {
            $this->applyFilter('locations.id', $locationName['filter']);
        }

        if (request('filters.date')) {
            $this->applyFilter('orders.day', request('filters.date'));
        }

        $menuCategoryName = json_decode(request('filters.menu_category_name'), true);

        if ($menuCategoryName['filter'] !== '' && $menuCategoryName['filter'] !== null) {
            $this->applyFilter('menu_categories.id', $menuCategoryName['filter']);
        }

        if (request('filters.amount')) {
            $this->applyFilter('orders.quantity', request('filters.amount'));
        }

        if (request('filters.voucher_percentage')) {
            $this->builder->whereRaw("FLOOR((orders.quantity * voucher_limits.percentage / 100)) like '%" . request('filters.voucher_percentage') . "%' ");
        }

        // sort
        $this->applySort('locations.name', request('sort.location_name'));
        $this->applySort('orders.day', request('sort.date'));
        $this->applySort('menu_categories.name', request('sort.menu_category_name'));
        $this->applySort('orders.quantity', request('sort.amount'));
        $this->applySort('voucher_percentage', request('sort.voucher_percentage'));

        return $this->builder;
    }
}
