<?php

namespace App\Http\Resources;

use App\Helpers\DateFormatter;
use App\ConsumerQrCode;
use Carbon\Carbon;
use bigfood\grid\PaginatableCollection;

/**
 * Class ConsumerQrCodeCollection
 *
 * @package App\Http\Resources
 */
class ConsumerQrCodeCollection extends PaginatableCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data'       => $this->collection->transform(function (ConsumerQrCode $item) {
                return $item->toArray();
            }),
            'pagination' => $this->pagination
        ];
    }
}
