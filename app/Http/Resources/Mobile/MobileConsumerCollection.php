<?php

namespace App\Http\Resources\Mobile;

use App\Consumer;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class MobileConsumerCollection
 *
 * @package App\Http\Resources\mobile
 */
class MobileConsumerCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->resource->transform(function (Consumer $item) {
            $companyEmail = !empty($item->company->settings) && !empty($item->company->settings()->where('setting_name', 'email')->first())
                ? $item->company->settings()->where('setting_name', 'email')->first()->value : null;

            $companyLogo = !empty($item->company->settings) && !empty($item->company->settings()
                ->where('setting_name', 'logo')->first())
                ? $item->company->settings()->where('setting_name', 'logo')->first()->value : '';

            return [
                'id'                  => $item->id,
                'location_group_id'   => $item->location_group_id,
                'location_group_name' => !empty($item->locationgroup) ? $item->locationgroup->name : null,
                'company_name'        => !empty($item->company) ? $item->company->name : null,
                'company_email'       => $companyEmail,
                'company_logo'        => $companyLogo,
                'location_id'         => $item->location->id,
                'user_id'             => $item->user_id,
                'account_id'          => $item->account_id,
                'firstname'           => $item->firstname,
                'lastname'            => $item->lastname,
                'birthday'            => date('d-m-Y', strtotime($item->birthday)),
                'image'               => $item->imageurl,
                'balance'             => $item->balance,
                'balance_limit'       => $item->balance_limit,
                'created_at'          => $item->created_at,
                'updated_at'          => $item->updated_at,
                'deleted_at'          => $item->deleted_at,
                'qr_code'             => !empty($item->qrCode) ? $item->qrCode->qr_code_hash : null,
            ];
        });
    }
}
