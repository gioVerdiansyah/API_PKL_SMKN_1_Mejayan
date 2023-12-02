<?php

namespace App\Http\Controllers\Api\Siswa;

use App\Http\Controllers\Controller;
use App\Http\Requests\UbahPassUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UbahPassController extends Controller
{
    public function ubahPass(UbahPassUpdateRequest $request){
        $data = $request->all();
        try {
            DB::beginTransaction();
            $user = User::where("id", $data["user_id"])->first();

            if(!$user){
                return response()->json(['ubahPass' => ['success' => false, 'message' => "User ID tidak ditemukan"]], 403);
            }

            if(Hash::check($data['oldPass'], $user->password)){
                $user->password = Hash::make($data['newPass']);
                $user->save();
                DB::commit();
                return response()->json(['ubahPass' => ['success' => true, 'message' => "Berhasil mengubah password"]], 201);
            }
            return response()->json(['ubahPass' => ['success' => false, 'message' => "Password tidak sama"]], 403);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['ubahPass' => ['success' => false, 'message' => "Error: ".$e->getMessage()]], 500);
        }
    }
}
