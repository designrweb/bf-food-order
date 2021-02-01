<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationFormRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name'       => 'required|max:128',
            'zip'        => 'nullable|numeric|regex:/\b\d{5}\b/',
            'city'       => 'nullable|string',
            'street'     => 'nullable|string',
            'email'      => 'nullable|email',
            'image_name' => 'nullable|string',
            'company_id' => 'required|numeric',
        ];
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

    /**
     *
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'company_id' => auth()->user()->company_id,
        ]);
    }
}
