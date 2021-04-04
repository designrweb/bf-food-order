<?php

namespace App\QueryBuilders;

use bigfood\grid\BaseSearch;
use Closure;
use Illuminate\Database\Eloquent\Builder;

class CateringCategorySearch extends BaseSearch
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
        $this->applyFilter('catering_categories.name', request('filters.name'));
        $this->applyFilter('catering_categories.location_id', request('filters.location.name'));

        // sort
        $this->applySort('catering_categories.name', request('sort.name'));
        $this->applySort('catering_categories.location_id', request('sort.name'));

        return $this->builder;
    }
}
