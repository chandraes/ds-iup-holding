<?php

use App\Http\Controllers\Api\HoldingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['check.divisi.token']], function () {

    Route::get('/check-connection', [HoldingController::class, 'checkConnection']);
    Route::get('/get-rekening', [HoldingController::class, 'getRekening']);
    Route::post('/ppn-masukan', [HoldingController::class, 'ppn_masukan']);
    Route::post('/ppn-keluaran', [HoldingController::class, 'ppn_keluaran']);
    Route::post('/kas-besar-masuk', [HoldingController::class, 'kas_besar_masuk']);


});
