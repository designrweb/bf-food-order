<?php

namespace App\Repositories;

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
     * @return mixed
     */
    public function all()
    {
        return app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                CateringCategorySearch::class,
            ])
            ->thenReturn()
            ->with('location')
            ->paginate(request('itemsPerPage') ?? 10);
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
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function get($id)
    {
        return $this->model->with('location')->findOrFail($id);
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
