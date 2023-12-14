<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterGuruRequest;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;

use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    // use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        $jurusan = Jurusan::all();
        return view('auth.register', compact('jurusan'));
    }
    protected function register(RegisterGuruRequest $request)
    {
        $path = NULL;
        if ($request->hasFile('poto_guru')) {
            $fileName = $request->file('poto_guru')->hashName();
            $path = $request->file('poto_guru')->storeAs('poto_guru', $fileName);
        }

        Guru::create([
            'nama' => $request->name,
            'gelar' => $request->gelar,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'deskripsi' => $request->deskripsi,
            'jurusan_id' => $request->jurusan_id,
            'photo_guru' => $path,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return view('auth.await-accept');
    }
}
