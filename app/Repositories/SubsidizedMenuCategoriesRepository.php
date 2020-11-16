<?php

namespace App\Repositories;

use App\Http\Resources\SubsidizedMenuCategoriesCollection;
use App\Http\Resources\SubsidizedMenuCategoriesResource;
use App\SubsidizedMenuCategories;
use App\QueryBuilders\SubsidizedMenuCategoriesSearch;
use Illuminate\Pipeline\Pipeline;
use bigfood\grid\RepositoryInterface;

class SubsidizedMenuCategoriesRepository implements RepositoryInterface
{
    /** @var SubsidizedMenuCategories */
    protected $model;

    public function __construct(SubsidizedMenuCategories $model)
    {
        $this->model = $model;
    }

    /**
     * @return SubsidizedMenuCategoriesCollection
     */
    public function all()
    {
        return new SubsidizedMenuCategoriesCollection(app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                SubsidizedMenuCategoriesSearch::class,
            ])
            ->thenReturn()
            ->paginate(request('itemsPerPage') ?? 10));
    }

    /**
     * @param array $data
     * @return SubsidizedMenuCategoriesResource
     */
    public function add(array $data)
    {
        return new SubsidizedMenuCategoriesResource($this->model->create($data));
    }

    /**
     * @param array $data
     * @param       $id
     * @return SubsidizedMenuCategoriesResource
     */
    public function update(array $data, $id)
    {
        $model = $this->model->findOrFail($id);
        $model->update($data);

        return new SubsidizedMenuCategoriesResource($model);
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
     * @return SubsidizedMenuCategoriesResource
     */
    public function get($id)
    {
        return new SubsidizedMenuCategoriesResource($this->model->findOrFail($id));
    }
}
