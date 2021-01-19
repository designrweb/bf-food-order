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
                $data = $item->toArray();

                $data['status']       = PaymentDump::STATUSES[$item->status];
                $data['created_at']   = date('M d, Y, H:i:s A', strtotime($item->created_at));
                $data['updated_at']   = date('M d, Y, H:i:s A', strtotime($item->updated_at));
                $data['requested_at'] = date('M d, Y', strtotime($item->requested_at));

                return $data;
            }),
            'pagination' => $this->pagination
        ];
    }
}
