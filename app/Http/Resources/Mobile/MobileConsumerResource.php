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
        $data['birthday']            = !empty($this->birthday) ? date('d.m.Y', strtotime($this->birthday)) : null;
        $data['id']                  = $this->id;
        $data['location_group_id']   = $this->location_group_id;
        $data['location_group_name'] = $this->locationgroup->name;
        $data['company_name']        = !empty($this->company) ? $this->company->name : null;
        $data['company_email']       = !empty($this->company->settings) && !empty($this->company->settings()->where('setting_name', 'email')->first()) ? $this->company->settings()->where('setting_name', 'email')->first()->value : null;
        $data['location_id']         = $this->location->id;
        $data['user_id']             = $this->user_id;
        $data['account_id']          = $this->account_id;
        $data['firstname']           = $this->firstname;
        $data['lastname']            = $this->lastname;
        $data['birthday']            = $this->birthday;
        $data['image']               = $this->imageurl;
        $data['balance']             = $this->balance;
        $data['balance_limit']       = $this->balance_limit;
        $data['created_at']          = $this->created_at;
        $data['updated_at']          = $this->updated_at;
        $data['deleted_at']          = $this->deleted_at;
        $data['qr_code']             = !empty($this->qrCode) ? $this->qrCode->qr_code_hash : null;

        return $data;
    }
}
