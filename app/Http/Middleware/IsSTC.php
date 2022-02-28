<?php

namespace App\Http\Middleware;

use App\Role;
use Closure;
use Illuminate\Support\Facades\Gate;

class IsSTC
{
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            if (!auth()->user()->isSTC) {
                return abort(404);
            }

        }

        return $next($request);

    }

}
