@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Hola, {{ $usuario->nombre ?? 'Usuario' }}</h1>
            <p class="text-sm text-gray-500 mt-1 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                {{ \Carbon\Carbon::now()->translatedFormat('d de F, Y') }} &bull; 
                <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Soleado 24°C
            </p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="downloadReport()" class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
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
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex flex-col pt-6">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-green-50 rounded-lg text-green-600">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
                </div>
                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800">
                    Activos hoy
                </span>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Trabajadores Activos</p>
                <div class="flex items-baseline gap-2 mt-1">
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['trabajadores_activos'] }}</p>
                    <p class="text-sm text-gray-400">/{{ $stats['total_trabajadores'] }}</p>
                </div>
            </div>
        </div>

        <!-- Alertas Urgentes -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex flex-col pt-6">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-red-50 rounded-lg text-red-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                @if($stats['alertas_urgentes'] > 0)
                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-red-100 text-red-800">
                    Acción requerida
                </span>
                @endif
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Alertas Urgentes</p>
                <div class="flex items-baseline gap-2 mt-1">
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['alertas_urgentes'] }}</p>
                </div>
            </div>
        </div>

        <!-- Cosechas en Proceso -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex flex-col pt-6">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                </div>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Cosechas en Proceso</p>
                <div class="flex items-baseline gap-2 mt-1">
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['cosechas_en_proceso'] }}</p>
                    <p class="text-sm text-gray-400">terrenos</p>
                </div>
            </div>
        </div>

        <!-- Progreso Tareas -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex flex-col pt-6">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-orange-50 rounded-lg text-orange-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                </div>
                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-orange-100 text-orange-800">
                    Progreso hoy
                </span>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Progreso Tareas</p>
                <div class="flex items-center gap-4 mt-1">
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['progreso_tareas'] }}%</p>
                    <div class="flex-1 max-w-[100px] h-2 bg-gray-100 rounded-full overflow-hidden">
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
                    <h2 class="text-lg font-bold text-gray-900">Estado de Cultivos</h2>
                    <a href="{{ route('admin.cosechas.index') }}" class="text-sm font-medium text-green-600 hover:text-green-700">Ver todos</a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($stats['cultivos'] as $cultivo)
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex flex-col">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-16 h-16 rounded-xl bg-gray-200 overflow-hidden flex-shrink-0">
                                @if(is_string($cultivo->imagenes) && json_decode($cultivo->imagenes))
                                    @php $imgs = json_decode($cultivo->imagenes); @endphp
                                    @if(count($imgs) > 0)
                                        <img src="{{ Storage::url($imgs[0]) }}" alt="Cultivo" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-green-100 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                                        </div>
                                    @endif
                                @else
                                    <div class="w-full h-full bg-green-100 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-gray-900">{{ $cultivo->semilla->nombre_semilla ?? 'Cultivo' }} - {{ $cultivo->terreno->nombre_terreno ?? 'Terreno' }}</h3>
                                <p class="text-sm text-gray-500">Etapa: {{ $cultivo->fase_actual }}</p>
                            </div>
                        </div>
                        
                        <div class="mb-4 flex-1">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-xs font-medium text-gray-500">Progreso</span>
                                <span class="text-xs font-bold text-gray-900">{{ number_format($cultivo->porcentaje_crecimiento, 0) }}%</span>
                            </div>
                            <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-green-500 rounded-full" style="width: {{ $cultivo->porcentaje_crecimiento }}%"></div>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-blue-50 text-blue-700">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                @if($cultivo->progreso_hidratacion == 100)
                                Húmedo
                                @else
                                Seco
                                @endif
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-gray-50 text-gray-600 border border-gray-200">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Est. {{ $cultivo->fecha_estimada ? \Carbon\Carbon::parse($cultivo->fecha_estimada)->translatedFormat('d M') : 'N/A' }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-2 border border-dashed border-gray-300 rounded-2xl p-6 text-center text-gray-500">
                        No hay cultivos en proceso en este momento.
                    </div>
                    @endforelse
                </div>
            </section>

            <!-- Seguimiento de Equipo -->
            <section class="mb-4">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold text-gray-900">Seguimiento de Equipo</h2>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium border border-gray-200 bg-white text-gray-700">
                            <span class="w-2 h-2 rounded-full bg-green-500"></span> Activos
                        </span>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium border border-gray-200 bg-white text-gray-700">
                            <span class="w-2 h-2 rounded-full bg-gray-400"></span> Pausa
                        </span>
                    </div>
                </div>
                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="grid grid-cols-12 gap-4 px-6 py-3 border-b border-gray-100 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <div class="col-span-5 md:col-span-4">Trabajador</div>
                        <div class="col-span-3 md:col-span-3">Estado</div>
                        <div class="col-span-4 md:col-span-4">Actividad Reciente</div>
                        <div class="col-span-1 hidden md:block text-right">Acción</div>
                    </div>
                    
                    <div class="divide-y divide-gray-100">
                        @forelse($stats['equipo'] as $miembro)
                        <div class="grid grid-cols-12 gap-4 px-6 py-4 items-center hover:bg-gray-50 transition-colors">
                            <div class="col-span-5 md:col-span-4 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gray-200 overflow-hidden flex-shrink-0">
                                    @if($miembro->imagen)
                                        <img src="{{ asset('uploads/' . $miembro->imagen) }}" alt="Avatar" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex justify-center items-center bg-blue-100 text-blue-600 font-bold uppercase">
                                            {{ substr($miembro->nombre, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="overflow-hidden">
                                    <p class="text-sm font-bold text-gray-900 truncate">{{ $miembro->nombre }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ $miembro->telefono ?? 'Sin teléfono' }}</p>
                                </div>
                            </div>
                            <div class="col-span-3 md:col-span-3">
                                @if($miembro->is_active)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Activo
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Descanso
                                    </span>
                                @endif
                            </div>
                            <div class="col-span-4 md:col-span-4 pb-1">
                                <p class="text-sm font-medium text-gray-700 truncate" title="{{ $miembro->actividad_reciente }}">{{ $miembro->actividad_reciente }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $miembro->tiempo_actividad }}</p>
                            </div>
                            <div class="col-span-1 hidden md:flex justify-end pr-2">
                                <a href="{{ route('admin.usuarios.edit', $miembro->documento) }}" 
                                   class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-bold text-blue-600 bg-blue-50 border border-blue-200 rounded-xl hover:bg-blue-600 hover:text-white hover:shadow-md hover:shadow-blue-200/50 hover:-translate-y-0.5 transition-all duration-300">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    Editar
                                </a>
                            </div>
                        </div>
                        @empty
                        <div class="p-6 text-center text-sm text-gray-500">
                            No hay trabajadores registrados en este momento.
                        </div>
                        @endforelse
                    </div>
                    
                    <div class="p-3 border-t border-gray-50 bg-gray-50 text-center rounded-b-2xl">
                        <a href="{{ route('admin.usuarios.index') }}" class="text-sm font-bold text-gray-600 hover:text-gray-900 transition-colors">Ver todos los trabajadores</a>
                    </div>
                </div>
            </section>
        </div>
        
        <!-- Right Column (1/3 width) -->
        <div class="xl:col-span-1 flex flex-col gap-6">
            
            <!-- Alertas -->
            <section class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hidden xl:block">
                <div class="flex justify-between items-center mb-5">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path></svg>
                        Alertas
                    </h2>
                    @if(count($stats['lista_alertas']) > 0)
                        <span class="px-2 py-0.5 rounded text-xs font-bold bg-red-100 text-red-700">{{ count($stats['lista_alertas']) }} nuevas</span>
                    @endif
                </div>
                
                <div class="space-y-4">
                    @forelse($stats['lista_alertas'] as $alerta)
                    <div class="border-l-4 border-red-500 pl-4 py-1 relative">
                        <div class="flex justify-between items-start mb-1">
                            <h3 class="text-sm font-bold text-gray-900">{{ $alerta->asunto }}</h3>
                            <span class="text-xs text-gray-400">{{ $alerta->created_at->diffForHumans(null, true, true) }}</span>
                        </div>
                        <p class="text-xs text-gray-600 mb-2 line-clamp-2" title="{{ $alerta->mensaje }}">{{ $alerta->mensaje }}</p>
                        <a href="{{ route('admin.soporte.index') }}" class="text-xs font-bold text-red-600 hover:text-red-700 mt-1 inline-block">Ver y Responder</a>
                    </div>
                    @if(!$loop->last)
                        <hr class="border-gray-100">
                    @endif
                    @empty
                    <div class="text-center text-sm text-gray-500 py-4">
                        Todo está funcionando correctamente. No hay alertas.
                    </div>
                    @endforelse
                </div>
            </section>
            
            <!-- Tareas de Hoy -->
            <section class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hidden xl:block">
                <div class="flex justify-between items-center mb-5">
                    <h2 class="text-lg font-bold text-gray-900">Tareas de Hoy</h2>
                    <a href="{{ route('admin.tareas.index') }}" class="text-xs font-bold text-green-600 hover:text-green-700 uppercase tracking-wider">+ Crear</a>
                </div>
                
                <div class="space-y-4">
                    @forelse($stats['lista_tareas_hoy'] as $tarea)
                    <div class="flex items-start gap-3 group">
                        <div class="mt-1 flex-shrink-0">
                            @if($tarea->id_estado == 9)
                                <div class="w-5 h-5 rounded flex items-center justify-center bg-green-500 text-white shadow-sm">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                            @elseif($tarea->id_estado == 8)
                                <div class="w-5 h-5 rounded flex items-center justify-center bg-orange-500 text-white shadow-sm">
                                    <svg class="w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                            @else
                                <div class="w-5 h-5 rounded border-2 border-gray-300 bg-white group-hover:border-green-400 transition-colors"></div>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-bold {{ $tarea->id_estado == 9 ? 'text-gray-400 line-through' : 'text-gray-900' }}">{{ $tarea->descripcion }}</p>
                            <p class="text-xs text-gray-500 flex items-center gap-1 mt-0.5">
                                @if($tarea->id_estado == 9)
                                    Completado
                                @else
                                    Asignado a: {{ $tarea->usuario->nombre ?? 'Usuario' }}
                                @endif
                            </p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-sm text-gray-500 py-4">
                        No hay tareas programadas para hoy.
                    </div>
                    @endforelse
                </div>
            </section>
            
            <!-- Estado del Terreno -->
            <section class="bg-gradient-to-br from-[#1b4332] to-[#081c15] rounded-2xl shadow-md p-6 text-white relative overflow-hidden hidden xl:block">
                <!-- Decorative background elements -->
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-white opacity-5 rounded-full blur-2xl"></div>
                <div class="absolute bottom-0 right-0 w-full h-1/2 bg-gradient-to-t from-black/20 to-transparent"></div>
                
                <h2 class="text-lg font-bold mb-4 relative z-10">Estado del Terreno</h2>
                
                <div class="flex gap-4 mb-5 relative z-10">
                    <div class="flex-1 text-center">
                        <div class="w-12 h-12 mx-auto rounded-full border-4 border-green-500 flex items-center justify-center text-sm font-bold mb-1 shadow-[0_0_10px_rgba(34,197,94,0.3)]">
                            {{ $stats['estado_terreno']['humedad'] }}%
                        </div>
                        <p class="text-[10px] text-green-200 uppercase tracking-wider">Humedad</p>
                    </div>
                    <div class="flex-1 text-center">
                        <div class="w-12 h-12 mx-auto rounded-full border-4 border-yellow-400 flex items-center justify-center text-sm font-bold mb-1 shadow-[0_0_10px_rgba(250,204,21,0.3)]">
                            pH {{ number_format($stats['estado_terreno']['ph'], 1) }}
                        </div>
                        <p class="text-[10px] text-green-200 uppercase tracking-wider">Acidez</p>
                    </div>
                </div>
                
                <div class="bg-white/10 backdrop-blur-md rounded-xl p-3 relative z-10 border border-white/5">
                    <p class="text-xs font-medium text-green-100 flex items-center justify-between pb-1.5 border-b border-white/10">
                        <span>Nitrógeno (N)</span>
                        <span class="font-bold text-white">{{ $stats['estado_terreno']['nitrogeno'] }} ppm</span>
                    </p>
                    <p class="text-xs font-medium text-green-100 flex items-center justify-between py-1.5 border-b border-white/10">
                        <span>Fósforo (P)</span>
                        <span class="font-bold text-white">{{ $stats['estado_terreno']['fosforo'] }} ppm</span>
                    </p>
                    <p class="text-xs font-medium text-green-100 flex items-center justify-between pt-1.5">
                        <span>Potasio (K)</span>
                        <span class="font-bold text-white">{{ $stats['estado_terreno']['potasio'] }} ppm</span>
                    </p>
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