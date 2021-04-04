<?php

namespace App\Services;

use App\Http\Resources\CateringCategoryCollection;
use App\Http\Resources\CateringCategoryResource;
use App\Repositories\CateringCategoryRepository;
use bigfood\grid\BaseModelService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
     * Returns all catering_categories transformed to resource
     *
     * @return CateringCategoryCollection
     */
    public function all(): CateringCategoryCollection
    {
        return $this->repository->all();
    }

    /**
     * Returns single product transformed to resource
     *
     * @param $id
     * @return CateringCategoryResource
     * @throws ModelNotFoundException
     */
    public function getOne($id): CateringCategoryResource
    {
        return $this->repository->get($id);
    }

    /**
     * Creates and returns the catering_categories model
     *
     * @param $data
     * @return CateringCategoryResource
     */
    public function create($data): CateringCategoryResource
    {
        return $this->repository->add($data);
    }

    /**
     * Updates and returns the catering_categories model
     *
     * @param $data
     * @param $id
     * @return CateringCategoryResource
     * @throws ModelNotFoundException
     */
    public function update($data, $id): CateringCategoryResource
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
