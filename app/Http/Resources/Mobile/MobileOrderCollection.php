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
            return $item->toArray();
        });
    }
}