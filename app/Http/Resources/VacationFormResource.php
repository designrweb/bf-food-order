<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class VacationFormResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $locationGroups = $this->locationGroups;

        return [
            'id'                  => $this->id,
            'name'                => $this->name,
            'start_date'          => Carbon::parse($this->start_date)->format('d.m.Y'),
            'end_date'            => Carbon::parse($this->end_date)->format('d.m.Y'),
            'location_name'       => $locationGroups->first()->locationGroup->location->name,
            'location_id'         => $locationGroups->first()->locationGroup->location->id,
            'location_group_id'   => $locationGroups->map(function ($locationGroup) {
                return ['id' => $locationGroup->location_group_id, 'name' => $locationGroup->locationGroup->name];
                })->toArray() ?? [],
        ];
    }
}
