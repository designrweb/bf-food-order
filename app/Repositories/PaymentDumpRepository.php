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

    /**
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param array $data
     * @param       $id
     * @return mixed
     */
    public function update(array $data, $id)
    {
        $model = $this->model->findOrFail($id);
        $model->update($data);

        return $model;
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
