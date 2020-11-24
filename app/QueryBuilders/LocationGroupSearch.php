<?php

namespace App\QueryBuilders;

use bigfood\grid\BaseSearch;
use Closure;
use Illuminate\Database\Eloquent\Builder;

class LocationGroupSearch extends BaseSearch
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
        $this->applyFilter('location_groups.name', request('filters.name'));

        $this->builder->whereHas('location', function ($query) {
            $query->where('locations.name', 'like', '%' . request('filters.location_id') . '%');
        });

        // sort
        $this->applySort('location_groups.name', request('sort.name'));

        $this->builder->when(request('sort.location_id'), function (Builder $q) {
            return $q->orderBy('locations.name', request('sort.location_id'));
        });

        return $this->builder;
    }
}
