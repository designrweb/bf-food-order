<?php

namespace App\QueryBuilders;

use App\Payment;
use App\Services\ConsumerService;
use App\User;
use bigfood\grid\BaseSearch;
use Closure;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class PaymentSearch
 *
 * @package App\QueryBuilders
 */
class MealOrderSearch extends BaseSearch
{
    /**
     * @var ConsumerService
     */
    private $consumerService;

    public function __construct(ConsumerService $consumerService)
    {
        $this->consumerService = $consumerService;
    }
    /**
     * @param         $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->builder = $next($request);

        if (request()->user()->role === User::ROLE_USER) {
            $this->builder->where('payments.consumer_id', $this->consumerService->getCurrentConsumer()->id);
        }

        $this->builder->whereNotIn('payments.type', [Payment::TYPE_BANK_TRANSACTION, Payment::TYPE_MANUAL_TRANSACTION]);

        return $this->builder;
    }
}
