<?php

namespace App\Http\Controllers\Api\Guru;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserAuthRequest;
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
        $loginField = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'nama';

        // attempt login using custom logic
        if ($this->attemptLogin($request, $loginField)) {
            // if auth success, create token
            $token = Auth::guard('guru')->user()->createToken('authToken')->plainTextToken;
            $guru = Guru::with('jurusan')->where('email', $request->email)->orWhere('nama', $request->email)->first();
            $kelompok = Kelompok::with('anggota')->where('guru_id', $guru->id);

            $jumlahSiswa = User::whereIn('id', $kelompok->get()->pluck('anggota.*.user_id')->collapse()->toArray())->count();
            $jumlahKelompok = $kelompok->count();

            return response()->json([
                    'success' => true,
                    'data' => [
                        'guru' => $guru,
                        'mengampu' => [
                            'siswa' => $jumlahSiswa,
                            'kelompok' => $jumlahKelompok,
                        ],
                        'token' => $token
                    ],
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
        $user = Guru::where('email', $request->email)->orWhere('nama', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
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

    public function logout()
    {
        try{
            DB::beginTransaction();

            auth('sanctum')->user()->currentAccessToken()->delete();

            DB::commit();
            return response()->json([
                "success" => true,
                "message" => "Berhasil logout",
                "data" => []
            ]);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                "success" => false,
                "message" => "Gagal logout",
                "data" => $e->getMessage()
            ]);
        }
    }
}
