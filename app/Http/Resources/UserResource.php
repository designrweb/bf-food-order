<?php

namespace App\Http\Resources;

use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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

        $data['role_name']       = User::ROLES[$this->role];
        $data['salutation_name'] = User::SALUTATIONS[$this->userInfo->salutation];

        return $data;
    }
}
