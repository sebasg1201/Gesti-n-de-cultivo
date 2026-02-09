<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('index_welcome');
});

// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
// Note: Verification and Reset form handling would go here if full implementation is needed

// Protected Routes
Route::middleware(['auth:superadmin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Dashboard Logic specific routes (created from DashboardController to keep it simple as per request)
    Route::post('/dashboard/empresas', [DashboardController::class, 'storeEmpresa'])->name('empresas.store');
    Route::post('/dashboard/licencias', [DashboardController::class, 'storeLicencia'])->name('licencias.store');
    Route::post('/dashboard/administradores', [DashboardController::class, 'storeAdministrador'])->name('administradores.store');

    Route::resource('empresas', EmpresaController::class);
    Route::put('empresas/{id}/activar', [EmpresaController::class, 'activar'])->name('empresas.activar');
});
