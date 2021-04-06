<?php

namespace App\Http\Resources;

use App\Helpers\DateFormatter;
use App\CateringItem;
use Carbon\Carbon;
use bigfood\grid\PaginatableCollection;

/**
 * Class CateringItemCollection
 *
 * @package App\Http\Resources
 */
class CateringItemCollection extends PaginatableCollection
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
            'data'       => $this->collection->transform(function (CateringItem $item) {
                return $item->toArray();
            }),
            'pagination' => $this->pagination
        ];
    }
}
