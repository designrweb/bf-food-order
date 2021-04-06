<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CateringCategoryFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => 'required|string',
            'location_id' => 'required|numeric',
        ];
    }

    /**
     * @return string[]
     */
    public function attributes()
    {
        return [
            'location_id' => __('catering-category.Location'),
        ];
    }
}
