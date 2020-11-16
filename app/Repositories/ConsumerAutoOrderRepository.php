<?php

namespace App\Repositories;

use App\Http\Resources\ConsumerAutoOrderCollection;
use App\Http\Resources\ConsumerAutoOrderResource;
use App\ConsumerAutoOrder;
use App\QueryBuilders\ConsumerAutoOrderSearch;
use Illuminate\Pipeline\Pipeline;
use bigfood\grid\RepositoryInterface;

class ConsumerAutoOrderRepository implements RepositoryInterface
{
    /** @var ConsumerAutoOrder */
    protected $model;

    public function __construct(ConsumerAutoOrder $model)
    {
        $this->model = $model;
    }

    /**
     * @return ConsumerAutoOrderCollection
     */
    public function all()
    {
        return new ConsumerAutoOrderCollection(app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                ConsumerAutoOrderSearch::class,
            ])
            ->thenReturn()
            ->paginate(request('itemsPerPage') ?? 10));
    }

    /**
     * @param array $data
     * @return ConsumerAutoOrderResource
     */
    public function add(array $data)
    {
        return new ConsumerAutoOrderResource($this->model->create($data));
    }

    /**
     * @param array $data
     * @param       $id
     * @return ConsumerAutoOrderResource
     */
    public function update(array $data, $id)
    {
        $model = $this->model->findOrFail($id);
        $model->update($data);

        return new ConsumerAutoOrderResource($model);
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
     * @return ConsumerAutoOrderResource
     */
    public function get($id)
    {
        return new ConsumerAutoOrderResource($this->model->findOrFail($id));
    }
}
