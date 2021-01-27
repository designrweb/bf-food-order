<?php

namespace App\Repositories;

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
     * @return mixed
     */
    public function all()
    {
        return app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                MenuItemSearch::class,
            ])
            ->thenReturn()
            ->with(['menuCategory'])
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
        return $this->getModel($id);
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function getModel($id)
    {
        return $this->model->with('menuCategory')->findOrFail($id);
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function replicate($id)
    {
        $replicated = $this->getModel($id)->replicate(['availability_date']);
        $replicated->save();

        return $replicated;
    }
}
