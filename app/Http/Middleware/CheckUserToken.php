<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization');

        // Implementasi logika validasi token di sini
        if (!$this->isValidToken($token)) {
            return response()->json(['error' => 'Token tidak valid'], 401);
        }

        return $next($request);
    }

    private function isValidToken($token)
    {
        try {
            $user = Auth::guard('api')->attempt(['token' => $token]);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
