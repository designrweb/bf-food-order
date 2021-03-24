<?php

namespace App\Http\Resources\Mobile;

use App\Order;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class MobileOrderCollection
 *
 * @package App\Http\Resources\Mobile
 */
class MobileOrderCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->resource->transform(function (Order $item) {

            $data = $item->toArray();

            $data['menu_category_name'] = $item->menuItem->menuCategory->name;
            $data['menu_item_description'] = $item->menuItem->description;
            $data['menu_item_name'] = $item->menuItem->name;
            $data['price'] = $item->menuItem->menuCategory->price * $item->quantity;

            return $data;
        });
    }
}