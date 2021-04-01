<?php

namespace App\Rules;

use App\Services\ConsumerService;
use Illuminate\Contracts\Validation\Rule;

class PaymentAmountValidation implements Rule
{
    /**
     * @var ConsumerService
     */
    private $consumerService;

    /**
     * Create a new rule instance.
     *
     * @param ConsumerService $consumerService
     */
    public function __construct(ConsumerService $consumerService)
    {
        $this->consumerService = $consumerService;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $consumer = $this->consumerService->getOne(request()->get('consumer_id', null));

        if (!empty($consumer) && $consumer->balance + $value < 0) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('payment.The amount is bigger than the current consumer balance');
    }
}
