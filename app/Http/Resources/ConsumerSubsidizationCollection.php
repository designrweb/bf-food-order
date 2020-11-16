<?php

namespace App\Http\Resources;

use App\Helpers\DateFormatter;
use App\ConsumerSubsidization;
use Carbon\Carbon;
use bigfood\grid\PaginatableCollection;

/**
 * Class ConsumerSubsidizationCollection
 *
 * @package App\Http\Resources
 */
class ConsumerSubsidizationCollection extends PaginatableCollection
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
            'data'       => $this->collection->transform(function (ConsumerSubsidization $item) {
                return $item->toArray();
            }),
            'pagination' => $this->pagination
        ];
    }
}
