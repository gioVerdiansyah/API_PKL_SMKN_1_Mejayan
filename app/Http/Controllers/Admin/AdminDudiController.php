<?php

namespace App\Http\Controllers\Admin;

use App\Exports\DudiExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\DudiStoreRequest;
use App\Imports\Admin\AdminDudiImport;
use App\Models\Dudi;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class AdminDudiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $jurusans = Jurusan::all();
        $dudi = Dudi::with('jurusan')->latest();
        if ($request->has('query') && !empty($request->input('query'))) {
            $input = $request->input('query');
            $dudi->where('nama', 'LIKE', '%' . $input . '%')
                ->orWhere('pemimpin', 'LIKE', $input);
        }

        if ($request->has('jurusan') && !empty($request->input('jurusan'))) {
            $dudi->where('jurusan_id', "$request->jurusan");
        }

        $dudi = $dudi->paginate(10);
        return view('admin.kakomli.dudi.index', compact('dudi', 'jurusans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jurusans = Jurusan::all();
        return view('admin.kakomli.dudi.create', compact('jurusans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DudiStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $dudi = new Dudi;
            $dudi->nama = $request->nama;
            $dudi->pemimpin = $request->pemimpin;
            $dudi->no_telp = $request->no_telp;
            $dudi->email = $request->email;
            $dudi->koordinat = $request->koordinat;
            $dudi->radius = $request->radius;
            $dudi->alamat = $request->alamat;
            $dudi->jurusan_id = $request->jurusan_id;
            $dudi->senin = $request->senin;
            $dudi->selasa = $request->selasa;
            $dudi->rabu = $request->rabu;
            $dudi->kamis = $request->kamis;
            $dudi->jumat = $request->jumat;
            $dudi->sabtu = $request->sabtu;
            $dudi->minggu = $request->minggu;
            $dudi->ji_senin = $request->ji_senin;
            $dudi->ji_selasa = $request->ji_selasa;
            $dudi->ji_rabu = $request->ji_rabu;
            $dudi->ji_kamis = $request->ji_kamis;
            $dudi->ji_jumat = $request->ji_jumat;
            $dudi->ji_sabtu = $request->ji_sabtu;
            $dudi->ji_minggu = $request->ji_minggu;
            $dudi->save();

            DB::commit();
            return to_route('admin.dudi.index')->with('message', [
                'icon' => 'success',
                'title' => 'Success!',
                'text' => "Berhasil menambah dudi {$request->nama}"
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('message', [
                'icon' => 'error',
                'title' => 'Ada kesalahan server',
                'text' => "Error: $e"
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dudi = Dudi::where('id', $id)->first();
        if (!$dudi) {
            return back()->with('message', [
                'icon' => 'error',
                'title' => 'Ada kesalahan server',
                'text' => "ID dudi tidak ditemukan"
            ]);
        }

        return view('admin.kakomli.dudi.show', compact('dudi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dudi = Dudi::where('id', $id)->first();
        $jurusans = Jurusan::all();
        if (!$dudi) {
            return back()->with('message', [
                'icon' => 'error',
                'title' => 'Gagal!',
                'text' => 'ID Dudi tidak ditemukan'
            ]);
        }

        return view('admin.kakomli.dudi.edit', compact('dudi', 'jurusans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $dudi = Dudi::where('id', $id)->first();

            if (!$dudi) {
                return back()->with('message', [
                    'icon' => 'error',
                    'title' => 'Gagal!',
                    'text' => 'ID Dudi tidak ditemukan'
                ]);
            }

            $dudi->nama = $request->nama;
            $dudi->pemimpin = $request->pemimpin;
            $dudi->no_telp = $request->no_telp;
            $dudi->email = $request->email;
            $dudi->koordinat = $request->koordinat;
            $dudi->jurusan_id = $request->jurusan_id;
            $dudi->radius = $request->radius;
            $dudi->alamat = $request->alamat;
            $dudi->senin = $request->senin;
            $dudi->selasa = $request->selasa;
            $dudi->rabu = $request->rabu;
            $dudi->kamis = $request->kamis;
            $dudi->jumat = $request->jumat;
            $dudi->sabtu = $request->sabtu;
            $dudi->minggu = $request->minggu;
            $dudi->ji_senin = $request->ji_senin;
            $dudi->ji_selasa = $request->ji_selasa;
            $dudi->ji_rabu = $request->ji_rabu;
            $dudi->ji_kamis = $request->ji_kamis;
            $dudi->ji_jumat = $request->ji_jumat;
            $dudi->ji_sabtu = $request->ji_sabtu;
            $dudi->ji_minggu = $request->ji_minggu;
            $dudi->save();

            DB::commit();
            return to_route('admin.dudi.index')->with('message', [
                'icon' => 'success',
                'title' => 'Success!',
                'text' => "Berhasil me-edit dudi"
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('message', [
                'icon' => 'error',
                'title' => 'Ada kesalahan server',
                'text' => "Error: $e"
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $dudi = Dudi::where('id', $id)->first();

            if (!$dudi) {
                return back()->with('message', [
                    'icon' => 'error',
                    'title' => 'Gagal!',
                    'text' => 'ID Dudi tidak ditemukan'
                ]);
            }
            $dudiName = $dudi->nama;

            $dudi->delete();

            DB::commit();
            return to_route('admin.dudi.index')->with('message', [
                'icon' => 'success',
                'title' => 'Success!',
                'text' => "Berhasil me-hapus dudi $dudiName"
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('message', [
                'icon' => 'error',
                'title' => 'Ada kesalahan server',
                'text' => "Error: $e"
            ]);
        }
    }


    // Berurusan dengan Excel
    public function generateKolom()
    {
        return Excel::download(new DudiExport(), 'tambah_data_dudi.xlsx');
    }

    public function importData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file_excel' => [
                'required',
                'file',
                'mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'mimes:xlsx',
            ],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('message', [
                'icon' => 'error',
                'title' => 'Error validasi',
                'text' => 'harap masukkan file berupa .xlsx'
            ]);
        }
        try {
            $file = $request->file('file_excel');

            Excel::import(new AdminDudiImport, $file);

            return to_route('admin.dudi.index')->with('message', [
                'icon' => 'success',
                'title' => 'Success!',
                'text' => "Berhasil me-import data"
            ]);
        } catch (\Exception $e) {
            return back()->with('message', [
                'icon' => 'error',
                'title' => 'Gagal!',
                'text' => $e
            ]);
        }
    }
}