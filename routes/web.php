<?php

use Illuminate\Support\Facades\Route;





Route::get('/', function () {
    return view('welcome');
});

//Route::get('contactanos', [ContactController::class, 'index'])->name('contactanos.index');
   
