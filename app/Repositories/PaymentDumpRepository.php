<?php

namespace App\Repositories;

use App\PaymentDump;
use App\QueryBuilders\PaymentDumpSearch;
use Illuminate\Pipeline\Pipeline;

class PaymentDumpRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model(): string
    {
        return PaymentDump::class;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                PaymentDumpSearch::class,
            ])
            ->thenReturn()
            ->paginate(request('itemsPerPage') ?? 10);
    }
}
