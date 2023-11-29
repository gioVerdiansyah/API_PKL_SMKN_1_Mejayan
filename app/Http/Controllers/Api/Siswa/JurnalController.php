<?php

namespace App\Http\Controllers\Api\Siswa;

use App\Http\Controllers\Controller;
use App\Http\Requests\JurnalStoreRequest;
use App\Models\Jurnal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JurnalController extends Controller
{
    public function jurnal(JurnalStoreRequest $request){
        try {
            DB::beginTransaction();

            $user = User::where('id', $request->user_id)->first();
            if(!$user){
                return response()->json(['jurnal' => ['success' => false, 'message' => "User tidak ditemukan"]],404);
            }

            $sudahMengisi = Jurnal::where("user_id", $user->id)->whereDate('created_at',today())->exists();
            if($sudahMengisi){
                return response()->json(['jurnal' => ['success' => false, 'message' => "Anda sudah mengisi jurnal pada hari ini"]],403);
            }

            $jurnal = new Jurnal;
            $jurnal->user_id = $user->id;
            $jurnal->kegiatan = $request->kegiatan;


            if (!$request->hasFile("bukti")) {
                return response()->json(["jurnal" => ["success" => false, "message" => "Foto Bukti tidak ditemukan!"]], 404);
            }

            $fileName = $request->file("bukti")->hashName();
            $path = $request->file("bukti")->storeAs("jurnal", $fileName,);

            $jurnal->bukti = $path;
            $jurnal->save();

            DB::commit();

            return response()->json(["jurnal"=> ["success"=> true,'message' => 'Berhasil mengisi jurnal pada hari ini']],200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["jurnal" => ['success' => false, "message" => "Error: {$e->getMessage()}"]],500);
        }
    }
}
