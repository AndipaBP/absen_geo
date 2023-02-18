<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Pengguna\Dashboard\PenggunaDashboardController;
use App\Http\Controllers\Pengguna\Absensi\PenggunaAbsensiController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/






Route::middleware(['auth'])->group(function () {
    //
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/', [PenggunaDashboardController::class, 'index']);

    Route::prefix('absensi')->group(function () {
        Route::get('/', [PenggunaAbsensiController::class, 'index']);
        Route::post('/post/store', [PenggunaAbsensiController::class, 'store_absen']);


    });




});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class,'index'])->name('login');
    Route::post('/login/proses', [AuthController::class,'proses_login']);
});

