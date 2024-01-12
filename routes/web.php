<?php

use App\Http\Controllers\AbsensiTroubleController;
use App\Http\Controllers\Admin\KakomliController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\Guru\ForgotPasswordGuruController;
use App\Http\Controllers\Auth\Guru\ResetPasswordGuruController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Kakomli\DudiController;
use App\Http\Controllers\Kakomli\HomeController;
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
Route::get('/guru/{guru_id}/absen/cetak', [PrintController::class, 'absenPrint'])->name('print_absensi');

// Auth Kaomli
Route::get('/kakomli/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/kakomli/login', [LoginController::class, 'login']);
Route::post('/kakomli/logout', [LoginController::class, 'logout'])->name('logout');

// Route::get('/guru/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
// Route::post('/guru/register', [RegisterController::class, 'register']);


Route::middleware(['auth.kakomli'])->prefix('/kakomli')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::resource('/dudi', DudiController::class);
});

// Admin INI
Route::middleware(['admin.ini'])->prefix('/admin-ini')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/data_kakomli', [AdminController::class, 'dataKakomli'])->name('admin.persetujuan');
    Route::resource('/kakomli', KakomliController::class)->except('show');
});


// test
Route::get('/test', function(){
    return view('generate_pdf.jurnal_siswa');
});
