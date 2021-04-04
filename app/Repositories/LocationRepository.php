<?php

namespace App\Repositories;

use App\Location;
use App\QueryBuilders\LocationSearch;
use Illuminate\Pipeline\Pipeline;
use bigfood\grid\RepositoryInterface;

class LocationRepository implements RepositoryInterface
{
    /** @var Location */
    protected $model;

    /**
     * LocationRepository constructor.
     *
     * @param Location $model
     */
    public function __construct(Location $model)
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
                LocationSearch::class,
            ])
            ->thenReturn()
            ->with('locationGroups')
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
     * @return mixed
     */
    public function get($id)
    {
        return $this->model->with('company')->findOrFail($id);
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        $locationsArray = [];
        $allLocations   = $this->model::all();

        foreach ($allLocations as $location) {
            $locationsArray[] = [
                'id'   => $location->id,
                'name' => $location->name,
            ];
        }

        return $locationsArray;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getModel($id)
    {
        return $this->model->findOrFail($id);
    }
}
