<?php

namespace App\Http\Controllers\Kakomli;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use Illuminate\Http\Request;
use App\Models\Kelompok;

class PengurusPklController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pengurus = Kelompok::where('kakomli_id', auth()->guard('kakomli')->user()->id)->pluck('guru_id');

        $pengurus = Guru::whereIn('id', $pengurus)->latest();

        if ($request->has('query') && !empty($request->input('query'))) {
            $input = $request->input('query');
            $pengurus->where('nama', 'LIKE', '%' . $input . '%')
                ->orWhere('email', 'LIKE', $input);
        }

        $pengurus = $pengurus->paginate(10);

        return view('kakomli.pengurus_pkl.index', compact('pengurus'));
    }
}
