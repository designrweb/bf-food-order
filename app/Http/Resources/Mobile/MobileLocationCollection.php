<?php

namespace App\Http\Resources\Mobile;

use App\Location;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class MobileLocationCollection
 *
 * @package App\Http\Resources\Mobile
 */
class MobileLocationCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->resource->transform(function (Location $item) {
            return $item->toArray();
        });
    }
}