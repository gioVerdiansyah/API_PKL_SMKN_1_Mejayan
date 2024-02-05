<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class AdminPengurusPklController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $jurusans = Jurusan::all();
        $pengurus = Guru::latest();

        if ($request->has('query') && !empty($request->input('query'))) {
            $input = $request->input('query');
            $pengurus->where('nama', 'LIKE', '%' . $input . '%')
                ->orWhere('email', 'LIKE', $input);
        }

        $pengurus = $pengurus->paginate(10);

        return view('admin.kakomli.pengurus_pkl.index', compact('jurusans', 'pengurus'));
    }
}
