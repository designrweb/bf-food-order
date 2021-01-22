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
        $data                                                   = parent::toArray($request);
        $data['subsidization']['subsidization_organization_id'] = !empty($this->subsidization) ? $this->subsidization->subsidizationRule->subsidizationOrganization->id : null;
        $data['birthday']                                       = !empty($this->birthday) ? date('d.m.Y', strtotime($this->birthday)) : null;

        return $data;
    }
}
