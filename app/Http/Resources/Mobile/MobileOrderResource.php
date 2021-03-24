<?php

namespace App\Http\Resources\Mobile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class MobileOrderResource
 *
 * @package App\Http\Resources\Mobile
 */
class MobileOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);

        $data['menu_category_name'] = $this->menuItem->menuCategory->name;
        $data['menu_item_description'] = $this->menuItem->description;
        $data['menu_item_name'] = $this->menuItem->name;
        $data['price'] = $this->menuItem->menuCategory->price * $this->quantity;

        return $data;
    }
}