<?php

namespace App\QueryBuilders;

use bigfood\grid\BaseSearch;
use Closure;
use Illuminate\Database\Eloquent\Builder;

class PaymentDumpSearch extends BaseSearch
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

        // filters
        $this->applyFilter('payment_dumps.file_name', request('filters.file_name'));

        if (request('filters.created_at')) {
            $this->builder->where('payment_dumps.created_at', 'like', '%' . date('Y-m-d', strtotime(request('filters.created_at'))) . '%');
        }


        $status = json_decode(request('filters.status'), true);

        if ($status['filter'] !== '' && $status['filter'] !== null) {
            $this->builder->where('payment_dumps.status', $status['filter']);
        }

        if (request('filters.updated_at')) {
            $this->builder->where('payment_dumps.updated_at', 'like', '%' . date('Y-m-d', strtotime(request('filters.updated_at'))) . '%');
        }

        if (request('filters.requested_at')) {
            $this->builder->where('payment_dumps.requested_at', date('Y-m-d', strtotime(request('filters.requested_at'))));
        }

        // sort
        $this->applySort('payment_dumps.file_name', request('sort.file_name'));
        $this->applySort('payment_dumps.status', request('sort.status'));
        $this->applySort('payment_dumps.created_at', request('sort.created_at'));
        $this->applySort('payment_dumps.updated_at', request('sort.updated_at'));
        $this->applySort('payment_dumps.requested_at', request('sort.requested_at'));

        return $this->builder;
    }
}
