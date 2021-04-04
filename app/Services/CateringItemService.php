<?php

namespace App\Services;

use App\Http\Resources\CateringItemCollection;
use App\Http\Resources\CateringItemResource;
use App\Repositories\CateringItemRepository;
use bigfood\grid\BaseModelService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\CateringItem;

/**
 * Class CateringItemService
 *
 * @package App\Services
 */
class CateringItemService extends BaseModelService
{

    /**
     * @var CateringItemRepository
     */
    protected $repository;

    /**
     * @var CateringCategoryService
     */
    private $cateringCategoryService;

    /**
     * CateringItemService constructor.
     *
     * @param CateringItemRepository  $repository
     * @param CateringCategoryService $cateringCategoryService
     */
    public function __construct(CateringItemRepository $repository, CateringCategoryService $cateringCategoryService)
    {
        $this->repository              = $repository;
        $this->cateringCategoryService = $cateringCategoryService;
    }

    /**
     * Returns all catering_items transformed to resource
     *
     * @return CateringItemCollection
     */
    public function all(): CateringItemCollection
    {
        return $this->repository->all();
    }

    /**
     * Returns single product transformed to resource
     *
     * @param $id
     * @return CateringItemResource
     * @throws ModelNotFoundException
     */
    public function getOne($id): CateringItemResource
    {
        return $this->repository->get($id);
    }

    /**
     * Creates and returns the catering_items model
     *
     * @param $data
     * @return CateringItemResource
     */
    public function create($data): CateringItemResource
    {
        return $this->repository->add($data);
    }

    /**
     * Updates and returns the catering_items model
     *
     * @param $data
     * @param $id
     * @return CateringItemResource
     * @throws ModelNotFoundException
     */
    public function update($data, $id): CateringItemResource
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
        return $this->getFullStructure((new CateringItem()));
    }

    /**
     * @return array
     */
    public function getViewStructure(): array
    {
        return $this->getSimpleStructure((new CateringItem()));
    }

    /**
     * @return array
     */
    public function getStatusList()
    {
        return $this->repository->getStatusList();
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
                'label' => __('catering-item.Name')
            ],
            [
                'key'   => 'description',
                'label' => __('catering-item.Description')
            ],
            [
                'key'   => 'catering_category.name',
                'label' => __('catering-item.Catering Category')
            ],
            [
                'key'   => 'status_human',
                'label' => __('app.Status')
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
                'label' => __('catering-item.Name')
            ],
            [
                'key'   => 'catering_category.name',
                'label' => __('catering-item.Catering Category')
            ],
            [
                'key'   => 'status_human',
                'label' => __('app.Status')
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
            'name'                   => '',
            'catering_category.name' => [
                'values' => $this->cateringCategoryService->getList(),
                'filter' => '',
                'type'   => 'select',
            ],
            'status_human'           => [
                'values' => $this->repository->getStatusList(),
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
            'name'                   => '',
            'catering_category.name' => '',
            'status_human'           => '',
        ];
    }
}
