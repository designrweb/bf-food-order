<?php

namespace App\Repositories;

use App\LocationGroup;
use App\QueryBuilders\LocationGroupSearch;
use Illuminate\Pipeline\Pipeline;

class LocationGroupRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model(): string
    {
        return LocationGroup::class;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                LocationGroupSearch::class,
            ])
            ->thenReturn()
            ->with('location')
            ->paginate(request('itemsPerPage') ?? 10);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return $this->model->with('location')->findOrFail($id);
    }

    /**
     * @param null $locationId
     * @return array
     */
    public function getList($locationId = null): array
    {
        $locationGroupArray = [];
        $allLocationGroup   = $this->model->newQuery();

        if (!empty($locationId)) {
            $allLocationGroup = $allLocationGroup->where('location_id', $locationId);
        }

        $allLocationGroup = $allLocationGroup->get();

        foreach ($allLocationGroup as $location) {
            $locationGroupArray[] = [
                'id'   => $location->id,
                'name' => $location->name,
            ];
        }

        return $locationGroupArray;
    }
}
