<?php

namespace App\Services;

use App\Http\Resources\CompanyCollection;
use App\Http\Resources\CompanyResource;
use App\Repositories\CompanyRepository;
use bigfood\grid\BaseModelService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Company;


class CompanyService extends BaseModelService
{

    protected $repository;
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(CompanyRepository $repository, UserService $userService)
    {
        $this->repository  = $repository;
        $this->userService = $userService;
    }

    /**
     * Returns all companies transformed to resource
     *
     * @return CompanyCollection
     */
    public function all(): CompanyCollection
    {
        return $this->repository->all();
    }

    /**
     * Returns single product transformed to resource
     *
     * @param $id
     * @return CompanyResource
     * @throws ModelNotFoundException
     */
    public function getOne($id): CompanyResource
    {
        return $this->repository->get($id);
    }

    /**
     * Creates and returns the companies model
     *
     * @param $data
     * @return CompanyResource
     */
    public function create($data): CompanyResource
    {
        return $this->repository->add($data);
    }

    /**
     * Updates and returns the companies model
     *
     * @param $data
     * @param $id
     * @return CompanyResource
     * @throws ModelNotFoundException
     */
    public function update($data, $id): CompanyResource
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
        return $this->getFullStructure((new Company()));
    }

    /**
     * @return array
     */
    public function getViewStructure(): array
    {
        return $this->getSimpleStructure((new Company()));
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        return $this->repository->getList();
    }

    /**
     * @param null $id
     * @return bool
     */
    public function switchCompany($id = null): bool
    {
        if (!$id) $id = $this->repository->getFirst()->id;

        return $this->userService->switchCompany($id);
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
                'label' => __('location-group.Group Name')
            ],
            [
                'key'   => 'zip',
                'label' => __('app.Zip')
            ],
            [
                'key'   => 'street',
                'label' => __('app.Street')
            ],
            [
                'key'   => 'city',
                'label' => __('app.City')
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
                'label' => __('location-group.Group Name')
            ],
            [
                'key'   => 'zip',
                'label' => __('app.Zip')
            ],
            [
                'key'   => 'street',
                'label' => __('app.Street')
            ],
            [
                'key'   => 'city',
                'label' => __('app.City')
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
            'name'   => '',
            'email'  => '',
            'zip'    => '',
            'street' => '',
            'city'   => '',
        ];
    }

    /**
     * @param Model $model
     * @return array
     */
    protected function getSortFields(Model $model): array
    {
        return [
            'id'     => '',
            'name'   => '',
            'email'  => '',
            'zip'    => '',
            'street' => '',
            'city'   => '',
        ];
    }
}
