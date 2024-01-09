<?php

namespace App\Http\Controllers\Api\Guru;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;

class KelolaAbsensiController extends Controller
{
    public function getAbsen(Request $request)
    {
        try {
            $absen = Absensi::with('user')->whereDate('created_at', today())->whereNot('status', 5)->paginate(1);

            return response()->json(['absen' => ['success' => true, 'data' => $absen]], 200);
        } catch (\Exception $e) {
            return response()->json(['absen' => ['success' => false, 'message' => "Error: {$e->getMessage()}"]], 500);
        }
    }
    public function getAbsenPulang(Request $request)
    {
        try {
            $absen = Absensi::with('user')->whereDate('created_at', today())->where('status', 5)->paginate(1);

            return response()->json(['absen' => ['success' => true, 'data' => $absen]], 200);
        } catch (\Exception $e) {
            return response()->json(['absen' => ['success' => false, 'message' => "Error: {$e->getMessage()}"]], 500);
        }
    }
}
