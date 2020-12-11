<?php

namespace App\Repositories;

use App\Http\Resources\MenuItemCollection;
use App\Http\Resources\MenuItemResource;
use App\MenuItem;
use App\QueryBuilders\MenuItemSearch;
use Illuminate\Pipeline\Pipeline;
use bigfood\grid\RepositoryInterface;

class MenuItemRepository implements RepositoryInterface
{
    /** @var MenuItem */
    protected $model;

    public function __construct(MenuItem $model)
    {
        $this->model = $model;
    }

    /**
     * @return MenuItemCollection
     */
    public function all()
    {
        return new MenuItemCollection(app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                MenuItemSearch::class,
            ])
            ->thenReturn()
            ->with(['menuCategory'])
            ->paginate(request('itemsPerPage') ?? 10));
    }

    /**
     * @param array $data
     * @return MenuItemResource
     */
    public function add(array $data)
    {
        return new MenuItemResource($this->model->create($data));
    }

    /**
     * @param array $data
     * @param       $id
     * @return MenuItemResource
     */
    public function update(array $data, $id)
    {
        $model = $this->model->findOrFail($id);
        $model->update($data);

        return new MenuItemResource($model);
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
     * @return MenuItemResource
     */
    public function get($id)
    {
        return new MenuItemResource($this->model->with('menuCategory', 'location')->findOrFail($id));
    }
}
