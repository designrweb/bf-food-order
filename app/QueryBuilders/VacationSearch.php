<?php

namespace App\QueryBuilders;

use bigfood\grid\BaseSearch;
use Closure;
use Illuminate\Database\Eloquent\Builder;

class VacationSearch extends BaseSearch
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

        $this->builder = $this->builder->select(['vacations.*', 'location_groups.name as location_groups_name', 'locations.name as location_name'])
            ->leftJoin('vacation_location_group', 'vacation_location_group.vacation_id', '=', 'vacations.id')
            ->leftJoin('location_groups', 'location_groups.id', '=', 'vacation_location_group.location_group_id')
            ->join('locations', 'locations.id', '=', 'location_groups.location_id')
            ->groupBy('locations.id');

        // filters
        $this->applyFilter('vacations.id', request('filters.id'));
        $this->applyFilter('vacations.name', request('filters.name'));

        if (request('filters.start_date')) {
            $this->builder->where('vacations.start_date', '>=', date('Y-m-d', strtotime(request('filters.start_date'))));
        }

        if (request('filters.end_date')) {
            $this->builder->where('vacations.end_date', '<=', date('Y-m-d', strtotime(request('filters.end_date'))));
        }

        $this->builder->when(request('filters.location_name'), function (Builder $q) {
            $q->where('locations.name', 'like', '%' . request('filters.location_name') . '%');
        });

        $this->builder->when(request('filters.location_group_name'), function (Builder $q) {
            $q->where('location_groups.name', 'like', '%' . request('filters.location_group_name') . '%');
        });

        // sort
        $this->applySort('vacations.id', request('sort.id'));
        $this->applySort('vacations.name', request('sort.name'));
        $this->applySort('vacations.start_date', request('sort.start_date'));
        $this->applySort('vacations.end_date', request('sort.end_date'));

        $this->builder->when(request('sort.location_name'), function (Builder $q) {
            return $q->orderBy('locations.name', request('sort.location_name'));
        });

        $this->builder->when(request('sort.location_group_name'), function (Builder $q) {
            return $q->orderBy('location_groups.name', request('sort.location_group_name'));
        });

        return $this->builder;
    }
}
