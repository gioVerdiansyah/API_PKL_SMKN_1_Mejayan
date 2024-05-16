<?php

namespace App\Http\Controllers\Kakomli;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileKakomliRequest;
use App\Models\Guru;
use App\Models\Kakomli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EditProfileController extends Controller
{
    public function edit()
    {
        $kakomli = Kakomli::where('id', auth()->guard('kakomli')->user()->id)->first();
        $guru = Guru::where('nama', $kakomli->nama)->first();
        return view('kakomli.edit_profile', compact('kakomli', 'guru'));
    }
    public function update(UpdateProfileKakomliRequest $request)
    {
        try {
            DB::beginTransaction();
            $kakomli = Kakomli::where('id', auth()->guard('kakomli')->user()->id)->first();

            $guru = Guru::where('nama', $kakomli->nama)->first();
            $guru->nama = $request->nama;
            $guru->no_hp = $request->no_hp;
            $guru->email = $request->email;
            $guru->deskripsi = $request->deskripsi;

            $kakomli->nama = $request->nama;
            $kakomli->email = $request->email;
            if ($request->has('password')) {
                $kakomli->password = Hash::make($request->password);
                $guru->password = Hash::make($request->password);
            }

            if ($request->hasFile('photo_profile')) {
                if (strpos($kakomli->photo_profile, 'storage/') !== false) {
                    Storage::delete(explode('storage/', $kakomli->photo_profile)[1]);
                }
                $fileName = $request->file('photo_profile')->hashName();
                $path = $request->file('photo_profile')->storeAs('photo_kakomli', $fileName);
                $kakomli->photo_profile = 'storage/' . $path;

                $guru->photo_profile = config('app.url') . '/storage/' . $path;
            }

            $guru->save();
            $kakomli->save();
            DB::commit();
            return to_route('kakomli.edit_profile')->with('message', [
                'icon' => 'success',
                'title' => "Berhasil",
                'text' => "Berhasil me-update profile!"
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('message', [
                'icon' => 'success',
                'title' => "Berhasil",
                'text' => "Berhasil me-update profile!"
            ]);
        }
    }
}
