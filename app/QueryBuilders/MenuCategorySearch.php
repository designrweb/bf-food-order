<?php

namespace App\QueryBuilders;

use bigfood\grid\BaseSearch;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

/**
 * Class MenuCategorySearch
 *
 * @package App\QueryBuilders
 */
class MenuCategorySearch extends BaseSearch
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

        // filters
        $this->applyFilter('menu_categories.name', request('filters.name'));
        $this->applyFilter('menu_categories.category_order', request('filters.category_order'));
        $this->applyFilter('menu_categories.price', str_replace(',', '.', request('filters.price_locale')));
        $this->applyFilter('menu_categories.presaleprice', str_replace(',', '.', request('filters.presaleprice_locale')));

        // sort
        $this->applySort('menu_categories.name', request('sort.name'));

        if (!empty(request('sort.category_order'))) {
            $this->applySort('menu_categories.category_order', request('sort.category_order'));
        } else {
            $this->applySort('menu_categories.category_order', 'asc');
        }

        if (request('filters.location.name')) {
            $this->builder->whereHas('location', function (Builder $q) {
                $q->where('locations.name', 'like', '%' . request('filters.location.name') . '%');
            });
        }

        if (request('filters.tax_rate')) {
            $this->builder->where('tax_rate', request('filters.tax_rate'));
        }

        if (request('sort.tax_rate')) {
            $this->applySort('tax_rate', request('sort.tax_rate'));
        }

        $this->applySort('menu_categories.price', request('sort.price_locale'));
        $this->applySort('menu_categories.presaleprice', request('sort.presaleprice_locale'));

        return $this->builder;
    }
}
