<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FinancialReportFormRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'start_date'  => 'required',
            'end_date'    => 'required',
            'location_id' => 'required|numeric',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'start_date.required'  => __('validation.name_required'),
            'end_date.required'    => __('validation.name_required'),
            'location_id.required' => __('validation.name_required'),
        ];
    }
}
