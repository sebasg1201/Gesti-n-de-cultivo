<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\TipoLicenciaController;

//buscar empresa automaticamente 
Route::get('/buscar-empresa/{nit}', function ($nit) {

    return \App\Models\Empresa::where('id_empresa', $nit)->first();

});

Route::get('/empresa/buscar/{nit}', [DashboardController::class, 'buscarEmpresa']);



// Solicitud Compra Routes
use App\Http\Controllers\SolicitudCompraController;

Route::get('/solicitud-compra/{licencia}', [SolicitudCompraController::class, 'create'])->name('solicitud.create');
Route::post('/solicitud-compra', [SolicitudCompraController::class, 'store'])->name('solicitud.store');

// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');

Route::get('password/verify', [App\Http\Controllers\Auth\CodeVerificationController::class, 'show'])->name('password.verify.form');
Route::post('password/verify', [App\Http\Controllers\Auth\CodeVerificationController::class, 'verify'])->name('password.verify.code');

Route::get('password/reset-request', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Protected Routes
Route::middleware(['auth:superadmin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Dashboard Logic specific routes
    Route::post('/dashboard/empresas', [DashboardController::class, 'storeEmpresa'])->name('empresas.store');
    Route::post('/dashboard/licencias/asignar', [DashboardController::class, 'storeLicencia'])->name('licencias.asignar');
    Route::put('/dashboard/licencias/{id}', [DashboardController::class, 'updateLicencia'])->name('licencias.update_dashboard'); // Distinct name to avoid conflict with resource controller if any
    Route::get('/dashboard/licencias/exportar', [DashboardController::class, 'exportarReporte'])->name('licencias.exportar');

    // Licencias routes inside SuperAdmin area
    Route::get('/licencias', [TipoLicenciaController::class, 'index'])->name('licencias.index');
    Route::get('/licencias/create', [TipoLicenciaController::class, 'create'])->name('licencias.create');
    Route::post('/licencias', [TipoLicenciaController::class, 'store'])->name('licencias.store');
    Route::get('/licencias/{id}/edit', [TipoLicenciaController::class, 'edit'])->name('licencias.edit');
    Route::put('/licencias/{id}', [TipoLicenciaController::class, 'update'])->name('licencias.update');
    Route::delete('/licencias/{id}', [TipoLicenciaController::class, 'destroy'])->name('licencias.destroy');

    Route::post('/dashboard/administradores', [DashboardController::class, 'storeAdministrador'])->name('administradores.store');

    Route::get('/dashboard/solicitudes', [SolicitudCompraController::class, 'index'])->name('solicitudes.index');
    Route::put('/dashboard/solicitudes/{id}/visto', [SolicitudCompraController::class, 'markAsSeen'])->name('solicitudes.markAsSeen');
    Route::delete('/dashboard/solicitudes/{id}', [SolicitudCompraController::class, 'destroy'])->name('solicitudes.destroy');

    Route::get('/reportes', [App\Http\Controllers\ReporteController::class, 'index'])->name('reportes.index');

    Route::resource('SuperAdmin', EmpresaController::class);
    Route::put('SuperAdmin/{id}/activar', [EmpresaController::class, 'activar'])->name('SuperAdmin.activar');
});

Route::get('/', [HomeController::class, 'index']);