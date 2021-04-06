<?php

namespace App\QueryBuilders;

use bigfood\grid\BaseSearch;
use Illuminate\Database\Eloquent\Builder;
use Closure;
use App\User;

class AdministratorSearch extends BaseSearch
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
             ->selectRaw('IF(locations.name, locations.name, "") as location_name, IF(companies.name, companies.name, "") as company_name')
            ->leftJoin('locations', 'users.location_id', '=', 'locations.id')
            ->leftJoin('user_info', 'users.id', '=', 'user_info.user_id')
            ->leftJoin('companies', 'users.company_id', '=', 'companies.id')
            ->whereIn('users.role', [User::ROLE_ADMIN, User::ROLE_POS_MANAGER])
            ->where(function ($q) {
                $q->orWhere('users.company_id', request()->user()->company_id);
                $q->orWhere('locations.company_id', request()->user()->company_id);
            });

        // filters
        $this->applyFilter('users.id', request('filters.id'));
        $this->applyFilter('users.email', request('filters.email'));
        $this->applyFilter('users.role', request('filters.role'));

        if (!empty(request('filters.location.name'))) {
            $this->builder->whereHas('location', function ($query) {
                $query->where('locations.name', 'like', '%' . request('filters.location.name') . '%');
            });
        }

        if (!empty(request('filters.company.name'))) {
            $this->builder->whereHas('company', function ($query) {
                $query->where('companies.name', 'like', '%' . request('filters.company.name') . '%');
            });
        }

        // sort
        $this->applySort('users.id', request('sort.id'));
        $this->applySort('users.email', request('sort.email'));
        $this->applySort('users.role', request('sort.role'));

        $this->builder->when(request('sort.company.name'), function (Builder $q) {
            return $q->orderBy('companies.name', request('sort.company.name'));
        });

        $this->builder->when(request('sort.location.name'), function (Builder $q) {
            return $q->orderBy('locations.name', request('sort.location.name'));
        });

        return $this->builder;
    }
}
