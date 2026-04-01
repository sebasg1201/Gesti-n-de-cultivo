@extends('layouts.admin')

@section('title', 'Control y Reportes')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
<h1 class="text-3xl font-bold text-gray-900 dark:text-emerald-50">
    Hola, {{ auth()->user()->nombre }} {{ auth()->user()->apellido ?? '' }}
</h1>

<p class="text-sm text-gray-500 dark:text-emerald-100/60 mt-1 flex items-center gap-2">
        </div>
        <div class="flex items-center gap-3">
            <button onclick="downloadReport()" class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 border border-gray-300 dark:border-emerald-900/30 rounded-lg shadow-sm text-sm font-medium text-gray-700 dark:text-emerald-100 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Exportar
            </button>
            <button class="flex items-center gap-2 px-4 py-2 bg-[#00c853] text-white rounded-lg shadow-sm text-sm font-medium hover:bg-green-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Nuevo Reporte
            </button>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Trabajadores Activos -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 shadow-sm border border-gray-100 dark:border-emerald-900/20 flex flex-col pt-6">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-green-50 dark:bg-emerald-900/30 rounded-lg text-green-600 dark:text-emerald-400">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
                </div>
                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 dark:bg-emerald-900/50 text-green-800 dark:text-emerald-200">
                    Activos hoy
                </span>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-emerald-100/60">Trabajadores Activos</p>
                <div class="flex items-baseline gap-2 mt-1">
                    <p class="text-3xl font-bold text-gray-900 dark:text-emerald-50">{{ $stats['trabajadores_activos'] }}</p>
                    <p class="text-sm text-gray-400 dark:text-emerald-500/50">/{{ $stats['total_trabajadores'] }}</p>
                </div>
            </div>
        </div>

        <!-- Alertas Urgentes -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 shadow-sm border border-gray-100 dark:border-emerald-900/20 flex flex-col pt-6">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-red-50 dark:bg-red-900/30 rounded-lg text-red-600 dark:text-red-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                @if($stats['alertas_urgentes'] > 0)
                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-200">
                    Acción requerida
                </span>
                @endif
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-emerald-100/60">Alertas Urgentes</p>
                <div class="flex items-baseline gap-2 mt-1">
                    <p class="text-3xl font-bold text-gray-900 dark:text-emerald-50">{{ $stats['alertas_urgentes'] }}</p>
                </div>
            </div>
        </div>

        <!-- Cosechas en Proceso -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 shadow-sm border border-gray-100 dark:border-emerald-900/20 flex flex-col pt-6">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg text-blue-600 dark:text-blue-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                </div>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-emerald-100/60">Cosechas en Proceso</p>
                <div class="flex items-baseline gap-2 mt-1">
                    <p class="text-3xl font-bold text-gray-900 dark:text-emerald-50">{{ $stats['cosechas_en_proceso'] }}</p>
                    <p class="text-sm text-gray-400 dark:text-emerald-500/50">terrenos</p>
                </div>
            </div>
        </div>

        <!-- Progreso Tareas -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 shadow-sm border border-gray-100 dark:border-emerald-900/20 flex flex-col pt-6">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-orange-50 dark:bg-orange-900/30 rounded-lg text-orange-600 dark:text-orange-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                </div>
                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-orange-100 dark:bg-orange-900/50 text-orange-800 dark:text-orange-200">
                    Progreso semanal
                </span>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-emerald-100/60">Progreso Tareas</p>
                <div class="flex items-center gap-4 mt-1">
                    <p class="text-3xl font-bold text-gray-900 dark:text-emerald-50">{{ $stats['progreso_tareas'] }}%</p>
                    <div class="flex-1 max-w-[100px] h-2 bg-gray-100 dark:bg-emerald-950 rounded-full overflow-hidden">
                        <div class="h-full bg-orange-500 rounded-full" style="width: {{ $stats['progreso_tareas'] }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        
        <!-- Left/Center Column (2/3 width on large screens) -->
        <div class="xl:col-span-2 flex flex-col gap-8">
            
            <!-- Estado de Cultivos -->
            <section>
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-emerald-50">Estado de Cultivos</h2>
                    <a href="{{ route('admin.cosechas.index') }}" class="text-sm font-medium text-green-600 hover:text-green-700">Ver todos</a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($stats['cultivos'] as $cultivo)
                    <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 shadow-sm border border-gray-100 dark:border-emerald-900/20 flex flex-col">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-16 h-16 rounded-xl bg-gray-200 dark:bg-slate-900 overflow-hidden flex-shrink-0">
                                @if(is_string($cultivo->imagenes) && json_decode($cultivo->imagenes))
                                    @php $imgs = json_decode($cultivo->imagenes); @endphp
                                    @if(count($imgs) > 0)
                                        <img src="{{ Storage::url($imgs[0]) }}" alt="Cultivo" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-green-100 dark:bg-emerald-900/30 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-green-500 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                                        </div>
                                    @endif
                                @else
                                    <div class="w-full h-full bg-green-100 dark:bg-emerald-900/30 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-green-500 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-gray-900 dark:text-emerald-50">{{ $cultivo->semilla->nombre_semilla ?? 'Cultivo' }} - {{ $cultivo->terreno->nombre_terreno ?? 'Terreno' }}</h3>
                                <p class="text-sm text-gray-500 dark:text-emerald-500">Etapa: {{ $cultivo->fase_actual }}</p>
                            </div>
                        </div>
                        
                        <div class="mb-4 flex-1">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-xs font-medium text-gray-500 dark:text-emerald-100/60">Progreso</span>
                                <span class="text-xs font-bold text-gray-900 dark:text-emerald-200">{{ number_format($cultivo->porcentaje_crecimiento, 0) }}%</span>
                            </div>
                            <div class="w-full h-2 bg-gray-100 dark:bg-emerald-950 rounded-full overflow-hidden">
                                <div class="h-full bg-green-500 rounded-full" style="width: {{ $cultivo->porcentaje_crecimiento }}%"></div>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                @if($cultivo->progreso_hidratacion == 100)
                                Húmedo
                                @else
                                Seco
                                @endif
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-gray-50 dark:bg-slate-900 text-gray-600 dark:text-emerald-400 border border-gray-200 dark:border-emerald-900/30">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Est. {{ $cultivo->fecha_estimada ? \Carbon\Carbon::parse($cultivo->fecha_estimada)->translatedFormat('d M') : 'N/A' }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-2 border border-dashed border-gray-300 dark:border-emerald-900/30 rounded-2xl p-6 text-center text-gray-500 dark:text-emerald-700 bg-white dark:bg-slate-800/50">
                        No hay cultivos en proceso en este momento.
                    </div>
                    @endforelse
                </div>
            </section>

            <!-- Seguimiento de Equipo -->
            <section class="mb-4">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-emerald-50">Seguimiento de Equipo</h2>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium border border-gray-200 dark:border-emerald-800 bg-white dark:bg-slate-800 text-gray-700 dark:text-emerald-100">
                            <span class="w-2 h-2 rounded-full bg-green-500"></span> Activos
                        </span>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-emerald-900/20 overflow-hidden">
                    <div class="grid grid-cols-12 gap-4 px-6 py-3 border-b border-gray-100 dark:border-emerald-900/30 bg-gray-50 dark:bg-slate-900/50 text-xs font-semibold text-gray-500 dark:text-emerald-500 uppercase tracking-wider">
                        <div class="col-span-5 md:col-span-4">Trabajador</div>
                        <div class="col-span-3 md:col-span-3">Estado</div>
                        <div class="col-span-4 md:col-span-4">Actividad Reciente</div>
                        <div class="col-span-1 hidden md:block text-right">Acción</div>
                    </div>
                    
                    <div class="divide-y divide-gray-100 dark:divide-emerald-900/10">
                        @forelse($stats['equipo'] as $miembro)
                        <div class="grid grid-cols-12 gap-4 px-6 py-4 items-center hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                            <div class="col-span-5 md:col-span-4 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-emerald-900/50 overflow-hidden flex-shrink-0">
                                    @if($miembro->imagen)
                                        <img src="{{ asset('uploads/' . $miembro->imagen) }}" alt="Avatar" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex justify-center items-center bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-300 font-bold uppercase">
                                            {{ substr($miembro->nombre, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="overflow-hidden">
                                    <p class="text-sm font-bold text-gray-900 dark:text-emerald-50 truncate">{{ $miembro->nombre }}</p>
                                    <p class="text-xs text-gray-500 dark:text-emerald-500 truncate">{{ $miembro->telefono ?? 'Sin teléfono' }}</p>
                                </div>
                            </div>
                            <div class="col-span-3 md:col-span-3">
                                @if($miembro->is_active)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Activo
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-emerald-400">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Descanso
                                    </span>
                                @endif
                            </div>
                            <div class="col-span-4 md:col-span-4 pb-1">
                                <p class="text-sm font-medium text-gray-700 dark:text-emerald-100 truncate" title="{{ $miembro->actividad_reciente }}">{{ $miembro->actividad_reciente }}</p>
                                <p class="text-xs text-gray-400 dark:text-emerald-600 mt-0.5">{{ $miembro->tiempo_actividad }}</p>
                            </div>
                            <div class="col-span-1 hidden md:flex justify-end pr-2">
                                <a href="{{ route('admin.usuarios.index') }}" 
                                   class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-bold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl hover:bg-blue-600 hover:text-white dark:hover:bg-blue-500 transition-all duration-300">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                    Personal
                                </a>
                            </div>
                        </div>
                        @empty
                        <div class="p-6 text-center text-sm text-gray-500">
                            No hay trabajadores registrados en este momento.
                        </div>
                        @endforelse
                    </div>
                    
                    <div class="p-3 border-t border-gray-50 dark:border-emerald-900/10 bg-gray-50 dark:bg-slate-900/50 text-center rounded-b-2xl">
                        <a href="{{ route('admin.usuarios.index') }}" class="text-sm font-bold text-gray-600 dark:text-emerald-400 hover:text-gray-900 dark:hover:text-emerald-200 transition-colors">Ver todos los trabajadores</a>
                    </div>
                </div>
            </section>
        </div>
        
        <!-- Right Column (1/3 width) -->
        <div class="xl:col-span-1 flex flex-col gap-6">
            
            <!-- Tareas de Hoy -->
            <section class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-emerald-900/20 p-5 hidden xl:block transition-all duration-300">
                <div class="flex justify-between items-center mb-5">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-emerald-50">Tareas de Hoy</h2>
                    <a href="{{ route('admin.tareas.index') }}" class="text-xs font-bold text-green-600 dark:text-green-400 hover:text-green-700 uppercase tracking-wider">+ CREAR</a>
                </div>
                
                <div class="space-y-3">
                    @forelse($stats['lista_tareas_hoy'] as $tarea)
                    <div class="flex items-center gap-4 p-3 rounded-xl border border-gray-50 dark:border-emerald-900/30 hover:border-green-100 dark:hover:border-emerald-500 hover:bg-green-50/30 dark:hover:bg-emerald-900/20 transition-all duration-300 group">
                        <div class="flex-shrink-0">
                            @if($tarea->id_estado == 15 || $tarea->id_estado == 9)
                                <div class="w-8 h-8 rounded-full flex items-center justify-center bg-green-100 dark:bg-green-900/50 text-green-600 dark:text-green-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                            @elseif($tarea->id_estado == 17 || $tarea->id_estado == 8)
                                <div class="w-8 h-8 rounded-full flex items-center justify-center bg-orange-100 dark:bg-orange-900/50 text-orange-600 dark:text-orange-400 animate-pulse">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                            @else
                                <div class="w-8 h-8 rounded-full border-2 border-gray-200 dark:border-emerald-900/50 bg-white dark:bg-slate-900 group-hover:border-green-400 transition-colors flex items-center justify-center">
                                    <div class="w-2 h-2 rounded-full bg-gray-200 dark:bg-emerald-800 group-hover:bg-green-400"></div>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold truncate {{ ($tarea->id_estado == 15 || $tarea->id_estado == 9) ? 'text-gray-400 dark:text-emerald-800 line-through font-medium' : 'text-gray-800 dark:text-emerald-100' }}">
                                {{ $tarea->descripcion }}
                            </p>
                            <div class="flex items-center gap-2 mt-0.5">
                                <span class="text-[10px] text-gray-500 dark:text-emerald-500 font-medium">{{ $tarea->usuario->nombre ?? 'Asignado' }}</span>
                                <span class="w-1 h-1 rounded-full bg-gray-300 dark:bg-emerald-900"></span>
                                <span class="px-1.5 py-0.5 rounded text-[9px] uppercase font-bold {{ $tarea->tipo_tarea == 'riego' ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400' : ($tarea->tipo_tarea == 'insumo' ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400' : 'bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400') }}">
                                    {{ $tarea->tipo_tarea }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <div class="w-12 h-12 bg-gray-50 dark:bg-slate-900/50 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-gray-300 dark:text-emerald-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-emerald-600">No hay tareas programadas para hoy.</p>
                    </div>
                    @endforelse
                </div>

                @if(count($stats['lista_tareas_hoy']) > 0)
                <div class="mt-6 pt-4 border-t border-gray-50 dark:border-emerald-900/10">
                    <a href="{{ route('admin.tareas.index') }}" class="flex items-center justify-center w-full py-2 px-4 bg-gray-50 dark:bg-slate-900/50 text-gray-700 dark:text-emerald-300 text-sm font-bold rounded-xl hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors group">
                        Gestionar Tareas
                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </a>
                </div>
                @endif
            </section>
            
            <!-- Estado del Terreno (Clima Rotativo) -->
            <section class="bg-gradient-to-br from-[#1b4332] to-[#081c15] rounded-2xl shadow-md p-6 text-white relative overflow-hidden hidden xl:block min-h-[160px] group/weather">
                <!-- Decorative background elements -->
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-white opacity-5 rounded-full blur-2xl"></div>
                <div class="absolute bottom-0 right-0 w-full h-1/2 bg-gradient-to-t from-black/20 to-transparent"></div>
                
                <!-- Manual Controls (Hover only) -->
                <div class="absolute inset-y-0 left-0 flex items-center z-20 opacity-0 group-hover/weather:opacity-100 transition-opacity duration-300 pl-2">
                    <button onclick="prevTerrain()" class="text-white/70 hover:text-white transition-all transform hover:scale-125 border-none outline-none drop-shadow-md">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                </div>
                <div class="absolute inset-y-0 right-0 flex items-center z-20 opacity-0 group-hover/weather:opacity-100 transition-opacity duration-300 pr-2">
                    <button onclick="nextTerrain()" class="text-white/70 hover:text-white transition-all transform hover:scale-125 border-none outline-none drop-shadow-md">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>

                <div class="flex justify-between items-center mb-4 relative z-10">
                    <h2 class="text-lg font-bold">Clima Real</h2>
                    <div id="terrain-indicator" class="flex gap-1">
                        <!-- Dots will be inserted here by JS -->
                    </div>
                </div>
                
                <!-- Weather info container -->
                <div id="weather-card-info" class="relative z-10 transition-all duration-500 opacity-0 transform translate-y-2">
                    <div class="flex items-center justify-between mb-4 px-2">
                        <div class="flex items-center gap-3">
                            <div id="weather-icon-large" class="text-yellow-400">
                                <!-- Icon here -->
                            </div>
                            <div>
                                <p id="weather-temp-large" class="text-2xl font-bold">--°C</p>
                                <p id="weather-desc-large" class="text-[10px] text-green-200 uppercase tracking-widest leading-none mt-1">Sincronizando...</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] text-green-200 uppercase tracking-wider mb-1">Precipitación</p>
                            <p id="weather-precip" class="text-sm font-bold">-- mm</p>
                        </div>
                    </div>
                    
                    <!-- New Fields: Crop and Location -->
                    <div class="flex justify-between items-end border-t border-white/10 pt-3 mt-1 px-1">
                        <div class="overflow-hidden">
                            <p class="text-[10px] text-green-300 uppercase tracking-wider leading-none mb-1">Cosecha Actual</p>
                            <p id="weather-crop" class="text-sm font-bold truncate">--</p>
                        </div>
                        <div class="text-right flex-shrink-0 ml-4">
                            <p class="text-[10px] text-green-300 uppercase tracking-wider leading-none mb-1">Terreno</p>
                            <p id="weather-location" class="text-sm font-bold">--</p>
                        </div>
                    </div>
                </div>
            </section>
            
        </div>
    </div>
</div>

@push('scripts')
<script>
    function downloadReport() {
        window.print();
    }

    // Weather API Integration with Rotation
    document.addEventListener('DOMContentLoaded', function() {
        const terrenos = @json($stats['terrenos_clima']);
        let currentIndex = 0;
        let rotationInterval;

        if (!terrenos || terrenos.length === 0) {
            const descElement = document.getElementById('weather-desc-large');
            if (descElement) descElement.textContent = 'No hay terrenos registrados';
            return;
        }

        // Initialize dots indicator
        const indicator = document.getElementById('terrain-indicator');
        if (indicator) {
            terrenos.forEach((_, i) => {
                const dot = document.createElement('div');
                dot.className = `w-1.5 h-1.5 rounded-full transition-all duration-300 ${i === 0 ? 'bg-white w-3' : 'bg-white/30'}`;
                dot.id = `dot-${i}`;
                indicator.appendChild(dot);
            });
        }
        
        function updateWeatherUI(terrain, weatherData) {
            const current = weatherData.current;
            const temp = Math.round(current.temperature_2m);
            const code = current.weather_code;
            const precip = current.precipitation;
            
            const weatherMap = {
                0: { text: 'Cielo Despejado', icon: 'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z', color: 'text-yellow-400' },
                1: { text: 'Principalmente Despejado', icon: 'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z', color: 'text-yellow-400' },
                2: { text: 'Parcialmente Nublado', icon: 'M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z', color: 'text-gray-300' },
                3: { text: 'Nublado', icon: 'M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z', color: 'text-gray-400' },
                45: { text: 'Niebla', icon: 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', color: 'text-gray-200' },
                48: { text: 'Niebla Escarchada', icon: 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', color: 'text-gray-200' },
                51: { text: 'Llovizna Ligera', icon: 'M20 16.242c-.22.217-.457.417-.71.598A7.923 7.923 0 0112 19a7.923 7.923 0 01-7.29-2.16m15.29-2.082A8.001 8.001 0 004.5 9h.5A7 7 0 1119.5 9h.5a8.001 8.001 0 00-7.29 5.242', color: 'text-blue-200' },
                61: { text: 'Lluvia Ligera', icon: 'M20 16.242c-.22.217-.457.417-.71.598A7.923 7.923 0 0112 19a7.923 7.923 0 01-7.29-2.16m15.29-2.082A8.001 8.001 0 004.5 9h.5A7 7 0 1119.5 9h.5a8.001 8.001 0 00-7.29 5.242', color: 'text-blue-300' },
                80: { text: 'Chubascos de Lluvia', icon: 'M20 16.242c-.22.217-.457.417-.71.598A7.923 7.923 0 0112 19a7.923 7.923 0 01-7.29-2.16m15.29-2.082A8.001 8.001 0 004.5 9h.5A7 7 0 1119.5 9h.5a8.001 8.001 0 00-7.29 5.242', color: 'text-blue-400' },
                95: { text: 'Tormenta', icon: 'M13 10V3L4 14h7v7l9-11h-7z', color: 'text-yellow-600' }
            };

            const condition = weatherMap[code] || { text: 'Variado', icon: 'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z', color: 'text-yellow-400' };

            // Update Elements
            document.getElementById('weather-temp-large').textContent = `${temp}°C`;
            document.getElementById('weather-desc-large').textContent = condition.text;
            document.getElementById('weather-precip').textContent = `${precip} mm`;
            document.getElementById('weather-crop').textContent = terrain.cosecha || 'Sin cosecha';
            document.getElementById('weather-location').textContent = terrain.nombre;
            document.getElementById('weather-icon-large').innerHTML = `
                <svg class="w-10 h-10 ${condition.color}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${condition.icon}"></path></svg>
            `;
            
            // Animate dots
            terrenos.forEach((_, i) => {
                const d = document.getElementById(`dot-${i}`);
                if (d) {
                    if (i === currentIndex) {
                        d.classList.add('bg-white', 'w-3');
                        d.classList.remove('bg-white/30');
                    } else {
                        d.classList.remove('bg-white', 'w-3');
                        d.classList.add('bg-white/30');
                    }
                }
            });

            // Show card info
            const weatherInfo = document.getElementById('weather-card-info');
            if (weatherInfo) {
                weatherInfo.classList.remove('opacity-0', 'translate-y-2');
                weatherInfo.classList.add('opacity-100', 'translate-y-0');
            }
        }

        function fetchAndDisplayTerrain(index) {
            const terrain = terrenos[index];
            const lat = terrain.latitud || 4.6097;
            const lon = terrain.longitud || -74.0817;

            // Fade out
            const weatherInfo = document.getElementById('weather-card-info');
            if (weatherInfo) {
                weatherInfo.classList.add('opacity-0', 'translate-y-2');
                weatherInfo.classList.remove('opacity-100', 'translate-y-0');
            }

            setTimeout(() => {
                fetch(`https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current=temperature_2m,weather_code,precipitation&timezone=auto`)
                .then(r => r.json())
                .then(data => {
                    updateWeatherUI(terrain, data);
                })
                .catch(e => console.error('Error clima:', e));
            }, 500);
        }

        function autoRotate() {
            currentIndex = (currentIndex + 1) % terrenos.length;
            fetchAndDisplayTerrain(currentIndex);
        }

        function resetInterval() {
            clearInterval(rotationInterval);
            rotationInterval = setInterval(autoRotate, 10000);
        }

        window.nextTerrain = function() {
            currentIndex = (currentIndex + 1) % terrenos.length;
            fetchAndDisplayTerrain(currentIndex);
            resetInterval();
        }

        window.prevTerrain = function() {
            currentIndex = (currentIndex - 1 + terrenos.length) % terrenos.length;
            fetchAndDisplayTerrain(currentIndex);
            resetInterval();
        }

        // Start
        fetchAndDisplayTerrain(currentIndex);
        rotationInterval = setInterval(autoRotate, 10000); // 10 seconds
    });
</script>
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .max-w-7xl, .max-w-7xl * {
            visibility: visible;
        }
        .max-w-7xl {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        /* Ocultar botones e interacciones */
        button, a, .hidden.xl\:block {
            display: none !important;
        }
    }
</style>
@endpush
@endsection