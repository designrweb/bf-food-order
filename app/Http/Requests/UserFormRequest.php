<?php

namespace App\Http\Requests;

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
            'email'                => 'required|unique:users,email,' . $this->id,
            'user_info.first_name' => 'required|string',
            'user_info.last_name'  => 'required|string',
            'user_info.salutation' => 'required|string',
            'user_info.zip'        => 'required|numeric',
            'user_info.city'       => 'required|string',
            'user_info.street'     => 'required|string',
        ];
    }
}
