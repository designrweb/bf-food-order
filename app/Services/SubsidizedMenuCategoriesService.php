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

    /**
     * @var SubsidizedMenuCategoriesRepository
     */
    protected $repository;

    /**
     * @var SubsidizedMenuCategoriesRepository
     */
    protected $menuCategoryService;

    public function __construct(SubsidizedMenuCategoriesRepository $repository, MenuCategoryService $menuCategoryService)
    {
        $this->repository          = $repository;
        $this->menuCategoryService = $menuCategoryService;
    }

    /**
     * Returns all subsidized_menu_categories
     *
     * @return mixed
     */
    public function all()
    {
        return $this->repository->all();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getOne($id)
    {
        return $this->repository->get($id);
    }


    /**
     * Creates and returns the subsidized_menu_categories model
     *
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->repository->add($data);
    }

    /**
     * Updates and returns the subsidized_menu_categories model
     *
     * @param $data
     * @param $id
     * @return mixed
     * @throws ModelNotFoundException
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
        return $this->getFullStructure((new SubsidizedMenuCategories()));
    }

    /**
     * @return array
     */
    public function getViewStructure(): array
    {
        return $this->getSimpleStructure((new SubsidizedMenuCategories()));
    }

    /**
     * @param null $id
     * @return mixed
     */
    public function getSubsidizationMenuCategories($id = null)
    {
        return $this->repository->getSubsidizationMenuCategories($this->menuCategoryService, $id);
    }

    /**
     * Get subsidization information for menu category
     *
     * @param $menuCategoryId
     * @param $subsidizationRuleId
     * @return mixed
     */
    public function getMenuCategoryWithSubsidization($menuCategoryId, $subsidizationRuleId)
    {
        return $this->repository->getMenuCategoryWithSubsidization($menuCategoryId, $subsidizationRuleId);
    }
}
