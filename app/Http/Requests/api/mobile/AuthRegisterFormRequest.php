<?php

namespace App\Http\Requests\api\mobile;


use App\Http\Requests\api\BaseApiFormRequest;

/**
 * Class AuthRegisterFormRequest
 *
 * @package App\Http\Requests\api\mobile
 */
class AuthRegisterFormRequest extends BaseApiFormRequest
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
            'email'    => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
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
            'email.unique'   => 'ERROR_EMAIL_ALREADY_EXISTS',

            'password.required'  => 'ERROR_PASSWORD_IS_REQUIRED',
            'password.string'    => 'ERROR_PASSWORD_MUST_BE_STRING',
            'password.confirmed' => 'ERROR_PASSWORD_NOT_MATCH',
            'password.min'       => 'ERROR_PASSWORD_MIN_6',
        ];
    }
}
