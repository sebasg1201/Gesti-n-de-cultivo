@extends('layouts.admin')

@section('content')
<style>
    /* Animaciones Globales de Barras - Versión Ultra-Visible */
    @keyframes liquid-flow {
        0% {
            background-position: 0% 50%;
        }

        100% {
            background-position: -200% 50%;
        }
    }

    @keyframes water-surge {
        0% {
            transform: translateX(-100%) skewX(-15deg);
            opacity: 0;
        }

        50% {
            opacity: 0.8;
        }

        100% {
            transform: translateX(250%) skewX(-15deg);
            opacity: 0;
        }
    }

    .animate-water-flow {
        position: relative;
        overflow: hidden;
        background: linear-gradient(90deg,
                #0ea5e9,
                #3b82f6,
                #0ea5e9,
                #1d4ed8,
                #0ea5e9);
        background-size: 300% 100%;
        animation: liquid-flow 3s linear infinite;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2), 0 0 20px rgba(59, 130, 246, 0.6);
    }

    .animate-water-flow::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 60px;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.8), transparent);
        animation: water-surge 2s ease-in-out infinite;
        z-index: 2;
    }

    .animate-water-flow::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 800 600'%3E%3Cpath fill='%23ffffff' fill-opacity='0.2' d='M0 500c150-50 350-50 500 0s350 50 500 0V0H0z'/%3E%3C/svg%3E");
        background-size: 400px 100%;
        animation: liquid-flow 10s linear infinite reverse;
        opacity: 0.4;
    }

    @keyframes growth-pulse {
        0% {
            filter: brightness(1) drop-shadow(0 0 0px rgba(34, 197, 94, 0));
        }

        50% {
            filter: brightness(1.3) drop-shadow(0 0 8px rgba(34, 197, 94, 0.5));
        }

        100% {
            filter: brightness(1) drop-shadow(0 0 0px rgba(34, 197, 94, 0));
        }
    }

    .animate-growth-shimmer {
        position: relative;
        overflow: hidden;
        background: linear-gradient(90deg, #10b981, #22c55e, #10b981);
        background-size: 200% 100%;
        animation: liquid-flow 5s linear infinite, growth-pulse 3s ease-in-out infinite;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1), 0 0 15px rgba(16, 185, 129, 0.4);
    }

    .animate-growth-shimmer::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        animation: water-surge 4s ease-in-out infinite;
    }
