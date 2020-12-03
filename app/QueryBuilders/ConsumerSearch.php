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

        $this->builder->select('consumers.*, location_groups.name as location_groups_name')
            ->leftJoin('location_groups', 'location_groups.id', '=', 'consumers.location_group_id');

        if (auth()->user()->role === User::ROLE_USER) {
            $this->applyFilter('user_id', auth()->user()->id);
        }

        return $this->builder;
    }
}
