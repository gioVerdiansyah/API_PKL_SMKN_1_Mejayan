<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SiswaExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Imports\Admin\AdminSiswaImport;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class AdminSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $siswa = User::latest();
        $jurusans = Jurusan::all();

        if ($request->has('query') && !empty($request->input('query'))) {
            $input = $request->input('query');
            $siswa->where('name', 'LIKE', '%' . $input . '%')
                ->orWhere('nis', 'LIKE', $input);
        }

        if ($request->has('jurusan') && !empty($request->input('jurusan'))) {
            $siswa->where('jurusan_id', "$request->jurusan");
        }

        $siswa = $siswa->paginate(10);

        return view('admin.kakomli.siswa.index', compact('siswa', 'jurusans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jurusan = Jurusan::all();
        $kelas = Kelas::all();
        return view('admin.kakomli.siswa.create', compact('jurusan', 'kelas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $siswa = new User;
            $siswa->name = $request->nama;
            $siswa->nis = $request->nis;
            $siswa->email = $request->email;
            $siswa->password = Hash::make($request->password ?? 'password');
            $siswa->no_hp = $request->no_telp;
            $siswa->no_hp_ortu = $request->no_hp_ortu;
            $siswa->absen = $request->absen;
            $siswa->kelas_id = $request->kelas;
            $siswa->jurusan_id = $request->jurusan;
            $siswa->jenis_kelamin = $request->jenis_kelamin;
            $siswa->alamat = $request->alamat;

            if($request->hasFile('photo_profile')){
                $fileName = $request->file('photo_profile')->hashName();
                $path = $request->file('photo_profile')->storeAs('photo_siswa', $fileName);
                $siswa->photo_profile = 'storage/' . $path;
            }

            $siswa->save();

            DB::commit();
            return to_route('admin.siswa.index')->with('message', [
                'icon' => 'success',
                'title' => 'Success',
                'text' => 'Berhasil menambah siswa ' . $request->nama
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('message', [
                'icon' => 'error',
                'title' => 'Ada kesalahan server',
                'text' => $e
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $siswa = User::where('id', $id)->first();
        if (!$siswa) {
            return back()->with('message', [
                'icon' => 'error',
                'title' => 'Ada kesalahan server',
                'text' => "ID siswa tidak ditemukan"
            ]);
        }

        return view('admin.kakomli.siswa.show', compact('siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jurusan = Jurusan::all();
        $kelas = Kelas::all();
        $siswa = User::where('id', $id)->first();
        if (!$siswa) {
            return back()->with('message', [
                'icon' => 'error',
                'title' => 'Gagal!',
                'text' => 'ID Siswa tidak ditemukan'
            ]);
        }

        return view('admin.kakomli.siswa.edit', compact('siswa','jurusan', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id)
    {
        try {
            DB::beginTransaction();

            $siswa = User::where('id', $id)->first();

            if (!$siswa) {
                return back()->with('message', [
                    'icon' => 'error',
                    'title' => 'Ada kesalahan server',
                    'text' => "ID siswa tidak ditemukan"
                ]);
            }

            $siswa->name = $request->nama;
            $siswa->nis = $request->nis;
            $siswa->email = $request->email;
            $siswa->password = Hash::make($request->password ?? 'password');
            $siswa->no_hp = $request->no_telp;
            $siswa->no_hp_ortu = $request->no_hp_ortu;
            $siswa->absen = $request->absen;
            $siswa->kelas_id = $request->kelas;
            $siswa->jurusan_id = $request->jurusan;
            $siswa->jenis_kelamin = $request->jenis_kelamin;
            $siswa->alamat = $request->alamat;

            if ($request->password !== null) {
                $siswa->password = Hash::make($request->password);
            }

            if ($request->hasFile('photo_profile')) {
                if (strpos($siswa->photo_profile, 'storage/') !== false) {
                    if (Storage::exists(explode('storage/', $siswa->photo_profile)[1])) {
                        Storage::delete(explode('storage/', $siswa->photo_profile)[1]);
                    }
                }
                $fileName = $request->file('photo_profile')->hashName();
                $path = $request->file('photo_profile')->storeAs('photo_siswa', $fileName);
                $siswa->photo_profile = 'storage/' . $path;
            }

            $siswa->save();

            DB::commit();
            return to_route('admin.siswa.index')->with('message', [
                'icon' => 'success',
                'title' => 'Success',
                'text' => 'Berhasil me-update siswa'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('message', [
                'icon' => 'error',
                'title' => 'Ada kesalahan server',
                'text' => $e
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
            $siswa = User::where('id', $id)->first();

            if (!$siswa) {
                return back()->with('message', [
                    'icon' => 'error',
                    'title' => 'Gagal!',
                    'text' => 'ID Siswa tidak ditemukan'
                ]);
            }
            $siswaName = $siswa->name;

            if (strpos($siswa->photo_profile, 'storage/') !== false) {
                if (Storage::exists(explode('storage/', $siswa->photo_profile)[1])) {
                    Storage::delete(explode('storage/', $siswa->photo_profile)[1]);
                }
            }

            $siswa->delete();

            DB::commit();
            return to_route('admin.siswa.index')->with('message', [
                'icon' => 'success',
                'title' => 'Success!',
                'text' => "Berhasil me-hapus siswa $siswaName"
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
        return Excel::download(new SiswaExport(), 'tambah_data_siswa_pkl.xlsx');
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

            Excel::import(new AdminSiswaImport, $file);

            return to_route('admin.siswa.index')->with('message', [
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