</style>
<div class="min-h-[calc(100vh-4rem)] bg-emerald-50/30 p-4 md:p-8">
    <div class="max-w-7xl mx-auto space-y-8">

        <!-- Header con Botón de Regreso -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.cosechas.index') }}"
                    class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-emerald-600 shadow-sm border border-emerald-100 hover:bg-emerald-50 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-black text-emerald-950 flex items-center gap-3">
                        Detalle de Cosecha
                        <span
                            class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs rounded-full uppercase tracking-widest font-bold">#{{ $cosecha->id_cosecha }}</span>
                    </h1>
                    <p class="text-emerald-600 font-medium mt-1">
                        {{ $cosecha->semilla->nombre_semilla ?? 'Semilla Desconocida' }} en
                        {{ $cosecha->terreno->nombre ?? 'Terreno Desconocido' }}
                    </p>
                </div>
            </div>

            <div class="hidden sm:flex items-center gap-3">
                <span class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-emerald-700 font-bold text-sm tracking-wide uppercase">Ciclo Activo</span>
            </div>
        </div>

        <!-- Metric Cards Row -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Card 1: Cosecha Estimada -->
            <div
                class="bg-white rounded-[2rem] p-6 shadow-sm border border-emerald-50 relative overflow-hidden group hover:shadow-md transition-shadow">
                <div
                    class="absolute -right-4 -top-4 w-24 h-24 bg-rose-50 rounded-full group-hover:scale-110 transition-transform duration-300">
                </div>

                <div class="relative z-10">
                    <div class="flex flex-col gap-1 mb-4">
                        <div
                            class="flex items-center gap-2 text-emerald-600 font-black uppercase tracking-widest text-[10px]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10m-13 9h16a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z" />
                            </svg>
                            Cosecha Estimada
                        </div>
                    </div>

                    <h3 class="text-3xl font-black text-slate-800 leading-none mb-3">
                        {{ $diasRestantes > 0 ? intval($diasRestantes) . ' Días' : 'Lista' }}
                    </h3>

                    <div
                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-rose-50 text-rose-600 text-xs font-bold">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        Aproximadamente {{ floor($diasRestantes) }} días
                    </div>
                </div>
            </div>

            <!-- Card 4: Estimación de Riegos -->
            <div
                class="bg-white rounded-[2rem] p-6 shadow-sm border border-emerald-50 relative overflow-hidden group hover:shadow-md transition-shadow">
                <div
                    class="absolute -right-4 -top-4 w-24 h-24 bg-cyan-50 rounded-full group-hover:scale-110 transition-transform duration-300">
                </div>

                <div class="relative z-10">
                    <div class="flex flex-col gap-1 mb-4">
                        <div
                            class="flex items-center gap-2 text-cyan-600 font-black uppercase tracking-widest text-[10px]">
                            <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                            </svg>
                            Estimación de Riegos
                        </div>
                    </div>

                    <h3 class="text-3xl font-black text-slate-800 leading-none mb-3">
                        {{ $cosecha->frecuencia_riego_dias > 0 && $diasTotales > 0 ? ceil($diasTotales / $cosecha->frecuencia_riego_dias) : 'N/A' }}
                        <span class="text-sm text-slate-500 font-bold uppercase tracking-widest">Total</span>
                    </h3>

                    <div
                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-cyan-50 text-cyan-600 text-xs font-bold">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                        {{ $riegosCompletados }} completados
                    </div>
                </div>
            </div>

            <!-- Card 5: Clima del Terreno (Dynamic) -->
            <div
                class="bg-emerald-900 rounded-[2rem] p-6 shadow-xl border border-emerald-800 relative overflow-hidden group transition-all duration-500">
                <div
                    class="absolute -right-6 -top-6 w-32 h-32 bg-emerald-800/50 rounded-full blur-2xl group-hover:scale-125 transition-transform duration-700">
                </div>

                <div class="relative z-10 flex flex-col h-full justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2 text-emerald-400 font-black uppercase tracking-widest text-[10px]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                Estado Clima
                            </div>
                            <span class="px-2 py-0.5 bg-emerald-800/50 rounded-lg text-[8px] font-bold text-emerald-400 border border-emerald-700 uppercase tracking-widest">Vivo</span>
                        </div>

                        <div class="flex items-center gap-4">
                            <div id="weather-icon-main" class="w-12 h-12 rounded-2xl bg-emerald-800 flex items-center justify-center text-yellow-400 shadow-inner">
                                <svg class="w-7 h-7 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 id="weather-temp-main" class="text-4xl font-black text-white leading-none">--°C</h3>
                                <p id="weather-desc-main" class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest mt-1">Sincronizando...</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-emerald-800/50 flex items-center justify-between">
                        <div class="text-[9px] font-medium text-emerald-500 uppercase tracking-wider">
                            {{ $cosecha->terreno->nombre ?? 'Ubicación' }}
                        </div>
                        <div id="weather-humidity" class="text-[10px] font-black text-white flex items-center gap-1">
                            <svg class="w-3 h-3 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                            --% HR
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ciclo de Vida del Cultivo -->
        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-emerald-50">
            <div class="flex justify-between items-end mb-8">
                <div>
                    <h3 class="text-xl font-black text-slate-800">Ciclo de Vida del Cultivo</h3>
                    <p class="text-sm font-bold mt-1 text-emerald-500">
                        Fase actual: <span class="uppercase tracking-wide">{{ $faseActual }}</span>
                    </p>
                </div>
                <div class="flex items-center gap-4">
                    @if($cosecha->id_estado != 14)
                    @if($porcentaje >= 1)
                    <div class="flex flex-col md:flex-row gap-3">
                        <a href="{{ route('admin.cultivos.create', ['id_cosecha' => $cosecha->id_cosecha]) }}"
                            class="inline-flex items-center gap-2 px-6 py-2 bg-emerald-600 text-white font-black rounded-xl shadow-lg shadow-emerald-200 hover:bg-emerald-700 hover:-translate-y-0.5 transition-all text-sm uppercase tracking-wider">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Cosechar Ahora
                        </a>

                        <form action="{{ route('admin.cultivos.finalize', $cosecha->id_cosecha) }}" method="POST" onsubmit="return confirm('¿Estás seguro de finalizar esta cosecha? Esto liberará el terreno para una nueva siembra.')">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-6 py-2 bg-slate-800 text-white font-black rounded-xl shadow-lg shadow-slate-200 hover:bg-slate-900 hover:-translate-y-0.5 transition-all text-sm uppercase tracking-wider">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Finalizar Cosecha
                            </button>
                        </form>
                    </div>
                    @else
                    <div class="px-4 py-2 bg-slate-100 rounded-xl text-slate-400 text-xs font-bold uppercase tracking-widest flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Opciones bloqueadas
                    </div>
                    @endif
                    @else
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center gap-2 px-6 py-2 bg-emerald-50 text-emerald-700 font-black rounded-xl text-sm uppercase tracking-wider border border-emerald-100 italic">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Ciclo Completado
                        </span>
                        <a href="{{ route('admin.cosechas.resumen', $cosecha->id_cosecha) }}"
                            class="inline-flex items-center gap-2 px-6 py-2 bg-emerald-600 text-white font-black rounded-xl shadow-lg shadow-emerald-200 hover:bg-emerald-700 hover:-translate-y-0.5 transition-all text-sm uppercase tracking-wider">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a2 2 0 00-2-2H5a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            Ver Resultados
                        </a>
                    </div>
                    @endif
                    <div class="text-3xl font-black text-slate-800">
                        {{ number_format($porcentaje, 0) }}%
                    </div>
                </div>

            </div>

            <div class="relative pt-2">
                <!-- Barra de progreso Track -->
                <div class="h-4 w-full bg-slate-100 rounded-full overflow-hidden flex">
                    <!-- Segmentos de la barra (Visuales) -->
                    <div class="h-full border-r-2 border-white animate-growth-shimmer transition-all duration-1000 ease-out"
                        style="width: {{ $porcentaje }}%"></div>
                </div>

                <!-- Puntos y Etiquetas del Timeline -->
                <div
                    class="relative top-4 flex justify-between text-[10px] md:text-xs font-bold text-slate-400 uppercase tracking-widest px-2">
                    <div
                        class="text-left {{ $porcentaje >= 0 && $porcentaje < 20 ? 'text-emerald-500 font-black' : '' }}">
                        Siembra</div>
                    <div
                        class="text-center {{ $porcentaje >= 20 && $porcentaje < 50 ? 'text-emerald-500 font-black' : '' }}">
                        Vegetativo</div>
                    <div
                        class="text-center {{ $porcentaje >= 50 && $porcentaje < 75 ? 'text-emerald-500 font-black' : '' }}">
                        Floración</div>
                    <div
                        class="text-center {{ $porcentaje >= 75 && $porcentaje < 90 ? 'text-emerald-500 font-black' : '' }}">
                        Llenado</div>
                    <div class="text-right {{ $porcentaje >= 90 ? 'text-emerald-500 font-black' : '' }}">Cosecha</div>
                </div>
            </div>
        </div>

        <!-- Cumplimiento de Hidratación (Barra Azul) -->
        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-cyan-50">
            <div class="flex justify-between items-end mb-8">
                <div>
                    <h3 class="text-xl font-black text-slate-800">Cumplimiento de Riego</h3>
                    <p class="text-sm font-bold mt-1 text-cyan-500">
                        Estado hídrico:
                        <span class="uppercase tracking-wide">
                            @if($porcentajeHidratacion >= 80) Óptimo
                            @elseif($porcentajeHidratacion >= 50) Regular
                            @else Crítico
                            @endif
                        </span>
                    </p>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-black text-slate-800">
                        {{ number_format($porcentajeHidratacion, 0) }}%
                    </div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">
                        Monitoreo de frecuencia y aplicación
                    </p>
                </div>
            </div>

            <div class="relative pt-2">
                <!-- Barra de progreso Track -->
                <div class="h-4 w-full bg-slate-100 rounded-full overflow-hidden flex relative">
                    <!-- Sombra o barra guía indicando la meta de crecimiento -->
                    <div class="absolute left-0 top-0 bottom-0 bg-slate-200/50" style="width: {{ $porcentaje }}%"></div>
                    <!-- Segmentos de la barra Azul -->
                    <div class="h-full border-r-2 border-white animate-water-flow transition-all duration-1000 ease-out relative z-10"
                        style="width: {{ $porcentajeHidratacion }}%"></div>
                </div>

                <!-- Indicadores (Visuales) -->
                <div
                    class="relative top-4 flex justify-between text-[10px] md:text-xs font-bold text-slate-400 uppercase tracking-widest px-2">
                    <div class="text-left text-cyan-600 font-black">0%</div>
                    <div class="text-center">Progreso Total de Hidratación (Ciclo Completo)</div>
                    <div class="text-right text-cyan-600 font-black">100%</div>
                </div>
            </div>
        </div>

        <!-- Detalles Técnicos y Multimedia -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-emerald-50">
                <h4 class="font-black text-emerald-950 uppercase tracking-widest text-sm mb-6">Detalles Técnicos</h4>
                <ul class="space-y-4">
                    <li class="flex justify-between items-center border-b border-emerald-50 pb-3">
                        <span class="text-sm font-medium text-slate-500">Variedad Sembrada</span>
                        <a href="{{ route('tipo_semillas.index') }}" class="text-sm font-bold text-slate-800 hover:text-emerald-600 hover:underline transition-all decoration-2 underline-offset-4">
                            {{ $cosecha->semilla->nombre_semilla }}
                        </a>
                    </li>
                    <li class="flex justify-between items-center border-b border-emerald-50 pb-3">
                        <span class="text-sm font-medium text-slate-500">Terreno Designado</span>
                        <a href="{{ route('admin.terrenos.index') }}" class="text-sm font-bold text-slate-800 hover:text-emerald-600 hover:underline transition-all decoration-2 underline-offset-4">
                            {{ $cosecha->terreno->nombre }}
                        </a>
                    </li>
                    <li class="flex justify-between items-center border-b border-emerald-50 pb-3">
                        <span class="text-sm font-medium text-slate-500">Cantidad Plantada</span>
                        <a href="{{ route('tipo_semillas.index') }}" class="text-sm font-bold text-slate-800 hover:text-emerald-600 hover:underline transition-all decoration-2 underline-offset-4">
                            {{ number_format($cosecha->Cantidad, 0) }} und
                        </a>
                    </li>
                    <li class="flex justify-between items-center border-b border-emerald-50 pb-3">
                        <span class="text-sm font-medium text-slate-500">Rendimiento Esperado</span>
                        <span class="text-sm font-bold text-emerald-600">{{ number_format($cosecha->produccion_estimada, 1) }} kg</span>
                    </li>
                </ul>
            </div>

            <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-emerald-50 flex flex-col items-center justify-center text-center">
                @if($cosecha->imagenes)
                <img src="{{ asset('uploads/' . $cosecha->imagenes) }}" alt="Foto Cultivo"
                    class="w-full max-h-64 object-cover rounded-2xl shadow-sm mb-4">
                @else
                <div class="w-24 h-24 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-300 mb-4">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <p class="text-sm font-bold text-slate-400">Sin fotografía registrada para este lote.</p>
                @endif
            </div>
        </div>

        <!-- Línea de Tiempo del Cultivo (Historial) -->
        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-emerald-50 relative overflow-hidden">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6 mb-8">
                <div>
                    <h3 class="text-xl font-black text-slate-800">Historial de Tratamiento</h3>
                    <p class="text-sm font-bold mt-1 text-slate-500">Registro de riegos, insumos y mantenimiento</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.tareas.index') }}"
                        class="p-2.5 bg-white border border-emerald-100 text-emerald-600 rounded-xl hover:bg-emerald-50 transition-all shadow-sm group/tasks"
                        title="Gestionar Tareas">
                        <svg class="w-5 h-5 group-hover/tasks:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </a>
                    <div class="h-8 w-px bg-slate-200 hidden md:block mx-1"></div>

                    <!-- Filtros por Tipo -->
                    <div class="flex items-center gap-2">
                        <a href="{{ request()->fullUrlWithQuery(['type' => null]) }}"
                            class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ !request('type') ? 'bg-slate-800 text-white shadow-lg shadow-slate-200' : 'bg-slate-50 text-slate-400 hover:bg-slate-100' }}">
                            Todos
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['type' => 'riego']) }}"
                            class="flex items-center gap-2 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ request('type') === 'riego' ? 'bg-cyan-500 text-white shadow-lg shadow-cyan-200' : 'bg-cyan-50 text-cyan-600 hover:bg-cyan-100 border border-cyan-100' }}">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                            </svg>
                            Riego
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['type' => 'insumo']) }}"
                            class="flex items-center gap-2 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ request('type') === 'insumo' ? 'bg-purple-500 text-white shadow-lg shadow-purple-200' : 'bg-purple-50 text-purple-600 hover:bg-purple-100 border border-purple-100' }}">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                            Insumo
                        </a>
                    </div>

                    <div class="h-8 w-px bg-slate-200 hidden md:block mx-1"></div>




                    <a href="{{ route('admin.cosechas.export_history', $cosecha->id_cosecha) }}" class="flex items-center gap-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-600 px-4 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all border border-emerald-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Exportar
                    </a>

                </div>
            </div>

            @if($historial->isEmpty())
            <div class="text-center py-16 bg-slate-50/50 rounded-[2rem] border-2 border-dashed border-slate-200">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center text-slate-300 mx-auto mb-4 shadow-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0l-8 8-8-8" />
                    </svg>
                </div>
                <p class="text-slate-500 font-bold">No se encontraron actividades con los filtros seleccionados.</p>
                @if(request('status') || request('type'))
                <a href="{{ request()->fullUrlWithQuery(['status' => null, 'type' => null]) }}" class="text-emerald-600 text-xs font-black uppercase mt-2 inline-block">Limpiar filtros</a>
                @endif
            </div>

            @else
            <div class="space-y-6 relative mb-8 before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-200 before:to-transparent">
                @foreach($historial as $item)
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active scroll-mt-24" id="item-{{ $loop->index }}">

                    <!-- Icon -->
                    <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10
                                {{ $item->tipo_historial == 'riego' ? 'bg-cyan-500' : ($item->tipo_historial == 'insumo' ? 'bg-purple-500' : ($item->tipo_historial == 'recoleccion' ? 'bg-orange-500' : 'bg-emerald-500')) }} shadow-sm">
                        @if($item->tipo_historial == 'riego')
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                        </svg>
                        @elseif($item->tipo_historial == 'insumo')
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                        @elseif($item->tipo_historial == 'recoleccion')
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                        </svg>
                        @else
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 15.536c-1.171 1.952-3.07 1.952-4.242 0-1.172-1.953-1.172-5.119 0-7.072 1.171-1.952 3.07-1.952 4.242 0M8 10.5h4m-4 3h4m9-1.5a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        @endif
                    </div>

                    <!-- Card -->
                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-[1.5rem] border border-slate-100 bg-white shadow-sm hover:shadow-md transition-all">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-[10px] uppercase tracking-widest font-black 
                                        {{ $item->tipo_historial == 'riego' ? 'text-cyan-600' : ($item->tipo_historial == 'insumo' ? 'text-purple-600' : ($item->tipo_historial == 'recoleccion' ? 'text-orange-600' : 'text-emerald-600')) }}">
                                {{ $item->titulo_historial }}
                            </span>
                            <span class="text-xs font-bold text-slate-400">{{ \Carbon\Carbon::parse($item->fecha_historial)->format('d/m/Y') }}</span>
                        </div>
                        <p class="text-slate-700 font-medium text-sm">{{ $item->descripcion_historial ?: 'Sin detalles adicionales' }}</p>

                        @if($item->observacion_trabajador)
                        <div class="mt-3 p-3 bg-emerald-50 rounded-xl border border-emerald-100 flex gap-2">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                            <div>
                                <p class="text-[9px] font-black text-emerald-600 uppercase tracking-widest leading-none mb-1">Obs. {{ $item->usuario->nombre ?? 'Trabajador' }}</p>
                                <p class="text-xs text-emerald-800 font-medium italic">"{{ $item->observacion_trabajador }}"</p>
                            </div>
                        </div>
                        @endif

                        <div class="mt-2 text-right">
                            @if($item->estado_historial == 'Completado')
                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg> Realizado el {{ \Carbon\Carbon::parse($item->fecha_historial)->format('d/m/Y H:i') }}
                            </span>
                            @elseif($item->estado_historial == 'Retraso')
                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-md border border-indigo-100">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg> Realizado con Retraso el {{ \Carbon\Carbon::parse($item->fecha_historial)->format('d/m/Y H:i') }}
                            </span>
                            @elseif($item->estado_historial == 'En Proceso')
                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded-md">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg> En Proceso (Iniciado: {{ \Carbon\Carbon::parse($item->fecha_historial)->format('d/m/Y H:i') }})
                            </span>
                            @elseif($item->estado_historial == 'Perdida')
                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-rose-600 bg-rose-50 px-2 py-1 rounded-md">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg> Perdida el {{ \Carbon\Carbon::parse($item->fecha_historial)->format('d/m/Y H:i') }}
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-slate-500 bg-slate-50 px-2 py-1 rounded-md">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg> Programado para {{ \Carbon\Carbon::parse($item->fecha_historial)->format('d/m/Y H:i') }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Paginación Custom -->
            <div class="flex items-center justify-between border-t border-slate-100 pt-6">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                    Mostrando {{ $historial->firstItem() ?? 0 }}-{{ $historial->lastItem() ?? 0 }} de {{ $historial->total() }} registros
                </p>
                <div class="flex gap-2">
                    {{ $historial->onEachSide(1)->links('vendor.pagination.simple-tailwind') }}
                </div>
            </div>
            @endif
        </div>
    </div>

