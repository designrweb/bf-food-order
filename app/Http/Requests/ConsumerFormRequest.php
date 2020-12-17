<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConsumerFormRequest extends FormRequest
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
            'account_id'        => 'required|string|unique:consumers,account_id,' . $this->id,
            'firstname'         => 'required|string',
            'lastname'          => 'required|string',
            'birthday'          => 'required|string',
            'location_group_id' => 'required|numeric',
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
            'user_id' => auth()->user()->id,
        ]);
    }
}
