<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConsumerResource extends JsonResource
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

        $data['subsidization']['subsidization_organization_id'] = !empty($this->subsidization) ?
            $this->subsidization->subsidizationRule->subsidizationOrganization->id : null;
        $data['subsidization']['subsidization_start']           = !empty($this->subsidization) &&
        !empty($this->subsidization->subsidization_start) ? date('d.m.Y', strtotime
        ($this->subsidization->subsidization_start)) : null;
        $data['subsidization']['subsidization_end']             = !empty($this->subsidization) &&
        !empty($this->subsidization->subsidization_end) ? date('d.m.Y', strtotime($this->subsidization->subsidization_end)) : null;

        $data['birthday'] = !empty($this->birthday) ? date('d.m.Y', strtotime($this->birthday)) : null;

        $data['subsidization']['subsidization_rule']['start_date'] =
            !empty($this->subsidization) && !empty
            ($this->subsidization->subsidizationRule->start_date) ? date('d.m.Y', strtotime($this->subsidization->subsidizationRule->start_date)) : null;
        $data['subsidization']['subsidization_rule']['end_date']   =
            !empty($this->subsidization) && !empty
            ($this->subsidization->subsidizationRule->end_date) ? date('d.m.Y', strtotime($this->subsidization->subsidizationRule->end_date)) : null;

        return $data;
    }
}