</div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const lat = {
            {
                $cosecha - > terreno && $cosecha - > terreno - > latitud ? number_format($cosecha - > terreno - > latitud, 8, '.', '') : '4.570868'
            }
        };
        const lon = {
            {
                $cosecha - > terreno && $cosecha - > terreno - > longitud ? number_format($cosecha - > terreno - > longitud, 8, '.', '') : '-74.297333'
            }
        };
        fetchWeather(lat, lon);

        function fetchWeather(la, lo) {
            const url = `https://api.open-meteo.com/v1/forecast?latitude=${la}&longitude=${lo}&current=temperature_2m,relative_humidity_2m,weather_code&timezone=auto`;

            fetch(url)
                .then(res => res.json())
                .then(data => {
                    const current = data.current;
                    const temp = Math.round(current.temperature_2m);
                    const hum = current.relative_humidity_2m;
                    const code = current.weather_code;

                    const weatherMap = {
                        0: {
                            text: 'Despejado',
                            icon: 'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z',
                            color: 'text-yellow-400'
                        },
                        1: {
                            text: 'P. Nublado',
                            icon: 'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z',
                            color: 'text-emerald-200'
                        },
                        2: {
                            text: 'Parcial',
                            icon: 'M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z',
                            color: 'text-emerald-300'
                        },
                        3: {
                            text: 'Nublado',
                            icon: 'M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z',
                            color: 'text-gray-400'
                        },
                        45: {
                            text: 'Niebla',
                            icon: 'M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z',
                            color: 'text-gray-300'
                        },
                        61: {
                            text: 'Lluvia',
                            icon: 'M20 16.242c-.22.217-.457.417-.71.598A7.923 7.923 0 0112 19a7.923 7.923 0 01-7.29-2.16m15.29-2.082A8.001 8.001 0 004.5 9h.5A7 7 0 1119.5 9h.5a8.001 8.001 0 00-7.29 5.242',
                            color: 'text-blue-400'
                        },
                        80: {
                            text: 'Chubascos',
                            icon: 'M20 16.242c-.22.217-.457.417-.71.598A7.923 7.923 0 0112 19a7.923 7.923 0 01-7.29-2.16m15.29-2.082A8.001 8.001 0 004.5 9h.5A7 7 0 1119.5 9h.5a8.001 8.001 0 00-7.29 5.242',
                            color: 'text-blue-500'
                        },
                        95: {
                            text: 'Tormenta',
                            icon: 'M13 10V3L4 14h7v7l9-11h-7z',
                            color: 'text-yellow-600'
                        }
                    };

                    const condition = weatherMap[code] || {
                        text: 'Variable',
                        icon: 'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z',
                        color: 'text-yellow-400'
                    };

                    document.getElementById('weather-temp-main').textContent = `${temp}°C`;
                    document.getElementById('weather-desc-main').textContent = condition.text;
                    document.getElementById('weather-humidity').innerHTML = `
                            <svg class="w-3 h-3 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg> ${hum}% HR`;
                    document.getElementById('weather-icon-main').innerHTML = `
                            <svg class="w-7 h-7 ${condition.color}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${condition.icon}"></path>
                            </svg>`;
                })
                .catch(err => {
                    console.error('Error fetching weather:', err);
                    document.getElementById('weather-desc-main').textContent = 'Error';
                });
        }
    });
</script>
@endpush
@endsection