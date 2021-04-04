<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CateringItemFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'                 => 'required|string',
            'catering_category_id' => 'required|numeric',
            'description'          => 'string',
            'status'               => 'required|numeric',
        ];
    }

    /**
     * @return string[]
     */
    public function attributes()
    {
        return [
            'catering_category_id' => __('catering-category.Catering Category'),
        ];
    }
}
