<?php

namespace App\Http\Resources;

use App\Helpers\DateFormatter;
use App\Vacation;
use Carbon\Carbon;
use bigfood\grid\PaginatableCollection;

/**
 * Class VacationCollection
 *
 * @package App\Http\Resources
 */
class VacationCollection extends PaginatableCollection
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
            'data'       => $this->collection->transform(function (Vacation $item) {
                return $item->toArray();
            }),
            'pagination' => $this->pagination
        ];
    }
}
