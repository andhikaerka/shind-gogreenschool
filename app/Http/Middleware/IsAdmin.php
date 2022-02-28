<?php

namespace App\Http\Middleware;

use App\Role;
use Closure;
use Illuminate\Support\Facades\Gate;

class IsAdmin
{
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            if (!auth()->user()->isAdmin) {
                return abort(404);
            }

        }

        return $next($request);

    }

}
