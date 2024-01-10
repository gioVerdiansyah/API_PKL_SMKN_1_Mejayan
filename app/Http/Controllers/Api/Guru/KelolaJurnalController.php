<?php

namespace App\Http\Controllers\Api\Guru;

use App\Http\Controllers\Controller;
use App\Models\Jurnal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelolaJurnalController extends Controller
{
    public function getJurnal()
    {
        try {
            $jurnal = Jurnal::with('user')->whereDate('created_at', today())->get();

            return response()->json(['jurnal' => ['success' => true, 'data' => $jurnal]]);
        } catch (\Exception $e) {
            return response()->json(['jurnal' => ['success' => false, 'message' => 'Ada kesalahaan server!']]);
        }
    }
    public function getNextPrevJurnal(int $day, int $status = null)
    {
        try {
            $jurnal = Jurnal::with('user');

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
}
