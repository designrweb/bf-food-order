<?php

namespace App\Http\Requests\api\mobile;

use App\Http\Requests\api\BaseApiFormRequest;

class OrderFormRequest extends BaseApiFormRequest
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
        return [];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [];
    }
}