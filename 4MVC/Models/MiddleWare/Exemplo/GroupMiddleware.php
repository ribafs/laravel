<?php
namespace App\Http\Middleware;

use Closure;

class GroupMiddleware
{
    public function handle($request, Closure $next, $group, $permission = null)
    {
        if(!$request->user()->hasGroup($group)) {
             abort(404);
        }

        if($permission !== null && !$request->user()->can($permission)) {
              abort(404);
        }

        return $next($request);
    }
}
