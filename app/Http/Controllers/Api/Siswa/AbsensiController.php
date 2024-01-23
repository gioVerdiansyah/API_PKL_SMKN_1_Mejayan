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
            $user = User::where('id', $request->user_id)->first();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'User tidak ditemukan'], 404);
            }
            $user_id = $user->id;

            $kelompok = Kelompok::with('dudi')->whereHas('anggota', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->first();
            $dudi = Dudi::where('id', $kelompok->dudi_id)->first();

            $absenSudahAda = Absensi::where('user_id', $user_id)
                ->whereDate('created_at', today())->where('status', '3')
                ->exists();

            if ($absenSudahAda) {
                return response()->json(['success' => false, 'message' => 'Anda tidak bisa Absen karena sudah dinyatakan ALPHA!'], 403);
            }


            $absenSudahAda = Absensi::where('user_id', $user_id)
                ->whereDate('created_at', today())->whereNotIn('status', ['3','6'])
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

            $jarakBatas = $dudi->radius;

            $now = Carbon::now()->locale('id');
            $hariIni = strtolower(Carbon::parse($now)->locale('id')->dayName);

            $jamMasuk = $user[$hariIni];
            if (is_null($jamMasuk)) {
                return response()->json(["success" => false, "message" => "Anda tidak dapat absen pada hari {$hariIni}"], 403);
            }
            $jamMasuk = explode(" - ", $jamMasuk)[0];
            $jamMasukTimestamp = strtotime($jamMasuk);
            $jamSekarangTimestamp = strtotime($now->format('H:i'));

            $selisihSatuJam = 3600;

            $jamMasuk = $user->{$hariIni};
            $jamMasuk = substr($jamMasuk, 0, 5);
            $telat = $now->diff(Carbon::parse($now->format('Y-m-d') . ' ' . $jamMasuk));
            $waktuTelat = $telat->format('%H:%I');
            $telatMenit = ($telat->h * 60) + $telat->i;

            if ($jamSekarangTimestamp >= ($jamMasukTimestamp - $selisihSatuJam)) {
                if ($jamSekarangTimestamp < strtotime(config('app.jam_tutup_absen'))) {
                    if ($request->wfh == '1') {
                        if ($jamSekarangTimestamp > $jamMasukTimestamp) {
                            Absensi::create([
                                'user_id' => $user_id,
                                'status' => 5,
                                'datang' => $now,
                                'telat' => $waktuTelat
                            ]);
                            DB::commit();
                            return response()->json(['success' => true, 'status' => 5, 'message' => 'Anda telat absen WFH selama ' . $telatMenit . ' menit'], 201);
                        } else {
                            Absensi::create([
                                'user_id' => $user_id,
                                'status' => 4,
                                'datang' => $now
                            ]);
                            DB::commit();
                            return response()->json(['success' => true, 'status' => 4, 'message' => 'Berhasil absen WFH!'], 201);
                        }
                    }
                    if ($jarak <= $jarakBatas) {
                        if ($jamSekarangTimestamp > $jamMasukTimestamp) {
                            Absensi::create([
                                'user_id' => $user_id,
                                'status' => 2,
                                'datang' => $now,
                                'telat' => $waktuTelat
                            ]);
                            DB::commit();
                            return response()->json(['success' => true, 'status' => 2, 'message' => 'Anda telat absen selama ' . $telatMenit . ' menit'], 201);
                        } else {
                            Absensi::create([
                                'user_id' => $user_id,
                                'status' => 1,
                                'datang' => $now
                            ]);
                            DB::commit();
                            return response()->json(['success' => true, 'status' => 1, 'message' => 'Berhasil absen tepat waktu!'], 201);
                        }
                    } else {
                        return response()->json(['success' => false, 'message' => 'Anda harus berada di kantor untuk melakukan absen'], 403);
                    }
                } else {
                    Absensi::create([
                        'user_id' => $user_id,
                        'status' => 3,
                        'datang' => $now,
                        'telat' => $waktuTelat
                    ]);
                    DB::commit();
                    return response()->json(['success' => true, 'status' => 3, 'message' => 'Anda dinyatakan ALPHA. Absen telah di tutup pukul ' . config('app.jam_tutup_absen')], 201);
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

            $kelompok = Kelompok::with('dudi')->whereHas('anggota', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->first();
            $dudi = Dudi::where('id', $kelompok->dudi_id)->first();

            $absenIzin = Izin::where('user_id', $user->id)->whereDate('created_at', today())->exists();
            if ($absenIzin) {
                return response()->json(['success' => false, 'message' => "Anda tidak bisa me-edit absen karena anda sudah melakukan izin"], 403);
            }

            $absen = Absensi::where('user_id', $user->id)->whereDate('created_at', today())->whereNotIn('status', ['3','6'])->first();
            if (!$absen) {
                return response()->json(['success' => false, 'message' => "ID Absen tidak ditemukan, mungkin Anda belum absen atau sudah dinyatakan ALPHA atau sudah melakukan izin pada hari ini!"]);
            }

            $now = Carbon::now()->locale('id');
            $hariIni = strtolower(Carbon::parse($now)->locale('id')->dayName);

            $jamMasuk = $user[$hariIni];
            if (is_null($jamMasuk)) {
                return response()->json(["success" => false, "message" => "Anda tidak dapat me-edit absen pada hari $hariIni"], 403);
            }
            $jamMasuk = explode(" - ", $jamMasuk)[0];
            $jamMasukTimestamp = strtotime($jamMasuk);
            $jamSekarangTimestamp = strtotime($now->format('H:i'));

            $selisihSatuJam = 3600;

            $jamMasuk = $user->{$hariIni};
            $jamMasuk = substr($jamMasuk, 0, 5);
            $telat = $now->diff(Carbon::parse($now->format('Y-m-d') . ' ' . $jamMasuk));
            $waktuTelat = $telat->format('%H:%I');
            $telatMenit = ($telat->h * 60) + $telat->i;

            if ($jamSekarangTimestamp >= ($jamMasukTimestamp - $selisihSatuJam)) {
                switch ($request->status) {
                    case 'WFH':
                        if ($absen->telat === '00:00:00') {
                            $absen->status = 4;
                            $absen->save();
                            DB::commit();
                            return response()->json(['success' => true, 'status' => 4, 'message' => "Berhasil mengubah absen menjadi WFH"]);
                        }
                        $absen->status = 5;
                        $absen->telat = $waktuTelat;
                        $absen->save();
                        DB::commit();
                        return response()->json(['success' => true, 'status' => 5, 'message' => "Berhasil mengubah absen menjadi WFH, namun Anda dinyatakan telat selama " . $telatMenit . " menit"]);
                    case 'Hadir':
                        if ($absen->telat === '00:00:00') {
                            $absen->status = 1;
                            $absen->save();
                            DB::commit();
                            return response()->json(['success' => true, 'status' => 1, 'message' => "Berhasil mengubah absen menjadi hadir"]);
                        }
                        $absen->status = 2;
                        $absen->telat = $waktuTelat;
                        $absen->save();
                        DB::commit();
                        return response()->json(['success' => true, 'status' => 2, 'message' => "Berhasil mengubah absen menjadi hadir, namun Anda dinyatakan telat selama " . $telatMenit . " menit"]);
                    case 'Reset':
                        $absen->delete();
                        DB::commit();
                        return response()->json(['success' => true,'status' => 1, 'message' => "Berhasil mereset absensi!!!"]);
                    default:
                        return response()->json(['success' => false, 'message' => "Status Absensi tidak ada yang valid!"]);
                }
            } else {
                return response()->json(['success' => false, 'message' => 'Absen di mulai 1 jam sebelum jam masuk!'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => "Error: $e"]);
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
