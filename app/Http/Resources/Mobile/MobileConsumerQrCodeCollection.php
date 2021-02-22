<?php

namespace App\Http\Resources\Mobile;

use App\ConsumerQrCode;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ConsumerQrCodeCollection
 *
 * @package App\Http\Resources\Mobile
 */
class MobileConsumerQrCodeCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->resource->transform(function (ConsumerQrCode $item) {
            return $item->toArray();
        });
    }
}