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

class PengurusPklController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pengurus = Guru::latest()->where('kakomli_id', auth()->guard('kakomli')->user()->id);

        if ($request->has('query') && !empty($request->input('query'))) {
            $input = $request->input('query');
            $pengurus->where('nama', 'LIKE', '%' . $input . '%')
                ->orWhere('email', 'LIKE', $input);
        }

        $pengurus = $pengurus->paginate(10);

        return view('kakomli.pengurus_pkl.index', compact('pengurus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kakomli.pengurus_pkl.create');
    }

    public function createFromAPI(){
        try{
            $response = Http::withHeader('x-api-key', config('app.api_key'))->get(config('app.admin_url_api') . 'guru');
            $data = json_decode($response->body());
            return view('kakomli.pengurus_pkl.createFromAPI', compact('data'));
        }catch(\Exception){
            return back()->with('message', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => "Ada kesalahaan server!"
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PengurusPklStoreRequest $request)
    {
        try{
            DB::beginTransaction();

            $pengurus = new Guru;
            $pengurus->nama = $request->nama;
            $pengurus->email = $request->email;
            $pengurus->no_hp = $request->no_hp;
            $pengurus->password = Hash::make($request->password);
            $pengurus->kakomli_id = auth()->guard('kakomli')->user()->id;
            $pengurus->deskripsi = $request->deskripsi;

            if($request->hasFile('photo_guru')){
                $fileName = $request->file('photo_guru')->hashName();
                $path = $request->file('photo_guru')->storeAs('photo_guru', $fileName);
                $pengurus->photo_guru = 'storage/' . $path;
            }

            $pengurus->save();

            DB::commit();
            return to_route('pengurus-pkl.index')->with('message', [
                'icon' => 'success',
                'title' => 'Success',
                'text' => "Berhasil menambah pengurus pkl"
            ]);
        }catch(\Exception $e){
            DB::rollBack();
            return back()->with('message', [
                'icon' => 'error',
                'title' => 'Ada kesalahan server',
                'text' => "Error: $e"
            ]);
        }
    }

    public function storeFromAPI(PengurusPklStoreAPIRequest $request){
        try{
            $guru_id = $request->guru_id;
            $response = Http::withHeader('x-api-key', config('app.api_key'))->post(config('app.admin_url_api') . 'selected-guru', [
                'selectedGuru' => $guru_id
            ]);

            $data = json_decode($response->body());

            DB::beginTransaction();

            foreach($data as $item){
                $pengurus = new Guru;
                $pengurus->nama = $item->nama;
                $pengurus->email = $item->email;
                $pengurus->no_hp = $item->nomor_hp;
                $pengurus->password = Hash::make('password');
                $pengurus->kakomli_id = auth()->guard('kakomli')->user()->id;
                $pengurus->photo_guru = config('app.admin_url') . $item->foto_guru;
                $pengurus->save();
            }

            DB::commit();
            return to_route('pengurus-pkl.index')->with('message', [
                'icon' => 'success',
                'title' => 'Success',
                'text' => "Berhasil menambah pengurus pkl"
            ]);
        }catch(\Exception){
            return back()->with('message', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => "Ada kesalahaan server!"
            ]);
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pengurus = Guru::where('id', $id)->first();
        if (!$pengurus) {
            return back()->with('message', [
                'icon' => 'error',
                'title' => 'Ada kesalahan server',
                'text' => "ID guru tidak ditemukan"
            ]);
        }

        return view('kakomli.pengurus_pkl.edit', compact('pengurus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $pengurus = Guru::where('id', $id)->first();

            if (!$pengurus) {
                return back()->with('message', [
                    'icon' => 'error',
                    'title' => 'Ada kesalahan server',
                    'text' => "ID siswa tidak ditemukan"
                ]);
            }

            $pengurus->nama = $request->nama;
            $pengurus->email = $request->email;
            $pengurus->email = $request->no_hp;
            $pengurus->kakomli_id = auth()->guard('kakomli')->user()->id;
            $pengurus->deskripsi = $request->deskripsi;

            if ($request->password !== null) {
                $pengurus->password = Hash::make($request->password);
            }

            if ($request->hasFile('photo_guru')) {
                if (strpos($pengurus->photo_guru, 'storage/') !== false) {
                    if (Storage::exists(explode('storage/', $pengurus->photo_guru)[1])) {
                        Storage::delete(explode('storage/', $pengurus->photo_guru)[1]);
                    }
                }
                $fileName = $request->file('photo_guru')->hashName();
                $path = $request->file('photo_guru')->storeAs('photo_guru', $fileName);
                $pengurus->photo_guru = 'storage/' . $path;
            }

            $pengurus->save();

            DB::commit();
            return to_route('pengurus-pkl.index')->with('message', [
                'icon' => 'success',
                'title' => 'Success',
                'text' => "Berhasil me-edit pengurus pkl"
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
            $pengurus = Guru::where('id', $id)->first();

            if (!$pengurus) {
                return back()->with('message', [
                    'icon' => 'error',
                    'title' => 'Gagal!',
                    'text' => 'ID Pengurus PKL tidak ditemukan'
                ]);
            }
            $pengurusName = $pengurus->name;

            if (strpos($pengurus->photo_guru, 'storage/') !== false) {
                if (Storage::exists(explode('storage/', $pengurus->photo_guru)[1])) {
                    Storage::delete(explode('storage/', $pengurus->photo_guru)[1]);
                }
            }

            $pengurus->delete();

            DB::commit();
            return to_route('pengurus-pkl.index')->with('message', [
                'icon' => 'success',
                'title' => 'Success!',
                'text' => "Berhasil me-hapus pengurus PKL $pengurusName"
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
        return Excel::download(new PengurusPklExport(), 'tambah_data_pengurus_pkl.xlsx');
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

            Excel::import(new PengurusPklImport(), $file);

            return to_route('pengurus-pkl.index')->with('message', [
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
