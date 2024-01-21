<?php

use App\Http\Controllers\AbsensiTroubleController;
use App\Http\Controllers\Admin\AdminDudiController;
use App\Http\Controllers\Admin\AdminPengurusPklController;
use App\Http\Controllers\Admin\AdminSiswaController;
use App\Http\Controllers\Admin\KakomliController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\Guru\EditProfileController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\Guru\ForgotPasswordGuruController;
use App\Http\Controllers\Auth\Guru\ResetPasswordGuruController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Kakomli\DudiController;
use App\Http\Controllers\Kakomli\EditProfileController as EditProfileKakomliController;
use App\Http\Controllers\Kakomli\HomeController;
use App\Http\Controllers\Kakomli\PengelolaanPkl\KelompokSiswaController;
use App\Http\Controllers\Kakomli\PengurusPklController;
use App\Http\Controllers\Kakomli\RekapPendataanController;
use App\Http\Controllers\Kakomli\SiswaController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\TestingController;
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
Route::post('/guru/{guru_id}/absen/print', [PrintController::class, 'printAbsensiSiswa'])->name('cetak_rekap_absensi');
Route::get('/guru/{guru_id}/absen/cetak', [PrintController::class, 'absenPrint'])->name('print_absensi');

// Auth Kaomli
Route::get('/kakomli/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/kakomli/login', [LoginController::class, 'login']);
Route::post('/kakomli/logout', [LoginController::class, 'logout'])->name('logout');

// Route::get('/guru/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
// Route::post('/guru/register', [RegisterController::class, 'register']);


Route::middleware(['auth.kakomli'])->prefix('/kakomli')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/edit-profile', [EditProfileKakomliController::class, 'edit'])->name('kakomli.edit_profile');
    Route::put('/edit-profile', [EditProfileKakomliController::class, 'update'])->name('kakomli.update_profile');

    Route::resource('/dudi', DudiController::class);
    Route::get('/export-column-dudi', [DudiController::class, 'generateKolom'])->name('dudi.download_list_table');
    Route::post('/import-data-dudi', [DudiController::class, 'importData'])->name('dudi.import_data');

    Route::resource('/siswa-siswi', SiswaController::class)->names('siswa');
    Route::get('/export-column-siswa', [SiswaController::class, 'generateKolom'])->name('siswa.download_list_table');
    Route::post('/import-data-siswa', [SiswaController::class, 'importData'])->name('siswa.import_data');

    Route::resource('/pengurus-pkl', PengurusPklController::class)->except('show');
    Route::get('/export-column-pengurus-pkl', [PengurusPklController::class, 'generateKolom'])->name('pengurus-pkl.download_list_table');
    Route::post('/import-data-pengurus-pkl', [PengurusPklController::class, 'importData'])->name('pengurus-pkl.import_data');

    Route::prefix('/pengelolaan_pkl')->group(function(){
        Route::resource('/kelompok-siswa', KelompokSiswaController::class);
    });

    Route::prefix('/rekap-pendataan')->group(function(){
        Route::get('/list-DuDi', [RekapPendataanController::class, 'showDownloadPage'])->name('rekap_pendataan.dudi.show_download');
        Route::get('/list-DuDi-download', [RekapPendataanController::class, 'downloadListDudi'])->name('rekap_pendataan.dudi.download');
        Route::get('/list-DuDi-print', [RekapPendataanController::class, 'printListDudi'])->name('rekap_pendataan.dudi.print');

        Route::get('/pemetaan-DuDi', [RekapPendataanController::class, 'showDownloadPagePemetaan'])->name('rekap_pendataan.pemetaan_dudi.show_download');
        Route::get('/pemetaan-DuDi-download', [RekapPendataanController::class, 'downloadPemetaanDudi'])->name('rekap_pendataan.pemetaan_dudi.download');
        Route::get('/pemetaan-DuDi-print', [RekapPendataanController::class, 'printPemetaanDudi'])->name('rekap_pendataan.pemetaan_dudi.print');
    });
});

// Admin INI
Route::middleware(['admin.ini'])->prefix('/admin-ini')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/data_kakomli', [AdminController::class, 'dataKakomli'])->name('admin.persetujuan');
    Route::resource('/kakomli', KakomliController::class)->except('show');

    Route::resource('/dudi', AdminDudiController::class)->names('admin.dudi');
    Route::get('/export-column-dudi', [AdminDudiController::class, 'generateKolom'])->name('admin.dudi.download_list_table');
    Route::post('/import-data-dudi', [AdminDudiController::class, 'importData'])->name('admin.dudi.import_data');

    Route::resource('/siswa', AdminSiswaController::class)->names('admin.siswa');
    Route::get('/export-column-siswa', [AdminSiswaController::class, 'generateKolom'])->name('admin.siswa.download_list_table');
    Route::post('/import-data-siswa', [AdminSiswaController::class, 'importData'])->name('admin.siswa.import_data');

    Route::resource('/pengurus-pkl', AdminPengurusPklController::class)->names('admin.pengurus-pkl');
    Route::get('/export-column-pengurus-pkl', [AdminPengurusPklController::class, 'generateKolom'])->name('admin.pengurus_pkl.download_list_table');
    Route::post('/import-data-pengurus-pkl', [AdminSiswaController::class, 'importData'])->name('admin.pengurus_pkl.import_data');
});


// test
Route::prefix('/test')->group(function(){
    Route::get('/getColumn', [TestingController::class, 'getColumn']);
    Route::get('/table-dudi-list', [TestingController::class, 'tableDudiList']);
    Route::get('/table-pemetaan-dudi', [TestingController::class, 'tablePemetaanDudi']);
});
