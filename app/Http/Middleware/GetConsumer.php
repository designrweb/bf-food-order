<?php

namespace App\Http\Middleware;

use App\Consumer;
use App\Services\ConsumerService;
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
     */
    public function handle($request, Closure $next)
    {


        return $next($request);
    }
}