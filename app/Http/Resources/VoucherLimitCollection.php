<?php

namespace App\Http\Resources;

use App\Helpers\DateFormatter;
use App\VoucherLimit;
use Carbon\Carbon;
use bigfood\grid\PaginatableCollection;

/**
 * Class VoucherLimitCollection
 *
 * @package App\Http\Resources
 */
class VoucherLimitCollection extends PaginatableCollection
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
            'data'       => $this->collection->transform(function (VoucherLimit $item) {
                return $item->toArray();
            }),
            'pagination' => $this->pagination
        ];
    }
}
