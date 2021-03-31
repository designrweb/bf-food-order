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
    /** @var MenuCategoryRepository */
    protected $repository;
    /**
     * @var ConsumerService
     */
    private $consumerService;

    public function __construct(MenuCategoryRepository $repository, ConsumerService $consumerService)
    {
        $this->repository      = $repository;
        $this->consumerService = $consumerService;
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
     * @param $id
     * @return MenuCategoryResource
     */
    public function getByLocationId($id)
    {
        $categories = $this->repository->getByLocationId($id);

        //@todo - change this to avoid query db in loop
        foreach ($categories as $category) {
            $category->is_allow_for_subsidization = $category->isAllowSubsidization($this->consumerService->getCurrentConsumer());
        }

        return $categories;
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
                'key'   => 'tax_rate',
                'label' => __('menu-category.Tax')
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
            ],
            [
                'key'   => 'location.name',
                'label' => __('menu-category.Location')
            ],
            [
                'key'   => 'tax_rate',
                'label' => __('menu-category.Tax')
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
            'location.name'       => '',
            'tax_rate'            => [
                'values' => $this->getTaxRates(),
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
            'name'                => '',
            'category_order'      => '',
            'presaleprice_locale' => '',
            'price_locale'        => '',
            'tax_rate'            => '',
        ];
    }

    /**
     * @return mixed
     */
    public function getTaxRates()
    {
        return $this->repository->getTaxRates();
    }
}
