<?php

namespace App\Http\Controllers\Api\Guru;

use App\Http\Controllers\Controller;
use App\Models\Jurnal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelolaJurnalController extends Controller
{
    public function getJurnal(string $guru_id)
    {
        try {
            $jurnal = Jurnal::with(['user' => function($query) use($guru_id) {
$query->where('guru_id', $guru_id);
            }])->whereDate('created_at', today())->get();

            return response()->json(['jurnal' => ['success' => true, 'data' => $jurnal]]);
        } catch (\Exception $e) {
            return response()->json(['jurnal' => ['success' => false, 'message' => 'Ada kesalahaan server!']]);
        }
    }
    public function getNextPrevJurnal(string $guru_id, int $day, int $status = null)
    {
        try {
            $jurnal = Jurnal::with([
                'user' => function ($query) use ($guru_id) {
                    $query->where('guru_id', $guru_id);
                }
            ]);

            if($status){
                $jurnal = $jurnal->where('status', "$status");
            }

            $jurnal = $jurnal->whereDate('created_at', today()->subDays($day))->get();

            return response()->json(['jurnal' => ['success' => true, 'data' => $jurnal]]);
        } catch (\Exception $e) {
            return response()->json(['jurnal' => ['success' => false, 'message' => 'Ada kesalahaan server!']]);
        }
    }

    public function jurnalAgreement(Request $request){
        try{
            DB::beginTransaction();
            $jurnal = Jurnal::where('id', $request->jurnal_id)->first();

            if(!$jurnal){
                return response()->json(['jurnal' => ['success' => false, 'message' => 'ID jurnal tidak ditemukan']]);
            }

            $jurnal->status = "{$request->status}";
            if($request->has('keterangan')){
                $jurnal->keterangan = $request->keterangan;
            }
            $jurnal->save();

            DB::commit();
            return response()->json(['jurnal' => ['success' => true, 'message' => "Jurnal berhasil di " . (($request->status == 1) ? 'setujui' : 'tolak')]]);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['jurnal' => ['success' => false, 'message' => 'Error: ' . $e]]);
        }
    }

    public function jurnalReject(){
        try{
            $user_id = [];
            $absen = Jurnal::whereDate('created_at', today())->get();
            foreach ($absen as $item) {
                array_push($user_id, $item->user_id);
            }
            $user = User::whereNotIn('id', $user_id)->get();

            return response()->json(['jurnal' => ['success' => true, 'data' => $user]]);
        }catch(\Exception $e){
            return response()->json(['jurnal' => ['success' => false, 'message' => "Ada kesalahan server"]]);
        }
    }
}
