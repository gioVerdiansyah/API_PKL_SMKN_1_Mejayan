<?php

namespace App\Http\Controllers\Api\Guru;

use App\Http\Controllers\Controller;
use App\Models\Izin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelolaIzinController extends Controller
{
    public function getIzin(string $guru_id, $status = null)
    {
        try {
            $izin = Izin::with([
                'user' => function ($query) use ($guru_id) {
                    $query->where('guru_id', $guru_id);
                }
            ]);

            if(!is_null($status)){
                $izin = $izin->where('status', $status);
            }

            $izin = $izin->paginate(1);

            return response()->json(['izin' => ['success' => true, 'data' => $izin]]);
        } catch (\Exception $e) {
            return response()->json(['izin' => ['success' => false, 'message' => "Ada kesalahaan server"]]);
        }
    }

    public function izinAgreement(Request $request)
    {
        try {
            DB::beginTransaction();
            $izin = Izin::where('id', $request->izin_id)->first();

            if (!$izin) {
                return response()->json(['izin' => ['success' => false, 'message' => 'ID izin tidak ditemukan']]);
            }

            $izin->status = "{$request->status}";
            if ($request->has('keterangan')) {
                $izin->comment_guru = $request->keterangan;
            }
            $izin->save();

            DB::commit();
            return response()->json(['izin' => ['success' => true, 'message' => "Izin berhasil di " . (($request->status == 1) ? 'setujui' : 'tolak')]]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['izin' => ['success' => false, 'message' => 'Error: ' . $e]]);
        }
    }
}
