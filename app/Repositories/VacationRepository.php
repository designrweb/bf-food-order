<?php

namespace App\Repositories;

use App\Http\Resources\VacationCollection;
use App\Http\Resources\VacationResource;
use App\Vacation;
use App\QueryBuilders\VacationSearch;
use Illuminate\Pipeline\Pipeline;
use bigfood\grid\RepositoryInterface;

class VacationRepository implements RepositoryInterface
{
    /** @var Vacation */
    protected $model;

    public function __construct(Vacation $model)
    {
        $this->model = $model;
    }

    /**
     * @return VacationCollection
     */
    public function all()
    {
        return new VacationCollection(app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                VacationSearch::class,
            ])
            ->thenReturn()
            ->paginate(request('itemsPerPage') ?? 10));
    }

    /**
     * @param array $data
     * @return VacationResource
     */
    public function add(array $data)
    {
        return new VacationResource($this->model->create($data));
    }

    /**
     * @param array $data
     * @param       $id
     * @return VacationResource
     */
    public function update(array $data, $id)
    {
        $model = $this->model->findOrFail($id);
        $model->update($data);

        return new VacationResource($model);
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
     * @return VacationResource
     */
    public function get($id)
    {
        return new VacationResource($this->model->findOrFail($id));
    }
}
