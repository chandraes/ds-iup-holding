<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PengaturanController;
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
        Route::prefix('pengaturan')->group(function() {
            Route::get('/', [PengaturanController::class, 'index'])->name('pengaturan');
        });

        Route::prefix('db')->group(function(){
            Route::get('/', [DatabaseController::class, 'index'])->name('db');

            Route::prefix('divisi')->group(function(){
                Route::get('/', [DatabaseController::class, 'divisi'])->name('db.divisi');
                Route::post('/store', [DatabaseController::class, 'divisi_store'])->name('db.divisi.store');
                Route::post('/update/{divisi}', [DatabaseController::class, 'divisi_update'])->name('db.divisi.update');
                Route::delete('/delete/{divisi}', [DatabaseController::class, 'divisi_delete'])->name('db.divisi.delete');
                Route::get('/regenerate-token/{divisi}', [DatabaseController::class, 'divisi_regenerate_token'])->name('db.divisi.regenerate_token');
            });

        });
    });

    // End Routing Admin
});

require __DIR__.'/auth.php';
