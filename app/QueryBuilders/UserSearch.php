<?php

namespace App\QueryBuilders;

use bigfood\grid\BaseSearch;
use Illuminate\Database\Eloquent\Builder;
use Closure;
use App\User;

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

        $this->builder->select(['users.*'])
            ->leftJoin('user_info', 'users.id', '=', 'user_info.user_id')
            ->whereIn('users.role', [User::ROLE_ADMIN, User::ROLE_POS_MANAGER])
            ->whereCompany();

        // filters
        $this->applyFilter('users.id', request('filters.id'));
        $this->applyFilter('users.email', request('filters.email'));
        $this->applyFilter('users.role', request('filters.role'));

        // sort
        $this->applySort('users.id', request('sort.id'));
        $this->applySort('users.email', request('sort.email'));
        $this->applySort('users.role', request('sort.role'));

        return $this->builder;
    }
}
