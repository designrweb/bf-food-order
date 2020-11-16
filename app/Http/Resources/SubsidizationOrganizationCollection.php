<?php

namespace App\Http\Resources;

use App\Helpers\DateFormatter;
use App\SubsidizationOrganization;
use Carbon\Carbon;
use bigfood\grid\PaginatableCollection;

/**
 * Class SubsidizationOrganizationCollection
 *
 * @package App\Http\Resources
 */
class SubsidizationOrganizationCollection extends PaginatableCollection
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
            'data'       => $this->collection->transform(function (SubsidizationOrganization $item) {
                return $item->toArray();
            }),
            'pagination' => $this->pagination
        ];
    }
}
