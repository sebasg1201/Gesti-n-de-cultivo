<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index_welcome');
});


use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index']);
