<?php

namespace App\Repositories;

use App\Http\Resources\SettingCollection;
use App\Http\Resources\SettingResource;
use App\Setting;
use App\QueryBuilders\SettingSearch;
use Illuminate\Pipeline\Pipeline;
use bigfood\grid\RepositoryInterface;

class SettingRepository implements RepositoryInterface
{
    /** @var Setting */
    protected $model;

    public function __construct(Setting $model)
    {
        $this->model = $model;
    }

    /**
     * @return SettingCollection
     */
    public function all()
    {
        return new SettingCollection(app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                SettingSearch::class,
            ])
            ->thenReturn()
            ->paginate(request('itemsPerPage') ?? 10));
    }

    /**
     * @param array $data
     * @return SettingResource
     */
    public function add(array $data)
    {
        return new SettingResource($this->model->create($data));
    }

    /**
     * @param array $data
     * @param       $id
     * @return SettingResource
     */
    public function update(array $data, $id)
    {
        $model = $this->model->findOrFail($id);
        $model->update($data);

        return new SettingResource($model);
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
     * @return SettingResource
     */
    public function get($id)
    {
        return new SettingResource($this->model->findOrFail($id));
    }
}
