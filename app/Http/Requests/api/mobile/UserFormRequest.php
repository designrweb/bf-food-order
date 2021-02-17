<?php


namespace App\Http\Requests\api\mobile;


use App\Http\Requests\api\BaseApiFormRequest;

class UserFormRequest extends BaseApiFormRequest
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
            'email'                => 'required|string|email|max:100',
            'user_info.first_name' => 'required|string|max:255',
            'user_info.last_name'  => 'required|string|max:255',
            'user_info.salutation' => 'required|string|max:20|in:mr,mrs',
            'user_info.zip'        => 'required|string|max:255',
            'user_info.city'       => 'required|string|max:255',
            'user_info.street'     => 'required|string|max:255',
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'email.required' => 'ERROR_EMAIL_IS_REQUIRED',
            'email.string'   => 'ERROR_EMAIL_MUST_BE_STRING',
            'email.email'    => 'ERROR_EMAIL_HAS_WRONG_FORMAT',
            'email.max'      => 'ERROR_EMAIL_MAX_100',

            'user_info.first_name.required' => 'ERROR_FIRST_NAME_IS_REQUIRED',
            'user_info.first_name.string'   => 'ERROR_FIRST_NAME_MUST_BE_STRING',
            'user_info.first_name.max'      => 'ERROR_FIRST_NAME_MAX_255',

            'user_info.last_name.required' => 'ERROR_LAST_NAME_IS_REQUIRED',
            'user_info.last_name.string'   => 'ERROR_LAST_NAME_MUST_BE_STRING',
            'user_info.last_name.max'      => 'ERROR_LAST_NAME_MAX_255',

            'user_info.salutation.required' => 'ERROR_SALUTATION_IS_REQUIRED',
            'user_info.salutation.string'   => 'ERROR_SALUTATION_MUST_BE_STRING',
            'user_info.salutation.max'      => 'ERROR_SALUTATION_MAX_20',
            'user_info.salutation.in'       => 'ERROR_SALUTATION_CAN_BE_MR_OR_MRS',

            'user_info.zip.required' => 'ERROR_ZIP_IS_REQUIRED',
            'user_info.zip.string'   => 'ERROR_ZIP_MUST_BE_STRING',
            'user_info.zip.max'      => 'ERROR_ZIP_MAX_255',

            'user_info.city.required' => 'ERROR_CITY_IS_REQUIRED',
            'user_info.city.string'   => 'ERROR_CITY_MUST_BE_STRING',
            'user_info.city.max'      => 'ERROR_CITY_MAX_255',

            'user_info.street.required' => 'ERROR_STREET_IS_REQUIRED',
            'user_info.street.string'   => 'ERROR_STREET_MUST_BE_STRING',
            'user_info.street.max'      => 'ERROR_STREET_MAX_255',
        ];
    }
}
