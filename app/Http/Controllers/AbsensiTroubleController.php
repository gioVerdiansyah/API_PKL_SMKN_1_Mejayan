<?php

namespace App\Http\Controllers;

use App\Http\Requests\AbsenTroubleStoreRequest;
use App\Models\Absensi;
use App\Models\Izin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbsensiTroubleController extends Controller {
    public function absenTroubles(Request $request) {
        try {
            $rememberToken = $request->input('rm_token');
            if(empty($rememberToken)) {
                return to_route('index')->with('message', [
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'token is missing'
                ]);
            }

            $user = User::where('id', $request->user_id)->where('remember_token', $rememberToken)->first();

            if($user && $user->getRememberToken() === $rememberToken) {
                return view('absen_trouble');
            } else {
                return to_route('index')->with('message', [
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'UUID User OR Token is invalid!'
                ]);
            }
        } catch (\Exception $e) {
            return to_route('index')->with('message', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Error: '.$e
            ]);
        }
    }
    public function absenTroublesStore(AbsenTroubleStoreRequest $request) {
        try {
            $rememberToken = $request->input('rm_token');
            if(empty($rememberToken)) {
                return to_route('index')->with('message', [
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'token is missing'
                ]);
            }

            $user = User::where('id', $request->user_id)->where('remember_token', $rememberToken)->first();
            $user_id = $user->id;

            if($user && $user->getRememberToken() === $rememberToken) {
                $now = Carbon::now()->locale('id');
                $hariIni = strtolower(Carbon::parse($now)->locale('id')->dayName);
                $jamMasuk = $user['detailUser']['detailPkl']['jamPkl']["$hariIni"];

                if(is_null($jamMasuk)) {
                    return to_route('index')->with('message', [
                        'icon' => 'error',
                        'title' => 'Gagal Absen',
                        'text' => 'Anda tidak dapat absen pada hari ' . $hariIni
                    ]);
                }

                if(strtolower($request->kategori_absen) == 'hadir' || strtolower($request->kategori_absen) == 'wfh') {
                    $absenSudahAda = Absensi::where('user_id', $user_id)
                        ->whereDate('created_at', today())->where('status', '!=', '5')
                        ->exists();

                    if($absenSudahAda) {
                        return to_route('index')->with('message', [
                            'icon' => 'error',
                            'title' => 'Gagal Absen',
                            'text' => 'Anda sudah absen!'
                        ]);
                    }

                    $jamMasuk = explode(" - ", $jamMasuk)[0];
                    $jamMasukTimestamp = strtotime($jamMasuk);
                    $jamSekarangTimestamp = strtotime($now->format('H:i'));

                    $selisihSatuJam = 3600;
                    if($jamSekarangTimestamp >= ($jamMasukTimestamp - $selisihSatuJam)) {
                        if(strtolower($request->kategori_absen) == 'wfh') {
                            Absensi::create([
                                'user_id' => $user_id,
                                'status' => 4,
                            ]);
                            DB::commit();
                            return to_route('index')->with('message', [
                                'icon' => 'success',
                                'title' => 'Berhasil',
                                'text' => 'Berhasil absen WFH!'
                            ]);
                        }

                        if($jamSekarangTimestamp > $jamMasukTimestamp) {
                            Absensi::create([
                                'user_id' => $user_id,
                                'status' => 2,
                            ]);
                            DB::commit();
                            return to_route('index')->with('message', [
                                'icon' => 'warning',
                                'title' => 'Berhasil',
                                'text' => 'Anda telat absen!'
                            ]);
                        } else {
                            Absensi::create([
                                'user_id' => $user_id,
                                'status' => 1,
                            ]);
                            DB::commit();
                            return to_route('index')->with('message', [
                                'icon' => 'success',
                                'title' => 'Berhasil',
                                'text' => 'Berhasil absen tepat waktu!'
                            ]);
                        }
                    } else {
                        return back()->with('message', [
                            'icon' => 'error',
                            'title' => 'Gagal!',
                            'text' => 'Absen di mulai 1 jam sebelum jam masuk!'
                        ]);
                    }
                }else{
                    $absenPulang = Absensi::where('user_id', $user_id)
                        ->whereDate('created_at', today())
                        ->where('status', 5)
                        ->exists();

                    if($absenPulang) {
                        return to_route('index')->with('message', [
                            'icon' => 'error',
                            'title' => 'Error',
                            'text' => 'Anda sudah absen pulang!'
                        ]);
                    }

                    $absenHadir = Absensi::where('user_id', $user_id)
                        ->whereDate('created_at', today())
                        ->whereIn('status', [1, 2, 4])
                        ->exists();

                    if(!$absenHadir) {
                        return back()->with('message', [
                            'icon' => 'error',
                            'title' => 'Error',
                            'text' => 'Anda belum absen hadir pada hari ini!'
                        ]);
                    }

                    $absenCutiIzinSakit = Izin::where('user_id', $user_id)
                        ->whereDate('created_at', today())
                        ->exists();

                    if($absenCutiIzinSakit) {
                        return to_route('index')->with('message', [
                            'icon' => 'error',
                            'title' => 'Gagal Absen!',
                            'text' => 'Anda tidak bisa absen pulang karena [\'Cuti\', \'Izin\', \'Sakit\']!'
                        ]);
                    }

                    $absenAlpha = Absensi::where('user_id', $user_id)
                        ->whereDate('created_at', today())
                        ->where('status', 3)
                        ->exists();

                    if($absenAlpha) {
                        return back()->with('message', [
                            'icon' => 'error',
                            'title' => 'Gagal absen',
                            'text' => 'Anda tidak bisa absen pulang karena anda dinyatakan alpha!'
                        ]);
                    }

                    Absensi::create([
                        'user_id' => $user_id,
                        'status' => 5,
                    ]);
                    DB::commit();
                    return to_route('index')->with('message', [
                        'icon' => 'success',
                        'title' => 'Berhasil',
                        'text' => 'Berhasil absen Pulang!'
                    ]);
                }
            } else {
                return to_route('index')->with('message', [
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'UUID User OR Token is invalid!'
                ]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('index')->with('message', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Error: '.$e
            ]);
        }
    }
}
