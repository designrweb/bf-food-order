<?php

namespace App\Http\Resources;

use App\Helpers\DateFormatter;
use App\Vacation;
use Carbon\Carbon;
use bigfood\grid\PaginatableCollection;

/**
 * Class VacationCollection
 *
 * @package App\Http\Resources
 */
class VacationCollection extends PaginatableCollection
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
            'data'       => $this->collection->transform(function (Vacation $item) {
                return [
                    'id'                  => $item->id,
                    'name'                => $item->name,
                    'start_date'          => date('l, d.m.Y', strtotime($item->start_date)),
                    'end_date'            => date('l, d.m.Y', strtotime($item->end_date)),
                    'location_name'       => $item->locationGroups->first()->locationGroup->location->name,
                    'location_id'         => $item->locationGroups->first()->locationGroup->location->id,
                    'location_group_id'   => $item->locationGroups->pluck('locationGroup.id')->toArray(),
                    'location_group_name' => $item->locationGroups->implode('locationGroup.name', ', '),
                ];
            }),
            'pagination' => $this->pagination
        ];
    }
}
