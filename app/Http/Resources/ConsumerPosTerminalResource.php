<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConsumerPosTerminalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            "consumer_id"              => $this->id,
            "firstname"                => $this->firstname,
            "lastname"                 => $this->lastname,
            "coefficient"              => $this->balance,
            "locationGroup"            => $this->locationgroup->name,
            "image"                    => $this->imageurl ? sprintf('uploads/%s', $this->imageurl) : null,
            "preOrderedItems"          => ConsumerOrdersPosTerminalResource::collection($this->preOrderedItems),
            "pickedUpPreOrderedItems"  => ConsumerOrdersPosTerminalResource::collection($this->pickedUpPreOrderedItems),
            "pickedUpPosOrderedItems"  => ConsumerOrdersPosTerminalResource::collection($this->pickedUpPosOrderedItems),
            "subsidizedMenuCategories" => [],
        ];
    }
}
