<?php


namespace App\Http\Requests\api\mobile;


use App\Http\Requests\api\BaseApiFormRequest;

/**
 * Class ConsumerFormRequest
 *
 * @package App\Http\Requests\api\mobile
 */
class ConsumerFormRequest extends BaseApiFormRequest
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
            'account_id'        => 'nullable|numeric|unique:consumers,account_id,' . $this->id,
            'firstname'         => 'required|string|max:255',
            'lastname'          => 'required|string|max:255',
            'birthday'          => 'required|string',
            'location_group_id' => 'required|numeric|exists:location_groups,id',
            'imageurl'          => 'nullable|string',
            'balance_limit'     => 'required|numeric',
        ];
    }

    /**
     *
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => auth('api')->user()->id,
        ]);
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'account_id.numeric' => 'ERROR_ACCOUNT_ID_MUST_BE_NUMERIC',
            'account_id.unique'  => 'ERROR_ACCOUNT_ID_MUST_BE_UNIQUE',

            'first_name.required' => 'ERROR_FIRST_NAME_IS_REQUIRED',
            'first_name.string'   => 'ERROR_FIRST_NAME_MUST_BE_STRING',
            'first_name.max'      => 'ERROR_FIRST_NAME_MAX_255',

            'last_name.required' => 'ERROR_LAST_NAME_IS_REQUIRED',
            'last_name.string'   => 'ERROR_LAST_NAME_MUST_BE_STRING',
            'last_name.max'      => 'ERROR_LAST_NAME_MAX_255',

            'birthday.required' => 'ERROR_BIRTHDAY_IS_REQUIRED',
            'birthday.string'   => 'ERROR_BIRTHDAY_MUST_BE_STRING',

            'location_group_id.required' => 'ERROR_LOCATION_GROUP_IS_REQUIRED',
            'location_group_id.numeric'  => 'ERROR_LOCATION_GROUP_MUST_BE_NUMERIC',
            'location_group_id.exists'   => 'ERROR_LOCATION_GROUP_NOT_EXISTS',

            'imageurl.string'   => 'ERROR_IMAGEURL_MUST_BE_STRING',

            'balance_limit.required' => 'ERROR_BALANCE_LIMIT_IS_REQUIRED',
            'balance_limit.numeric'  => 'ERROR_BALANCE_LIMIT_MUST_BE_NUMERIC',
        ];
    }
}
