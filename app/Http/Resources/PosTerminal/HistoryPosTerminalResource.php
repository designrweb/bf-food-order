<?php

namespace App\Http\Resources\PosTerminal;

use App\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class HistoryPosTerminalResource extends JsonResource
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
            "foodorder_id" => $this->id,
            "type"         => Order::TYPES[$this->type],
            "menuitem"     => $this->menuItem->name,
            "categoryName" => $this->menuItem->menuCategory->name,
            "quantity"     => $this->quantity,
            "total"        => $this->type === Order::TYPE_PRE_ORDER ?
                $this->menuItem->menuCategory->presaleprice * $this->quantity :
                $this->menuItem->menuCategory->price * $this->quantity,
            "consumer"     => $this->consumer ?
                sprintf('%s %s', $this->consumer->firstname, $this->consumer->lastname) :
                'Anonim',
            "pickedup_at"  => date('H:i', strtotime($this->pickedup_at))
        ];
    }
}
