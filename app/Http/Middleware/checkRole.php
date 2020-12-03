<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
            throw new ModelNotFoundException($model . ' model not found.');
        }

        $model = $model::find($entityId);

        if (!Gate::allows($action, $model)) {
            abort(403);
        }

        return $next($request);
    }
}
