<?php

namespace App\Http\Controllers\Kakomli;

use App\Http\Controllers\Controller;
use App\Models\Dudi;
use App\Models\Guru;
use App\Models\Kelompok;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $kakomli = auth()->guard('kakomli')->user();
        $kelompok = Kelompok::where('kakomli_id', $kakomli->id)->count();
        $user = User::where('jurusan_id', $kakomli->jurusan_id)->count();
        $dudi = Dudi::where('jurusan_id', $kakomli->jurusan_id)->count();
        $guru = Guru::where('kakomli_id', $kakomli->id)->count();
        return view('kakomli.home', compact('kelompok', 'user', 'dudi', 'guru'));
    }
}
