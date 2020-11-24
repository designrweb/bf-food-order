<?php

namespace App\Http\Resources;

use App\Helpers\DateFormatter;
use App\Location;
use Carbon\Carbon;
use bigfood\grid\PaginatableCollection;

/**
 * Class LocationCollection
 *
 * @package App\Http\Resources
 */
class LocationCollection extends PaginatableCollection
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
            'data'       => $this->collection->transform(function (Location $item) {
                return [
                    'id'             => $item->id,
                    'name'           => $item->name,
                    'image_name'     => $item->image_name,
                    'login_url'      => url($item->slug),
                    'voucher_limits' => '',
                    'city'           => $item->city,
                    'zip'            => $item->zip,
                    'email'          => $item->email,
                ];
            }),
            'pagination' => $this->pagination
        ];
    }
}
