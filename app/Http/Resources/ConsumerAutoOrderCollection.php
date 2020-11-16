<?php

namespace App\Http\Resources;

use App\Helpers\DateFormatter;
use App\ConsumerAutoOrder;
use Carbon\Carbon;
use bigfood\grid\PaginatableCollection;

/**
 * Class ConsumerAutoOrderCollection
 *
 * @package App\Http\Resources
 */
class ConsumerAutoOrderCollection extends PaginatableCollection
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
            'data'       => $this->collection->transform(function (ConsumerAutoOrder $item) {
                return $item->toArray();
            }),
            'pagination' => $this->pagination
        ];
    }
}
