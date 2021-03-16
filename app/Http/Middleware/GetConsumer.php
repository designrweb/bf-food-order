<?php

namespace App\Http\Middleware;

use App\Consumer;
use App\Services\ConsumerService;
use App\User;
use Closure;

class GetConsumer
{

    private $consumerService;

    public function __construct(ConsumerService $consumerService)
    {
        $this->consumerService = $consumerService;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @return mixed
     * @todo change this once consumer switcher will be done
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->role === User::ROLE_USER) {
//            $request->consumer = $request->user()->consumer;
        }

        return $next($request);
    }
}