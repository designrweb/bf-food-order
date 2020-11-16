<?php

namespace App\Http\Resources;

use App\Helpers\DateFormatter;
use App\VacationLocationGroup;
use Carbon\Carbon;
use bigfood\grid\PaginatableCollection;

/**
 * Class VacationLocationGroupCollection
 *
 * @package App\Http\Resources
 */
class VacationLocationGroupCollection extends PaginatableCollection
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
            'data'       => $this->collection->transform(function (VacationLocationGroup $item) {
                return $item->toArray();
            }),
            'pagination' => $this->pagination
        ];
    }
}
