<?php
namespace App\Services;

use App\Http\Resources\LocationCollection;
use App\Http\Resources\LocationResource;
use App\Repositories\LocationRepository;
use bigfood\grid\BaseModelService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Location;


class LocationService extends BaseModelService
{

    protected $repository;

    public function __construct(LocationRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Returns all locations transformed to resource
     *
     * @return LocationCollection
     */
    public function all(): LocationCollection
    {
         return $this->repository->all();
    }

    /**
     * Returns single product transformed to resource
     *
     * @param $id
     * @return LocationResource
     * @throws ModelNotFoundException
     */
    public function getOne($id): LocationResource
    {
        return $this->repository->get($id);
    }

    /**
     * Creates and returns the locations model
     *
     * @param $data
     * @return LocationResource
     */
    public function create($data): LocationResource
    {
        return $this->repository->add($data);
    }

    /**
     * Updates and returns the locations model
     *
     * @param $data
     * @param $id
     * @return LocationResource
     * @throws ModelNotFoundException
     */
    public function update($data, $id): LocationResource
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
        return $this->getFullStructure((new Location()));
    }

     /**
     * @return array
     */
    public function getViewStructure(): array
    {
        return $this->getSimpleStructure((new Location()));
    }
}
