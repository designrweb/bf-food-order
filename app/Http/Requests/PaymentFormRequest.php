<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'amount_locale' => 'required',
            'comment'       => 'required',
            'consumer_id'   => 'required|numeric',
        ];
    }
}
