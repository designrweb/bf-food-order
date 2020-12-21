<?php

namespace App\Repositories;

use App\Http\Resources\PaymentDumpCollection;
use App\Http\Resources\PaymentDumpResource;
use App\PaymentDump;
use App\QueryBuilders\PaymentDumpSearch;
use Illuminate\Pipeline\Pipeline;
use bigfood\grid\RepositoryInterface;

class PaymentDumpRepository implements RepositoryInterface
{
    /** @var PaymentDump */
    protected $model;

    public function __construct(PaymentDump $model)
    {
        $this->model = $model;
    }

    /**
     * @return PaymentDumpCollection
     */
    public function all()
    {
        return new PaymentDumpCollection(app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                PaymentDumpSearch::class,
            ])
            ->thenReturn()
            ->paginate(request('itemsPerPage') ?? 10));
    }

    /**
     * @param  $id
     * @return PaymentDumpResource
     */
    public function get($id): PaymentDumpResource
    {
        return new PaymentDumpResource($this->model->findOrFail($id));
    }

    /**
     * @param array $data
     * @return PaymentDumpResource
     */
    public function add(array $data): PaymentDumpResource
    {
        return new PaymentDumpResource($this->model->create($data));
    }

    /**
     * @param array $data
     * @param       $id
     * @return PaymentDumpResource
     */
    public function update(array $data, $id): PaymentDumpResource
    {
        $model = $this->model->findOrFail($id);
        $model->update($data);

        return new PaymentDumpResource($model);
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id): int
    {
        return $this->model->destroy($id);
    }
}
