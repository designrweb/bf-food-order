<?php

namespace App\Http\Resources;

use App\Consumer;
use bigfood\grid\PaginatableCollection;

/**
 * Class ConsumerCollection
 *
 * @package App\Http\Resources
 */
class ConsumerCollection extends PaginatableCollection
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
            'data'       => $this->collection->transform(function (Consumer $item) {
                return $item->toArray();
            }),
            'pagination' => $this->pagination
        ];
    }
}
