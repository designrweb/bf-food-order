<?php

namespace App\Http\Resources;

use App\Location;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationGroupResource extends JsonResource
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
            'id'            => $this->id,
            'name'          => $this->name,
            'location_id'   => $this->location_id,
            'locationsList' => Location::getLocationsList(),
        ];
    }
}
