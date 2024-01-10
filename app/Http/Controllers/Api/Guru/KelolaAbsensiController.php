<?php

namespace App\Http\Controllers\Api\Guru;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\User;
use Illuminate\Http\Request;

class KelolaAbsensiController extends Controller
{
    public function getAbsen(Request $request, string $guru_id)
    {
        try {
            $absen = Absensi::with([
                'user' => function ($query) use ($guru_id) {
                    $query->where('guru_id', $guru_id);
                }
            ])->whereDate('created_at', today())->whereNot('status', 5)->paginate(1);

            return response()->json(['absen' => ['success' => true, 'data' => $absen]], 200);
        } catch (\Exception $e) {
            return response()->json(['absen' => ['success' => false, 'message' => "Error: {$e->getMessage()}"]], 500);
        }
    }
    public function getAbsenPulang(Request $request, string $guru_id)
    {
        try {
            $absen = Absensi::with([
                'user' => function ($query) use ($guru_id) {
                    $query->where('guru_id', $guru_id);
                }
            ])->whereDate('created_at', today())->where('status', 5)->paginate(1);

            return response()->json(['absen' => ['success' => true, 'data' => $absen]], 200);
        } catch (\Exception $e) {
            return response()->json(['absen' => ['success' => false, 'message' => "Error: {$e->getMessage()}"]], 500);
        }
    }

    public function absenReject(string $guru_id)
    {
        try {
            $user_id = [];
            $absen = Absensi::whereDate('created_at', today())->get();
            foreach ($absen as $item) {
                array_push($user_id, $item->user_id);
            }
            $user = User::whereNotIn('id', $user_id)->get();

            return response()->json(['is' => $user_id, 'absen' => ['success' => true, 'data' => $user]]);
        } catch (\Exception $e) {
            return response()->json(['absen' => ['success' => false, 'message' => "Ada kesalahan server!"]]);
        }
    }
}
