<?php
namespace App\Services;

use App\Http\Resources\SubsidizationOrganizationCollection;
use App\Http\Resources\SubsidizationOrganizationResource;
use App\Repositories\SubsidizationOrganizationRepository;
use bigfood\grid\BaseModelService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\SubsidizationOrganization;


class SubsidizationOrganizationService extends BaseModelService
{

    protected $repository;

    public function __construct(SubsidizationOrganizationRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Returns all subsidization_organizations transformed to resource
     *
     * @return SubsidizationOrganizationCollection
     */
    public function all(): SubsidizationOrganizationCollection
    {
         return $this->repository->all();
    }

    /**
     * Returns single product transformed to resource
     *
     * @param $id
     * @return SubsidizationOrganizationResource
     * @throws ModelNotFoundException
     */
    public function getOne($id): SubsidizationOrganizationResource
    {
        return $this->repository->get($id);
    }

    /**
     * Creates and returns the subsidization_organizations model
     *
     * @param $data
     * @return SubsidizationOrganizationResource
     */
    public function create($data): SubsidizationOrganizationResource
    {
        return $this->repository->add($data);
    }

    /**
     * Updates and returns the subsidization_organizations model
     *
     * @param $data
     * @param $id
     * @return SubsidizationOrganizationResource
     * @throws ModelNotFoundException
     */
    public function update($data, $id): SubsidizationOrganizationResource
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
        return $this->getFullStructure((new SubsidizationOrganization()));
    }

     /**
     * @return array
     */
    public function getViewStructure(): array
    {
        return $this->getSimpleStructure((new SubsidizationOrganization()));
    }
}
