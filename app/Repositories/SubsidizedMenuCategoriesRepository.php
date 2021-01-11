<?php

namespace App\Repositories;

use App\MenuCategory;
use App\Services\MenuCategoryService;
use App\SubsidizedMenuCategories;
use App\QueryBuilders\SubsidizedMenuCategoriesSearch;
use Illuminate\Pipeline\Pipeline;

class SubsidizedMenuCategoriesRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model(): string
    {
        return SubsidizedMenuCategories::class;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                SubsidizedMenuCategoriesSearch::class,
            ])
            ->thenReturn()
            ->paginate(request('itemsPerPage') ?? 10);
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
            $resultedPrice      = round($menu->presaleprice - round($menu->presaleprice * ($percent / 100), 2), 2);

            $SubsidizationMenuCategoriesArray[$menu->id] = [
                'id'                  => $menu->id,
                'name'                => $menu->name,
                'presaleprice'        => $menu->presaleprice,
                'price'               => $menu->price,
                'subsidization_price' => str_replace('.', ',', $subsidizationPrice),
                'percent'             => $percent / 100,
                'percent_full'        => $percent,
                'resulted_price'      => $resultedPrice,
            ];
        }

        return $SubsidizationMenuCategoriesArray;
    }

    /**
     * @param $menuCategoryId
     * @param $subsidizationRuleId
     * @return mixed
     */
    // todo refactor this
    public function getMenuCategoryWithSubsidization($menuCategoryId, $subsidizationRuleId)
    {
        return $this->model
            ->where('menu_category_id', $menuCategoryId)
            ->where('subsidization_rules_id', $subsidizationRuleId)
            ->first();
    }
}
