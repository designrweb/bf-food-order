<?php

namespace App\Http\Resources;

use App\Helpers\DateFormatter;
use App\MenuItem;
use Carbon\Carbon;
use bigfood\grid\PaginatableCollection;

/**
 * Class MenuItemCollection
 *
 * @package App\Http\Resources
 */
class MenuItemCollection extends PaginatableCollection
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
            'data'       => $this->collection->transform(function (MenuItem $item) {
                return $item->toArray();
            }),
            'pagination' => $this->pagination
        ];
    }
}
