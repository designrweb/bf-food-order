<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubsidizationRuleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);

        $data['start_date'] = date('l, d.m.Y', strtotime($this->start_date));
        $data['end_date']   = date('l, d.m.Y', strtotime($this->end_date));

        return $data;
    }
}
