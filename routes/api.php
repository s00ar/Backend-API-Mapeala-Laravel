<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ContactController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(ContactController::class)->group(function () {
    Route::get('/contacts', 'index');
    Route::post('/contact', 'store');
    Route::get('/contact/{id}', 'show');
    Route::put('/contact/{id}', 'update');
    Route::delete('/contact/{id}', 'destroy');
});