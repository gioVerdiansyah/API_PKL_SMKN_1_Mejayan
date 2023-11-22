<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserAuthRequest;
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
        $loginField = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        // attempt login using custom logic
        if ($this->attemptLogin($request, $loginField)) {
            // if auth success, create token
            $token = auth()->user()->createToken('authToken')->plainTextToken;

            return response()->json([
                'success' => true,
                'user' => auth()->user(),
                'detail_user' => auth()->user()->detailUser()->get(),
                'token' => $token
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password Anda salah'
            ], 401);
        }
    }

    protected function attemptLogin(Request $request, $loginField)
    {
        $credentials = $this->credentials($request);

        // Check if the user can log in based on the email address or username
        $user = $this->guard()->getProvider()->retrieveByCredentials([
            $loginField => $credentials['email'],
        ]);

        if ($user && Hash::check($credentials['password'], $user->getAuthPassword())) {
            $this->guard()->login($user, $request->boolean('remember'));
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
        return Auth::guard();
    }

}
