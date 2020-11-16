<?php

namespace App\QueryBuilders;

use bigfood\grid\BaseSearch;
use Illuminate\Database\Eloquent\Builder;
use Closure;
use Illuminate\Support\Facades\DB;

class UserSearch extends BaseSearch
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
        $this->applyFilter('users.id', request('filters.id'));
        $this->applyFilter('users.name', request('filters.name'));
        $this->applyFilter('users.email', request('filters.email'));
        $this->applyFilter('users.created_at', request('filters.created_at'));
        $this->applyFilter('users.updated_at', request('filters.updated_at'));

        $this->builder->when(request('filters.user_info.first_name'), function (Builder $q) {
            $q->whereHas('userInfo', function ($q) {
                $q->where('user_info.first_name', 'like', '%' . request('filters.user_info.first_name') . '%');
            });
        });

        $this->builder->when(request('filters.user_info.last_name'), function (Builder $q) {
            $q->whereHas('userInfo', function ($q) {
                $q->where('user_info.last_name', 'like', '%' . request('filters.user_info.last_name') . '%');
            });
        });

        // search
        $this->applySort('users.id', request('sort.id'));
        $this->applySort('users.name', request('sort.name'));
        $this->applySort('users.email', request('sort.email'));
        $this->applySort('users.created_at', request('sort.created_at'));
        $this->applySort('users.updated_at', request('sort.updated_at'));

        $this->builder->when(request('sort.user_info.first_name'), function (Builder $q) {
            return $q->orderBy('user_info.first_name', request('sort.user_info.first_name'));
        });

        $this->builder->when(request('sort.user_info.last_name'), function (Builder $q) {
            return $q->orderBy('user_info.last_name', request('sort.user_info.last_name'));
        });

        return $this->builder;
    }
}
