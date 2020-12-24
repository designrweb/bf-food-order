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
     * @return mixed
     */
    public function all()
    {
        return $this->repository->all();
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function getOne($id)
    {
        return $this->repository->get($id);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->repository->add($data);
    }

    /**
     * @param $data
     * @param $id
     * @return mixed
     */
    public function update($data, $id)
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
     * @param $organizationId
     * @return array
     */
    public function getList($organizationId)
    {
        return $this->repository->getList($organizationId);
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
