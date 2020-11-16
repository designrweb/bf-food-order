<?php
namespace App\Services;

use App\Http\Resources\SubsidizedMenuCategoriesCollection;
use App\Http\Resources\SubsidizedMenuCategoriesResource;
use App\Repositories\SubsidizedMenuCategoriesRepository;
use bigfood\grid\BaseModelService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\SubsidizedMenuCategories;


class SubsidizedMenuCategoriesService extends BaseModelService
{

    protected $repository;

    public function __construct(SubsidizedMenuCategoriesRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Returns all subsidized_menu_categories transformed to resource
     *
     * @return SubsidizedMenuCategoriesCollection
     */
    public function all(): SubsidizedMenuCategoriesCollection
    {
         return $this->repository->all();
    }

    /**
     * Returns single product transformed to resource
     *
     * @param $id
     * @return SubsidizedMenuCategoriesResource
     * @throws ModelNotFoundException
     */
    public function getOne($id): SubsidizedMenuCategoriesResource
    {
        return $this->repository->get($id);
    }

    /**
     * Creates and returns the subsidized_menu_categories model
     *
     * @param $data
     * @return SubsidizedMenuCategoriesResource
     */
    public function create($data): SubsidizedMenuCategoriesResource
    {
        return $this->repository->add($data);
    }

    /**
     * Updates and returns the subsidized_menu_categories model
     *
     * @param $data
     * @param $id
     * @return SubsidizedMenuCategoriesResource
     * @throws ModelNotFoundException
     */
    public function update($data, $id): SubsidizedMenuCategoriesResource
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
        return $this->getFullStructure((new SubsidizedMenuCategories()));
    }

     /**
     * @return array
     */
    public function getViewStructure(): array
    {
        return $this->getSimpleStructure((new SubsidizedMenuCategories()));
    }
}
