<?php

namespace App\Http\Controllers\Api\Guru;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserAuthRequest;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(UserAuthRequest $request)
    {
        // modify to support login with username or email
        $loginField = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'nama';

        // attempt login using custom logic
        if ($this->attemptLogin($request, $loginField)) {
            // if auth success, create token
            $token = Auth::guard('guru')->user()->createToken('authToken')->plainTextToken;

            return response()->json([
                'login' => [
                    'success' => true,
                    'guru' => Guru::with('jurusan')->where('email', $request->email)->orWhere('nama', $request->email)->first(),
                    'token' => $token
                ]
            ], 200);
        } else {
            return response()->json([
                'login' => [
                    'success' => false,
                    'message' => 'Email atau Password Anda salah'
                ]
            ], 401);
        }
    }

    protected function attemptLogin(Request $request, $loginField)
    {
        $user = Guru::where('email', $request->email)->orWhere('nama', $request->email)->first();

        if ($user && $user->status === '1' && Hash::check($request->password, $user->password)) {
            $this->guard()->login($user, true);
            return true;
        }

        return false;
    }

    protected function credentials(Request $request)
    {
        return $request->only('email', 'password');
    }

    protected function guard()
    {
        return Auth::guard('guru');
    }
}
