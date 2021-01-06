<?php

namespace App\Repositories;

use App\Http\Resources\SubsidizedMenuCategoriesCollection;
use App\Http\Resources\SubsidizedMenuCategoriesResource;
use App\MenuCategory;
use App\Services\MenuCategoryService;
use App\SubsidizedMenuCategories;
use App\QueryBuilders\SubsidizedMenuCategoriesSearch;
use Illuminate\Pipeline\Pipeline;
use bigfood\grid\RepositoryInterface;

class SubsidizedMenuCategoriesRepository implements RepositoryInterface
{
    /** @var SubsidizedMenuCategories */
    protected $model;

    public function __construct(SubsidizedMenuCategories $model)
    {
        $this->model = $model;
    }

    /**
     * @return SubsidizedMenuCategoriesCollection
     */
    public function all()
    {
        return new SubsidizedMenuCategoriesCollection(app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                SubsidizedMenuCategoriesSearch::class,
            ])
            ->thenReturn()
            ->paginate(request('itemsPerPage') ?? 10));
    }

    /**
     * @param array $data
     * @return SubsidizedMenuCategoriesResource
     */
    public function add(array $data)
    {
        return new SubsidizedMenuCategoriesResource($this->model->create($data));
    }

    /**
     * @param array $data
     * @param       $id
     * @return SubsidizedMenuCategoriesResource
     */
    public function update(array $data, $id)
    {
        $model = $this->model->findOrFail($id);
        $model->update($data);

        return new SubsidizedMenuCategoriesResource($model);
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * @param       $id
     * @return SubsidizedMenuCategoriesResource
     */
    public function get($id)
    {
        return new SubsidizedMenuCategoriesResource($this->model->findOrFail($id));
    }


    /**
     * @param MenuCategoryService $menuCategoryService
     * @param null                $id
     * @return MenuCategory[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getSubsidizationMenuCategories(MenuCategoryService $menuCategoryService, $id = null)
    {
        $menuCategories                   = $menuCategoryService->getModelList();
        $SubsidizationMenuCategoriesArray = [];

        if (!empty($id)) {
            $menuCategoriesPercent = $this->model::where('subsidization_rules_id', $id)->pluck('percent', 'menu_category_id')->toArray();
        }

        foreach ($menuCategories as $menu) {
            $percent            = !empty($menuCategoriesPercent[$menu->id]) ? $menuCategoriesPercent[$menu->id] : 0;
            $subsidizationPrice = round($menu->presaleprice * ($percent / 100), 2);
            $resultedPrice      = round($menu->price - round($menu->presaleprice * ($percent / 100), 2), 2);

            $SubsidizationMenuCategoriesArray[$menu->id] = [
                'id'                  => $menu->id,
                'name'                => $menu->name,
                'presaleprice'        => $menu->presaleprice,
                'price'               => $menu->price,
                'subsidization_price' => $subsidizationPrice,
                'percent'             => $percent / 100,
                'percent_full'        => $percent,
                'resulted_price'      => $resultedPrice,
            ];
        }

        return $SubsidizationMenuCategoriesArray;
    }
}
