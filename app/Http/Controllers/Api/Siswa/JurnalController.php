<?php

namespace App\Http\Controllers\Api\Siswa;

use App\Http\Controllers\Controller;
use App\Http\Requests\JurnalStoreRequest;
use App\Models\Jurnal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class JurnalController extends Controller
{
    public function jurnal(JurnalStoreRequest $request){
        try {
            DB::beginTransaction();

            $user = User::where('id', $request->user_id)->first();
            if(!$user){
                return response()->json(['success' => false, 'message' => "User tidak ditemukan"],404);
            }

            $sudahMengisi = Jurnal::where("user_id", $user->id)->whereDate('created_at',today())->exists();
            if($sudahMengisi){
                return response()->json(['success' => false, 'message' => "Anda sudah mengisi jurnal pada hari ini"],403);
            }

            $jurnal = new Jurnal;
            $jurnal->user_id = $user->id;
            $jurnal->kegiatan = $request->kegiatan;


            if (!$request->hasFile("bukti")) {
                return response()->json(["success" => false, "message" => "Foto Bukti tidak ditemukan!"], 404);
            }

            $fileName = $request->file("bukti")->hashName();
            $path = $request->file("bukti")->storeAs("jurnal", $fileName,);

            $jurnal->bukti = $path;
            $jurnal->save();

            DB::commit();

            return response()->json(["success"=> true,'message' => 'Berhasil mengisi jurnal pada hari ini'],200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, "message" => "Error: {$e->getMessage()}"],500);
        }
    }

    public function jurnalGet(string $id){
        try{
            $jurnal = Jurnal::where('user_id', $id)->orderBy('created_at', 'desc')->paginate(2);

            if(!$jurnal){
                return response()->json(['success' => false, 'message' => "ID user tidak ditemukan, cobalah logout lalu login ulang"], 404);
            }

            return response()->json(['success' => true, 'data' => $jurnal], 200);
        }catch(\Exception $e){
            return response()->json(['success' => false, 'message' => "Error: Error: {$e->getMessage()}"], 500);
        }
    }
    public function jurnalShow(string $id){
        try{
            $jurnal = Jurnal::where('id', $id)->first();

            if(!$jurnal){
                return response()->json(['success' => false, 'message' => "ID user tidak ditemukan, cobalah logout lalu login ulang"], 404);
            }

            return response()->json(['success' => true, 'data' => $jurnal], 200);
        }catch(\Exception $e){
            return response()->json(['success' => false, 'message' => "Error: Error: {$e->getMessage()}"], 500);
        }
    }

    public function editJurnal(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $jurnal = Jurnal::where('id', $id)->first();

            if(!$jurnal){
                return response()->json(['success' => false, 'message' => "ID Jurnal tidak ditemukan!"], 404);
            }

            $jurnal->kegiatan = $request->kegiatan;
            $jurnal->status = '0';

            $path = $jurnal->bukti;

            if ($request->hasFile("bukti")) {
                $fileName = $request->file("bukti")->hashName();

                if(Storage::exists($path)){
                    Storage::delete($path);
                }

                $path = $request->file("bukti")->storeAs("jurnal", $fileName, );
            }


            $jurnal->bukti = $path;
            $jurnal->save();

            DB::commit();

            return response()->json(["success" => true, 'message' => 'Berhasil me-edit jurnal'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, "message" => "Error: {$e->getMessage()}"], 500);
        }
    }
}
