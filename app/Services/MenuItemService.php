<?php
namespace App\Services;

use App\Http\Resources\MenuItemCollection;
use App\Http\Resources\MenuItemResource;
use App\Repositories\MenuItemRepository;
use bigfood\grid\BaseModelService;
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
}
