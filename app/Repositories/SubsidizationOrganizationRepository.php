<?php

namespace App\Repositories;

use App\Http\Resources\SubsidizationOrganizationCollection;
use App\Http\Resources\SubsidizationOrganizationResource;
use App\SubsidizationOrganization;
use App\QueryBuilders\SubsidizationOrganizationSearch;
use Illuminate\Pipeline\Pipeline;
use bigfood\grid\RepositoryInterface;

class SubsidizationOrganizationRepository implements RepositoryInterface
{
    /** @var SubsidizationOrganization */
    protected $model;

    public function __construct(SubsidizationOrganization $model)
    {
        $this->model = $model;
    }

    /**
     * @return SubsidizationOrganizationCollection
     */
    public function all()
    {
        return new SubsidizationOrganizationCollection(app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                SubsidizationOrganizationSearch::class,
            ])
            ->thenReturn()
            ->with('company')
            ->paginate(request('itemsPerPage') ?? 10));
    }

    /**
     * @param array $data
     * @return SubsidizationOrganizationResource
     */
    public function add(array $data)
    {
        return new SubsidizationOrganizationResource($this->model->create($data));
    }

    /**
     * @param array $data
     * @param       $id
     * @return SubsidizationOrganizationResource
     */
    public function update(array $data, $id)
    {
        $model = $this->model->findOrFail($id);
        $model->update($data);

        return new SubsidizationOrganizationResource($model);
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
     * @return SubsidizationOrganizationResource
     */
    public function get($id)
    {
        return new SubsidizationOrganizationResource($this->model->with('company')->findOrFail($id));
    }
}
