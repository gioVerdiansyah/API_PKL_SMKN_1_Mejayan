<?php

namespace App\Http\Controllers\Api\Siswa;

use App\Http\Controllers\Controller;
use App\Http\Requests\AbsenRequest;
use App\Http\Requests\AbsenSalahRequest;
use App\Models\Absensi;
use App\Models\Dudi;
use App\Models\Guru;
use App\Models\Izin;
use App\Models\Kelompok;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{

    public function absen(AbsenRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = User::select('id')->where('id', $request->user_id)->first();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'User tidak ditemukan'], 404);
            }
            $user_id = $user->id;

            $kelompok = Kelompok::select('dudi_id')->with([
                'anggota' => function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                }
            ])->first();
            $dudi = Dudi::where('id', $kelompok->dudi_id)->first();

            $absenSudahAda = Absensi::where('user_id', $user_id)
                ->whereDate('created_at', today())->where('status', '!=', '5')
                ->exists();

            if ($absenSudahAda) {
                return response()->json(['success' => false, 'message' => 'Anda sudah absen!'], 403);
            }

            $absenIzin = Izin::where('user_id', $user_id)->whereDate('created_at', today())->exists();
            if ($absenIzin) {
                return response()->json(['success' => false, 'message' => "Anda tidak bisa absen karena anda sudah melakukan izin"], 403);
            }

            $coorUser = ['latitude' => $request->lat, 'longitude' => $request->lon];
            $officeCoordinates = explode(', ', $dudi['koordinat']);
            $officeCoordinates = ['latitude' => $officeCoordinates[0], 'longitude' => $officeCoordinates[1]];

            $jarak = $this->hitungJarak($coorUser, $officeCoordinates);

            $jarakBatas = 100;

            $now = Carbon::now()->locale('id');
            $hariIni = strtolower(Carbon::parse($now)->locale('id')->dayName);

            $jamMasuk = $dudi["$hariIni"];
            if (is_null($jamMasuk)) {
                return response()->json(["success" => false, "message" => "Anda tidak dapat absen pada hari $hariIni"], 403);
            }
            $jamMasuk = explode(" - ", $jamMasuk)[0];
            $jamMasukTimestamp = strtotime($jamMasuk);
            $jamSekarangTimestamp = strtotime($now->format('H:i'));

            $selisihSatuJam = 3600;

            if ($jamSekarangTimestamp >= ($jamMasukTimestamp - $selisihSatuJam)) {
                if ($jamSekarangTimestamp < strtotime(config('app.jam_tutup_absen'))) {
                    if ($request->wfh == '1') {
                        if ($jamSekarangTimestamp > $jamMasukTimestamp) {
                            Absensi::create([
                                'user_id' => $user_id,
                                'status' => 4,
                                'datang' => Carbon::now()
                            ]);
                            DB::commit();
                            return response()->json(['success' => true, 'status' => 4, 'message' => 'Berhasil absen WFH!'], 201);
                        } else {
                            Absensi::create([
                                'user_id' => $user_id,
                                'status' => 5,
                                'datang' => Carbon::now()
                            ]);
                            DB::commit();
                            return response()->json(['success' => true, 'status' => 4, 'message' => 'Anda telat absen WFH!'], 201);
                        }
                    }
                    if ($jarak <= $jarakBatas) {
                        if ($jamSekarangTimestamp > $jamMasukTimestamp) {
                            Absensi::create([
                                'user_id' => $user_id,
                                'status' => 2,
                                'datang' => Carbon::now()
                            ]);
                            DB::commit();
                            return response()->json(['success' => true, 'status' => 2, 'message' => 'Anda telat absen!'], 201);
                        } else {
                            Absensi::create([
                                'user_id' => $user_id,
                                'status' => 1,
                                'datang' => Carbon::now()
                            ]);
                            DB::commit();
                            return response()->json(['success' => true, 'status' => 1, 'message' => 'Berhasil absen tepat waktu!'], 201);
                        }
                    } else {
                        return response()->json(['success' => false, 'message' => 'Anda harus berada di kantor untuk melakukan absen'], 403);
                    }
                }else{
                    Absensi::create([
                        'user_id' => $user_id,
                        'status' => 3,
                        'datang' => Carbon::now()
                    ]);
                    DB::commit();
                    return response()->json(['success' => true, 'status' => 4, 'message' => 'Anda dinyatakan ALPHA'], 201);
                }
            } else {
                return response()->json(['success' => false, 'message' => 'Absen di mulai 1 jam sebelum jam masuk!'], 403);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, "message" => "Error: {$e->getMessage()}"], 500);
        }
    }

    private function hitungJarak($coord1, $coord2)
    {
        $lat1 = deg2rad($coord1['latitude']);
        $lon1 = deg2rad($coord1['longitude']);
        $lat2 = deg2rad($coord2['latitude']);
        $lon2 = deg2rad($coord2['longitude']);

        $deltaLat = $lat2 - $lat1;
        $deltaLon = $lon2 - $lon1;

        $a = sin($deltaLat / 2) ** 2 + cos($lat1) * cos($lat2) * sin($deltaLon / 2) ** 2;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $radius = 6371;

        $distance = $radius * $c;

        return $distance * 1000;
    }

    public function absenSalah(Request $request)
    {
        try {
            DB::beginTransaction();
            $user = User::where('id', $request->user_id)->first();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'User tidak ditemukan'], 404);
            }

            $kelompok = Kelompok::select('dudi_id')->with([
                'anggota' => function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                }
            ])->first();
            $dudi = Dudi::where('id', $kelompok->dudi_id)->first();

            $absen = Absensi::whereDate('created_at', today())->where('status', '!=', '5')->first();
            if (!$absen) {
                return response()->json(['success' => false, 'message' => "ID Absen tidak ditemukan, mungkin Anda belum absen!"]);
            }

            $now = Carbon::now()->locale('id');
            $hariIni = strtolower(Carbon::parse($now)->locale('id')->dayName);

            $jamMasuk = $dudi["$hariIni"];
            if (is_null($jamMasuk)) {
                return response()->json(["success" => false, "message" => "Anda tidak dapat absen pada hari $hariIni"], 403);
            }
            $jamMasuk = explode(" - ", $jamMasuk)[0];
            $jamMasukTimestamp = strtotime($jamMasuk);
            $jamSekarangTimestamp = strtotime($now->format('H:i'));

            $selisihSatuJam = 3600;

            if ($jamSekarangTimestamp >= ($jamMasukTimestamp - $selisihSatuJam)) {
                switch ($request->status) {
                    case '4':
                        $absen->status = $request->status;
                        $absen->save();
                        DB::commit();
                        return response()->json(['success' => true, 'message' => "Berhasil mengubah absen menjadi WFH"]);
                    case '1':
                        $absen->status = $request->status;
                        $absen->save();
                        DB::commit();
                        return response()->json(['success' => true, 'message' => "Berhasil mengubah absen menjadi hadir"]);
                    default:
                        return response()->json(['success' => false, 'message' => "Status Absensi tidak valid!"]);
                }
            } else {
                return response()->json(['success' => false, 'message' => 'Absen di mulai 1 jam sebelum jam masuk!'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, "Error: $e"]);
        }
    }

    public function pulang(AbsenRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = User::where('id', $request->user_id)->first();

            if (!$user) {
                return response()->json(['success' => false, 'message' => 'User tidak ditemukan'], 404);
            }
            $user_id = $user->id;

            $absenPulang = Absensi::where('user_id', $user_id)
                ->whereDate('created_at', today())
                ->where('pulang', '!=', null)
                ->exists();

            if ($absenPulang) {
                return response()->json(['success' => false, 'message' => 'Anda sudah absen pulang!'], 403);
            }

            $absenAlpha = Absensi::where('user_id', $user_id)
                ->whereDate('created_at', today())
                ->where('status', 3)
                ->exists();

            if ($absenAlpha) {
                return response()->json(['success' => false, 'message' => 'Anda tidak bisa absen pulang karena anda dinyatakan alpha!'], 403);
            }

            $absenHadir = Absensi::where('user_id', $user_id)
            ->whereDate('created_at', today())
            ->whereIn('status', [1, 2, 4, 5])
                ->exists();

            if (!$absenHadir) {
                return response()->json(['success' => false, 'message' => 'Anda belum absen hadir pada hari ini!'], 403);
            }

            $absenCutiIzinSakit = Izin::where('user_id', $user_id)
                ->whereDate('created_at', today())
                ->exists();

            if ($absenCutiIzinSakit) {
                return response()->json(['success' => false, 'message' => 'Anda tidak bisa absen pulang karena [\'Cuti\', \'Izin\', \'Sakit\']!'], 403);
            }

            $absenPulang = Absensi::where('user_id', $user_id)->whereDate('created_at', today())->first();

            $absenPulang->pulang = Carbon::now();
            $absenPulang->save();

            DB::commit();
            return response()->json(['success' => true, 'status' => 1, 'message' => 'Berhasil absen pulang!'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, "message" => "Error: {$e->getMessage()}"], 500);
        }
    }
}
