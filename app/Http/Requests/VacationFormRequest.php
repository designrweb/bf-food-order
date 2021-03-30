<?php

namespace App\Http\Requests;

use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Factory as ValidationFactory;

class VacationFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'              => 'required',
            'start_date'        => 'required|date|before:end_date',
            'end_date'          => 'required|date|after:start_date',
            'location_id'       => 'required|numeric',
            'location_group_id' => 'required|array|exists:App\LocationGroup,id',
        ];
    }

    /**
     * @param Validator $validator
     */
    public function withValidator(Validator $validator)
    {
        $orders = $this->checkPreOrders();

        $validator->after(function (Validator $validator) use ($orders) {
            if (!empty($orders) && $orders->isNotEmpty()) {
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

        $startDate = Carbon::parse($startDate)->format('Y-m-d');
        $endDate = Carbon::parse($endDate)->format('Y-m-d');

        return app(OrderService::class)->getPreOrdersByDateRangeAndLocationGroup($startDate, $endDate, $locationGroupIds);
    }

    public function attributes()
    {
        return [
            'start_date' => __('app.Start Date'),
            'end_date'   => __('app.End Date'),
        ];
    }
}
