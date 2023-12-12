<?php

use App\Http\Controllers\AbsensiTroubleController;
use App\Http\Controllers\AdminController;
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

Route::get('/absen/trouble', [AbsensiTroubleController::class, 'absenTroubles']);
Route::post('/absen/trouble', [AbsensiTroubleController::class, 'absenTroublesStore'])->name('absen-trouble');

Auth::routes(['verify'=> false]);


Route::get('/home', [App\Http\Controllers\GuruController::class, 'index'])->name('home');

// Admin INI
Route::middleware(['admin.ini'])->group(function(){
    Route::prefix('/admin-ini')->group(function(){
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/persetujuan', [AdminController::class, 'persetujuan'])->name('admin.persetujuan');
    });
});
