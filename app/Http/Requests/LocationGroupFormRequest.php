<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationGroupFormRequest extends FormRequest
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
            'name'        => 'required|string|max:255',
            'location_id' => 'required|numeric',
        ];
    }

    /**
     * @return string[]
     */
    public function attributes()
    {
        return [
            'location_id' => 'Location',
        ];
    }
}
