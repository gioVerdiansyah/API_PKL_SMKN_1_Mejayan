<?php

namespace App\Http\Controllers\Admin\AdminPengelolaanPkl;

use App\Http\Controllers\Controller;
use App\Http\Requests\KelompokSiswaStoreRequest;
use App\Http\Requests\KelompokSiswaUpdateRequest;
use App\Models\AnggotaKelompok;
use App\Models\Dudi;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\Kakomli;
use App\Models\Kelompok;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminKelompokSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $jurusans = Jurusan::all();
        $kelompok = Kelompok::latest();

        if ($request->has('query') && !empty($request->input('query'))) {
            $input = $request->input('query');

            $dudi_id = Dudi::where('nama', 'LIKE', "%$input%")->pluck('id');
            $guru_id = Guru::where('nama', 'LIKE', "%$input%")->pluck('id');
            $kakomli_id = Kakomli::where('nama', 'LIKE', "%$input%")->pluck('id');

            if(!$dudi_id->isEmpty()){
                $kelompok->whereIn('dudi_id', $dudi_id);
            }

            if(!$guru_id->isEmpty()){
                $kelompok->whereIn('guru_id', $guru_id);
            }

            if(!$kakomli_id->isEmpty()){
                $kelompok->whereIn('kakomli_id', $kakomli_id);
            }
            $kelompok->orWhere('nama_kelompok', 'LIKE', "%$input%");
        } else {
            $kelompok->with(['dudi', 'guru', 'kakomli', "anggota"]);
        }

        $kelompok = $kelompok->paginate(10);

        return view('admin.kakomli.pengelolaan_pkl.kelompok_siswa.index', compact('kelompok', 'jurusans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $anggotaTerdaftar = AnggotaKelompok::pluck('user_id');
        $dudiTerdaftar = Kelompok::pluck('dudi_id');

        $dudi = Dudi::whereNotIn('id', $dudiTerdaftar)->get();

        $guru = Guru::all();

        $anggota = User::whereNotIn('id', $anggotaTerdaftar)->get();

        return view('admin.kakomli.pengelolaan_pkl.kelompok_siswa.create', compact('dudi', 'guru', 'anggota'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KelompokSiswaStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $jurusan_id = Dudi::where('id', $request->dudi_id)->select('id', 'jurusan_id')->first()->jurusan_id;
            $kakomli_id = Kakomli::where('jurusan_id', $jurusan_id)->select('id')->first()->id;

            $kelompok = new Kelompok;
            $kelompok->nama_kelompok = $request->nama_kelompok;
            $kelompok->kakomli_id = $kakomli_id;
            $kelompok->dudi_id = $request->dudi_id;
            $kelompok->guru_id = $request->guru_id;
            $kelompok->save();

            foreach ($request->anggota as $item) {
                $anggota = new AnggotaKelompok;
                $anggota->user_id = $item;
                $kelompok->anggota()->save($anggota);
            }

            DB::commit();

            return to_route('admin.kelompok-siswa.index')->with('message', [
                'icon' => 'success',
                'title' => 'Success!',
                'text' => "Berhasil me-nambah kelompok {$request->nama_kelompok}"
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('message', [
                'icon' => 'error',
                'title' => 'Gagal!',
                'text' => $e
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kelompok = Kelompok::with(['anggota.user','guru','dudi'])->where('id', $id)->first();
        if (!$kelompok) {
            return back()->with('message', [
                'icon' => 'error',
                'title' => 'Ada kesalahan server',
                'text' => "ID Kelompok tidak ditemukan"
            ]);
        }

        return view('admin.kakomli.pengelolaan_pkl.kelompok_siswa.show', compact('kelompok'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kelompok = Kelompok::where('id', $id)->first();
        $anggotaTerdaftar = AnggotaKelompok::whereNot('kelompok_id', $kelompok->id)->pluck('user_id');

        if (!$kelompok) {
            return back()->with('message', [
                'icon' => 'error',
                'title' => 'Gagal!',
                'text' => 'ID kelompok tidak ditemukan'
            ]);
        }

        $dudi = Dudi::all();
        $guru = Guru::all();
        $anggota = User::whereNotIn('id', $anggotaTerdaftar)->get();
        $member = AnggotaKelompok::where('kelompok_id', $kelompok->id)->pluck('user_id')->toArray();

        return view('admin.kakomli.pengelolaan_pkl.kelompok_siswa.edit', compact('kelompok', 'dudi', 'guru', 'anggota', 'member'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KelompokSiswaUpdateRequest $request, string $id)
    {
        try {
            DB::beginTransaction();

            $kelompok = Kelompok::where('id', $id)->first();

            if (!$kelompok) {
                return back()->with('message', [
                    'icon' => 'error',
                    'title' => 'Ada kesalahan server',
                    'text' => "ID Kelompok tidak ditemukan"
                ]);
            }


            $jurusan_id = Dudi::where('id', $request->dudi_id)->select('id', 'jurusan_id')->first()->jurusan_id;
            $kakomli_id = Kakomli::where('jurusan_id', $jurusan_id)->select('id')->first()->id;

            $kelompok->nama_kelompok = $request->nama_kelompok;
            $kelompok->kakomli_id = $kakomli_id;
            $kelompok->dudi_id = $request->dudi_id;
            $kelompok->guru_id = $request->guru_id;
            $kelompok->save();

            AnggotaKelompok::where('kelompok_id', $kelompok->id)->delete();

            foreach ($request->anggota as $item) {
                $anggota = new AnggotaKelompok;
                $anggota->user_id = $item;
                $kelompok->anggota()->save($anggota);
            }

            DB::commit();

            return to_route('admin.kelompok-siswa.index')->with('message', [
                'icon' => 'success',
                'title' => 'Success!',
                'text' => "Berhasil me-edit kelompok"
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('message', [
                'icon' => 'error',
                'title' => 'Gagal!',
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
            $kelompok = Kelompok::where('id', $id)->first();

            if (!$kelompok) {
                return back()->with('message', [
                    'icon' => 'error',
                    'title' => 'Gagal!',
                    'text' => 'ID Kelompok tidak ditemukan'
                ]);
            }
            $kelompokName = $kelompok->nama_kelompok;

            $kelompok->delete();

            DB::commit();
            return to_route('admin.kelompok-siswa.index')->with('message', [
                'icon' => 'success',
                'title' => 'Success!',
                'text' => "Berhasil me-hapus kelompok $kelompokName"
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
}
