<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!in_array($request->user()->role, [User::ROLE_ADMIN, User::ROLE_SUPER_ADMIN])) {
            return redirect()->route('profile.index');
        }

        return $next($request);
    }
}
