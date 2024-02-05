<?php

namespace App\Http\Controllers\Kakomli;

use App\Exports\PengurusPklExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\PengurusPklStoreAPIRequest;
use App\Http\Requests\PengurusPklStoreRequest;
use App\Imports\PengurusPklImport;
use App\Models\Guru;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
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
