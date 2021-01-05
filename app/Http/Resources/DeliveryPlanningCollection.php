<?php

namespace App\Http\Resources;

use App\Helpers\DateFormatter;
use App\Order;
use Carbon\Carbon;
use bigfood\grid\PaginatableCollection;

/**
 * Class DeliveryPlanningCollection
 *
 * @package App\Http\Resources
 */
class DeliveryPlanningCollection extends PaginatableCollection
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
                return $item->toArray();
            }),
            'pagination' => $this->pagination
        ];
    }
}
