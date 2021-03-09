<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'location_id'          => 'required_if:role,' . User::ROLE_POS_MANAGER,
            'user_info.first_name' => 'required|string',
            'user_info.last_name'  => 'required|string',
            'user_info.salutation' => 'required|string',
            'user_info.zip'        => 'required|numeric|regex:/\b\d{5}\b/',
            'user_info.city'       => 'required|string',
            'user_info.street'     => 'required|string',
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

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'zip.regex' => 'Zip must have 5 digits',
        ];
    }
}
