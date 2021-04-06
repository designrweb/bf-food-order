<?php

namespace App\Services;

use App\Repositories\CateringCategoryRepository;
use bigfood\grid\BaseModelService;
use Illuminate\Database\Eloquent\Model;
use App\CateringCategory;


class CateringCategoryService extends BaseModelService
{

    /**
     * @var CateringCategoryRepository
     */
    protected $repository;

    /**
     * @var LocationService
     */
    private $locationService;

    /**
     * CateringCategoryService constructor.
     *
     * @param CateringCategoryRepository $repository
     * @param LocationService            $locationService
     */
    public function __construct(CateringCategoryRepository $repository, LocationService $locationService)
    {
        $this->repository      = $repository;
        $this->locationService = $locationService;
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
        return $this->getFullStructure((new CateringCategory()));
    }

    /**
     * @return array
     */
    public function getViewStructure(): array
    {
        return $this->getSimpleStructure((new CateringCategory()));
    }

    /**
     * @return array
     */
    public function getList()
    {
        return $this->repository->getList();
    }

    /**
     * @param Model $model
     * @return array[]
     */
    protected function getViewFieldsLabels(Model $model): array
    {
        return [
            [
                'key'   => 'name',
                'label' => __('catering-category.Name')
            ],
            [
                'key'   => 'location.name',
                'label' => __('catering-category.Location')
            ],
            [
                'key'   => 'created_at_human',
                'label' => __('app.Created At')
            ],
            [
                'key'   => 'updated_at_human',
                'label' => __('app.Updated At')
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
                'label' => __('catering-category.Name')
            ],
            [
                'key'   => 'location.name',
                'label' => __('catering-category.Location')
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
            'name'          => '',
            'location.name' => [
                'values' => $this->locationService->getList(),
                'filter' => '',
                'type'   => 'select',
            ],
        ];
    }

    /**
     * @param Model $model
     * @return array
     */
    protected function getSortFields(Model $model): array
    {
        return [
            'name'          => '',
            'location.name' => '',
        ];
    }
}
