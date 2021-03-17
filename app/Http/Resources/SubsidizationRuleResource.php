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

        $data['start_date_human'] = $this->start_date ? date('l, d.m.Y', strtotime($this->start_date)) : null;
        $data['end_date_human']   = $this->end_date ? date('l, d.m.Y', strtotime($this->end_date)) : null;
        $data['start_date']       = $this->start_date ? date('d.m.Y', strtotime($this->start_date)) : null;
        $data['end_date']         = $this->end_date ? date('d.m.Y', strtotime($this->end_date)) : null;

        return $data;
    }
}
