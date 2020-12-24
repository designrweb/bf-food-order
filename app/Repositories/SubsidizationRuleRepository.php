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
     * @return mixed
     */
    public function all()
    {
        return app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                SubsidizationRuleSearch::class,
            ])
            ->thenReturn()
            ->with('subsidizationOrganization')
            ->paginate(request('itemsPerPage') ?? 10);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param array $data
     * @param       $id
     * @return mixed
     */
    public function update(array $data, $id)
    {
        $model = $this->model->findOrFail($id);
        $model->update($data);

        return $model;
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
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function get($id)
    {
        return $this->model->with(['subsidizationOrganization', 'subsidizedMenuCategories.menuCategory'])->findOrFail($id);
    }

    /**
     * @param null $organizationId
     * @return array
     */
    public function getList($organizationId = null)
    {
        $subsidizationRulesArray = [];
        $allSubsidizationRules   = $this->model->newQuery();

        if (!empty($organizationId)) {
            $allSubsidizationRules = $allSubsidizationRules->where('subsidization_organization_id', $organizationId);
        }

        $allSubsidizationRules = $allSubsidizationRules->get();

        foreach ($allSubsidizationRules as $rules) {
            $subsidizationRulesArray[] = [
                'id'   => $rules->id,
                'name' => $rules->rule_name,
            ];
        }

        return $subsidizationRulesArray;
    }
}
