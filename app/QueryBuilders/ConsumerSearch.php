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

        if (auth()->user()->role === User::ROLE_USER) {
            $this->applyFilter('user_id', auth()->user()->id);
        }

        return $this->builder;
    }
}
