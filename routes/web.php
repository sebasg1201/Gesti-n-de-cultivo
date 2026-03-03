<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\TipoLicenciaController;
use App\Http\Controllers\TipoCosechaController;

//buscar empresa automaticamente 
Route::get('/buscar-empresa/{nit}', function ($nit) {

    return \App\Models\Empresa::where('id_empresa', $nit)->first();

});

Route::get('/empresa/buscar/{nit}', [DashboardController::class, 'buscarEmpresa']);



// Solicitud Compra Routes
use App\Http\Controllers\SolicitudCompraController;

Route::get('/solicitud-compra/{licencia}', [SolicitudCompraController::class, 'create'])->name('solicitud.create');
Route::post('/solicitud-compra', [SolicitudCompraController::class, 'store'])->name('solicitud.store');

// Authentication Routes (SuperAdmin - Hidden)
Route::get('super-admin-login', [LoginController::class, 'showLoginForm'])->name('superadmin.login');
Route::post('super-admin-login', [LoginController::class, 'login']);
Route::post('super-admin-logout', [LoginController::class, 'logout'])->name('logout');

// Authentication Routes (Usuario - Admin/User)
use App\Http\Controllers\Auth\UsuarioLoginController;
Route::get('login', [UsuarioLoginController::class, 'showLoginForm'])->name('usuario.login');
Route::post('login', [UsuarioLoginController::class, 'login'])->name('usuario.login.submit');
Route::post('logout', [UsuarioLoginController::class, 'logout'])->name('usuario.logout');

// Password Reset Routes
Route::get('password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');

Route::get('password/verify', [App\Http\Controllers\Auth\CodeVerificationController::class, 'show'])->name('password.verify.form');
Route::post('password/verify', [App\Http\Controllers\Auth\CodeVerificationController::class, 'verify'])->name('password.verify.code');

Route::get('password/reset-request', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Protected Routes (SuperAdmin)
Route::middleware(['auth:superadmin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Dashboard Logic specific routes
    Route::post('/dashboard/empresas', [DashboardController::class, 'storeEmpresa'])->name('empresas.store');
    Route::post('/dashboard/licencias/asignar', [DashboardController::class, 'storeLicencia'])->name('licencias.asignar'); // New route

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

// Protected Routes (Usuario - Admin)
use App\Http\Controllers\Admin\AdminController;

Route::middleware(['auth:usuario'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/configuracion', [AdminController::class, 'configuracion'])->name('admin.configuracion');
    
    // Rutas para la gestión de licencias del usuario administrador
    Route::get('/admin/licencias', [App\Http\Controllers\Admin\TipoLicenciaController::class, 'index'])->name('admin.licencias.index');
    Route::get('/admin/licencias/contacto', [App\Http\Controllers\Admin\TipoLicenciaController::class, 'contacto'])->name('admin.licencias.contacto');
    Route::post('/admin/licencias/contacto', [App\Http\Controllers\Admin\TipoLicenciaController::class, 'enviarContacto'])->name('admin.licencias.enviar_contacto');
    // Rutas para la gestión de usuarios (Supervisor y Trabajador) de la empresa
    Route::resource('/admin/usuarios', \App\Http\Controllers\Admin\UsuarioEmpresaController::class, ['as' => 'admin']);
    
    // Ruta para asignar trabajo (Fases Programadas)
    Route::get('/admin/usuarios/{usuario}/asignar-trabajo', [\App\Http\Controllers\Admin\UsuarioEmpresaController::class, 'asignarTrabajo'])->name('admin.usuarios.asignar_trabajo');
    Route::post('/admin/usuarios/{usuario}/asignar-trabajo', [\App\Http\Controllers\Admin\UsuarioEmpresaController::class, 'storeTrabajo'])->name('admin.usuarios.store_trabajo');
});


Route::get('/', [HomeController::class, 'index']);



Route::resource('tipo_cosechas', TipoCosechaController::class);
use App\Http\Controllers\TipoSemillaController;
Route::resource('tipo_semillas', TipoSemillaController::class);
use App\Http\Controllers\TipoRiegoController;
Route::resource('tipo_riegos', TipoRiegoController::class);

use App\Http\Controllers\EstadoController;
Route::resource('estados', EstadoController::class);
