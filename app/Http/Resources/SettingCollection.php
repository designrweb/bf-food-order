<?php

namespace App\Http\Resources;

use App\Helpers\DateFormatter;
use App\Setting;
use Carbon\Carbon;
use bigfood\grid\PaginatableCollection;

/**
 * Class SettingCollection
 *
 * @package App\Http\Resources
 */
class SettingCollection extends PaginatableCollection
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
            'data'       => $this->collection->transform(function (Setting $item) {
                return $item->toArray();
            }),
            'pagination' => $this->pagination
        ];
    }
}
