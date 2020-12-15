<?php

namespace App\Http\Requests;

use App\Rules\OrdersValidation;
use App\Services\OrderService;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Factory as ValidationFactory;

class VacationFormRequest extends FormRequest
{
    /**
     * VacationFormRequest constructor.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'              => 'required',
            'start_date'        => 'required',
            'end_date'          => 'required',
            'location_id'       => 'required|numeric',
            'location_group_id' => 'required|array',
        ];
    }

    /**
     * @param Validator $validator
     */
    public function withValidator(Validator $validator)
    {
        $orders = $this->checkPreOrders();

        $validator->after(function (Validator $validator) use ($orders) {
            if (empty($orders)) {
                $validator->errors()->add('orders_exists', $orders);
            }
        });
    }

    /**
     * @return false|mixed
     */
    public function checkPreOrders()
    {
        $startDate          = request()->get('start_date');
        $endDate            = request()->get('end_date');
        $locationGroupIds   = request()->get('location_group_id');
        $withDeletingOrders = request()->get('with_deleting_orders');

        if (!empty($withDeletingOrders)) {
            return false;
        }

        return OrderService::getPreOrdersByDateRangeAndLocationGroup($startDate, $endDate, $locationGroupIds);
    }
}
