<?php

namespace App\Http\Resources;

use App\MenuCategory;
use bigfood\grid\PaginatableCollection;

/**
 * Class MenuCategoryCollection
 *
 * @package App\Http\Resources
 */
class MenuCategoryCollection extends PaginatableCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data'       => $this->collection->transform(function (MenuCategory $item) {
                $data = $item->toArray();

                $data['price_locale'] = $item->price_locale == '0,00' ? __('menu-category.Not Available for POS') : $item->price_locale;

                return $data;
            }),
            'pagination' => $this->pagination
        ];
    }
}
