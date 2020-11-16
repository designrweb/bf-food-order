<?php

namespace App\Http\Resources;

use App\Helpers\DateFormatter;
use App\MenuCategory;
use Carbon\Carbon;
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
                return $item->toArray();
            }),
            'pagination' => $this->pagination
        ];
    }
}
