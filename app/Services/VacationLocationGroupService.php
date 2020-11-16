<?php
namespace App\Services;

use App\Http\Resources\VacationLocationGroupCollection;
use App\Http\Resources\VacationLocationGroupResource;
use App\Repositories\VacationLocationGroupRepository;
use bigfood\grid\BaseModelService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\VacationLocationGroup;


class VacationLocationGroupService extends BaseModelService
{

    protected $repository;

    public function __construct(VacationLocationGroupRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Returns all vacation_location_group transformed to resource
     *
     * @return VacationLocationGroupCollection
     */
    public function all(): VacationLocationGroupCollection
    {
         return $this->repository->all();
    }

    /**
     * Returns single product transformed to resource
     *
     * @param $id
     * @return VacationLocationGroupResource
     * @throws ModelNotFoundException
     */
    public function getOne($id): VacationLocationGroupResource
    {
        return $this->repository->get($id);
    }

    /**
     * Creates and returns the vacation_location_group model
     *
     * @param $data
     * @return VacationLocationGroupResource
     */
    public function create($data): VacationLocationGroupResource
    {
        return $this->repository->add($data);
    }

    /**
     * Updates and returns the vacation_location_group model
     *
     * @param $data
     * @param $id
     * @return VacationLocationGroupResource
     * @throws ModelNotFoundException
     */
    public function update($data, $id): VacationLocationGroupResource
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
        return $this->getFullStructure((new VacationLocationGroup()));
    }

     /**
     * @return array
     */
    public function getViewStructure(): array
    {
        return $this->getSimpleStructure((new VacationLocationGroup()));
    }
}
