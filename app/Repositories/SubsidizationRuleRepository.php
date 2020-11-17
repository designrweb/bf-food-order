<?php

namespace App\Repositories;

use App\Http\Resources\SubsidizationRuleCollection;
use App\Http\Resources\SubsidizationRuleResource;
use App\SubsidizationRule;
use App\QueryBuilders\SubsidizationRuleSearch;
use Illuminate\Pipeline\Pipeline;
use bigfood\grid\RepositoryInterface;

class SubsidizationRuleRepository implements RepositoryInterface
{
    /** @var SubsidizationRule */
    protected $model;

    public function __construct(SubsidizationRule $model)
    {
        $this->model = $model;
    }

    /**
     * @return SubsidizationRuleCollection
     */
    public function all()
    {
        return new SubsidizationRuleCollection(app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                SubsidizationRuleSearch::class,
            ])
            ->thenReturn()
            ->paginate(request('itemsPerPage') ?? 10));
    }

    /**
     * @param array $data
     * @return SubsidizationRuleResource
     */
    public function add(array $data)
    {
        return new SubsidizationRuleResource($this->model->create($data));
    }

    /**
     * @param array $data
     * @param       $id
     * @return SubsidizationRuleResource
     */
    public function update(array $data, $id)
    {
        $model = $this->model->findOrFail($id);
        $model->update($data);

        return new SubsidizationRuleResource($model);
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * @param       $id
     * @return SubsidizationRuleResource
     */
    public function get($id)
    {
        return new SubsidizationRuleResource($this->model->findOrFail($id));
    }
}
