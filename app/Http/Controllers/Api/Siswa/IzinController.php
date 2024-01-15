<?php

namespace App\Http\Controllers\Api\Siswa;

use App\Http\Controllers\Controller;
use App\Http\Requests\IzinStoreRequest;
use App\Models\Izin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class IzinController extends Controller
{
    public function izin(IzinStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = User::where('name', $request->name)->first();

            if (!$user) {
                return response()->json(['izin' => ['success' => false, 'message' => 'Nama siswa tidak ditemukan']], 404);
            }

            $sudahIzin = Izin::where('user_id', $user->id)->whereDate('created_at', today())->exists();
            if ($sudahIzin) {
                return response()->json(['izin' => ['success' => false, "message" => "Anda sudah izin pada hari ini"]], 403);
            }

            $izin = new Izin;
            $izin->user_id = $user->id;
            $izin->tipe_izin = $request->tipe_izin;
            $izin->alasan = $request->alasan;
            $izin->awal_izin = Carbon::parse($request->awal_izin);
            $izin->akhir_izin = Carbon::parse($request->akhir_izin);

            if (!$request->hasFile("bukti")) {
                return response()->json(["izin" => ["success" => false, "message" => "Foto Bukti tidak ditemukan!"]], 404);
            }

            $nameFile = $request->file('bukti')->hashName();
            $path = $request->file('bukti')->storeAs('bukti_izin', $nameFile);

            $izin->bukti = $path;
            $izin->save();

            DB::commit();
            return response()->json(['izin' => ['success' => true, 'message' => "Berhasil izin pada hari ini"]], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["izin" => ["success" => false, 'message' => "Error: {$e->getMessage()}"]], 500);
        }
    }

    public function izinGet(string $id)
    {
        try {
            $user = User::where('id', $id)->first();
            if (!$user) {
                return response()->json(['izin' => ['success' => false, 'message' => 'User Id tidak di temukan']], 404);
            }
            $dataIzin = Izin::where('user_id', $user->id)->latest()->paginate(3);

            return response()->json(['izin' => ['success' => true, 'message' => 'Berhasil mendapatkan data', 'data' => $dataIzin->toArray()]], 200);
        } catch (\Exception $e) {
            return response()->json(['izin' => ['success' => false, 'message' => "Error: {$e->getMessage()}"]], 500);
        }
    }

    public function izinShow(string $id)
    {
        try{
            $dataIzin = Izin::with('user')->where('id', $id)->first();

            if (!$dataIzin){
                return response()->json(['izin' => ['success' => false, 'message' => 'Data izin tidak ditemukan']], 404);
            }

            return response()->json(['izin' => ['success' => true, 'message' => 'Berhasil mendapatkan data', 'data' => $dataIzin]], 200);
        }catch(\Exception $e){
            return response()->json(['izin' => ['success' => false, 'message' => "Error: {$e->getMessage()}"]], 500);
        }
    }

    public function editIzin(Request $request, string $id)
    {
        try {
            DB::beginTransaction();
            $user = User::where('name', $request->name)->first();

            if (!$user) {
                return response()->json(['izin' => ['success' => false, 'message' => $request->all()]], 404);
            }

            $izin = Izin::where('id', $id)->first();

            if(!$izin){
                return response()->json(['izin' => ['success' => false, 'message' => 'ID Absen tidak ditemukan']], 404);
            }

            $izin->user_id = $user->id;
            $izin->tipe_izin = $request->tipe_izin;
            $izin->alasan = $request->alasan;
            $izin->awal_izin = Carbon::parse($request->awal_izin);
            $izin->akhir_izin = Carbon::parse($request->akhir_izin);

            $path = $izin->bukti;
            if ($request->hasFile("bukti")) {
                if(Storage::exists($path)){
                    Storage::delete($path);
                }
                $nameFile = $request->file('bukti')->hashName();
                $path = $request->file('bukti')->storeAs('bukti_izin', $nameFile);
            }


            $izin->bukti = $path;
            $izin->save();

            DB::commit();
            return response()->json(['izin' => ['success' => true, 'message' => "Berhasil me-edit izin"]], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["izin" => ["success" => false, 'message' => "Error: {$e->getMessage()}"]], 500);
        }
    }
}
