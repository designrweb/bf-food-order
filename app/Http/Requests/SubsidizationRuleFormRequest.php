<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubsidizationRuleFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'rule_name'                     => 'required|string',
            'start_date'                    => 'nullable|required_with:end_date|date',
            'end_date'                      => 'nullable|required_with:start_date|date|after_or_equal:start_date',
            'subsidization_organization_id' => 'required|numeric',
        ];
    }

    /**
     *
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'created_by' => auth()->user()->id,
        ]);
    }
}
