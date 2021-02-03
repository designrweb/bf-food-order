<?php

namespace App\Services;

use App\Http\Resources\MenuCategoryCollection;
use App\Http\Resources\MenuCategoryResource;
use App\Repositories\MenuCategoryRepository;
use bigfood\grid\BaseModelService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\MenuCategory;

/**
 * Class MenuCategoryService
 *
 * @package App\Services
 */
class MenuCategoryService extends BaseModelService
{

    protected $repository;

    public function __construct(MenuCategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return MenuCategoryCollection
     */
    public function all()
    {
        return $this->repository->all();
    }

    /**
     * Returns single product transformed to resource
     *
     * @param $id
     * @return MenuCategoryResource
     * @throws ModelNotFoundException
     */
    public function getOne($id): MenuCategoryResource
    {
        return $this->repository->get($id);
    }

    /**
     * Creates and returns the menu_categories model
     *
     * @param $data
     * @return MenuCategoryResource
     */
    public function create($data): MenuCategoryResource
    {
        return $this->repository->add($data);
    }

    /**
     * Updates and returns the menu_categories model
     *
     * @param $data
     * @param $id
     * @return MenuCategoryResource
     * @throws ModelNotFoundException
     */
    public function update($data, $id): MenuCategoryResource
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
    public function getList()
    {
        return $this->repository->getList();
    }

    /**
     * @return MenuCategory[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getModelList()
    {
        return $this->repository->getModelList();
    }

    /**
     * @return array
     */
    public function getIndexStructure(): array
    {
        return $this->getFullStructure((new MenuCategory()));
    }

    /**
     * @return array
     */
    public function getViewStructure(): array
    {
        return $this->getSimpleStructure((new MenuCategory()));
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
                'label' => __('menu-category.Name')
            ],
            [
                'key'   => 'category_order',
                'label' => __('menu-category.Category Order')
            ],
            [
                'key'   => 'presaleprice_locale',
                'label' => __('menu-category.Presale Price')
            ],
            [
                'key'   => 'price_locale',
                'label' => __('menu-category.Price')
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
                'key'   => 'name',
                'label' => __('menu-category.Name')
            ],
            [
                'key'   => 'category_order',
                'label' => __('menu-category.Category Order')
            ],
            [
                'key'   => 'presaleprice_locale',
                'label' => __('menu-category.Presale Price')
            ],
            [
                'key'   => 'price_locale',
                'label' => __('menu-category.Price')
            ]
        ];
    }

    /**
     * @param Model $model
     * @return array
     */
    protected function getFilters(Model $model): array
    {
        return [
            'name'                => '',
            'category_order'      => '',
            'presaleprice_locale' => '',
            'price_locale'        => '',
        ];
    }

    /**
     * @param Model $model
     * @return array
     */
    protected function getSortFields(Model $model): array
    {
        return [
            'name'                => '',
            'category_order'      => '',
            'presaleprice_locale' => '',
            'price_locale'        => '',
        ];
    }
}
