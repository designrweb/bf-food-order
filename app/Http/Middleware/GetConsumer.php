<?php

namespace App\Http\Middleware;

use App\Consumer;
use Closure;

class GetConsumer
{
    /**
     * Handle an incoming request.
     * @todo change this once consumer switcher will be done
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $consumerId = session('consumerId') ?? 16;

        $request->consumer = Consumer::find($consumerId);

        return $next($request);
    }
}