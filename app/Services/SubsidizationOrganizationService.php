<?php

namespace App\Services;

use App\Http\Resources\SubsidizationOrganizationCollection;
use App\Http\Resources\SubsidizationOrganizationResource;
use App\Repositories\SubsidizationOrganizationRepository;
use bigfood\grid\BaseModelService;
use Illuminate\Database\Eloquent\Model;
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
     * @param $id
     * @return Model|null
     */
    public function getOne($id): ?Model
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
    public function getList(): array
    {
        return $this->repository->getList();
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

    /**
     * @param Model $model
     * @return \string[][]
     */
    protected function getViewFieldsLabels(Model $model): array
    {
        return [
            [
                'key'   => 'name',
                'label' => __('app.Name')
            ],
            [
                'key'   => 'zip',
                'label' => __('app.Zip')
            ],
            [
                'key'   => 'city',
                'label' => __('app.City')
            ],
            [
                'key'   => 'street',
                'label' => __('app.Street')
            ],
            [
                'key'   => 'company.name',
                'label' => __('company.Company')
            ],
        ];
    }

    /**
     * @param Model $model
     * @return \string[][]
     */
    public function getIndexFieldsLabels(Model $model): array
    {
        return [
            [
                'key'   => 'name',
                'label' => __('app.Name')
            ],
            [
                'key'   => 'zip',
                'label' => __('app.Zip')
            ],
            [
                'key'   => 'city',
                'label' => __('app.City')
            ],
            [
                'key'   => 'street',
                'label' => __('app.Street')
            ],
            [
                'key'   => 'company.name',
                'label' => __('company.Company')
            ],
        ];
    }

    /**
     * @param Model $model
     * @return string[]
     */
    protected function getFilters(Model $model): array
    {
        return [
            'name'         => '',
            'zip'          => '',
            'city'         => '',
            'street'       => '',
            'company.name' => '',
        ];
    }

    /**
     * @param Model $model
     * @return array
     */
    protected function getSortFields(Model $model): array
    {
        return [
            'name'         => '',
            'zip'          => '',
            'city'         => '',
            'street'       => '',
            'company.name' => '',
        ];
    }
}
