<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});


// Route::get('/check', [CourierController::class, 'check']);
Route::get('/check', [HomeController::class, 'getFrodly']);
