<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\HoldingController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::group(['middleware' => ['check.divisi.token']], function () {

    Route::get('/check-connection', [HoldingController::class, 'checkConnection']);
});
