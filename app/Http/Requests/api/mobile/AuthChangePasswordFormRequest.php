<?php

namespace App\Http\Requests\api\mobile;

use App\Http\Requests\api\BaseApiFormRequest;

/**
 * Class AuthChangePasswordFormRequest
 *
 * @package App\Http\Requests\api\mobile
 */
class AuthChangePasswordFormRequest extends BaseApiFormRequest
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
            'old_password' => 'required|password:api',
            'password'     => 'required|string|confirmed|min:6',
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'old_password.required' => 'ERROR_OLD_PASSWORD_IS_REQUIRED',
            'old_password.password' => 'ERROR_OLD_PASSWORD_NOT_MATCH',

            'password.required'  => 'ERROR_PASSWORD_IS_REQUIRED',
            'password.string'    => 'ERROR_PASSWORD_MUST_BE_STRING',
            'password.confirmed' => 'ERROR_PASSWORD_NOT_MATCH',
            'password.min'       => 'ERROR_PASSWORD_MIN_6',
        ];
    }
}