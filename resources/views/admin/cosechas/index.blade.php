@extends('layouts.admin')

@section('title', 'Control de Cosechas')

@section('content')
    <style>
        /* Animaciones Globales de Barras - Versión Ultra-Visible */
        @keyframes liquid-flow {
            0% { background-position: 0% 50%; }
            100% { background-position: -200% 50%; }
        }

        @keyframes water-surge {
            0% { transform: translateX(-100%) skewX(-15deg); opacity: 0; }
            50% { opacity: 0.8; } /* Opacidad aumentada */
            100% { transform: translateX(250%) skewX(-15deg); opacity: 0; }
        }

        .animate-water-flow {
            position: relative;
            overflow: hidden;
            background: linear-gradient(
                90deg, 
                #0ea5e9, 
                #3b82f6, 
                #0ea5e9, 
                #1d4ed8, 
                #0ea5e9
            );
            background-size: 300% 100%;
            animation: liquid-flow 3s linear infinite; /* Más rápida */
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.2), 0 0 15px rgba(59, 130, 246, 0.6);
        }

        .animate-water-flow::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 60px; /* Más ancha */
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.8), transparent);
            animation: water-surge 2s ease-in-out infinite; /* Más rápida */
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
            animation: liquid-flow 8s linear infinite reverse;
            opacity: 0.4;
        }

        @keyframes growth-pulse {
            0% { filter: brightness(1) drop-shadow(0 0 0px rgba(34,197,94,0)); }
            50% { filter: brightness(1.3) drop-shadow(0 0 8px rgba(34,197,94,0.5)); }
            100% { filter: brightness(1) drop-shadow(0 0 0px rgba(34,197,94,0)); }
        }

        .animate-growth-shimmer {
            position: relative;
            overflow: hidden;
            background: linear-gradient(90deg, #10b981, #22c55e, #10b981);
            background-size: 200% 100%;
            animation: liquid-flow 5s linear infinite, growth-pulse 3s ease-in-out infinite;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.1), 0 0 10px rgba(16, 185, 129, 0.4);
        }

        .animate-growth-shimmer::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            animation: water-surge 4s ease-in-out infinite;
        }
    </style>
    <div class="space-y-8 animate-in fade-in duration-700">
        <!-- Header con Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div
                class="bg-gradient-to-br from-emerald-600 to-green-600 rounded-3xl p-8 text-white shadow-2xl shadow-emerald-200 relative overflow-hidden group">
                <div
                    class="absolute -right-4 -top-4 w-24 h-24 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700">
                </div>
                <p class="text-emerald-100 text-sm font-black uppercase tracking-widest mb-2">Cultivos Activos</p>
                <div class="flex items-end gap-3">
                    <h3 class="text-5xl font-black">{{ $cosechas->total() }}</h3>
                    <span class="text-emerald-200 mb-1 font-bold">Lotes en curso</span>
                </div>
            </div>

            <div
                class="bg-white rounded-3xl p-8 border-2 border-emerald-50 shadow-xl shadow-emerald-50/50 flex flex-col justify-center">
                <p class="text-emerald-400 text-xs font-black uppercase tracking-widest mb-1">Terrenos Disponibles</p>
                <h3 class="text-3xl font-black text-emerald-950">{{ $terrenos->count() }}</h3>
            </div>

            <div class="flex items-center">
                <button onclick="document.getElementById('modal-nueva-cosecha').classList.remove('hidden')"
                    class="w-full bg-emerald-700 text-white rounded-3xl py-6 font-black uppercase tracking-tighter hover:bg-emerald-800 hover:scale-[1.02] active:scale-95 transition-all shadow-xl shadow-emerald-200 flex items-center justify-center gap-4 group">
                    <div
                        class="w-8 h-8 rounded-full bg-emerald-500 flex items-center justify-center group-hover:rotate-90 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    Iniciar Nueva Siembra
                </button>
            </div>
        </div>

        <!-- Galería de Cosechas -->
        <div class="bg-white rounded-[2.5rem] border border-emerald-50 shadow-2xl shadow-emerald-100/50 p-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <h3 class="text-3xl font-black text-emerald-950">Galería de Cosechas</h3>
                    <p class="text-sm font-medium text-emerald-600 mt-1">Gestión visual de cultivos, terrenos y ciclos de
                        producción.</p>
                </div>

                <div class="flex flex-col items-end gap-3">
                    <div class="flex flex-wrap justify-end gap-2">
                        <a href="{{ route('admin.cosechas.index') }}"
                            class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest transition-all {{ !request('fase') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-200 scale-105' : 'bg-white text-emerald-600 border border-emerald-100 hover:bg-emerald-50' }}">
                            Todos
                        </a>
                        @foreach(['Siembra', 'Vegetativo', 'Floración', 'Llenado', 'Cosecha'] as $fase)
                            <a href="{{ route('admin.cosechas.index', array_merge(request()->query(), ['fase' => $fase])) }}"
                                class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest transition-all flex items-center gap-2 {{ request('fase') == $fase ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-200 scale-105' : 'bg-white text-emerald-600 border border-emerald-100 hover:bg-emerald-50' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ 
                                    $fase == 'Siembra' ? 'bg-blue-400' : (
                                    $fase == 'Vegetativo' ? 'bg-emerald-400' : (
                                    $fase == 'Floración' ? 'bg-rose-400' : (
                                    $fase == 'Llenado' ? 'bg-amber-400' : 'bg-orange-400'))) 
                                }}"></span>
                                {{ $fase }}
                            </a>
                        @endforeach
                    </div>

                    <div class="flex flex-wrap items-center justify-end gap-3">
                        <form action="{{ route('admin.cosechas.index') }}" method="GET" class="flex items-center gap-2 bg-white p-1 rounded-full border border-emerald-100 shadow-sm">
                            @if(request('fase'))
                                <input type="hidden" name="fase" value="{{ request('fase') }}">
                            @endif
                            <select name="month" class="bg-transparent border-0 text-[10px] font-bold text-emerald-700 focus:ring-0 cursor-pointer pl-4 pr-8">
                                <option value="">Mes...</option>
                                @php
                                    $meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                                @endphp
                                @foreach($meses as $index => $mes)
                                    <option value="{{ $index + 1 }}" {{ request('month') == ($index + 1) ? 'selected' : '' }}>{{ $mes }}</option>
                                @endforeach
                            </select>
                            <select name="year" class="bg-transparent border-0 text-[10px] font-bold text-emerald-700 focus:ring-0 cursor-pointer pr-8">
                                <option value="">Año...</option>
                                @for($y = date('Y'); $y >= 2024; $y--)
                                    <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                            <button type="submit" class="p-1.5 bg-emerald-50 text-emerald-600 rounded-full hover:bg-emerald-100 transition-colors mr-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </button>
                        </form>
                        
                        <a href="{{ route('admin.cosechas.export', request()->all()) }}" class="flex items-center gap-2 px-5 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-full text-[10px] font-black uppercase tracking-widest shadow-lg shadow-emerald-100 transition-all transform hover:-translate-y-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            Exportar CSV
                        </a>
                    </div>
                </div>
            </div>

            @if($cosechas->isEmpty())
                <div class="py-20 text-center">
                    <div class="flex flex-col items-center gap-4 opacity-30">
                        <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <p class="font-black text-emerald-950 uppercase tracking-widest text-xs">No hay cosechas activas
                            registradas</p>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($cosechas as $cosecha)
                        <div
                            class="bg-white rounded-3xl border border-emerald-100 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden group flex flex-col h-full">
                            <!-- Imagen Header -->
                            <div class="relative h-48 w-full overflow-hidden bg-emerald-50">
                                @if($cosecha->imagenes)
                                    <img src="{{ asset('uploads/' . $cosecha->imagenes) }}"
                                        alt="{{ $cosecha->semilla->nombre_semilla ?? 'Cultivo' }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-emerald-200">
                                        <svg class="w-16 h-16 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

                                <!-- Status Badge -->
                                <div
                                    class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full flex items-center gap-1.5 shadow-sm">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    <span class="text-[10px] font-black text-emerald-900 uppercase tracking-wider">{{ $cosecha->fase_actual }}</span>
                                </div>

                                <!-- Info Overlay -->
                                <div class="absolute bottom-4 left-4 right-4">
                                    <h4 class="text-xl font-black text-white leading-tight mb-1">
                                        {{ $cosecha->semilla->nombre_semilla ?? 'Variedad Desconocida' }}
                                    </h4>
                                    <div class="flex items-center gap-1.5 text-emerald-50">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span class="text-xs font-semibold">{{ $cosecha->terreno->nombre ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="p-5 flex-grow flex flex-col justify-between space-y-4">
                                <div class="grid grid-cols-2 gap-y-4 gap-x-2">
                                    <div>
                                        <p class="text-[9px] font-bold text-emerald-400 uppercase tracking-widest mb-0.5">Siembra
                                        </p>
                                        <div class="flex items-center gap-1.5 text-emerald-900 font-semibold text-xs">
                                            <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10m-13 9h16a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z" />
                                            </svg>
                                            {{ \Carbon\Carbon::parse($cosecha->fecha_siembra)->format('d M Y') }}
                                        </div>
                                    </div>
                                    <div>
                                        <p
                                            class="text-[9px] font-bold text-emerald-400 uppercase tracking-widest mb-0.5 text-right">
                                            Cosecha Est.</p>
                                        <div class="flex items-center justify-end gap-1.5 text-emerald-600 font-bold text-xs">
                                            @if($cosecha->fecha_estimada)
                                                {{ \Carbon\Carbon::parse($cosecha->fecha_estimada)->format('d M Y') }}
                                            @else
                                                N/A
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-[9px] font-bold text-emerald-400 uppercase tracking-widest mb-0.5">Plantas
                                        </p>
                                        <div class="flex items-center gap-1.5 text-emerald-900 font-medium text-xs">
                                            {{ number_format($cosecha->Cantidad, 0) }} und
                                        </div>
                                    </div>
                                    <div>
                                        <p
                                            class="text-[9px] font-bold text-emerald-400 uppercase tracking-widest mb-0.5 text-right">
                                            Rendimiento</p>
                                        <div class="flex items-center justify-end gap-1.5 text-emerald-900 font-bold text-sm">
                                            {{ number_format($cosecha->produccion_estimada, 1) }} kg
                                        </div>
                                    </div>
                                </div>

                                <!-- Progress Bars -->
                                <div class="space-y-3 mt-4 border-t border-emerald-50 pt-4">
                                    <!-- Growth Bar -->
                                    <div>
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-[9px] font-bold text-emerald-600 uppercase tracking-widest">Crecimiento (Tiempo)</span>
                                            <span class="text-[9px] font-black text-emerald-900">{{ number_format($cosecha->porcentaje_crecimiento, 0) }}%</span>
                                        </div>
                                        <div class="w-full bg-emerald-50 rounded-full h-1.5 border border-emerald-100/50 overflow-hidden">
                                            <div class="animate-growth-shimmer h-1.5 rounded-full transition-all duration-1000" style="width: {{ $cosecha->porcentaje_crecimiento }}%"></div>
                                        </div>
                                    </div>

                                    <!-- Hydration Bar -->
                                    <div>
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-[9px] font-bold text-blue-600 uppercase tracking-widest flex items-center gap-1">
                                                Hidratación 
                                                @if($cosecha->progreso_hidratacion < $cosecha->porcentaje_crecimiento - 10)
                                                    <svg class="w-3 h-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                                @endif
                                            </span>
                                            <span class="text-[9px] font-black text-blue-900">{{ number_format($cosecha->progreso_hidratacion, 0) }}%</span>
                                        </div>
                                        <div class="w-full bg-blue-50 rounded-full h-1.5 border border-blue-100/50 overflow-hidden relative">
                                            <!-- The blue bar -->
                                            <div class="animate-water-flow h-1.5 rounded-full transition-all duration-1000" style="width: {{ $cosecha->progreso_hidratacion }}%"></div>
                                        </div>
                                    </div>
                                </div>

                                <a href="{{ route('admin.cosechas.show', $cosecha->id_cosecha) }}"
                                    class="w-full mt-4 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold text-sm py-2.5 rounded-xl transition-colors flex items-center justify-center gap-2">
                                    Ver Detalles
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($cosechas->hasPages())
                    <div class="mt-8">
                        {{ $cosechas->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>

    <!-- Modal Nueva Cosecha -->
    <div id="modal-nueva-cosecha" class="fixed inset-0 z-[100] hidden overflow-y-auto px-4 py-6 sm:px-0">
        <div class="fixed inset-0 bg-emerald-950/80 backdrop-blur-md transition-opacity"
            onclick="this.parentElement.classList.add('hidden')"></div>

        <div
            class="relative mx-auto mt-10 max-w-2xl bg-white rounded-[3rem] shadow-2xl overflow-hidden animate-in zoom-in-95 duration-300">
            <!-- Header Modal -->
            <div class="p-10 bg-gradient-to-br from-emerald-900 to-emerald-950 text-white relative">
                <h2 class="text-3xl font-black leading-none">Nueva Siembra</h2>
                <p class="text-emerald-400 text-sm mt-2 font-bold uppercase tracking-widest">Registro de Ciclo Productivo
                </p>
                <button onclick="this.closest('#modal-nueva-cosecha').classList.add('hidden')"
                    class="absolute top-10 right-10 text-emerald-500 hover:text-white transition-colors">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('admin.cosechas.store') }}" method="POST" enctype="multipart/form-data"
                class="p-10 space-y-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Terreno -->
                    <div class="space-y-3">
                        <label class="block text-xs font-black text-emerald-950 uppercase tracking-widest ml-4">Terreno
                            Disponible</label>
                        <select name="id_terreno" id="select-terreno" required
                            class="w-full bg-emerald-50 border-2 border-emerald-50 rounded-2xl p-4 text-emerald-900 font-bold focus:border-emerald-500 transition-all">
                            <option value="" disabled selected>Seleccione Terreno</option>
                            @foreach($terrenos as $terreno)
                                <option value="{{ $terreno->id_terreno }}"
                                    data-impacto="{{ $terreno->tipoSuelo->impacto_dias ?? 0 }}">
                                    {{ $terreno->nombre }} ({{ $terreno->Ancho * $terreno->Alto }} m²)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Semilla -->
                    <div class="space-y-3">
                        <label class="block text-xs font-black text-emerald-950 uppercase tracking-widest ml-4">Especie a
                            Sembrar</label>
                        <select name="id_semilla" id="select-semilla" required
                            class="w-full bg-emerald-50 border-2 border-emerald-50 rounded-2xl p-4 text-emerald-900 font-bold focus:border-emerald-500 transition-all">
                            <option value="" disabled selected>Seleccione Variedad</option>
                            @foreach($semillas as $semilla)
                                <option value="{{ $semilla->id_semilla }}" data-yield="{{ $semilla->rendimiento_promedio }}"
                                    data-base-dias="{{ $semilla->tiempo_base_dias ?? 0 }}">
                                    {{ $semilla->nombre_semilla }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Riego -->
                    <div class="space-y-3">
                        <label class="block text-xs font-black text-emerald-950 uppercase tracking-widest ml-4">Tipo de
                            Riego Inicial</label>
                        <select name="id_tipo_riego" id="select-riego" required
                            class="w-full bg-emerald-50 border-2 border-emerald-50 rounded-2xl p-4 text-emerald-900 font-bold focus:border-emerald-500 transition-all">
                            <option value="" disabled selected>Seleccione Riego</option>
                            @foreach($riegos as $riego)
                                <option value="{{ $riego->id_tipo_riego }}" data-impacto="{{ $riego->impacto_dias ?? 0 }}">
                                    {{ $riego->tipo_riego }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Cantidad -->
                    <div class="space-y-3">
                        <label class="block text-xs font-black text-emerald-950 uppercase tracking-widest ml-4">Cantidad
                            (Semillas/Plantas)</label>
                        <input type="number" name="cantidad_sembrada" id="input-cantidad" step="0.01" required min="1"
                            placeholder="Ej: 1000"
                            class="w-full bg-emerald-50 border-2 border-emerald-50 rounded-2xl p-4 text-emerald-900 font-bold placeholder:text-emerald-200 focus:border-emerald-500 transition-all">
                    </div>

                    <!-- Fecha -->
                    <div class="space-y-3">
                        <label class="block text-xs font-black text-emerald-950 uppercase tracking-widest ml-4">Fecha de
                            Inicio</label>
                        <input type="date" name="fecha_siembra" id="input-fecha" required value="{{ date('Y-m-d') }}"
                            class="w-full bg-emerald-50 border-2 border-emerald-50 rounded-2xl p-4 text-emerald-900 font-bold focus:border-emerald-500 transition-all">
                    </div>

                    <!-- Frecuencia de Riego -->
                    <div class="space-y-3">
                        <label class="block text-xs font-black text-emerald-950 uppercase tracking-widest ml-4">Frecuencia de Riego (Días)</label>
                        <input type="number" name="frecuencia_riego_dias" id="input-frecuencia" required min="1" max="30"
                            placeholder="Ej: 3" value="3"
                            class="w-full bg-emerald-50 border-2 border-emerald-50 rounded-2xl p-4 text-emerald-900 font-bold placeholder:text-emerald-200 focus:border-emerald-500 transition-all">
                    </div>

                    <!-- Litros por Riego -->
                    <div class="space-y-3">
                        <label class="block text-xs font-black text-emerald-950 uppercase tracking-widest ml-4">Litros por Riego</label>
                        <input type="number" step="0.5" name="litros_por_riego" id="input-litros" required min="1"
                            placeholder="Ej: 500" value="500"
                            class="w-full bg-emerald-50 border-2 border-emerald-50 rounded-2xl p-4 text-emerald-900 font-bold placeholder:text-emerald-200 focus:border-emerald-500 transition-all">
                    </div>
                </div>

                <!-- Imagen -->
                <div class="space-y-3">
                    <label class="block text-xs font-black text-emerald-950 uppercase tracking-widest ml-4">Fotografía del
                        Cultivo (Opcional)</label>
                    <div class="relative group">
                        <input type="file" name="imagen" accept="image/*" id="input-imagen"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div
                            class="w-full bg-emerald-50 border-2 border-dashed border-emerald-200 rounded-3xl p-8 text-center flex flex-col items-center justify-center gap-4 group-hover:bg-emerald-100/50 group-hover:border-emerald-400 transition-all duration-300">
                            <div
                                class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-sm text-emerald-500 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-emerald-900">Haz clic o arrastra una imagen aquí</p>
                                <p class="text-xs font-medium text-emerald-500 mt-1" id="file-name-display">PNG, JPG hasta
                                    2MB</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Previsualización de Producción y Fecha -->
                <div id="preview-produccion"
                    class="hidden bg-emerald-50 rounded-3xl p-6 border-2 border-emerald-100 grid-cols-1 md:grid-cols-2 gap-4 items-center">
                    <div class="flex items-center gap-4 md:border-r-2 md:border-emerald-100 pr-4">
                        <div
                            class="w-12 h-12 bg-emerald-600 rounded-2xl flex items-center justify-center text-white shrink-0">
                            <!-- Icono para produccion -->
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-emerald-400 uppercase tracking-widest">Est. Producción
                            </p>
                            <h4 id="valor-estimado" class="text-2xl font-black text-emerald-950 leading-none truncate">0 kg
                            </h4>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 md:pl-4">
                        <div
                            class="w-12 h-12 bg-emerald-600 rounded-2xl flex items-center justify-center text-white shrink-0">
                            <!-- Icono para calendario -->
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10m-13 9h16a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-emerald-400 uppercase tracking-widest">Est. Cosecha
                            </p>
                            <h4 id="fecha-estimada-preview"
                                class="text-xl font-black text-emerald-950 leading-none truncate w-full">N/A</h4>
                        </div>
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit"
                        class="w-full bg-emerald-500 text-white rounded-3xl py-6 font-black uppercase tracking-widest hover:bg-emerald-600 transition-all shadow-xl shadow-emerald-100 flex items-center justify-center gap-4">
                        Confirmar Inicio de Siembra
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const selectSemilla = document.getElementById('select-semilla');
                const selectTerreno = document.getElementById('select-terreno');
                const selectRiego = document.getElementById('select-riego');
                const inputCantidad = document.getElementById('input-cantidad');
                const inputFecha = document.getElementById('input-fecha');

                const previewDiv = document.getElementById('preview-produccion');
                const valorEstimado = document.getElementById('valor-estimado');
                const fechaEstimadaPreview = document.getElementById('fecha-estimada-preview');

                function updatePreview() {
                    const optionSemilla = selectSemilla.options[selectSemilla.selectedIndex];
                    const optionTerreno = selectTerreno ? selectTerreno.options[selectTerreno.selectedIndex] : null;
                    const optionRiego = selectRiego ? selectRiego.options[selectRiego.selectedIndex] : null;

                    const yieldValue = optionSemilla && !optionSemilla.disabled ? parseFloat(optionSemilla.getAttribute('data-yield')) : 0;
                    const cantidad = parseFloat(inputCantidad.value) || 0;

                    let showPreview = false;

                    // Update Production
                    if (yieldValue > 0 && cantidad > 0) {
                        const estimado = (yieldValue * cantidad).toLocaleString(undefined, {
                            minimumFractionDigits: 1,
                            maximumFractionDigits: 1
                        });
                        valorEstimado.textContent = `${estimado} kg`;
                        showPreview = true;
                    } else {
                        valorEstimado.textContent = `0 kg`;
                    }

                    // Update Date
                    if (optionSemilla && optionTerreno && optionRiego && inputFecha.value && !optionSemilla.disabled && !optionTerreno.disabled && !optionRiego.disabled) {
                        const baseDias = parseInt(optionSemilla.getAttribute('data-base-dias') || 0);
                        const impactoSuelo = parseInt(optionTerreno.getAttribute('data-impacto') || 0);
                        const impactoRiego = parseInt(optionRiego.getAttribute('data-impacto') || 0);

                        const totalDias = baseDias + impactoSuelo + impactoRiego;

                        const fechaInicio = new Date(inputFecha.value);
                        fechaInicio.setDate(fechaInicio.getDate() + totalDias);

                        const opcionesFecha = { year: 'numeric', month: 'short', day: 'numeric', timeZone: 'UTC' };
                        fechaEstimadaPreview.textContent = fechaInicio.toLocaleDateString('es-ES', opcionesFecha);
                        showPreview = true;
                    } else {
                        fechaEstimadaPreview.textContent = `N/A`;
                    }

                    if (showPreview) {
                        previewDiv.classList.remove('hidden');
                        previewDiv.classList.add('grid');
                    } else {
                        previewDiv.classList.add('hidden');
                        previewDiv.classList.remove('grid');
                    }
                }

                if (selectSemilla) selectSemilla.addEventListener('change', updatePreview);
                if (selectTerreno) selectTerreno.addEventListener('change', updatePreview);
                if (selectRiego) selectRiego.addEventListener('change', updatePreview);
                if (inputCantidad) inputCantidad.addEventListener('input', updatePreview);
                if (inputFecha) inputFecha.addEventListener('change', updatePreview);

                const inputImagen = document.getElementById('input-imagen');
                const fileNameDisplay = document.getElementById('file-name-display');

                if (inputImagen && fileNameDisplay) {
                    inputImagen.addEventListener('change', function (e) {
                        if (e.target.files.length > 0) {
                            fileNameDisplay.textContent = e.target.files[0].name;
                            fileNameDisplay.classList.add('text-emerald-700', 'font-black');
                        } else {
                            fileNameDisplay.textContent = 'PNG, JPG hasta 2MB';
                            fileNameDisplay.classList.remove('text-emerald-700', 'font-black');
                        }
                    });
                }
            });
        </script>
    @endpush

@endsection