<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AppointmentApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/appointments', [AppointmentApiController::class, 'index']);
Route::post('/appointments', [AppointmentApiController::class, 'store']);