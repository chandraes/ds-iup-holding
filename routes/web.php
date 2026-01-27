<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PajakController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Start Routing Admin

    Route::group(['middleware' => ['role:su,admin']], function() {

        Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan');
        Route::group(['prefix' => 'pengaturan', 'as' => 'pengaturan.'], function () {

            Route::get('/akun', [PengaturanController::class, 'akun'])->name('akun');
            Route::group(['prefix' => 'akun', 'as' => 'akun.'], function () {
                Route::post('/', [PengaturanController::class, 'akun_store'])->name('store');
                Route::patch('/{user}', [PengaturanController::class, 'akun_update'])->name('update');
                Route::delete('/{user}', [PengaturanController::class, 'akun_delete'])->name('delete');
            });

            Route::prefix('aplikasi')->group(function(){
                Route::get('/', [PengaturanController::class, 'aplikasi'])->name('aplikasi');
                Route::post('/', [PengaturanController::class, 'aplikasi_store'])->name('aplikasi.store');
            });

            Route::get('/group-wa', [PengaturanController::class, 'group_wa'])->name('group-wa');
            Route::group(['prefix' => 'group-wa', 'as' => 'group-wa.'], function () {
                Route::get('/get-group-wa', [PengaturanController::class, 'get_group_wa'])->name('get-group-wa');
                Route::patch('/{group}', [PengaturanController::class, 'group_wa_update'])->name('update');
            });
        });

        Route::prefix('db')->group(function(){
            Route::get('/', [DatabaseController::class, 'index'])->name('db');

            Route::get('/divisi', [DatabaseController::class, 'divisi'])->name('db.divisi');
            Route::group(['prefix' => 'divisi', 'as' => 'db.divisi.'], function () {
                Route::post('/store', [DatabaseController::class, 'divisi_store'])->name('store');
                Route::patch('/update/{divisi}', [DatabaseController::class, 'divisi_update'])->name('update');
                Route::delete('/delete/{divisi}', [DatabaseController::class, 'divisi_delete'])->name('delete');
                Route::get('/regenerate-token/{divisi}', [DatabaseController::class, 'divisi_regenerate_token'])->name('regenerate_token');
            });

        });

        Route::prefix('rekap')->group(function(){
            Route::get('/', [RekapController::class, 'index'])->name('rekap');
        });

        Route::group(['prefix' => 'pajak', 'as' => 'pajak.'], function () {
            Route::get('/rekap-ppn', [PajakController::class, 'rekap_ppn'])->name('rekap-ppn');

        });
    });

    // End Routing Admin
});

require __DIR__.'/auth.php';
