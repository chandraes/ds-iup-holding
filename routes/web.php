<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\RekapController;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::group(['middleware' => ['role:su,admin']], function() {
        Route::prefix('pengaturan')->group(function () {
            Route::get('/', [PengaturanController::class, 'index'])->name('pengaturan');
            Route::prefix('aplikasi')->group(function(){
                Route::get('/', [PengaturanController::class, 'aplikasi'])->name('pengaturan.aplikasi');
                Route::patch('/update', [PengaturanController::class, 'aplikasi_update'])->name('pengaturan.aplikasi.update');
            });

            Route::get('/wa', [PengaturanController::class, 'group_wa'])->name('pengaturan.wa');
            Route::get('/wa/get-wa-group', [PengaturanController::class, 'get_group_wa'])->name('pengaturan.wa.get-group-wa');
            Route::patch('/wa/{group}/update', [PengaturanController::class, 'group_wa_update'])->name('pengaturan.wa.update');

            Route::get('/akun', [PengaturanController::class, 'akun'])->name('pengaturan.akun');
            Route::group(['prefix' => 'akun', 'as' => 'pengaturan.akun.'], function () {
                Route::post('/', [PengaturanController::class, 'akun_store'])->name('store');
                Route::patch('/{user}', [PengaturanController::class, 'akun_update'])->name('update');
                Route::delete('/{user}', [PengaturanController::class, 'akun_delete'])->name('delete');
            });

            Route::post('/password-konfirmasi', [PengaturanController::class, 'password_konfirmasi'])->name('pengaturan.password-konfirmasi');
            Route::post('/password-konfirmasi/cek', [PengaturanController::class, 'password_konfirmasi_cek'])->name('pengaturan.password-konfirmasi-cek');

            Route::prefix('batasan')->group(function(){
                Route::get('/', [PengaturanController::class, 'batasan'])->name('pengaturan.batasan');
                Route::patch('/update/{batasan}', [PengaturanController::class, 'batasan_update'])->name('pengaturan.batasan.update');
            });
        });

        // database routing
        Route::get('/db', [App\Http\Controllers\DatabaseController::class, 'index'])->name('db');
        Route::group(['prefix' => 'db', 'as' => 'db.'], function () {

            Route::get('/divisi', [App\Http\Controllers\DatabaseController::class, 'divisi'])->name('divisi');
            Route::group(['prefix' => 'divisi', 'as' => 'divisi.'], function () {
                Route::post('/', [App\Http\Controllers\DatabaseController::class, 'divisi_store'])->name('store');
                Route::patch('/{divisi}', [App\Http\Controllers\DatabaseController::class, 'divisi_update'])->name('update');
                Route::delete('/{divisi}', [App\Http\Controllers\DatabaseController::class, 'divisi_delete'])->name('delete');
                Route::patch('/{divisi}/regenerate-token', [App\Http\Controllers\DatabaseController::class, 'divisi_regenerate_token'])->name('regenerate-token');
            });

            Route::get('/rekening', [App\Http\Controllers\DatabaseController::class, 'rekening'])->name('rekening');
            Route::patch('/rekening/{rekening}', [App\Http\Controllers\DatabaseController::class, 'rekening_update'])->name('rekening.update');

        });

        Route::get('/pajak', [App\Http\Controllers\PajakController::class, 'index'])->name('pajak');
        Route::group(['prefix' => 'pajak', 'as' => 'pajak.'], function () {
            Route::get('/rekap-ppn', [App\Http\Controllers\PajakController::class, 'rekap_ppn'])->name('rekap-ppn');
            Route::post('/rekap-ppn/bayar', [App\Http\Controllers\PajakController::class, 'bayar_ppn'])->name('rekap-ppn.bayar');
            // Route::get('/rekap-ppn/{bulan}/{tahun}', [App\Http\Controllers\PajakController::class, 'rekap_ppn'])->name('rekap-ppn.bulan-tahun');
        });

        Route::get('/rekap', [RekapController::class, 'index'])->name('rekap');
        Route::group(['prefix' => 'rekap', 'as' => 'rekap.'], function() {
            Route::prefix('kas-besar')->group(function(){
                Route::get('/', [RekapController::class, 'kas_besar'])->name('kas-besar');
                Route::get('/print/{bulan}/{tahun}', [RekapController::class, 'kas_besar_print'])->name('kas-besar.print');
            });
        });
    });

});


