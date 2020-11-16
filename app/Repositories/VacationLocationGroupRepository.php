<?php

namespace App\Repositories;

use App\Http\Resources\VacationLocationGroupCollection;
use App\Http\Resources\VacationLocationGroupResource;
use App\VacationLocationGroup;
use App\QueryBuilders\VacationLocationGroupSearch;
use Illuminate\Pipeline\Pipeline;
use bigfood\grid\RepositoryInterface;

class VacationLocationGroupRepository implements RepositoryInterface
{
    /** @var VacationLocationGroup */
    protected $model;

    public function __construct(VacationLocationGroup $model)
    {
        $this->model = $model;
    }

    /**
     * @return VacationLocationGroupCollection
     */
    public function all()
    {
        return new VacationLocationGroupCollection(app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                VacationLocationGroupSearch::class,
            ])
            ->thenReturn()
            ->paginate(request('itemsPerPage') ?? 10));
    }

    /**
     * @param array $data
     * @return VacationLocationGroupResource
     */
    public function add(array $data)
    {
        return new VacationLocationGroupResource($this->model->create($data));
    }

    /**
     * @param array $data
     * @param       $id
     * @return VacationLocationGroupResource
     */
    public function update(array $data, $id)
    {
        $model = $this->model->findOrFail($id);
        $model->update($data);

        return new VacationLocationGroupResource($model);
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
     * @return VacationLocationGroupResource
     */
    public function get($id)
    {
        return new VacationLocationGroupResource($this->model->findOrFail($id));
    }
}
