<?php

namespace App\Http\Controllers;

use App\Mail\AgreementMail;
use App\Models\Guru;
use App\Models\Kakomli;
use App\Models\PrivateStorage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
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
