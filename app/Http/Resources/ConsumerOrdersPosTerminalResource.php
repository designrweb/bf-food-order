<?php

namespace App\Http\Resources;

use App\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsumerOrdersPosTerminalResource extends JsonResource
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
            'menuitem_id'      => $this->menuitem->menuitem_id,
            'menu_category_id' => $this->menuitem->menuCategory->id,
            'name'             => $this->menuitem->name,
            'categoryName'     => $this->menuitem->menuCategory->name,
            'description'      => $this->menuitem->description,
            'price'            => $this->menuitem->menuCategory->price,
            'type'             => Order::TYPES[$this->type],
            'quantity'         => $this->quantity,
            'consumer_id'      => $this->consumer_id,
            'pickedup_at'      => $this->pickedup_at ? date('d.m.Y H:i', strtotime($this->pickedup_at)) : null,
            'is_subsidized'    => $this->is_subsidized,
        ];
    }
}
