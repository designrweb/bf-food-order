<?php

namespace App\Http\Resources;

use App\Helpers\DateFormatter;
use App\SubsidizationRule;
use Carbon\Carbon;
use bigfood\grid\PaginatableCollection;

/**
 * Class SubsidizationRuleCollection
 *
 * @package App\Http\Resources
 */
class SubsidizationRuleCollection extends PaginatableCollection
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
            'data'       => $this->collection->transform(function (SubsidizationRule $item) {
                $data = $item->toArray();

                $data['start_date'] = !empty($item->start_date) ? date('l, d.m.Y', strtotime
                ($item->start_date)) : null;
                $data['end_date']   = !empty($item->start_date) ? date('l, d.m.Y', strtotime
                ($item->end_date)) : null;

                return $data;
            }),
            'pagination' => $this->pagination
        ];
    }
}
