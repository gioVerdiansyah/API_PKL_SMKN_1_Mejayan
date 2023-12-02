<?php

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
    Route::post('/register', App\Http\Controllers\Api\RegisterController::class);
    Route::post('/login', App\Http\Controllers\Api\Siswa\LoginController::class);
    Route::get('/check-login', [App\Http\Controllers\Api\CheckLoginController::class, 'index']);
    Route::post('/absensi/hadir', [App\Http\Controllers\Api\Siswa\AbsensiController::class, 'absen']);
    Route::post('/absensi/pulang', [App\Http\Controllers\Api\Siswa\AbsensiController::class, 'pulang']);
    Route::post('/absensi/izin', [App\Http\Controllers\Api\Siswa\AbsensiController::class, 'izin']);
    Route::get('/absensi/izin/get/{id}', [App\Http\Controllers\Api\Siswa\AbsensiController::class, 'izinGet']);
    Route::post('/jurnal', [\App\Http\Controllers\Api\Siswa\JurnalController::class,'jurnal']);
    Route::put('/ubah-pass', [\App\Http\Controllers\Api\Siswa\UbahPassController::class,'ubahPass']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
