<?php

namespace App\Http\Controllers;

use App\Models\Dudi;
use App\Models\Guru;
use App\Models\Kakomli;
use App\Models\Kelompok;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    public function dashboard()
    {
        $kelompok = Kelompok::count();
        $user = User::count();
        $dudi = Dudi::count();
        $guru = Guru::count();
        return view('admin.dashboard', compact('kelompok', 'user', 'dudi', 'guru'));
    }

    public function dataKakomli()
    {
        $kakomli = Kakomli::whereNot('email', config('app.admin_email'))->paginate(10);
        return view('admin.kakomli.index', compact('kakomli'));
    }

    public function authorizationQR(){
        $response = Http::withHeaders([
            'x-api-key' => config('app.api_key_bot_wa')
        ])->get(config('app.app_url_bot_wa') . '/start-session', [
            'session' => 'PKL_SMKN1Mejayan',
            'scan' => true
        ]);

        return view('admin.authorizationQR', compact('response'));
    }
}
