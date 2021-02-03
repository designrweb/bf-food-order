<?php

namespace App\Services;

use App\Repositories\LocationGroupRepository;
use bigfood\grid\BaseModelService;
use Illuminate\Database\Eloquent\Model;
use App\LocationGroup;

class LocationGroupService extends BaseModelService
{
    /** @var LocationGroupRepository */
    protected $repository;

    /** @var LocationService */
    protected $locationService;

    /**
     * LocationGroupService constructor.
     *
     * @param LocationGroupRepository $repository
     * @param LocationService         $locationService
     */
    public function __construct(LocationGroupRepository $repository, LocationService $locationService)
    {
        $this->repository      = $repository;
        $this->locationService = $locationService;
    }

    /**
     * Returns all location_group
     *
     * @return mixed
     */
    public function all()
    {
        return $this->repository->all();
    }

    /**
     * Returns single location_group model
     *
     * @param $id
     * @return mixed
     */
    public function getOne($id)
    {
        return $this->repository->get($id);
    }

    /**
     * Creates and returns the location_group model
     *
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->repository->add($data);
    }

    /**
     * Updates and returns the location_group model
     *
     * @param $data
     * @param $id
     * @return mixed
     */
    public function update($data, $id)
    {
        return $this->repository->update($data, $id);
    }

    /**
     * @param null $locationId
     * @return mixed
     */
    public function getList($locationId = null)
    {
        return $this->repository->getList($locationId);
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

    /**
     * @param Model $model
     * @return array
     */
    protected function getFilters(Model $model): array
    {
        return [
            'name'               => '',
            'location_id'        => [
                'values' => $this->locationService->getList(),
                'filter' => '',
                'type'   => 'select',
            ],
            'number_of_students' => '',
        ];
    }

    /**
     * @param Model $model
     * @return array
     */
    protected function getSortFields(Model $model): array
    {
        return [
            'name'               => '',
            'location_id'        => '',
            'number_of_students' => '',
        ];
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
                'key'   => 'location.name',
                'label' => __('location.Location')
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
                'key'   => 'location_id',
                'label' => __('location.Location')
            ],
            [
                'key'   => 'number_of_students',
                'label' => __('location-group.Number of students')
            ],
        ];
    }

    /**
     * Returns allowed actions for the front-end part
     *
     * @return array
     */
    protected function getAllowActions(): array
    {
        return [
            'all'    => true,
            'create' => true,
            'view'   => true,
            'edit'   => true,
            'delete' => false,
        ];
    }
}
