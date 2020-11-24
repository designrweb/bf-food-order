<?php

namespace App\Http\Resources;

use App\Helpers\DateFormatter;
use App\Company;
use Carbon\Carbon;
use bigfood\grid\PaginatableCollection;

/**
 * Class CompanyCollection
 *
 * @package App\Http\Resources
 */
class CompanyCollection extends PaginatableCollection
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
            'data'       => $this->collection->transform(function (Company $item) {
                return $item->toArray();
            }),
            'pagination' => $this->pagination
        ];
    }
}
