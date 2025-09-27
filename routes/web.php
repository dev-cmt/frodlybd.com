<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourierController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/check', [CourierController::class, 'check']);
