<?php

namespace App\Http\Resources;

use App\Company;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'image_name'     => $this->image_name,
            'company_id'     => $this->company_id,
            'companiesList'  => Company::getCompaniesList(),
            'voucher_limits' => '',
            'city'           => $this->city,
            'zip'            => $this->zip,
            'email'          => $this->email,
            'slug'           => $this->slug,
        ];
    }
}
