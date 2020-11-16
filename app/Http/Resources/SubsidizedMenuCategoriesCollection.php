<?php

namespace App\Http\Resources;

use App\Helpers\DateFormatter;
use App\SubsidizedMenuCategories;
use Carbon\Carbon;
use bigfood\grid\PaginatableCollection;

/**
 * Class SubsidizedMenuCategoriesCollection
 *
 * @package App\Http\Resources
 */
class SubsidizedMenuCategoriesCollection extends PaginatableCollection
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
            'data'       => $this->collection->transform(function (SubsidizedMenuCategories $item) {
                return $item->toArray();
            }),
            'pagination' => $this->pagination
        ];
    }
}
