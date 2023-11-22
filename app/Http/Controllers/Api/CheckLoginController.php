<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CheckLoginController extends Controller
{
    public function index(Request $request)
    {
        try {
            $rememberToken = $request->input('remember_token');
            if(empty($rememberToken)) {
                return response()->json(['success' => false, 'error' => "token is missing"]);
            }

            $user = User::where('remember_token', $rememberToken)->first();

            if ($user && $user->getRememberToken() === $rememberToken) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false]);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], $e->getCode());
        }
    }
}
