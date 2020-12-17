<?php

namespace App\QueryBuilders;

use App\User;
use bigfood\grid\BaseSearch;
use Closure;
use Illuminate\Database\Eloquent\Builder;

class SubsidizationOrganizationSearch extends BaseSearch
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

        $this->builder->select(['subsidization_organizations.*', 'companies.name as company_name'])
            ->leftJoin('companies', 'companies.id', '=', 'subsidization_organizations.company_id');

        // filters
        if (request('filters.id')) {
            $this->applyFilter('subsidization_organizations.id', request('filters.id'));
        }

        if (request('filters.name')) {
            $this->applyFilter('subsidization_organizations.name', request('filters.name'));
        }

        if (request('filters.zip')) {
            $this->applyFilter('subsidization_organizations.zip', request('filters.zip'));
        }

        if (request('filters.city')) {
            $this->applyFilter('subsidization_organizations.city', request('filters.city'));
        }

        if (request('filters.street')) {
            $this->applyFilter('subsidization_organizations.street', request('filters.street'));
        }

        $this->builder->when(request('filters.company.name'), function (Builder $q) {
            $q->where('company_name', 'like', '%' . request('filters.company.name') . '%');
        });

        // sort
        $this->applySort('subsidization_organizations.id', request('sort.id'));
        $this->applySort('subsidization_organizations.name', request('sort.name'));
        $this->applySort('subsidization_organizations.zip', request('sort.zip'));
        $this->applySort('subsidization_organizations.city', request('sort.city'));
        $this->applySort('subsidization_organizations.street', request('sort.street'));
        $this->builder->when(request('sort.company.name'), function (Builder $q) {
            return $q->orderBy('company_name', request('sort.company.name'));
        });

        return $this->builder;
    }
}
