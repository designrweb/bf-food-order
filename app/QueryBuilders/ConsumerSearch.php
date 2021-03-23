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

        $this->builder->select([
            'consumers.*',
            'location_groups.name as location_groups_name',
            'locations.name as location_name',
            'users.email',
            'user_info.first_name',
            'user_info.last_name',
            'subsidization_rules.rule_name as subsidization_rules_rule_name'
        ])
            ->leftJoin('consumer_subsidizations', 'consumers.id', '=', 'consumer_subsidizations.consumer_id')
            ->leftJoin('subsidization_rules', 'consumer_subsidizations.subsidization_rule_id', '=', 'subsidization_rules.id')
            ->leftJoin('location_groups', 'location_groups.id', '=', 'consumers.location_group_id')
            ->join('locations', 'locations.id', '=', 'location_groups.location_id')
            ->leftJoin('users', 'users.id', '=', 'consumers.user_id')
            ->join('user_info', 'user_info.user_id', '=', 'users.id');

        if (auth()->user()->role === User::ROLE_USER) {
            $this->builder->where('consumers.user_id', auth()->user()->id);
        }

        // filters
        if (request('filters.id')) {
            $this->applyFilter('consumers.id', request('filters.id'));
        }

        if (request('filters.account_id')) {
            $this->applyFilter('consumers.account_id', request('filters.account_id'));
        }

        $this->builder->whereRaw("CONCAT_WS(' ', consumers.firstname, consumers.lastname) like '%" . request('filters.full_name') . "%' ");

        $this->builder->when(request('filters.user.email'), function (Builder $q) {
            $q->where('users.email', 'like', '%' . request('filters.user.email') . '%');
        });

        if (request('filters.location_group.name')) {
            $this->builder->whereHas('locationGroup.location', function (Builder $q) {
                $q->where('locations.name', 'like', '%' . request('filters.location_group.location.name') . '%');
            });
        }

        if (request('filters.location_group.name')) {
            $this->builder->whereHas('locationGroup', function (Builder $q) {
                $q->where('location_groups.name', 'like', '%' . request('filters.location_group.name') . '%');
            });
        }

        if (request('filters.user.user_info.first_name')) {
            $this->builder->whereHas('user.userInfo', function (Builder $q) {
                $q->where('user_info.first_name', 'like', '%' . request('filters.user.user_info.first_name') . '%');
            });
        }

        if (request('filters.user.user_info.full_name')) {
            $this->builder->whereHas('user.userInfo', function (Builder $q) {
                $q->where(function ($q) {
                    $q->orWhere('user_info.first_name', 'like', '%' . request('filters.user.user_info.full_name') . '%')
                        ->orWhere('user_info.last_name', 'like', '%' . request('filters.user.user_info.full_name') . '%');
                });
            });
        }

        if (request('filters.subsidization.subsidization_rule.rule_name')) {
            $this->builder->whereHas('subsidization.subsidizationRule', function (Builder $q) {
                $q->where('subsidization_rules.rule_name', 'like', '%' . request('filters.subsidization.subsidization_rule.rule_name') . '%');
            });
        }

        // sort
        $this->applySort('consumers.id', request('sort.id'));

        $this->applySort('consumers.account_id', request('sort.account_id'));

        $this->builder->when(request('sort.full_name'), function (Builder $q) {
            return $q->orderByRaw("CONCAT_WS(' ', consumers.firstname, consumers.lastname) " . request('sort.full_name'));
        });

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

        $this->builder->when(request('sort.user.user_info.full_name'), function (Builder $q) {
            return $q->orderBy('first_name', request('sort.user.user_info.full_name'))
                ->orderBy('last_name', request('sort.user.user_info.full_name'));
        });

        $this->builder->when(request('sort.subsidization.subsidization_rule.rule_name'), function (Builder $q) {
            return $q->orderBy('subsidization_rules.rule_name', request('sort.subsidization.subsidization_rule.rule_name'));
        });

        return $this->builder;
    }
}
