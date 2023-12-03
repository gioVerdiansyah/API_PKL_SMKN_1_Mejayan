<?php

use App\Http\Controllers\Api\CheckLoginController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\Siswa\AbsensiController;
use App\Http\Controllers\Api\Siswa\JurnalController;
use App\Http\Controllers\Api\Siswa\LoginController;
use App\Http\Controllers\Api\Siswa\UbahPassController;
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
    Route::post('/absensi/izin', [AbsensiController::class, 'izin']);
    Route::get('/absensi/izin/get/{id}', [AbsensiController::class, 'izinGet']);
    Route::post('/jurnal', [JurnalController::class,'jurnal']);
    Route::put('/ubah-pass', [UbahPassController::class,'ubahPass']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
