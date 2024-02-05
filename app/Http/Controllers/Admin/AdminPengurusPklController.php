<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PengurusPklExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\PengurusPklStoreAPIRequest;
use App\Http\Requests\PengurusPklStoreRequest;
use App\Imports\Admin\AdminPengurusPklImport;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\Kakomli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class AdminPengurusPklController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $jurusans = Jurusan::all();
        $pengurus = Guru::with(['kakomli.jurusan'])->latest();

        if ($request->has('query') && !empty($request->input('query'))) {
            $input = $request->input('query');
            $pengurus->where('nama', 'LIKE', '%' . $input . '%')
                ->orWhere('email', 'LIKE', $input);
        }

        if ($request->has('jurusan') && !empty($request->input('jurusan'))) {
            $pengurus = Guru::with(['kakomli.jurusan'])->whereHas('kakomli', function ($query) use ($request) {
                $query->where('jurusan_id', $request->input('jurusan'));
            })->latest();
        }

        $pengurus = $pengurus->paginate(10);

        return view('admin.kakomli.pengurus_pkl.index', compact('jurusans', 'pengurus'));
    }
}
