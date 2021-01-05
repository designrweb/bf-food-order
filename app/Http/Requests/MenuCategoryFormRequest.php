<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuCategoryFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'           => 'required|string',
            'location_id'    => 'required|numeric',
            'price'          => 'numeric',
            'presaleprice'   => 'numeric',
            'category_order' => 'integer',
        ];
    }
}
