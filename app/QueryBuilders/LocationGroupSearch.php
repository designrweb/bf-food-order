<?php

namespace App\QueryBuilders;

use bigfood\grid\BaseSearch;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

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

        $this->builder->select(['location_groups.*', DB::raw('COUNT(consumers.id) as number_of_students')])
            ->leftJoin('consumers', 'location_groups.id', '=', 'consumers.location_group_id')
            ->leftJoin('locations', 'location_groups.location_id', '=', 'locations.id')
            ->groupBy('location_groups.id');

        // filters
        $this->applyFilter('location_groups.name', request('filters.name'));

        $locationId = json_decode(request('filters.location_id'), true);

        if ($locationId['filter'] !== '' && $locationId['filter'] !== null) {
            $this->applyFilter('location_groups.location_id', $locationId['filter']);
        }

        if (request('filters.number_of_students')) {
            $this->builder->havingRaw('COUNT(consumers.id) = ?', [request('filters.number_of_students')]);
        }

        // sort
        $this->applySort('location_groups.name', request('sort.name'));

        $this->builder->when(request('sort.location_id'), function (Builder $q) {
            return $q->orderBy('locations.name', request('sort.location_id'));
        });

        $this->builder->when(request('sort.number_of_students'), function (Builder $q) {
            return $q->orderBy('number_of_students', request('sort.number_of_students'));
        });

        return $this->builder;
    }
}
