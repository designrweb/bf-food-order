<?php

namespace App\Http\Resources;

use App\PaymentDump;
use bigfood\grid\PaginatableCollection;

/**
 * Class PaymentDumpCollection
 *
 * @package App\Http\Resources
 */
class PaymentDumpCollection extends PaginatableCollection
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
            'data'       => $this->collection->transform(function (PaymentDump $item) {
                return $item->toArray();
            }),
            'pagination' => $this->pagination
        ];
    }
}
