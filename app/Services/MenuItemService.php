<?php

namespace App\Services;

use App\Http\Resources\MenuItemCollection;
use App\Http\Resources\MenuItemResource;
use App\Repositories\MenuItemRepository;
use bigfood\grid\BaseModelService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\MenuItem;


class MenuItemService extends BaseModelService
{

    protected $repository;

    public function __construct(MenuItemRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Returns all menu_items transformed to resource
     *
     * @return MenuItemCollection
     */
    public function all(): MenuItemCollection
    {
        return $this->repository->all();
    }

    /**
     * Returns single product transformed to resource
     *
     * @param $id
     * @return MenuItemResource
     * @throws ModelNotFoundException
     */
    public function getOne($id): MenuItemResource
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
     * Creates and returns the menu_items model
     *
     * @param $data
     * @return MenuItemResource
     */
    public function create($data): MenuItemResource
    {
        return $this->repository->add($data);
    }

    /**
     * Updates and returns the menu_items model
     *
     * @param $data
     * @param $id
     * @return MenuItemResource
     * @throws ModelNotFoundException
     */
    public function update($data, $id): MenuItemResource
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
                'label' => 'Name'
            ],
            [
                'key'   => 'description',
                'label' => 'Description'
            ],
            [
                'key'   => 'menu_category.presaleprice_locale',
                'label' => 'Presale Price'
            ],
            [
                'key'   => 'menu_category.price_locale',
                'label' => 'Price'
            ],
            [
                'key'   => 'menu_category.name',
                'label' => 'Menu Category'
            ],
            [
                'key'   => 'availability_date_human',
                'label' => 'Availability Date'
            ],
            [
                'key'   => 'location.name',
                'label' => 'Location'
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
                'label' => 'Name'
            ],
            [
                'key'   => 'menu_category.presaleprice_locale',
                'label' => 'Presale Price'
            ],
            [
                'key'   => 'menu_category.price_locale',
                'label' => 'Price'
            ],
            [
                'key'   => 'menu_categories_name',
                'label' => 'Menu Category'
            ],
            [
                'key'   => 'availability_date_human',
                'label' => 'Availability Date'
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
