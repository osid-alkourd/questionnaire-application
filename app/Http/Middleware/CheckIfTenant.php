<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckIfTenant
{

    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('tenant')->check()) {
            return redirect()->route('tenant.login')
                ->with('error', 'please enter your credential as a tenant');
        }
        return $next($request);
    }
}
