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
            'menuitem_id'      => $this->menuItem->id,
            'menu_category_id' => $this->menuItem->menuCategory->id,
            'name'             => $this->menuItem->name,
            'categoryName'     => $this->menuItem->menuCategory->name,
            'description'      => $this->menuItem->description,
            'price'            => $this->menuItem->menuCategory->price,
            'type'             => Order::TYPES[$this->type],
            'quantity'         => $this->quantity,
            'consumer_id'      => $this->consumer_id,
            'pickedup_at'      => $this->pickedup_at ? date('d.m.Y H:i', strtotime($this->pickedup_at)) : null,
            'is_subsidized'    => $this->is_subsidized,
        ];
    }
}
