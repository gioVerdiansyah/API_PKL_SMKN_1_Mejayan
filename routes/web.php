<?php

use App\Http\Controllers\AbsensiTroubleController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\Guru\ForgotPasswordGuruController;
use App\Http\Controllers\Auth\Guru\ResetPasswordGuruController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\PrintController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;






/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('index');


// Auth::routes(['verify' => false]);

// Reset password siswa
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::prefix('/guru')->group(function(){
    Route::get('/password/reset', [ForgotPasswordGuruController::class, 'showLinkRequestForm'])->name('password_guru.request');
    Route::post('/password/email', [ForgotPasswordGuruController::class, 'sendResetLinkEmail'])->name('password_guru.email');
    Route::get('/password/reset/{token}', [ResetPasswordGuruController::class, 'showResetForm'])->name('password_guru.reset');
    Route::post('/password/reset', [ResetPasswordGuruController::class, 'reset'])->name('password_guru.update');
});

// Absensi bermasalah
Route::get('/absen/trouble', [AbsensiTroubleController::class, 'absenTroubles']);
Route::post('/absen/trouble', [AbsensiTroubleController::class, 'absenTroublesStore'])->name('absen-trouble');

// print
Route::get('/print/jurnal/{id}', [PrintController::class, 'showPrintJurnalSiswa']);
Route::post('/print/jurnal', [PrintController::class, 'printJurnalSiswa'])->name('print_jurnal');
Route::get('/guru/{guru_id}/absen/print', [PrintController::class, 'showPrintAbensiSiswa']);
Route::post('/guru/absen/print', [PrintController::class, 'absenPrint'])->name('print_absensi');

// Auth Guru
Route::get('/guru/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/guru/login', [LoginController::class, 'login']);
Route::post('/guru/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/guru/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/guru/register', [RegisterController::class, 'register']);


Route::middleware(['auth.guru'])->prefix('/guru')->group(function () {
    Route::get('/home', [App\Http\Controllers\GuruController::class, 'index'])->name('home');
});

// Admin INI
Route::middleware(['admin.ini'])->prefix('/admin-ini')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/persetujuan', [AdminController::class, 'persetujuan'])->name('admin.persetujuan');
    Route::patch('/agreement/{id}', [AdminController::class, 'acceptOrReject'])->name('admin.acceptorreject');
});


// test
Route::get('/test', function(){
    return view('generate_pdf.jurnal_siswa');
});
