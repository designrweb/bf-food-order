<?php

namespace App\Http\Middleware;

use Closure;

class CheckModelExists
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param Closure                  $next
     * @param                          $model
     * @return mixed
     */
    public function handle($request, Closure $next, $model)
    {
        $parameters = $request->route()->parameters();

        if (!empty($parameters['id']) && empty($model::find($parameters['id']))) {
            $routeName = $request->route()->getName();

            return redirect()->route(str_replace(['.edit', '.show'], '.index', $routeName));
        }

        return $next($request);
    }
}
