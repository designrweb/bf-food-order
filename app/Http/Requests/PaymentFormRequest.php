<?php

namespace App\Http\Requests;

use App\Rules\PaymentAmountValidation;
use App\Services\ConsumerService;
use Illuminate\Foundation\Http\FormRequest;

class PaymentFormRequest extends FormRequest
{
    /**
     * @var ConsumerService
     */
    private $consumerService;

    /**
     * PaymentFormRequest constructor.
     *
     * @param ConsumerService $consumerService
     */
    public function __construct(ConsumerService $consumerService)
    {
        $this->consumerService = $consumerService;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'amount_locale' => ['required', new PaymentAmountValidation($this->consumerService)],
            'comment'       => 'required',
            'consumer_id'   => 'required|numeric',
        ];
    }
}
