<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthKakomli
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::guard('kakomli')->check()){
            return to_route('index');
        }

        if (Auth::guard('kakomli')->check() && Auth::guard('kakomli')->user()->email !== config('app.admin_email')) {
            return $next($request);
        }

        return to_route('admin.dashboard');
    }
}
