<?php

namespace App\Http\Middleware;

use App\Role;
use Closure;
use Illuminate\Support\Facades\Gate;

class ApprovalMiddleware
{
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            if (!auth()->user()->approved) {
                return redirect()->route('home')->with('message', trans('global.yourAccountNeedsAdminApproval'));
            }

        }

        return $next($request);

    }

}
