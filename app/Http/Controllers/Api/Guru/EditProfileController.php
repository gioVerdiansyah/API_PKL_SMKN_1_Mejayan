<?php

namespace App\Http\Controllers\Api\Guru;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateGuruRequest;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EditProfileController extends Controller
{
    public function edit(UpdateGuruRequest $request, string $guru_id)
    {
        try {
            DB::beginTransaction();
            $guru = Guru::where("id", $guru_id)->first();

            if (!$guru) {
                return response()->json(['success' => false, 'message' => "User ID tidak ditemukan!"], 403);
            }

            if ($request->hasFile('photo_guru')) {
                if (strpos($guru->photo_guru, 'storage/') !== false) {
                    Storage::delete(explode('storage/', $guru->photo_guru)[1]);
                }
                $fileName = $request->file('photo_guru')->hashName();
                $path = $request->file('photo_guru')->storeAs('photo_guru', $fileName);
                $guru->photo_guru = config('app.url') . '/storage/' . $path;
            }

            if ($request->no_hp) {
                $guru->no_hp = $request->no_hp;
            }

            $guru->email = $request->email;
            $guru->deskripsi = $request->deskripsi;

            if ($request->filled('oldPass') && $request->filled('newPass')) {
                if (Hash::check($request->oldPass, $guru->password)) {
                    $guru->password = Hash::make($request->newPass);
                } else {
                    return response()->json(['success' => false, 'message' => "Password tidak sama dengan yang dulu"], 403);
                }
            }

            $guru->save();
            DB::commit();
            return response()->json(['success' => true, 'message' => "Logout dan login kembali untuk melihat perubahan"], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => "Error: " . $e->getMessage()], 500);
        }
    }
}
