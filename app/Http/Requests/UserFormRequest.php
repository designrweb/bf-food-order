<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @todo fix `|not_in:null`? js form sending null as string
     * @return array
     */
    public function rules()
    {
        return [
            'location_id'          => 'required_if:role,' . User::ROLE_POS_MANAGER,
            'user_info.first_name' => 'required|string|not_in:null',
            'user_info.last_name'  => 'required|string|not_in:null',
            'user_info.salutation' => 'required|string|not_in:null',
            'user_info.zip'        => 'required|numeric|regex:/\b\d{5}\b/|not_in:null',
            'user_info.city'       => 'required|string|not_in:null',
            'user_info.street'     => 'required|string|not_in:null',
        ];
    }

    /**
     *
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'company_id'  => request()->get('role') !== User::ROLE_ADMIN ? null : auth()->user()->company_id,
            'location_id' => request()->get('role') === User::ROLE_ADMIN ? null : request()->get('location_id'),
        ]);
    }


    public function attributes()
    {
        return [
            'user_info.first_name' => __('user.First Name'),
            'user_info.last_name'  => __('user.Last Name'),
            'user_info.salutation' => __('user.Parent Salutation'),
            'user_info.zip'        => __('user.Zip'),
            'user_info.city'       => __('user.City'),
            'user_info.street'     => __('user.Street'),
        ];
    }
}
