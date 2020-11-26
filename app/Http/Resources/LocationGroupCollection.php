<?php

namespace App\Http\Resources;

use App\Helpers\DateFormatter;
use App\LocationGroup;
use Carbon\Carbon;
use bigfood\grid\PaginatableCollection;

/**
 * Class LocationGroupCollection
 *
 * @package App\Http\Resources
 */
class LocationGroupCollection extends PaginatableCollection
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
            'data'       => $this->collection->transform(function (LocationGroup $item) {
                return [
                    'id'                 => $item->id,
                    'name'               => $item->name,
                    'location_id'        => $item->location->name,
                    'number_of_students' => $item->consumers->count()
                ];
            }),
            'pagination' => $this->pagination
        ];
    }
}
