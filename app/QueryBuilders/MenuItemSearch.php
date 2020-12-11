<?php

namespace App\QueryBuilders;

use bigfood\grid\BaseSearch;
use Closure;
use Illuminate\Database\Eloquent\Builder;

class MenuItemSearch extends BaseSearch
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

        $this->builder->select('menu_items.*', 'menu_categories.price', 'menu_categories.presaleprice', 'menu_categories.name as menu_categories_name')
            ->join('menu_categories', 'menu_categories.id', '=', 'menu_items.menu_category_id');


        // filters
        if (!empty(request('filters.name'))) {
            $this->applyFilter('menu_items.name', request('filters.name'));
        }

        if (!empty(request('filters.availability_date_human'))) {
            $this->applyFilter('menu_items.availability_date', date('Y-m-d', strtotime(request('filters.availability_date_human'))));
        }

        $this->builder->when(request('filters.menu_category.presaleprice'), function (Builder $q) {
            $q->where('menu_categories.presaleprice', 'like', '%' . request('filters.menu_category.presaleprice') . '%');
        });

        $this->builder->when(request('filters.menu_category.price'), function (Builder $q) {
            $q->where('menu_categories.price', 'like', '%' . request('filters.menu_category.price') . '%');
        });

        $this->builder->when(request('filters.menu_categories_name'), function (Builder $q) {
            $q->where('menu_categories.name', 'like', '%' . request('filters.menu_categories_name') . '%');
        });

        // sort
        $this->applySort('menu_items.name', request('sort.name'));
        $this->applySort('menu_items.availability_date', request('sort.availability_date_human'));

        $this->builder->when(request('sort.menu_category.presaleprice'), function (Builder $q) {
            return $q->orderBy('menu_categories.presaleprice', request('sort.menu_category.presaleprice'));
        });

        $this->builder->when(request('sort.menu_category.price'), function (Builder $q) {
            return $q->orderBy('menu_categories.price', request('sort.menu_category.price'));
        });

        $this->builder->when(request('sort.menu_categories_name'), function (Builder $q) {
            return $q->orderBy('menu_categories.name', request('sort.menu_categories_name'));
        });

        return $this->builder;
    }
}
