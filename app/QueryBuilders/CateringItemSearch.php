<?php

namespace App\QueryBuilders;

use bigfood\grid\BaseSearch;
use Closure;
use Illuminate\Database\Eloquent\Builder;

class CateringItemSearch extends BaseSearch
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
        $this->applyFilter('catering_items.name', request('filters.name'));
        $this->applyFilter('catering_items.status', request('filters.status_human'));
        $this->applyFilter('catering_items.catering_category_id', request('filters.catering_category.name'));

        // sort
        $this->applySort('catering_items.name', request('sort.name'));
        $this->applySort('catering_items.status', request('sort.status_human'));
        $this->applySort('catering_items.catering_category_id', request('sort.catering_category.name'));

        return $this->builder;
    }
}
