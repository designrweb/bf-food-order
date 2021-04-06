<?php

namespace App\Http\Resources;

use App\Helpers\DateFormatter;
use App\CateringCategory;
use Carbon\Carbon;
use bigfood\grid\PaginatableCollection;

/**
 * Class CateringCategoryCollection
 *
 * @package App\Http\Resources
 */
class CateringCategoryCollection extends PaginatableCollection
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
            'data'       => $this->collection->transform(function (CateringCategory $item) {
                return $item->toArray();
            }),
            'pagination' => $this->pagination
        ];
    }
}
