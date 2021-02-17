<?php

namespace App\Http\Resources\Mobile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MobileConsumerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);
        // TODO: uncomment if needed
        // $data['subsidization']['subsidization_organization_id'] = !empty($this->subsidization) ?
        // $this->subsidization->subsidizationRule->subsidizationOrganization->id : null;
        $data['birthday'] = !empty($this->birthday) ? date('d.m.Y', strtotime($this->birthday)) : null;

        return $data;
    }
}
