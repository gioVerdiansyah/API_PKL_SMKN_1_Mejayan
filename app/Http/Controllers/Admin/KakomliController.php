<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\KakomliStoreRequest;
use App\Http\Requests\KakomliUpdateRequest;
use App\Models\Jurusan;
use App\Models\Kakomli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class KakomliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kakomli = Kakomli::with('jurusan')->whereNot('email', config('app.admin_email'))->paginate(10);
        return view('admin.kakomli.index', compact('kakomli'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hasJurusan = Kakomli::whereNot('email', config('app.admin_email'))->pluck('jurusan_id');
        $jurusans = Jurusan::whereNotIn('id', $hasJurusan)->get();
        return view('admin.kakomli.create', compact('jurusans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KakomliStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $kakomli = new Kakomli;
            $kakomli->jurusan_id = $request->jurusan;
            $kakomli->nama = $request->nama;
            $kakomli->email = $request->email;
            $kakomli->password = Hash::make($request->password);
            $kakomli->save();

            DB::commit();
            return to_route('kakomli.index')->with('message' , [
                'icon' => 'success',
                'title' => 'Success!',
                'text' => 'Berhasil menambah kakomli ' . $request->nama
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('message' , [
                'icon' => 'error',
                'title' => 'Ada kesalahan server',
                'text' => $e
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kakomli = Kakomli::where('id', $id)->first();
        $jurusans = Jurusan::all();
        if(!$kakomli){
            return back()->with('message', [
                'icon' => 'error',
                'title' => 'Ada kesalahan server',
                'text' => "ID kakomli tidak ditemukan"
            ]);
        }
        return view('admin.kakomli.edit', compact('kakomli', 'jurusans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KakomliUpdateRequest $request, string $id)
    {
        try{
            DB::beginTransaction();
            $kakomli = Kakomli::where('id', $id)->first();
            if (!$kakomli) {
                return back()->with('message', [
                    'icon' => 'error',
                    'title' => 'Ada kesalahan server',
                    'text' => "ID kakomli tidak ditemukan"
                ]);
            }

            $kakomli->jurusan_id = $request->jurusan;
            $kakomli->nama = $request->nama;
            $kakomli->email = $request->email;

            if($request->password !== null){
                $kakomli->password = Hash::make($request->password);
            }

            if($request->hasFile('photo_profile')){
                if (strpos($kakomli->photo_profile, 'storage/') !== false) {
                    if (Storage::exists(explode('storage/', $kakomli->photo_profile)[1])) {
                        Storage::delete(explode('storage/', $kakomli->photo_profile)[1]);
                    }
                }
                $fileName = $request->file('photo_profile')->hashName();
                $path = $request->file('photo_profile')->storeAs('photo_profile', $fileName);
                $kakomli->photo_profile = 'storage/' . $path;
            }

            $kakomli->save();

            DB::commit();
            return to_route('kakomli.index')->with('message', [
                'icon' => 'success',
                'title' => 'Success',
                'text' => "Berhasil me-update kakomli"
            ]);
        }catch(\Exception $e){
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
        try{
            DB::beginTransaction();
            $kakomli = Kakomli::where('id', $id)->first();
            if (!$kakomli) {
                return back()->with('message', [
                    'icon' => 'error',
                    'title' => 'Ada kesalahan server',
                    'text' => "ID kakomli tidak ditemukan"
                ]);
            }

            if (Storage::exists(explode('storage/', $kakomli->photo_profile)[1])) {
                Storage::delete(explode('storage/', $kakomli->photo_profile)[1]);
            }

            $kakomli->delete();

            DB::commit();
            return to_route('kakomli.index')->with('message', [
                'icon' => 'success',
                'title' => 'Success',
                'text' => "Berhasil me-hapus kakomli"
            ]);
        }catch(\Exception $e){
            DB::rollBack();
            return back()->with('message', [
                'icon' => 'error',
                'title' => 'Ada kesalahan server',
                'text' => $e
            ]);
        }
    }
}
