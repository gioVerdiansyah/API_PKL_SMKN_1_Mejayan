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
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
