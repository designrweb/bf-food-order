<?php

namespace App\Services;

use App\Repositories\MenuItemRepository;
use bigfood\grid\BaseModelService;
use Illuminate\Database\Eloquent\Model;
use App\MenuItem;

/**
 * Class MenuItemService
 *
 * @package App\Services
 */
class MenuItemService extends BaseModelService
{

    protected $repository;

    /**
     * MenuItemService constructor.
     *
     * @param MenuItemRepository $repository
     */
    public function __construct(MenuItemRepository $repository)
    {
        $this->repository = $repository;
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
     * @param $id
     * @return Model
     */
    public function replicate($id)
    {
        return $this->repository->replicate($id);
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
     * @param array $data
     * @return mixed
     */
    public function getCountExistingMenuItems(array $data)
    {
        return $this->repository->getCountExistingMenuItems($data);
    }

    /**
     * @return array
     */
    public function getIndexStructure(): array
    {
        return $this->getFullStructure((new MenuItem()));
    }

    /**
     * @return array
     */
    public function getViewStructure(): array
    {
        return $this->getSimpleStructure((new MenuItem()));
    }

    /**
     * @return bool[]
     */
    protected function getAllowActions()
    {
        return [
            'all'    => true,
            'create' => true,
            'view'   => true,
            'edit'   => true,
            'delete' => true,
            'copy'   => true,
        ];
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
                'label' => __('app.Name')
            ],
            [
                'key'   => 'description',
                'label' => __('menu-item.Description')
            ],
            [
                'key'   => 'menu_category.presaleprice_locale',
                'label' => __('menu-category.Presale Price')
            ],
            [
                'key'   => 'menu_category.price_locale',
                'label' => __('menu-category.Price')
            ],
            [
                'key'   => 'menu_category.name',
                'label' => __('menu-category.Menu Category')
            ],
            [
                'key'   => 'availability_date_human',
                'label' => __('menu-item.Availability Date')
            ],
            [
                'key'   => 'location.name',
                'label' => __('location.Location')
            ]
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
                'label' => __('app.Name')
            ],
            [
                'key'   => 'menu_category.presaleprice_locale',
                'label' => __('menu-category.Presale Price')
            ],
            [
                'key'   => 'menu_category.price_locale',
                'label' => __('menu-category.Price')
            ],
            [
                'key'   => 'menu_categories_name',
                'label' => __('menu-category.Menu Category')
            ],
            [
                'key'   => 'availability_date_human',
                'label' => __('menu-item.Availability Date')
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
            'name'                              => '',
            'menu_category.presaleprice_locale' => '',
            'menu_category.price_locale'        => '',
            'menu_categories_name'              => '',
            'availability_date_human'           => '',
        ];
    }

    /**
     * @param Model $model
     * @return array
     */
    protected function getSortFields(Model $model): array
    {
        return [
            'name'                              => '',
            'menu_category.presaleprice_locale' => '',
            'menu_category.price_locale'        => '',
            'menu_categories_name'              => '',
            'availability_date_human'           => '',
        ];
    }
}
