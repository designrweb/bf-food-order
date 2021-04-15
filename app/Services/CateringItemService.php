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
     * @return mixed
     */
    public function all()
    {
        return $this->repository->all();
    }

    /**
     * @return mixed
     */
    public function getAllForPos()
    {
        return $this->repository->getAllForPos();
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

    /**
     * Returns allowed actions for the front-end part
     *
     * @return array
     */
    protected function getAllowActions()
    {
        return [
            'all'    => true,
            'create' => true,
            'view'   => true,
            'edit'   => true,
            'delete' => false,
        ];
    }
}
