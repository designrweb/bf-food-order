<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VacationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                  => $this->id,
            'name'                => $this->name,
            'start_date'          => $this->start_date,
            'end_date'            => $this->end_date,
            'location_name'       => $this->locationGroups->first()->locationGroup->location->name,
            'location_group_name' => $this->locationGroups->implode('locationGroup.name', ', '),
            'location_id'         => $this->locationGroups->first()->locationGroup->location->id,
            'location_group_id'   => $this->locationGroups->pluck('locationGroup.id')->toArray() ?? [],
        ];
    }
}
