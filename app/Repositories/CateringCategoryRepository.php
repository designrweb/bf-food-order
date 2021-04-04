<?php

namespace App\Repositories;

use App\Http\Resources\CateringCategoryCollection;
use App\Http\Resources\CateringCategoryResource;
use App\CateringCategory;
use App\QueryBuilders\CateringCategorySearch;
use Illuminate\Pipeline\Pipeline;
use bigfood\grid\RepositoryInterface;

class CateringCategoryRepository implements RepositoryInterface
{
    /** @var CateringCategory */
    protected $model;

    public function __construct(CateringCategory $model)
    {
        $this->model = $model;
    }

    /**
     * @return CateringCategoryCollection
     */
    public function all()
    {
        return new CateringCategoryCollection(app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                CateringCategorySearch::class,
            ])
            ->thenReturn()
            ->with('location')
            ->paginate(request('itemsPerPage') ?? 10));
    }

    /**
     * @param array $data
     * @return CateringCategoryResource
     */
    public function add(array $data)
    {
        return new CateringCategoryResource($this->model->create($data));
    }

    /**
     * @param array $data
     * @param       $id
     * @return CateringCategoryResource
     */
    public function update(array $data, $id)
    {
        $model = $this->model->findOrFail($id);
        $model->update($data);

        return new CateringCategoryResource($model);
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
     * @return CateringCategoryResource
     */
    public function get($id)
    {
        return new CateringCategoryResource($this->model->with('location')->findOrFail($id));
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        $menuCategoriesArray = [];
        $allMenuCategories   = $this->model::all();

        foreach ($allMenuCategories as $menuCategory) {
            $menuCategoriesArray[] = [
                'id'   => $menuCategory->id,
                'name' => $menuCategory->name,
            ];
        }

        return $menuCategoriesArray;
    }
}
