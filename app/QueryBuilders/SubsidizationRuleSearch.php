<?php

namespace App\QueryBuilders;

use bigfood\grid\BaseSearch;
use Closure;
use Illuminate\Database\Eloquent\Builder;

class SubsidizationRuleSearch extends BaseSearch
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

        $this->builder->select(['subsidization_rules.*', 'subsidization_organizations.name as subsidization_organizations_name'])
            ->leftJoin('subsidization_organizations', 'subsidization_organizations.id', '=', 'subsidization_rules.subsidization_organization_id');

        // filters
        if (request('filters.id')) {
            $this->applyFilter('subsidization_rules.id', request('filters.id'));
        }

        if (request('filters.rule_name')) {
            $this->applyFilter('subsidization_rules.rule_name', request('filters.rule_name'));
        }

        if (request('filters.start_date')) {
            $this->builder->where('subsidization_rules.start_date', '>=', date('Y-m-d', strtotime(request('filters.start_date'))));
        }

        if (request('filters.end_date')) {
            $this->builder->where('subsidization_rules.end_date', '<=', date('Y-m-d', strtotime(request('filters.end_date'))));
        }

        $this->builder->when(request('filters.subsidization_organization.name'), function (Builder $q) {
            $q->where('subsidization_organizations.name', 'like', '%' . request('filters.subsidization_organization.name') . '%');
        });

        // sort
        $this->applySort('subsidization_rules.id', request('sort.id'));
        $this->applySort('subsidization_rules.rule_name', request('sort.rule_name'));
        $this->applySort('subsidization_rules.start_date', request('sort.start_date'));
        $this->applySort('subsidization_rules.end_date', request('sort.end_date'));

        $this->builder->when(request('sort.subsidization_organization.name'), function (Builder $q) {
            return $q->orderBy('subsidization_organizations.name', request('sort.subsidization_organization.name'));
        });

        return $this->builder;
    }
}
