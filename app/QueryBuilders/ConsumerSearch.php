<?php

namespace App\QueryBuilders;

use App\User;
use bigfood\grid\BaseSearch;
use Closure;
use Illuminate\Database\Eloquent\Builder;

class ConsumerSearch extends BaseSearch
{
    /**
     * @param         $request
     * @param Closure $next
     * @return Builder|mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var Builder $builder */
        $this->builder = $next($request);

        $this->builder->select(['consumers.*', 'location_groups.name as location_groups_name', 'locations.name as location_name', 'users.email', 'user_info.first_name'])
            ->leftJoin('location_groups', 'location_groups.id', '=', 'consumers.location_group_id')
            ->join('locations', 'locations.id', '=', 'location_groups.location_id')
            ->leftJoin('users', 'users.id', '=', 'consumers.user_id')
            ->join('user_info', 'user_info.user_id', '=', 'users.id');

        if (auth()->user()->role === User::ROLE_USER) {
            $this->applyFilter('user_id', auth()->user()->id);
        }

        // filters
        $this->applyFilter('consumers.id', request('filters.id'));
        $this->applyFilter('consumers.account_id', request('filters.account_id'));
        $this->applyFilter('consumers.firstname', request('filters.firstname'));
        $this->builder->when(request('filters.user.email'), function (Builder $q) {
            $q->where('users.email', 'like', '%' . request('filters.user.email') . '%');
        });
        $this->builder->whereHas('locationGroup.location', function (Builder $q) {
            $q->where('locations.name', 'like', '%' . request('filters.location_group.location.name') . '%');
        });
        $this->builder->whereHas('locationGroup', function (Builder $q) {
            $q->where('location_groups.name', 'like', '%' . request('filters.location_group.name') . '%');
        });
        $this->builder->whereHas('user.userInfo', function (Builder $q) {
            $q->where('user_info.first_name', 'like', '%' . request('filters.user.user_info.first_name') . '%');
        });

        // sort
        $this->applySort('consumers.id', request('sort.id'));
        $this->applySort('consumers.account_id', request('sort.account_id'));
        $this->applySort('consumers.firstname', request('sort.firstname'));
        $this->builder->when(request('sort.user.email'), function (Builder $q) {
            return $q->orderBy('users.email', request('sort.user.email'));
        });
        $this->builder->when(request('sort.location_group.location.name'), function (Builder $q) {
            return $q->orderBy('location_name', request('sort.location_group.location.name'));
        });
        $this->builder->when(request('sort.location_group.name'), function (Builder $q) {
            return $q->orderBy('location_groups_name', request('sort.location_group.name'));
        });
        $this->builder->when(request('sort.user.user_info.first_name'), function (Builder $q) {
            return $q->orderBy('first_name', request('sort.user.user_info.first_name'));
        });

        return $this->builder;
    }
}
