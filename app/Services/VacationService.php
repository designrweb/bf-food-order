<?php

namespace App\Services;

use App\Http\Resources\VacationCollection;
use App\Http\Resources\VacationResource;
use App\Repositories\VacationRepository;
use bigfood\grid\BaseModelService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Vacation;


class VacationService extends BaseModelService
{

    protected $repository;

    public function __construct(VacationRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Returns all vacation transformed to resource
     *
     * @return VacationCollection
     */
    public function all(): VacationCollection
    {
        return $this->repository->all();
    }

    /**
     * Returns single product transformed to resource
     *
     * @param $id
     * @return VacationResource
     * @throws ModelNotFoundException
     */
    public function getOne($id): VacationResource
    {
        return $this->repository->get($id);
    }

    /**
     * Creates and returns the vacation model
     *
     * @param $data
     * @return VacationResource
     */
    public function create($data): VacationResource
    {
        return $this->repository->add($data);
    }

    /**
     * Updates and returns the vacation model
     *
     * @param $data
     * @param $id
     * @return VacationResource
     * @throws ModelNotFoundException
     */
    public function update($data, $id): VacationResource
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
        return $this->getFullStructure((new Vacation()));
    }

    /**
     * @return array
     */
    public function getViewStructure(): array
    {
        return $this->getSimpleStructure((new Vacation()));
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
                'label' => 'Name'
            ],
            [
                'key'   => 'start_date',
                'label' => 'Date From'
            ],
            [
                'key'   => 'end_date',
                'label' => 'Date To'
            ],
            [
                'key'   => 'location_name',
                'label' => 'Location'
            ],
            [
                'key'   => 'location_group_name',
                'label' => 'Group'
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
                'key'   => 'id',
                'label' => '#'
            ],
            [
                'key'   => 'name',
                'label' => 'Name'
            ],
            [
                'key'   => 'start_date',
                'label' => 'Date From'
            ],
            [
                'key'   => 'end_date',
                'label' => 'Date To'
            ],
            [
                'key'   => 'location_name',
                'label' => 'Location'
            ],
            [
                'key'   => 'location_group_name',
                'label' => 'Group'
            ],
        ];
    }

    /**
     * @param Model $model
     * @return array
     */
    protected function getFilters(Model $model): array
    {
        return [
            'name'                => '',
            'start_date'          => '',
            'end_date'            => '',
            'location_name'       => '',
            'location_group_name' => '',
        ];
    }

    /**
     * @param Model $model
     * @return array
     */
    protected function getSortFields(Model $model): array
    {
        return [
            'name'                => '',
            'start_date'          => '',
            'end_date'            => '',
            'location_name'       => '',
            'location_group_name' => '',
        ];
    }

}
