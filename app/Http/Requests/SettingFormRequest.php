<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'setting_name' => 'required|string',
            'visible_name' => 'required|string',
            'value'        => 'required|string',
        ];
    }

    /**
     *
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'company_id' => auth()->user()->userCompany->company_id,
        ]);
    }
}
