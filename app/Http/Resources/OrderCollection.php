<?php

namespace App\Http\Resources;

use App\Order;
use bigfood\grid\PaginatableCollection;
use Carbon\Carbon;

/**
 * Class OrderCollection
 *
 * @package App\Http\Resources
 */
class OrderCollection extends PaginatableCollection
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
            'data'       => $this->collection->transform(function (Order $item) {
                $data = $item->toArray();

                $data['day']         = date('l, d.m.Y', strtotime($item->day));
                $data['day_machine'] = Carbon::parse($item->day)->toDateString();

                return $data;
            }),
            'pagination' => $this->pagination
        ];
    }
}
