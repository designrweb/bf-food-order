<?php

namespace App\QueryBuilders;

use bigfood\grid\BaseSearch;
use Closure;
use Illuminate\Database\Eloquent\Builder;

class ConsumerSearch extends BaseSearch
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

        $this->builder->select('consumers.*, location_groups.name as location_groups_name')
            ->leftJoin('location_groups', 'location_groups.id', '=', 'consumers.location_group_id');

        // filters
//        $this->applyFilter('users.id', request('filters.id'));
//        $this->applyFilter('users.email', request('filters.email'));
//        $this->applyFilter('users.created_at', request('filters.created_at'));
//        $this->applyFilter('users.updated_at', request('filters.updated_at'));
//
//        $this->builder->when(request('filters.user_info.first_name'), function (Builder $q) {
//            $q->where('user_info.first_name', 'like', '%' . request('filters.user_info.first_name') . '%');
//        });
//
//        $this->builder->when(request('filters.user_info.last_name'), function (Builder $q) {
//            $q->where('user_info.last_name', 'like', '%' . request('filters.user_info.last_name') . '%');
//        });
//
//        // sort
//        $this->applySort('users.id', request('sort.id'));
//        $this->applySort('users.name', request('sort.name'));
//        $this->applySort('users.email', request('sort.email'));
//        $this->applySort('users.created_at', request('sort.created_at'));
//        $this->applySort('users.updated_at', request('sort.updated_at'));
//
//        $this->builder->when(request('sort.user_info.first_name'), function (Builder $q) {
//            return $q->orderBy('user_info.first_name', request('sort.user_info.first_name'));
//        });
//
//        $this->builder->when(request('sort.user_info.last_name'), function (Builder $q) {
//            return $q->orderBy('user_info.last_name', request('sort.user_info.last_name'));
//        });

        return $this->builder;
    }
}
