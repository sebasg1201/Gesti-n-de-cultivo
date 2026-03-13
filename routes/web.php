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
Route::post('/validar-unicidad', [EmpresaController::class, 'validarUnicidad']);



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
    Route::get('/dashboard/solicitudes/exportar', [SolicitudCompraController::class, 'exportarReporte'])->name('solicitudes.exportar');
    Route::put('/dashboard/solicitudes/{id}/visto', [SolicitudCompraController::class, 'markAsSeen'])->name('solicitudes.markAsSeen');
    Route::put('/dashboard/solicitudes/{id}/aprobado', [SolicitudCompraController::class, 'aprobar'])->name('solicitudes.aprobar');
    Route::delete('/dashboard/solicitudes/{id}', [SolicitudCompraController::class, 'destroy'])->name('solicitudes.destroy');

    Route::get('/reportes', [App\Http\Controllers\ReporteController::class, 'index'])->name('reportes.index');

    Route::get('/SuperAdmin/reporte/excel', [EmpresaController::class, 'generarExcel'])->name('SuperAdmin.reporte.excel');
    Route::get('/SuperAdmin/reporte', [EmpresaController::class, 'generarReporte'])->name('SuperAdmin.reporte');
    Route::resource('SuperAdmin', EmpresaController::class);
    Route::put('SuperAdmin/{id}/activar', [EmpresaController::class, 'activar'])->name('SuperAdmin.activar');
});

// Protected Routes (Usuario - Admin)
use App\Http\Controllers\Admin\AdminController;

Route::middleware(['auth:usuario', 'check.license'])->group(function () {
    // Ruta para licencia expirada (el middleware la excluye de la verificación pero exige auth:usuario)
    Route::get('/licencia-expirada', [App\Http\Controllers\Admin\TipoLicenciaController::class, 'licenciaExpirada'])->name('licencia.expirada');

    // Dashboard original (Admin/Supervisor)
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/configuracion', [AdminController::class, 'configuracion'])->name('admin.configuracion');

    // Rutas para trabajador
    Route::get('/trabajador/dashboard', [AdminController::class, 'trabajadorInicio'])->name('trabajador.dashboard');
    Route::post('/trabajador/tareas/{id}/finalizar/{tipo}', [AdminController::class, 'finalizarTarea'])->name('trabajador.tareas.finalizar');
    Route::post('/trabajador/tareas/{id}/estado/{tipo}', [AdminController::class, 'actualizarEstadoTarea'])->name('trabajador.tareas.estado');

    // Rutas para Calendario de Trabajador
    Route::get('/trabajador/calendario', [AdminController::class, 'trabajadorCalendario'])->name('trabajador.calendario');
    Route::get('/trabajador/calendario/eventos', [AdminController::class, 'getEventosCalendario'])->name('trabajador.calendario.eventos');
    Route::post('/trabajador/calendario/registro', [AdminController::class, 'storeRegistroTrabajo'])->name('trabajador.calendario.store');

    // Nueva ruta para tareas categorizadas de administrador
    Route::get('/admin/tareas', [AdminController::class, 'tareasCategorizadas'])->name('admin.tareas.index');
    Route::post('/admin/tareas/store-riego', [AdminController::class, 'storeRiego'])->name('admin.tareas.store.riego');
    Route::post('/admin/tareas/store-insumo', [AdminController::class, 'storeInsumo'])->name('admin.tareas.store.insumo');
    Route::post('/admin/tareas/store-general', [AdminController::class, 'storeGeneral'])->name('admin.tareas.store.general');

    // Rutas para la gestión de licencias del usuario administrador
    Route::get('/admin/licencias', [App\Http\Controllers\Admin\TipoLicenciaController::class, 'index'])->name('admin.licencias.index');
    Route::get('/admin/licencias/contacto', [App\Http\Controllers\Admin\TipoLicenciaController::class, 'contacto'])->name('admin.licencias.contacto');
    Route::post('/admin/licencias/contacto', [App\Http\Controllers\Admin\TipoLicenciaController::class, 'enviarContacto'])->name('admin.licencias.enviar_contacto');
    // Rutas para la gestión de usuarios (Supervisor y Trabajador) de la empresa
    Route::resource('/admin/usuarios', \App\Http\Controllers\Admin\UsuarioEmpresaController::class, ['as' => 'admin']);

    // Ruta para asignar trabajo (Fases Programadas)
    Route::get('/admin/usuarios/{usuario}/asignar-trabajo', [\App\Http\Controllers\Admin\UsuarioEmpresaController::class, 'asignarTrabajo'])->name('admin.usuarios.asignar_trabajo');
    Route::post('/admin/usuarios/{usuario}/asignar-trabajo', [\App\Http\Controllers\Admin\UsuarioEmpresaController::class, 'storeTrabajo'])->name('admin.usuarios.store_trabajo');

    // Gestión de Cosechas
    Route::resource('/admin/cosechas', \App\Http\Controllers\Admin\CosechaController::class, ['as' => 'admin']);

    // Insumos y Proveedores
    Route::post('/admin/proveedores/{id}/entradas', [\App\Http\Controllers\ProveedorController::class, 'storeEntrada'])->name('admin.proveedores.entradas.store');
    Route::get('/admin/proveedores/{id}/historial', [\App\Http\Controllers\ProveedorController::class, 'historial'])->name('admin.proveedores.historial');
    Route::resource('/admin/proveedores', \App\Http\Controllers\ProveedorController::class, ['as' => 'admin']);
    Route::resource('/admin/insumos', \App\Http\Controllers\InsumoController::class, ['as' => 'admin']);

    // Tipo Insumo (Configuración de Catálogo)
    Route::get('/tipo_insumos/catalog', [\App\Http\Controllers\TipoInsumoController::class, 'catalog'])->name('tipo_insumos.catalog');
    Route::resource('/admin/tipo_insumos', \App\Http\Controllers\TipoInsumoController::class, ['as' => 'admin'])->parameters([
        'tipo_insumos' => 'tipo_insumo'
    ]);
});

Route::get('/', [HomeController::class, 'index'])->name('index_welcome');


Route::resource('tipo_cosechas', TipoCosechaController::class)->except(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy']);

use App\Http\Controllers\TipoSemillaController;

Route::get('tipo_semillas/catalog', [TipoSemillaController::class, 'catalog'])->name('tipo_semillas.catalog');
Route::resource('tipo_semillas', TipoSemillaController::class);

use App\Http\Controllers\InsumoController;

Route::get('insumos/catalog', [InsumoController::class, 'catalog'])->name('insumos.catalog');
Route::resource('insumos', InsumoController::class);

use App\Http\Controllers\TipoRiegoController;

Route::get('tipo_riegos/catalog', [TipoRiegoController::class, 'catalog'])->name('tipo_riegos.catalog');
Route::resource('tipo_riegos', TipoRiegoController::class);

use App\Http\Controllers\TipoSueloController;

Route::get('tipo_suelos/catalog', [TipoSueloController::class, 'catalog'])->name('tipo_suelos.catalog');
Route::resource('tipo_suelos', TipoSueloController::class);

use App\Http\Controllers\EstadoController;

Route::resource('estados', EstadoController::class);

use App\Http\Controllers\TerrenoController;

Route::resource('admin/terrenos', TerrenoController::class, ['as' => 'admin']);
