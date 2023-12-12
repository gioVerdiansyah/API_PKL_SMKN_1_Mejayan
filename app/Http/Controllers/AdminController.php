<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(){
        return view('admin.dashboard');
    }

    public function persetujuan(){
        $guru = Guru::with('jurusan')->where('status', '0')->get();
        return view('admin.persetujuan', compact('guru'));
    }
}
