<?php

namespace App\Http\Controllers\Api\Guru;

use App\Http\Controllers\Controller;
use App\Models\Izin;
use Illuminate\Http\Request;

class KelolaIzinController extends Controller
{
    public function getIzin(string $guru_id)
    {
        try {
            $izin = Izin::with([
                'user' => function ($query) use ($guru_id) {
                    $query->where('guru_id', $guru_id);
                }
            ])->paginate(1);

            return response()->json(['izin' => ['success' => true, 'data' => $izin]]);
        } catch (\Exception $e) {
            return response()->json(['izin' => ['success' => false, 'message' => "Ada kesalahaan server"]]);
        }
    }
}
