<?php

namespace App\Http\Resources;

use App\Helpers\DateFormatter;
use App\Payment;
use Carbon\Carbon;
use bigfood\grid\PaginatableCollection;

/**
 * Class PaymentCollection
 *
 * @package App\Http\Resources
 */
class PaymentCollection extends PaginatableCollection
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
            'data'       => $this->collection->transform(function (Payment $item) {
                return $item->toArray();
            }),
            'pagination' => $this->pagination
        ];
    }
}
