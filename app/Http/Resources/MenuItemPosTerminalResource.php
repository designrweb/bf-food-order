<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuItemPosTerminalResource extends JsonResource
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
            'menuitem_id'           => $this->id,
            'categoryId'            => $this->menuCategory->id,
            'categoryName'          => $this->menuCategory->name,
            'name'                  => $this->name,
            'price'                 => $this->menuCategory->price,
            'description'           => $this->description,
            'availability_date'     => $this->availability_date,
            'countPickedItems'      => $this->count_picked_items,
            'countPreOrderedItems'  => $this->count_pre_ordered_items,
            'countSpontaneousItems' => $this->count_spontaneous_items
        ];
    }
}
