<?php

namespace App\Services;

use App\Http\Resources\SubsidizationRuleCollection;
use App\Http\Resources\SubsidizationRuleResource;
use App\Repositories\SubsidizationRuleRepository;
use bigfood\grid\BaseModelService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\SubsidizationRule;


class SubsidizationRuleService extends BaseModelService
{

    protected $repository;

    public function __construct(SubsidizationRuleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Returns all subsidization_rules transformed to resource
     *
     * @return SubsidizationRuleCollection
     */
    public function all(): SubsidizationRuleCollection
    {
        return $this->repository->all();
    }

    /**
     * Returns single product transformed to resource
     *
     * @param $id
     * @return SubsidizationRuleResource
     * @throws ModelNotFoundException
     */
    public function getOne($id): SubsidizationRuleResource
    {
        return $this->repository->get($id);
    }

    /**
     * Creates and returns the subsidization_rules model
     *
     * @param $data
     * @return SubsidizationRuleResource
     */
    public function create($data): SubsidizationRuleResource
    {
        return $this->repository->add($data);
    }

    /**
     * Updates and returns the subsidization_rules model
     *
     * @param $data
     * @param $id
     * @return SubsidizationRuleResource
     * @throws ModelNotFoundException
     */
    public function update($data, $id): SubsidizationRuleResource
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
        return $this->getFullStructure((new SubsidizationRule()));
    }

    /**
     * @return array
     */
    public function getViewStructure(): array
    {
        return $this->getSimpleStructure((new SubsidizationRule()));
    }

    /**
     * @param Model $model
     * @return \string[][]
     */
    protected function getViewFieldsLabels(Model $model): array
    {
        return [
            [
                'key'   => 'rule_name',
                'label' => 'Rule Name'
            ],
            [
                'key'   => 'subsidization_organization.name',
                'label' => 'Subsidization Organization'
            ],
            [
                'key'   => 'start_date',
                'label' => 'Start Date'
            ],
            [
                'key'   => 'end_date',
                'label' => 'End Date'
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
                'key'   => 'rule_name',
                'label' => 'Rule Name'
            ],
            [
                'key'   => 'subsidization_organization.name',
                'label' => 'Subsidization Organization'
            ],
            [
                'key'   => 'start_date',
                'label' => 'Start Date'
            ],
            [
                'key'   => 'end_date',
                'label' => 'End Date'
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
            'rule_name'                       => '',
            'subsidization_organization.name' => '',
            'start_date'                      => '',
            'end_date'                        => '',
        ];
    }

    /**
     * @param Model $model
     * @return array
     */
    protected function getSortFields(Model $model): array
    {
        return [
            'rule_name'                       => '',
            'subsidization_organization.name' => '',
            'start_date'                      => '',
            'end_date'                        => '',
        ];
    }
}
