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

// 2FA Routes
use App\Http\Controllers\Auth\TwoFactorController;
Route::get('login/verify', [TwoFactorController::class, 'showForm'])->name('login.verify');
Route::post('login/verify', [TwoFactorController::class, 'verify'])->name('login.verify.submit');
Route::post('login/resend-code', [TwoFactorController::class, 'resend'])->name('login.resend');

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

    // Rutas para trabajador
    Route::get('/trabajador/dashboard', [AdminController::class, 'trabajadorInicio'])->name('trabajador.dashboard');
    Route::post('/trabajador/tareas/{id}/finalizar/{tipo}', [AdminController::class, 'finalizarTarea'])->name('trabajador.tareas.finalizar');
    Route::post('/trabajador/tareas/{id}/estado/{tipo}', [AdminController::class, 'actualizarEstadoTarea'])->name('trabajador.tareas.estado');

    // Rutas para Calendario de Trabajador
    Route::get('/trabajador/calendario', [AdminController::class, 'trabajadorCalendario'])->name('trabajador.calendario');
    Route::get('/trabajador/calendario/eventos', [AdminController::class, 'getEventosCalendario'])->name('trabajador.calendario.eventos');
    Route::post('/trabajador/calendario/registro', [AdminController::class, 'storeRegistroTrabajo'])->name('trabajador.calendario.store');

    // Nueva ruta para Mis Pagos (Trabajador)
    Route::get('/trabajador/mis-pagos', [AdminController::class, 'trabajadorPagos'])->name('trabajador.pagos');

    // Rutas de Soporte (Trabajador)
    Route::get('/trabajador/soporte', [AdminController::class, 'soporteTrabajador'])->name('trabajador.soporte');
    Route::post('/trabajador/soporte', [AdminController::class, 'storeSoporte'])->name('trabajador.soporte.store');

    // Nueva ruta para tareas categorizadas de administrador
    Route::get('/admin/tareas', [AdminController::class, 'tareasCategorizadas'])->name('admin.tareas.index');
    
    // Rutas de Soporte (Admin)
    Route::get('/admin/soporte', [AdminController::class, 'adminSoporte'])->name('admin.soporte.index');
    Route::post('/admin/soporte/{id}/responder', [AdminController::class, 'responderSoporte'])->name('admin.soporte.responder');
    Route::post('/admin/tareas/store-riego', [AdminController::class, 'storeRiego'])->name('admin.tareas.store.riego');
    Route::post('/admin/tareas/store-insumo', [AdminController::class, 'storeInsumo'])->name('admin.tareas.store.insumo');
    Route::post('/admin/tareas/store-general', [AdminController::class, 'storeGeneral'])->name('admin.tareas.store.general');
    Route::get('/admin/tareas/export', [AdminController::class, 'exportTareas'])->name('admin.tareas.export');
    Route::get('/admin/tareas/buscar-lotes', [AdminController::class, 'buscarLotes'])->name('admin.tareas.buscar_lotes');
    Route::get('/admin/tareas/buscar-trabajadores', [AdminController::class, 'buscarTrabajadores'])->name('admin.tareas.buscar_trabajadores');
    Route::get('/admin/tareas/buscar-insumos', [AdminController::class, 'buscarInsumos'])->name('admin.tareas.buscar_insumos');
    Route::get('/admin/tareas/buscar-terrenos', [AdminController::class, 'buscarTerrenos'])->name('admin.tareas.buscar_terrenos');

    // Rutas de edicion de tareas (Admin)
    Route::put('/admin/tareas/update-riego/{id}', [AdminController::class, 'updateRiego'])->name('admin.tareas.update.riego');
    Route::put('/admin/tareas/update-insumo/{id}', [AdminController::class, 'updateInsumo'])->name('admin.tareas.update.insumo');
    Route::put('/admin/tareas/update-general/{id}', [AdminController::class, 'updateGeneral'])->name('admin.tareas.update.general');
    Route::put('/admin/tareas/update-recoleccion/{id}', [AdminController::class, 'updateRecoleccion'])->name('admin.tareas.update.recoleccion');

    // Rutas para la gestión de licencias del usuario administrador
    Route::get('/admin/licencias', [App\Http\Controllers\Admin\TipoLicenciaController::class, 'index'])->name('admin.licencias.index');
    Route::get('/admin/licencias/contacto', [App\Http\Controllers\Admin\TipoLicenciaController::class, 'contacto'])->name('admin.licencias.contacto');
    Route::post('/admin/licencias/contacto', [App\Http\Controllers\Admin\TipoLicenciaController::class, 'enviarContacto'])->name('admin.licencias.enviar_contacto');
    // Rutas para la gestión de usuarios (Supervisor y Trabajador) de la empresa
    Route::resource('/admin/usuarios', \App\Http\Controllers\Admin\UsuarioEmpresaController::class, ['as' => 'admin']);

    // Ruta para asignar trabajo (Fases Programadas)
    Route::get('/admin/usuarios/{usuario}/asignar-trabajo', [\App\Http\Controllers\Admin\UsuarioEmpresaController::class, 'asignarTrabajo'])->name('admin.usuarios.asignar_trabajo');
    Route::post('/admin/usuarios/{usuario}/asignar-trabajo', [\App\Http\Controllers\Admin\UsuarioEmpresaController::class, 'storeTrabajo'])->name('admin.usuarios.store_trabajo');
    Route::get('/admin/usuarios/{usuario}/exportar-pagos', [\App\Http\Controllers\Admin\UsuarioEmpresaController::class, 'exportPagos'])->name('admin.usuarios.exportar_pagos');

    // Insumos y Proveedores
    Route::get('/admin/insumos/export', [\App\Http\Controllers\InsumoController::class, 'exportCSV'])->name('admin.insumos.export');
    Route::post('/admin/proveedores/{id}/entradas', [\App\Http\Controllers\ProveedorController::class, 'storeEntrada'])->name('admin.proveedores.entradas.store');
    Route::get('/admin/proveedores/{id}/historial', [\App\Http\Controllers\ProveedorController::class, 'historial'])->name('admin.proveedores.historial');
    Route::get('/admin/proveedores/entradas-dashboard', [\App\Http\Controllers\ProveedorController::class, 'entradasDashboard'])->name('admin.proveedores.entradas_dashboard');
    Route::get('/admin/proveedores/entradas-dashboard/exportar', [\App\Http\Controllers\ProveedorController::class, 'exportarEntradas'])->name('admin.proveedores.exportar_entradas');
    Route::get('/admin/proveedores/buscar-items', [\App\Http\Controllers\ProveedorController::class, 'buscarItems'])->name('admin.proveedores.buscar_items');
    Route::resource('/admin/proveedores', \App\Http\Controllers\ProveedorController::class, ['as' => 'admin']);
    Route::resource('/admin/insumos', \App\Http\Controllers\InsumoController::class, ['as' => 'admin']);
    
    // Perfil y Configuración (Admin y Trabajador)
    Route::get('/configuracion', [\App\Http\Controllers\Admin\ProfileController::class, 'index']); // Redundancia para evitar 404
    Route::get('/admin/configuracion', [\App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('admin.configuracion');
    Route::post('/admin/configuracion', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('admin.configuracion.update');
    
    // Cosechas y Cultivos
    Route::get('/admin/cosechas/export', [\App\Http\Controllers\Admin\CosechaController::class, 'exportCSV'])->name('admin.cosechas.export');
    Route::get('/admin/cosechas/buscar-terrenos', [DashboardController::class, 'buscarEmpresa']); // Redundant?
    Route::get('/admin/cosechas/{id}/export-history', [\App\Http\Controllers\Admin\CosechaController::class, 'exportHistory'])->name('admin.cosechas.export_history');
    Route::get('/admin/cosechas/buscar-terrenos', [\App\Http\Controllers\Admin\CosechaController::class, 'buscarTerrenos'])->name('admin.cosechas.buscar_terrenos');
    Route::get('/admin/cosechas/buscar-especies', [\App\Http\Controllers\Admin\CosechaController::class, 'buscarEspecies'])->name('admin.cosechas.buscar_especies');
    
    // Rutas para Resumen de Finalización y PDF
    Route::get('/admin/cosechas/{id}/resumen', [\App\Http\Controllers\Admin\CultivoController::class, 'finalizationSummary'])->name('admin.cosechas.resumen');
    Route::get('/admin/cosechas/{id}/pdf', [\App\Http\Controllers\Admin\CultivoController::class, 'downloadFinalizationPDF'])->name('admin.cosechas.pdf');

    Route::resource('/admin/cosechas', \App\Http\Controllers\Admin\CosechaController::class, ['as' => 'admin']);


    Route::get('/admin/cultivos/export', [\App\Http\Controllers\Admin\CultivoController::class, 'exportCSV'])->name('admin.cultivos.export');
    Route::get('/admin/cultivos/cosecha/{id}', [\App\Http\Controllers\Admin\CultivoController::class, 'cosechaDetail'])->name('admin.cultivos.cosechaDetail');
    Route::post('/admin/cultivos/finalize/{id}', [\App\Http\Controllers\Admin\CultivoController::class, 'finalize'])->name('admin.cultivos.finalize');
    Route::resource('/admin/cultivos', \App\Http\Controllers\Admin\CultivoController::class, ['as' => 'admin']);

    // Tipo Insumo
    Route::resource('tipo_insumos', \App\Http\Controllers\TipoInsumoController::class);

    Route::resource('tipo_cosechas', TipoCosechaController::class)->except(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy']);

    Route::get('tipo_semillas/catalog', [\App\Http\Controllers\TipoSemillaController::class, 'catalog'])->name('tipo_semillas.catalog');
    Route::resource('tipo_semillas', \App\Http\Controllers\TipoSemillaController::class);

    Route::get('insumos/catalog', [\App\Http\Controllers\InsumoController::class, 'catalog'])->name('insumos.catalog');
    // Se elimina la ruta resource redundante de insumos, ya que arriba existe /admin/insumos, pero si la app la usa, la mantenemos pero protegida
    Route::resource('insumos', \App\Http\Controllers\InsumoController::class);

    Route::get('tipo_riegos/catalog', [\App\Http\Controllers\TipoRiegoController::class, 'catalog'])->name('tipo_riegos.catalog');
    Route::resource('tipo_riegos', \App\Http\Controllers\TipoRiegoController::class);

    Route::get('tipo_suelos/catalog', [\App\Http\Controllers\TipoSueloController::class, 'catalog'])->name('tipo_suelos.catalog');
    Route::resource('tipo_suelos', \App\Http\Controllers\TipoSueloController::class);

    Route::resource('estados', \App\Http\Controllers\EstadoController::class);

    Route::get('admin/terrenos/export', [\App\Http\Controllers\TerrenoController::class, 'exportCSV'])->name('admin.terrenos.export');
    Route::resource('admin/terrenos', \App\Http\Controllers\TerrenoController::class, ['as' => 'admin']);

});

Route::get('/', [HomeController::class, 'index'])->name('index_welcome');
