<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubsidizationOrganizationFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'       => 'required|string',
            'city'       => 'nullable|string',
            'street'     => 'nullable|string',
            'zip'        => 'nullable|numeric|max:5|min:5',
            'company_id' => 'required|numeric',
        ];
    }
}
