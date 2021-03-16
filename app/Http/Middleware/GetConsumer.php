<?php

namespace App\Http\Middleware;

use App\Consumer;
use App\User;
use Closure;

class GetConsumer
{
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
        if ($request->user()->isUser()) {
            $consumerId = session('consumerId') ?? 16;

            if ($consumer = Consumer::find($consumerId)) {
                $request->consumer = $consumer;
            } else {
                $request->consumer = Consumer::first();
            }

        }

        return $next($request);
    }
}