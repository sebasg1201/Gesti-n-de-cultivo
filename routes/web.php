<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index_welcome');
});


use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index']);

use App\Http\Controllers\EmpresaController;
Route::resource('empresas', EmpresaController::class);
Route::put('empresas/{id}/activar', [EmpresaController::class, 'activar'])->name('empresas.activar');
