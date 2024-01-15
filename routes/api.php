<?php

use App\Http\Controllers\Api\CheckLoginController;
use App\Http\Controllers\Api\Guru\KelolaAbsensiController;
use App\Http\Controllers\Api\Guru\KelolaIzinController;
use App\Http\Controllers\Api\Guru\KelolaJurnalController;
use App\Http\Controllers\Api\Guru\RegisterController;
use App\Http\Controllers\Api\Siswa\AbsensiController;
use App\Http\Controllers\Api\Siswa\EditProfileController;
use App\Http\Controllers\Api\Siswa\IzinController;
use App\Http\Controllers\Api\Siswa\JurnalController;
use App\Http\Controllers\Api\Siswa\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;






/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware("verifyAPIKey")->group(function () {
    Route::post('/register', RegisterController::class);
    Route::post('/login', LoginController::class);
    Route::get('/check-login', [CheckLoginController::class, 'index']);
    Route::post('/absensi/hadir', [AbsensiController::class, 'absen']);
    Route::post('/absensi/pulang', [AbsensiController::class, 'pulang']);
    Route::post('/absensi/izin', [IzinController::class, 'izin']);
    Route::get('/absensi/izin/get/{id}', [IzinController::class, 'izinGet']);
    Route::get('/absensi/izin/show/{id}', [IzinController::class, 'izinShow']);
    Route::post('/absensi/izin/edit/{id}', [IzinController::class, 'editIzin']);
    Route::patch('/absensi/salah', [AbsensiController::class, 'absenSalah']);
    Route::post('/jurnal', [JurnalController::class,'jurnal']);
    Route::get('/jurnal/get/{id}', [JurnalController::class,'jurnalGet']);
    Route::get('/jurnal/show/{id}', [JurnalController::class,'jurnalShow']);
    Route::post('/jurnal/edit/{id}', [JurnalController::class,'editJurnal']);
    Route::post('/edit-profile/{id}', [EditProfileController::class,'editProfile']);
    Route::get('/absensi/trouble', [AbsensiController::class, 'absenTrouble']);


    // Guru
    Route::prefix('/guru')->group(function(){
        Route::post('/login', \App\Http\Controllers\Api\Guru\LoginController::class);

        // list absensi
        Route::get('/{guru_id}/absensi/get', [KelolaAbsensiController::class, 'getAbsen']);
        Route::get('/{guru_id}/absensi/pulang', [KelolaAbsensiController::class, 'getAbsenPulang']);
        Route::get('/{guru_id}/absen/reject', [KelolaAbsensiController::class, 'absenReject']);

        // list jurnal
        Route::get('/{guru_id}/jurnal/get', [KelolaJurnalController::class, 'getJurnal']);
        Route::put('/{guru_id}/jurnal/agreement', [KelolaJurnalController::class, 'jurnalAgreement']);
        Route::get('/{guru_id}/jurnal/prev_day/{day}/{status?}', [KelolaJurnalController::class, 'getNextPrevJurnal']);
        Route::get('/{guru_id}/jurnal/reject', [KelolaJurnalController::class, 'jurnalReject']);

        // list izin
        Route::get('/{guru_id}/izin/get/{status?}', [KelolaIzinController::class, 'getIzin']);
        Route::put('/{guru_id}/izin/agreement', [KelolaIzinController::class, 'izinAgreement']);
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
