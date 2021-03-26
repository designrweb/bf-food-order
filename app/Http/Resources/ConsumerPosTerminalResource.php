<?php

namespace App\Http\Resources;

use App\Http\Resources\PosTerminal\SubsidizedMenuCategoriesPosTerminalResource;
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
            "image"                    => $this->imageurl,
            "preOrderedItems"          => ConsumerOrdersPosTerminalResource::collection($this->preOrderedItems),
            "pickedUpPreOrderedItems"  => ConsumerOrdersPosTerminalResource::collection($this->pickedUpPreOrderedItems),
            "pickedUpPosOrderedItems"  => ConsumerOrdersPosTerminalResource::collection($this->pickedUpPosOrderedItems),
            "subsidizedMenuCategories" => SubsidizedMenuCategoriesPosTerminalResource::collection($this->subsidizedMenuCategories),
        ];
    }
}
