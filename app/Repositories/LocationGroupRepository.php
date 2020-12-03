<?php

namespace App\Repositories;

use App\Http\Resources\LocationGroupCollection;
use App\Http\Resources\LocationGroupResource;
use App\LocationGroup;
use App\QueryBuilders\LocationGroupSearch;
use Illuminate\Pipeline\Pipeline;
use bigfood\grid\RepositoryInterface;

class LocationGroupRepository implements RepositoryInterface
{
    /** @var LocationGroup */
    protected $model;

    public function __construct(LocationGroup $model)
    {
        $this->model = $model;
    }

    /**
     * @return LocationGroupCollection
     */
    public function all()
    {
        return new LocationGroupCollection(app(Pipeline::class)
            ->send(
                $this->model->newQuery()
                    ->select('location_groups.*')
                    ->leftJoin('locations', 'location_groups.location_id', '=', 'locations.id')
            )
            ->through([
                LocationGroupSearch::class,
            ])
            ->thenReturn()
            ->with('location')
            ->paginate(request('itemsPerPage') ?? 10));
    }

    /**
     * @param array $data
     * @return LocationGroupResource
     */
    public function add(array $data)
    {
        return new LocationGroupResource($this->model->create($data));
    }

    /**
     * @param array $data
     * @param       $id
     * @return LocationGroupResource
     */
    public function update(array $data, $id)
    {
        $model = $this->model->findOrFail($id);
        $model->update($data);

        return new LocationGroupResource($model);
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
     * @return LocationGroupResource
     */
    public function get($id)
    {
        return new LocationGroupResource($this->model->findOrFail($id));
    }

    /**
     * @return array
     */
    public function getList()
    {
        $locationGroupArray = [];
        $allLocationGroup   = $this->model::all();

        foreach ($allLocationGroup as $location) {
            $locationGroupArray[] = [
                'id'   => $location->id,
                'name' => $location->name,
            ];
        }

        return $locationGroupArray;
    }
}
