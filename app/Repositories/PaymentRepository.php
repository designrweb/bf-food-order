<?php

namespace App\Repositories;

use App\Http\Resources\PaymentCollection;
use App\Http\Resources\PaymentResource;
use App\Payment;
use App\QueryBuilders\PaymentSearch;
use Illuminate\Pipeline\Pipeline;
use bigfood\grid\RepositoryInterface;

class PaymentRepository implements RepositoryInterface
{
    /** @var Payment */
    protected $model;

    public function __construct(Payment $model)
    {
        $this->model = $model;
    }

    /**
     * @return PaymentCollection
     */
    public function all()
    {
        return new PaymentCollection(app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                PaymentSearch::class,
            ])
            ->thenReturn()
            ->paginate(request('itemsPerPage') ?? 10));
    }

    /**
     * @param array $data
     * @return PaymentResource
     */
    public function add(array $data)
    {
        return new PaymentResource($this->model->create($data));
    }

    /**
     * @param array $data
     * @param       $id
     * @return PaymentResource
     */
    public function update(array $data, $id)
    {
        $model = $this->model->findOrFail($id);
        $model->update($data);

        return new PaymentResource($model);
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * @param       $id
     * @return PaymentResource
     */
    public function get($id)
    {
        return new PaymentResource($this->model->findOrFail($id));
    }
}
