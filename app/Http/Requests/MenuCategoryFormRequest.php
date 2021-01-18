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
            'name'                => 'required|string',
            'location_id'         => 'required|numeric',
            'price_locale'        => 'required|numeric',
            'presaleprice_locale' => 'required|numeric',
            'category_order'      => 'required|integer',
        ];
    }

    /**
     * @return string[]
     */
    public function attributes()
    {
        return [
            'location_id' => 'Location',
            'price_locale' => 'Price',
            'presaleprice_locale' => 'Presale price',
        ];
    }
}
