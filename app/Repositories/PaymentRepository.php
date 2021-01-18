<?php

namespace App\Repositories;

use App\Payment;
use App\QueryBuilders\PaymentSearch;
use Illuminate\Pipeline\Pipeline;

class PaymentRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model(): string
    {
        return Payment::class;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return (app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                PaymentSearch::class,
            ])
            ->thenReturn()
            ->with('consumer.user')
            ->paginate(request('itemsPerPage') ?? 10));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return $this->model->with('consumer.user')->findOrFail($id);
    }
}
