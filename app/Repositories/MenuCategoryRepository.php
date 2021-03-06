<?php

namespace App\Repositories;

use App\Http\Resources\MenuCategoryCollection;
use App\Http\Resources\MenuCategoryResource;
use App\MenuCategory;
use App\QueryBuilders\MenuCategorySearch;
use Illuminate\Pipeline\Pipeline;
use bigfood\grid\RepositoryInterface;

class MenuCategoryRepository implements RepositoryInterface
{
    /** @var MenuCategory */
    protected $model;

    public function __construct(MenuCategory $model)
    {
        $this->model = $model;
    }

    /**
     * @return MenuCategoryCollection
     */
    public function all()
    {
        return app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                MenuCategorySearch::class,
            ])
            ->thenReturn()
            ->with('location')
            ->paginate(request('itemsPerPage') ?? 10);
    }

    /**
     * @return array
     */
    public function getList()
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

    /**
     * @return MenuCategory[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getModelList()
    {
        return $this->model::all();
    }


    /**
     * @param array $data
     * @return MenuCategoryResource
     */
    public function add(array $data)
    {
        return new MenuCategoryResource($this->model->create($data));
    }

    /**
     * @param array $data
     * @param       $id
     * @return MenuCategoryResource
     */
    public function update(array $data, $id)
    {
        $model = $this->model->findOrFail($id);
        $model->update($data);

        return new MenuCategoryResource($model);
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
     * @return MenuCategoryResource
     */
    public function get($id)
    {
        return new MenuCategoryResource($this->model->findOrFail($id));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getByLocationId($id)
    {
        return $this->model->where('location_id', $id)->get();
    }

    /**
     * @return mixed
     */
    public function getTaxRates()
    {
        return $this->model::TAX_RATES;
    }
}
