<?php

namespace App\Http\Controllers\Api\Siswa;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EditProfileController extends Controller
{
    public function editProfile(UpdateProfileRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $user = User::where("id", $id)->first();

            if (!$user) {
                return response()->json(['success' => false, 'message' => "User ID tidak ditemukan!"], 403);
            }

            if ($request->hasFile('photo_profile')) {
                if (Storage::exists(explode('storage/', $user->photo_profile)[1])) {
                    Storage::delete(explode('storage/', $user->photo_profile)[1]);
                }
                $fileName = $request->file('photo_profile')->hashName();
                $path = $request->file('photo_profile')->storeAs('photo_siswa', $fileName);
                $user->photo_profile = 'storage/' . $path;
            }

            if ($request->filled('oldPass') && $request->filled('newPass')) {
                if (Hash::check($request->oldPass, $user->password)) {
                    $user->password = Hash::make($request->newPass);
                } else {
                    return response()->json(['success' => false, 'message' => "Password tidak sama dengan yang dulu"], 403);
                }
            }

            if ($request->hasFile('photo_profile') || ($request->filled('oldPass') && $request->filled('newPass'))) {
                $user->save();
                DB::commit();
                return response()->json(['success' => true, 'message' => "Logout dan login kembali untuk melihat perubahan"], 201);
            } else {
                return response()->json(['success' => false, 'message' => "Tidak ada perubahan!!!"], 422);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => "Error: " . $e->getMessage()], 500);
        }
    }
}