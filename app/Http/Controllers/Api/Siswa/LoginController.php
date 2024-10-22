<?php
namespace App\Http\Controllers\Api\Siswa;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserAuthRequest;
use App\Models\Dudi;
use App\Models\Guru;
use App\Models\Kelompok;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            $user = User::with(['jurusan', 'kelas'])->where($loginField, $request->email)->first();
            $kelompok = Kelompok::with('dudi')->whereHas('anggota', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->first();

            if(!$kelompok){
                return response()->json([
                    'success' => false,
                    'message' => 'Anda belum didaftarkan kedalam kelompok!'
                ], 401);
            }

            $dudi = Dudi::where('id', $kelompok->dudi_id)->first();
            $guru = Guru::where('id', $kelompok->guru_id)->first();

            return response()->json([
                'success' => true,
                'data' => [
                    'user' => $user,
                    'guru' => $guru,
                    'dudi' => $dudi,
                    'token' => $token
                ],
                'message' => "Berhasil mendapatkan data!!!",
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Email/Nama atau Password Anda salah'
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

    public function logout()
    {
        try {
            DB::beginTransaction();

            auth('sanctum')->user()->currentAccessToken()->delete();

            DB::commit();
            return response()->json([
                "success" => true,
                "message" => "Berhasil logout",
                "data" => []
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "success" => false,
                "message" => "Gagal logout",
                "data" => $e->getMessage()
            ]);
        }
    }
}
