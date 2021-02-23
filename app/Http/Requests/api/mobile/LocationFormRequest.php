<?php

namespace App\Http\Requests\api\mobile;

use App\Http\Requests\api\BaseApiFormRequest;

class LocationFormRequest extends BaseApiFormRequest
{
    protected $forceJsonResponse = true;

    /**
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
            'name.required' => 'ERROR_NAME_IS_REQUIRED',
            'name.max'      => 'ERROR_NAME_MAX_128',

            'zip.numeric' => 'ERROR_ZIP_MUST_BE_NUMERIC',
            'zip.regex'   => 'ERROR_ZIP_MUST_BE_5_DIGITS',

            'city.string' => 'ERROR_CITY_MUST_BE_STRING',

            'street.string' => 'ERROR_STREET_MUST_BE_STRING',

            'email.email' => 'ERROR_STREET_MUST_BE_EMAIL',

            'image_name.string' => 'ERROR_IMAGE_NAME_MUST_BE_STRING',

            'company_id.numeric' => 'ERROR_COMPANY_ID_MUST_BE_NUMERIC',
        ];
    }
}