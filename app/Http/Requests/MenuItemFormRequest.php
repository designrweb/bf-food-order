<?php

namespace App\Http\Requests;

use App\MenuItem;
use App\Services\MenuItemService;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class MenuItemFormRequest extends FormRequest
{
    /**
     * @var MenuItemService
     */
    public $menuItemService;

    /**
     * MenuItemFormRequest constructor.
     *
     * @param MenuItemService $menuItemService
     */
    public function __construct(MenuItemService $menuItemService)
    {
        $this->menuItemService = $menuItemService;
    }

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
        $menuItemsCount = $this->menuItemService->getCountExistingMenuItems(request()->all());

        $validator->after(function (Validator $validator) use ($menuItemsCount) {
            if (!empty($menuItemsCount)) {
                $validator->errors()->add('menu_category_id', 'This day is booked for the chosen menu category');
            }
        });
    }
}
