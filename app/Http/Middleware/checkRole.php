<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Gate;

class checkRole
{
    /**
     * Handle an incoming request.
     *
     * @param                          $request
     * @param \Closure                 $next
     * @param                          $action
     * @param                          $model
     * @param null                     $field
     * @return mixed
     */
    public function handle($request, Closure $next, $action, $model, $field = null)
    {
        if (empty($field) || in_array($action, ['create', 'viewAny'])) {
            if (Gate::allows($action, $model)) {
                return $next($request);
            }
        }

        $entityId = $request->route('id');

        if (!class_exists($model)) {
            abort(403);
        }

        $model = $model::find($entityId);

        $policy = 'App\Policies\\' . class_basename($model) . 'Policy';

        if (!class_exists($policy)) {
            abort(403);
        }

        if (!Gate::allows($action, $model)) {
            abort(403);
        }

        return $next($request);
    }
}
