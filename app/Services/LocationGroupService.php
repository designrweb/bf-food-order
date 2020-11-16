<?php
namespace App\Services;

use App\Http\Resources\LocationGroupCollection;
use App\Http\Resources\LocationGroupResource;
use App\Repositories\LocationGroupRepository;
use bigfood\grid\BaseModelService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\LocationGroup;


class LocationGroupService extends BaseModelService
{

    protected $repository;

    public function __construct(LocationGroupRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Returns all location_group transformed to resource
     *
     * @return LocationGroupCollection
     */
    public function all(): LocationGroupCollection
    {
         return $this->repository->all();
    }

    /**
     * Returns single product transformed to resource
     *
     * @param $id
     * @return LocationGroupResource
     * @throws ModelNotFoundException
     */
    public function getOne($id): LocationGroupResource
    {
        return $this->repository->get($id);
    }

    /**
     * Creates and returns the location_group model
     *
     * @param $data
     * @return LocationGroupResource
     */
    public function create($data): LocationGroupResource
    {
        return $this->repository->add($data);
    }

    /**
     * Updates and returns the location_group model
     *
     * @param $data
     * @param $id
     * @return LocationGroupResource
     * @throws ModelNotFoundException
     */
    public function update($data, $id): LocationGroupResource
    {
        return $this->repository->update($data, $id);
    }

    /**
     * @param $id
     * @return bool
     */
    public function remove($id): bool
    {
        return $this->repository->delete($id);
    }

    /**
     * @return array
     */
    public function getIndexStructure(): array
    {
        return $this->getFullStructure((new LocationGroup()));
    }

     /**
     * @return array
     */
    public function getViewStructure(): array
    {
        return $this->getSimpleStructure((new LocationGroup()));
    }
}
