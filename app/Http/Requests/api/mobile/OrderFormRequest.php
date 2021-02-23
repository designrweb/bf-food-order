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
        return [
            'menuitem_id' => 'required|numeric',
            'consumer_id' => 'required|numeric',
            'quantity'    => 'required|min:1',
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'menuitem_id.required' => 'ERROR_MENUITEM_ID_IS_REQUIRED',
            'menuitem_id.numeric'  => 'ERROR_MENUITEM_ID_MUST_BE_NUMERIC',

            'consumer_id.required' => 'ERROR_CONSUMER_ID_IS_REQUIRED',
            'consumer_id.numeric'  => 'ERROR_CONSUMER_ID_MUST_BE_NUMERIC',

            'quantity.required' => 'ERROR_QUANTITY_IS_REQUIRED',
            'quantity.min'      => 'ERROR_QUANTITY_MIN_1',
        ];
    }
}