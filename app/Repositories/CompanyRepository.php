<?php

namespace App\Repositories;

use App\Http\Resources\CompanyCollection;
use App\Http\Resources\CompanyResource;
use App\Company;
use App\QueryBuilders\CompanySearch;
use Illuminate\Pipeline\Pipeline;
use bigfood\grid\RepositoryInterface;

class CompanyRepository implements RepositoryInterface
{
    /** @var Company */
    protected $model;

    public function __construct(Company $model)
    {
        $this->model = $model;
    }

    /**
     * @return CompanyCollection
     */
    public function all()
    {
        return new CompanyCollection(app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                CompanySearch::class,
            ])
            ->thenReturn()
            ->paginate(request('itemsPerPage') ?? 10));
    }

    /**
     * @param array $data
     * @return CompanyResource
     */
    public function add(array $data)
    {
        return new CompanyResource($this->model->create($data));
    }

    /**
     * @param array $data
     * @param       $id
     * @return CompanyResource
     */
    public function update(array $data, $id)
    {
        $model = $this->model->findOrFail($id);
        $model->update($data);

        return new CompanyResource($model);
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
     * @return CompanyResource
     */
    public function get($id)
    {
        return new CompanyResource($this->model->findOrFail($id));
    }

    /**
     * @return array
     */
    public function getList()
    {
        $companiesArray = [];
        $allCompanies   = $this->model::all();

        foreach ($allCompanies as $company) {
            $companiesArray[] = [
                'id'   => $company->id,
                'name' => $company->name,
            ];
        }

        return $companiesArray;
    }
}
