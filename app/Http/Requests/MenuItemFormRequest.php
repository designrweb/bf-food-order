<?php

namespace App\Http\Requests;

use App\MenuItem;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class MenuItemFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'              => 'required|string',
            'menu_category_id'  => 'required|numeric',
            'availability_date' => 'required',
            'description'       => 'string',
        ];
    }

    /**
     * @param Validator $validator
     */
    public function withValidator(Validator $validator)
    {
        $menuItemsCount = MenuItem::whereRaw('availability_date = "' . date('Y-m-d', strtotime(request()->get('availability_date'))) . '" ')
            ->where('menu_category_id', request()->get('menu_category_id'));

        if (!empty(request()->get('id'))) {
            $menuItemsCount = $menuItemsCount->where('id', '!=', request()->get('id'));
        }

        $menuItemsCount = $menuItemsCount->count();

        $validator->after(function (Validator $validator) use ($menuItemsCount) {
            if (!empty($menuItemsCount)) {
                $validator->errors()->add('menu_category_id', 'This day is booked for the chosen menu category');
            }
        });
    }
}
