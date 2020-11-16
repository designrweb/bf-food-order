<?php
namespace App\Services;

use App\Http\Resources\MenuCategoryCollection;
use App\Http\Resources\MenuCategoryResource;
use App\Repositories\MenuCategoryRepository;
use bigfood\grid\BaseModelService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\MenuCategory;


class MenuCategoryService extends BaseModelService
{

    protected $repository;

    public function __construct(MenuCategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Returns all menu_categories transformed to resource
     *
     * @return MenuCategoryCollection
     */
    public function all(): MenuCategoryCollection
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
}
