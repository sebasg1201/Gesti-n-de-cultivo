<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\TipoLicenciaController;

Route::get('/', function () {
    return view('index_welcome');
});



Route::resource('empresas', EmpresaController::class);
Route::put('empresas/{id}/activar', [EmpresaController::class, 'activar'])->name('empresas.activar');

Route::get('/licencias', [TipoLicenciaController::class,'index'])->name('licencias.index');
Route::get('/licencias/create', [TipoLicenciaController::class,'create'])->name('licencias.create');
Route::post('/licencias', [TipoLicenciaController::class,'store'])->name('licencias.store');

Route::get('/licencias/{id}/edit', [TipoLicenciaController::class,'edit'])->name('licencias.edit');
Route::put('/licencias/{id}', [TipoLicenciaController::class,'update'])->name('licencias.update');
Route::delete('/licencias/{id}', [TipoLicenciaController::class,'destroy'])->name('licencias.destroy');

Route::get('/', [HomeController::class, 'index']);