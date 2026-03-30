@extends('layouts.admin')

@section('title', 'Gestión de Terrenos')

@section('content')
    <div class="space-y-6">
        {{-- Las alertas de success/error ahora se manejan en el layout principal --}}

        @if ($errors->any())
            <div class="auto-dismiss bg-red-100 dark:bg-red-900/30 border-l-4 border-red-500 text-red-700 dark:text-red-400 p-4 rounded-xl shadow-sm mb-6">
                <div class="flex items-center mb-2">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-bold cursor-default flex-1">Hay errores en el formulario:</span>
                </div>
                <ul class="list-disc ml-10 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <!-- Add/Edit Form Column -->
            <div class="xl:col-span-1">
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-emerald-50 dark:border-emerald-900/20 p-6 sticky top-6 transition-all duration-300">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="bg-emerald-600 p-3 rounded-2xl text-white shadow-lg shadow-emerald-100 dark:shadow-none transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 id="formTitle" class="text-lg font-bold text-emerald-900 dark:text-emerald-50">Registrar Terreno</h3>
                            <p class="text-[10px] font-medium text-emerald-500 dark:text-emerald-400 uppercase tracking-widest mt-1">Gestor
                                Espacial</p>
                        </div>
                    </div>

                    <form id="terrenoForm" action="{{ route('admin.terrenos.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div id="methodField"></div>

                        <div>
                            <label class="block text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-wider mb-2">Nombre del
                                Terreno</label>
                            <input type="text" name="nombre" id="nombre" required placeholder="Ej. Lote 1, Parcela Norte"
                                class="w-full px-4 py-3 rounded-2xl border-emerald-100 dark:border-emerald-900/20 focus:border-emerald-500 focus:ring-emerald-500 bg-emerald-50/30 dark:bg-slate-900 text-sm dark:text-emerald-50 transition-all"
                                value="{{ old('nombre') }}">
                        </div>


                        <!-- Unified Map & Weather Integration -->
                        <div class="space-y-4">
                            <label class="block text-xs font-bold text-emerald-700 uppercase tracking-wider mb-2">
                                Ubicación en el Mapa
                            </label>
                            
                             <div class="relative group">
                                <div id="map" class="w-full h-72 rounded-3xl border-2 border-emerald-100 dark:border-emerald-900 shadow-inner overflow-hidden z-0 transition-colors">
                                </div>
                                
                                <!-- Weather Overlay -->
                                <div id="map-weather" class="absolute top-3 right-3 z-[1000] bg-white/95 dark:bg-slate-800/95 backdrop-blur-md rounded-2xl p-3 shadow-xl border border-emerald-100 dark:border-emerald-900/50 min-w-[120px] transition-all duration-500 pointer-events-none opacity-0 translate-y-2 translate-x-1">
                                    <div class="flex items-center gap-3">
                                        <div id="map-weather-icon" class="w-8 h-8 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <span id="map-weather-temp" class="text-base font-black text-emerald-950 dark:text-emerald-50 block leading-none">--°C</span>
                                            <p id="map-weather-desc" class="text-[9px] font-bold text-emerald-500 dark:text-emerald-400 uppercase tracking-widest mt-1">Sincronizando...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-black text-emerald-500 dark:text-emerald-400 uppercase tracking-widest mb-1 ml-2">Latitud</label>
                                    <input type="number" step="any" name="latitud" id="latitud" required
                                        class="w-full px-4 py-3 rounded-2xl bg-emerald-50/30 dark:bg-slate-900 border-emerald-100 dark:border-emerald-900/20 focus:border-emerald-500 focus:ring-emerald-500 text-sm font-mono text-emerald-900 dark:text-emerald-50 transition-all"
                                        placeholder="0.000000">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-emerald-500 dark:text-emerald-400 uppercase tracking-widest mb-1 ml-2">Longitud</label>
                                    <input type="number" step="any" name="longitud" id="longitud" required
                                        class="w-full px-4 py-3 rounded-2xl bg-emerald-50/30 dark:bg-slate-900 border-emerald-100 dark:border-emerald-900/20 focus:border-emerald-500 focus:ring-emerald-500 text-sm font-mono text-emerald-900 dark:text-emerald-50 transition-all"
                                        placeholder="0.000000">
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-wider mb-2">Ubicación Específica</label>
                            <input type="text" name="ubicacion" id="ubicacion" placeholder="Ej. Vereda La Cima, Finca San José..."
                                class="w-full px-4 py-3 rounded-2xl border-emerald-100 dark:border-emerald-900/20 focus:border-emerald-500 focus:ring-emerald-500 bg-emerald-50/30 dark:bg-slate-900 text-sm dark:text-emerald-50 transition-all font-medium"
                                value="{{ old('ubicacion') }}">
                        </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-wider mb-2">Departamento</label>
                                        <input type="text" name="departamento" id="departamento" placeholder="Ej. Tolima"
                                            class="w-full px-4 py-3 rounded-2xl border-emerald-100 dark:border-emerald-900/20 focus:border-emerald-500 focus:ring-emerald-500 bg-emerald-50/30 dark:bg-slate-900 text-sm dark:text-emerald-50 transition-all font-medium"
                                            value="{{ old('departamento') }}">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-wider mb-2">Ciudad
                                            / Municipio</label>
                                        <input type="text" name="ciudad" id="ciudad" placeholder="Ej. Ibagué"
                                            class="w-full px-4 py-3 rounded-2xl border-emerald-100 dark:border-emerald-900/20 focus:border-emerald-500 focus:ring-emerald-500 bg-emerald-50/30 dark:bg-slate-900 text-sm dark:text-emerald-50 transition-all font-medium"
                                            value="{{ old('ciudad') }}">
                                    </div>
                                </div>

                                <div>
                                    <label
                                        class="block text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-wider mb-2">Código
                                        Postal</label>
                                    <input type="text" name="codigo_postal" id="codigo_postal" placeholder="Ej. 730001"
                                        class="w-full px-4 py-3 rounded-2xl border-emerald-100 dark:border-emerald-900/20 focus:border-emerald-500 focus:ring-emerald-500 bg-emerald-50/30 dark:bg-slate-900 text-sm dark:text-emerald-50 transition-all font-medium"
                                        value="{{ old('codigo_postal') }}">
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-wider mb-2">Ancho
                                            (m)</label>
                                        <input type="number" step="0.01" name="Ancho" id="Ancho" required min="1"
                                            class="w-full px-4 py-3 rounded-2xl border-emerald-100 dark:border-emerald-900/20 focus:border-emerald-500 focus:ring-emerald-500 bg-emerald-50/30 dark:bg-slate-900 text-sm dark:text-emerald-50 transition-all font-medium"
                                            value="{{ old('Ancho') }}">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-wider mb-2">Largo
                                            (m)</label>
                                        <input type="number" step="0.01" name="Largo" id="Largo" required min="1"
                                            class="w-full px-4 py-3 rounded-2xl border-emerald-100 dark:border-emerald-900/20 focus:border-emerald-500 focus:ring-emerald-500 bg-emerald-50/30 dark:bg-slate-900 text-sm dark:text-emerald-50 transition-all font-medium"
                                            value="{{ old('Largo') }}">
                                    </div>
                                </div>

                                <div>
                                    <label
                                        class="block text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-wider mb-2">Tipo
                                        de
                                        Suelo</label>
                                    <select name="id_tipo_suelo" id="id_tipo_suelo" required
                                        class="w-full px-4 py-3 rounded-2xl border-emerald-100 dark:border-emerald-900/20 focus:border-emerald-500 focus:ring-emerald-500 bg-emerald-50/30 dark:bg-slate-900 text-sm dark:text-emerald-50 transition-all font-medium">
                                        <option value="">Seleccione un suelo...</option>
                                        @foreach($tipoSuelos as $suelo)
                                            <option value="{{ $suelo->id_tipo_suelo }}" {{ old('id_tipo_suelo') == $suelo->id_tipo_suelo ? 'selected' : '' }}>
                                                {{ $suelo->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div id="estadoContainer" class="hidden animate-in fade-in duration-300">
                                    <label
                                        class="block text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-wider mb-2">Estado
                                        del
                                        Terreno</label>
                                    <select name="id_estado" id="id_estado"
                                        class="w-full px-4 py-3 rounded-2xl border-emerald-100 dark:border-emerald-900/20 focus:border-emerald-500 focus:ring-emerald-500 bg-emerald-50/30 dark:bg-slate-900 text-sm dark:text-emerald-50 transition-all font-medium">
                                        @foreach($estados as $estado)
                                            <option value="{{ $estado->id_estado }}">
                                                {{ $estado->nombre_estado }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>



                                <div class="flex gap-3 pt-2">
                                    <button type="button" onclick="resetForm()" id="btnCancel"
                                        class="hidden px-6 py-4 bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold rounded-2xl transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                    <button type="submit" id="btnSubmit"
                                        class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-emerald-200 transition-all transform hover:-translate-y-1">
                                        Guardar Terreno
                                    </button>
                                </div>
                    </form>
                </div>
            </div>

            <!-- Inventory List Column -->
            <div class="xl:col-span-2">
                <div
                    class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-emerald-50 dark:border-emerald-900/20 overflow-hidden min-h-[600px] flex flex-col transition-all duration-300">
                    <div
                        class="p-6 border-b border-emerald-50 dark:border-emerald-900/10 bg-gray-50/50 dark:bg-slate-900/50 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div>
                            <h3 class="text-xl font-black text-emerald-950 dark:text-emerald-50">Parcelas Registradas</h3>
                            <p class="text-xs font-medium text-emerald-600 dark:text-emerald-400 mt-1">Mapa general de su finca</p>
                        </div>

                        <div class="flex flex-wrap items-center gap-3">
                            <form action="{{ route('admin.terrenos.index') }}" method="GET"
                                class="flex items-center gap-2 bg-white dark:bg-slate-900 p-1 rounded-2xl border border-emerald-100 dark:border-emerald-900/30 shadow-sm shadow-emerald-100/50 dark:shadow-none">
                                <select name="ciudad"
                                    class="bg-transparent border-0 text-[10px] font-bold text-emerald-700 dark:text-emerald-400 focus:ring-0 cursor-pointer pl-4">
                                    <option value="">Municipio...</option>
                                    @foreach($municipios as $muni)
                                        <option value="{{ $muni }}" {{ request('ciudad') == $muni ? 'selected' : '' }}>{{ $muni }}
                                        </option>
                                    @endforeach
                                </select>
                                <select name="month"
                                    class="bg-transparent border-0 text-[10px] font-bold text-emerald-700 dark:text-emerald-400 focus:ring-0 cursor-pointer">
                                    <option value="">Mes...</option>
                                    @php
                                        $meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                                    @endphp
                                    @foreach($meses as $index => $mes)
                                        <option value="{{ $index + 1 }}" {{ request('month') == ($index + 1) ? 'selected' : '' }}>
                                            {{ $mes }}</option>
                                    @endforeach
                                </select>
                                <select name="year"
                                    class="bg-transparent border-0 text-[10px] font-bold text-emerald-700 dark:text-emerald-400 focus:ring-0 cursor-pointer">
                                    <option value="">Año...</option>
                                    @for($y = date('Y'); $y >= 2024; $y--)
                                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                                <button type="submit"
                                    class="p-1.5 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-xl hover:bg-emerald-100 dark:hover:bg-emerald-800 transition-colors mr-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </button>
                            </form>

                            <a href="{{ route('admin.terrenos.export', request()->all()) }}"
                                class="flex items-center gap-2 px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-[1.5rem] text-[10px] font-black uppercase tracking-widest shadow-lg shadow-emerald-100 dark:shadow-none transition-all transform hover:-translate-y-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Exportar CSV
                            </a>

                            <div class="bg-white dark:bg-slate-900 border-2 border-emerald-100 dark:border-emerald-900/20 px-6 py-2 rounded-2xl flex items-center gap-3 shadow-sm transition-colors">
                                <span
                                    class="text-2xl font-black text-emerald-600 dark:text-emerald-400">{{ collect($terrenos->items())->count() }}</span>
                                <span
                                    class="text-[10px] font-bold text-emerald-400 dark:text-emerald-600 uppercase tracking-widest leading-none">Terrenos<br>Totales</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex-1 overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr
                                    class="bg-white dark:bg-slate-900/50 text-[10px] font-black text-emerald-400 uppercase tracking-[0.2em] border-b border-emerald-50 dark:border-emerald-900/10">
                                    <th class="px-6 py-4">Terreno</th>
                                    <th class="px-6 py-4">Coordenadas</th>
                                    <th class="px-6 py-4">Dimensiones</th>
                                    <th class="px-6 py-4">Estado</th>
                                    <th class="px-6 py-4 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-emerald-50/50">
                                @forelse($terrenos as $terreno)
                                    <tr class="hover:bg-emerald-50/30 transition-all group cursor-pointer"
                                        onclick="viewOnMap(this)" data-terreno="{{ json_encode($terreno) }}">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-4">
                                                <div
                                                    class="w-10 h-10 bg-emerald-600 rounded-xl flex items-center justify-center text-white font-black text-base shadow-lg shadow-emerald-100 dark:shadow-none transform group-hover:rotate-12 transition-transform">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <span
                                                        class="font-black text-emerald-950 dark:text-emerald-50 block text-sm">{{ $terrenos_item->nombre ?? $terreno->nombre }}</span>
                                                    <span
                                                        class="text-[9px] font-bold text-emerald-400 dark:text-emerald-500 uppercase tracking-wider flex items-center gap-1 mt-1 font-mono">
                                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        </svg>
                                                        {{ $terreno->ubicacion ?? 'Ubicación no especificada' }}
                                                        @if($terreno->departamento || $terreno->ciudad || $terreno->codigo_postal)
                                                            |
                                                            {{ trim($terreno->departamento . ($terreno->ciudad ? ', ' . $terreno->ciudad : '') . ' ' . $terreno->codigo_postal) }}
                                                        @endif
                                                    </span>
                                                    <span
                                                        class="text-[9px] font-bold text-emerald-600 uppercase tracking-wider opacity-70 mt-0.5 block">Suelo:
                                                        {{ optional($terreno->tipoSuelo)->nombre ?? 'No asignado' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-col gap-1">
                                                <span
                                                    class="text-[10px] font-mono font-bold text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/30 px-2 py-0.5 rounded-md border border-emerald-100 dark:border-emerald-800 flex items-center gap-1.5">
                                                    <span class="text-[8px] text-emerald-400 dark:text-emerald-600 w-5">LAT:</span>
                                                    {{ number_format($terreno->latitud, 6) }}
                                                </span>
                                                <span
                                                    class="text-[10px] font-mono font-bold text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/30 px-2 py-0.5 rounded-md border border-emerald-100 dark:border-emerald-800 flex items-center gap-1.5">
                                                    <span class="text-[8px] text-emerald-400 dark:text-emerald-600 w-5">LNG:</span>
                                                    {{ number_format($terreno->longitud, 6) }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="space-y-1">
                                                <div class="flex flex-col gap-1">
                                                    <span
                                                        class="text-[10px] font-black text-emerald-900 dark:text-emerald-50 border border-emerald-100 dark:border-emerald-900/40 bg-white dark:bg-slate-900 px-2 py-1 rounded-lg shadow-sm inline-flex items-center gap-1.5">
                                                        <svg class="w-3 h-3 text-emerald-500" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                                        </svg>
                                                        {{ $terreno->Ancho }}m &times; {{ $terreno->Largo }}m
                                                    </span>
                                                    <span
                                                        class="text-[9px] font-bold text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/30 px-2 py-1 rounded-lg mt-0.5 inline-block border border-emerald-100 dark:border-emerald-800">
                                                        &approx; {{ number_format($terreno->area_m2 ?? ($terreno->Ancho * $terreno->Largo), 2) }}
                                                        m&sup2;
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if(optional($terreno->estado)->id_estado == 7)
                                                <div
                                                    class="bg-emerald-50 dark:bg-emerald-900/30 rounded-xl px-2 py-1 border border-emerald-200 dark:border-emerald-800/40 inline-flex items-center gap-1.5 shadow-sm">
                                                    <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div>
                                                    <span
                                                        class="text-xs font-black text-emerald-700 dark:text-emerald-400">{{ optional($terreno->estado)->nombre_estado ?? 'Disponible' }}</span>
                                                </div>
                                            @else
                                                <div
                                                    class="bg-amber-50 dark:bg-amber-900/30 rounded-xl px-2 py-1 border border-amber-200 dark:border-amber-800/40 inline-flex items-center gap-1.5 shadow-sm">
                                                    <div class="w-1.5 h-1.5 rounded-full bg-amber-500"></div>
                                                    <span
                                                        class="text-xs font-black text-amber-700 dark:text-amber-400">{{ optional($terreno->estado)->nombre_estado ?? 'Ocupado' }}</span>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div
                                                class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all">
                                                <button data-terreno="{{ json_encode($terreno) }}"
                                                    onclick="event.stopPropagation(); openEdit(this)"
                                                    class="p-2.5 bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-100 transition-colors shadow-sm">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </button>
                                                <form action="{{ route('admin.terrenos.destroy', $terreno->id_terreno) }}"
                                                    method="POST" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        onclick="event.stopPropagation(); return confirm('¿Eliminar este terreno de manera permanente?')"
                                                        class="p-2.5 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 transition-colors shadow-sm">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7M10 11v6M14 11v6M4 7h16M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-8 py-32 text-center">
                                            <div class="flex flex-col items-center justify-center opacity-50">
                                                <svg class="w-16 h-16 text-emerald-300 mb-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                </svg>
                                                <p class="text-emerald-600 font-bold text-lg">Su mapa está vacío.</p>
                                                <p class="text-sm text-emerald-500 mt-1">Comience registrando un terreno en el
                                                    formulario lateral.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="p-6 bg-gray-50/50 dark:bg-slate-900/50 border-t border-emerald-50 dark:border-emerald-900/10">
                        {{ $terrenos->links() }}
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
                <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
                    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
                <script>
                    // Inyectar CSS de Leaflet dinámicamente si no existe
                    if (!document.getElementById('leaflet-css')) {
                        const link = document.createElement('link');
                        link.id = 'leaflet-css';
                        link.rel = 'stylesheet';
                        link.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
                        link.integrity = 'sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=';
                        link.crossOrigin = '';
                        document.head.appendChild(link);
                    }

                    const terrenoForm = document.getElementById('terrenoForm');
                    const formTitle = document.getElementById('formTitle');
                    const methodField = document.getElementById('methodField');
                    const btnCancel = document.getElementById('btnCancel');
                    const btnSubmit = document.getElementById('btnSubmit');

                    function updateMarker(latlng) {
                        if (!marker) return;
                        marker.setLatLng(latlng);
                        document.getElementById('latitud').value = latlng.lat.toFixed(8);
                        document.getElementById('longitud').value = latlng.lng.toFixed(8);

                        // Auto-fill address from API
                        reverseGeocode(latlng.lat, latlng.lng);

                        // Fetch weather for this position
                        fetchMapWeather(latlng.lat, latlng.lng);
                    }

                    function onMapClick(e) {
                        updateMarker(e.latlng);
                    }

                    function fetchMapWeather(lat, lon) {
                        const weatherUrl = `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current=temperature_2m,weather_code&timezone=auto`;
                        const overlay = document.getElementById('map-weather');

                        fetch(weatherUrl)
                            .then(res => res.json())
                            .then(data => {
                                const current = data.current;
                                const temp = Math.round(current.temperature_2m);
                                const code = current.weather_code;

                                const weatherMap = {
                                    0: { text: 'Despejado', icon: 'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z', color: 'text-yellow-500' },
                                    2: { text: 'Parcial', icon: 'M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z', color: 'text-gray-400' },
                                    3: { text: 'Nublado', icon: 'M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z', color: 'text-gray-500' },
                                    61: { text: 'Lluvia', icon: 'M20 16.242c-.22.217-.457.417-.71.598A7.923 7.923 0 0112 19a7.923 7.923 0 01-7.29-2.16m15.29-2.082A8.001 8.001 0 004.5 9h.5A7 7 0 1119.5 9h.5a8.001 8.001 0 00-7.29 5.242', color: 'text-blue-500' },
                                    95: { text: 'Tormenta', icon: 'M13 10V3L4 14h7v7l9-11h-7z', color: 'text-yellow-700' }
                                };

                                const condition = weatherMap[code] || { text: 'Variable', icon: 'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z', color: 'text-yellow-500' };

                                document.getElementById('map-weather-temp').textContent = `${temp}°C`;
                                document.getElementById('map-weather-desc').textContent = condition.text;
                                document.getElementById('map-weather-icon').innerHTML = `<svg class="w-5 h-5 ${condition.color}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${condition.icon}"></path></svg>`;

                                overlay.classList.remove('opacity-0', 'translate-y-2');
                                overlay.classList.add('opacity-100', 'translate-y-0');
                            })
                            .catch(err => console.error("Error fetching map weather:", err));
                    }

                    let map;
                    let marker; // Marcador principal para el formulario
                    let otherMarkers = []; // Almacén para los marcadores de otros terrenos
                    const defaultLocation = [4.570868, -74.297333]; // Colombia default [lat, lng]

                    // Datos de terrenos inyectados desde Blade
                    const listaTerrenos = @json($terrenos->items());

                    // Fix Leaflet Default Icon issue
                    function fixLeafletIcons() {
                        try {
                            if (typeof L !== 'undefined' && L.Icon && L.Icon.Default) {
                                delete L.Icon.Default.prototype._getIconUrl;
                                L.Icon.Default.mergeOptions({
                                    iconRetinaUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon-2x.png',
                                    iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon.png',
                                    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
                                });
                            }
                        } catch (e) {
                            console.error("Error fixing icons:", e);
                        }
                    }

                    function initMap() {
                        try {
                            // Verificar si Leaflet está cargado
                            if (typeof L === 'undefined') {
                                setTimeout(initMap, 500);
                                return;
                            }

                            fixLeafletIcons();

                            // Configurar límites para el departamento del Tolima, Colombia
                            const tolimaBounds = L.latLngBounds(
                                [2.8, -76.3], // Suroeste
                                [5.3, -74.4]  // Noreste
                            );

                            // Inicializar Mapa
                            map = L.map('map', {
                                maxBounds: tolimaBounds,
                                maxBoundsViscosity: 1.0,
                                minZoom: 8
                            }).setView(defaultLocation, 13);

                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '&copy; OpenStreetMap contributors'
                            }).addTo(map);

                            // Inicializar Marcador Arrastrable
                            marker = L.marker(defaultLocation, {
                                draggable: true
                            }).addTo(map);

                            // Fetch initial location and weather data
                            reverseGeocode(defaultLocation[0], defaultLocation[1]);
                            fetchMapWeather(defaultLocation[0], defaultLocation[1]);

                            // Evento clic en el mapa
                            map.on('click', onMapClick);

                            // Evento fin de arrastre del marcador
                            marker.on('dragend', function (e) {
                                updateMarker(marker.getLatLng());
                            });

                            // Cargar todos los terrenos existentes
                            renderAllTerrenos();

                        } catch (error) {
                            console.error("Error al inicializar el mapa:", error);
                            const container = document.getElementById('map');
                            if (container) {
                                container.innerHTML = `<div class="flex items-center justify-center h-full bg-gray-50 text-gray-400 text-xs text-center p-4 italic">Error al cargar el mapa interactivo.</div>`;
                            }
                        }
                    }

                    function reverseGeocode(lat, lng) {
                        fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
                            .then(res => res.json())
                            .then(data => {
                                if (data && data.address) {
                                    const depto = data.address.state || data.address.county || data.address.region || '';
                                    const city = data.address.city || data.address.town || data.address.village || data.address.municipality || '';
                                    const postal = data.address.postcode || '';

                                    if (document.getElementById('departamento')) document.getElementById('departamento').value = depto;
                                    if (document.getElementById('ciudad')) document.getElementById('ciudad').value = city;
                                    if (document.getElementById('codigo_postal')) document.getElementById('codigo_postal').value = postal;
                                }
                            })
                            .catch(err => console.error("Error geocodificando la ubicación:", err));
                    }


                    function renderAllTerrenos() {
                        // Limpiar marcadores previos si existen (excepto el del formulario)
                        otherMarkers.forEach(m => map.removeLayer(m));
                        otherMarkers = [];

                        if (!listaTerrenos || listaTerrenos.length === 0) return;

                        const bounds = L.latLngBounds([]);
                        let hasValidCoords = false;

                        listaTerrenos.forEach(t => {
                            const lat = t.latitud || t.Latitud;
                            const lng = t.longitud || t.Longitud;

                            if (lat && lng && !isNaN(parseFloat(lat)) && !isNaN(parseFloat(lng))) {
                                const pos = [parseFloat(lat), parseFloat(lng)];

                                // Marcador visual (no arrastrable) para referencia
                                const m = L.marker(pos, {
                                    opacity: 0.7,
                                    zIndexOffset: -100 // Por debajo del marcador principal
                                }).addTo(map);

                                // Popup con información y acción
                                const popupContent = `
                                        <div class="p-2">
                                            <h4 class="font-bold text-emerald-800 text-sm mb-1">${t.nombre}</h4>
                                            <p class="text-[10px] text-gray-500 mb-2">${t.Ancho}m x ${t.Largo}m</p>
                                            <button onclick='window.editFromMap(${JSON.stringify(t)})' 
                                               class="w-full bg-emerald-600 text-white text-[10px] py-1 px-2 rounded-lg hover:bg-emerald-700 transition-colors">
                                               Editar Terreno
                                            </button>
                                        </div>
                                    `;
                                m.bindPopup(popupContent);

                                otherMarkers.push(m);
                                bounds.extend(pos);
                                hasValidCoords = true;
                            }
                        });

                        // Ajustar vista si hay marcadores
                        if (hasValidCoords && map) {
                            map.fitBounds(bounds, { padding: [50, 50], maxZoom: 15 });
                        }
                    }

                    // Exponer función de edición para los popups del mapa
                    window.editFromMap = function (terreno) {
                        editTerreno(terreno);
                    };

                    function viewOnMap(row) {
                        try {
                            const terreno = JSON.parse(row.getAttribute('data-terreno'));
                            // Llenar el formulario en modo "Solo Lectura" (Visualización)
                            fillForm(terreno, 'view');
                        } catch (e) {
                            console.error("Error al visualizar el terreno:", e);
                        }
                    }

                    // Sincronizar inputs manuales con el mapa
                    document.getElementById('latitud').addEventListener('input', syncMapFromInputs);
                    document.getElementById('longitud').addEventListener('input', syncMapFromInputs);

                    function syncMapFromInputs() {
                        const latVal = document.getElementById('latitud').value;
                        const lngVal = document.getElementById('longitud').value;
                        const lat = parseFloat(latVal);
                        const lng = parseFloat(lngVal);

                        if (!isNaN(lat) && !isNaN(lng) && lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180) {
                            const pos = [lat, lng];
                            if (marker) marker.setLatLng(pos);
                            if (map) map.setView(pos, map.getZoom());
                        }
                    }

                    function openEdit(btn) {
                        try {
                            const terreno = JSON.parse(btn.getAttribute('data-terreno'));
                            // Llenar el formulario en modo "Edición" completa
                            fillForm(terreno, 'edit');
                        } catch (e) {
                            console.error("Error parsing terreno:", e);
                        }
                    }

                    function toggleReadOnly(isReadOnly) {
                        const inputs = [
                            'nombre', 'ubicacion', 'Ancho', 'Largo', 'id_tipo_suelo', 'id_estado', 'latitud', 'longitud', 'departamento', 'ciudad', 'codigo_postal'
                        ];

                        inputs.forEach(id => {
                            const el = document.getElementById(id);
                            if (!el) return;

                            // Handle select elements specifically
                            if (el.tagName === 'SELECT') {
                                el.disabled = isReadOnly;
                                // Add hidden input so value still submits if it were ever needed, 
                                // but since view mode hides submit button, just UI disabled is fine.
                            } else {
                                el.readOnly = isReadOnly;
                            }

                            if (isReadOnly) {
                                el.classList.add('bg-gray-100', 'cursor-not-allowed', 'opacity-80', 'border-gray-200');
                                el.classList.remove('bg-emerald-50/30', 'border-emerald-100');
                            } else {
                                el.classList.remove('bg-gray-100', 'cursor-not-allowed', 'opacity-80', 'border-gray-200');
                                el.classList.add('bg-emerald-50/30', 'border-emerald-100');
                            }
                        });

                        // Toggle map interactions
                        if (marker) {
                            if (isReadOnly) marker.dragging.disable();
                            else marker.dragging.enable();
                        }
                        if (map) {
                            if (isReadOnly) map.off('click', onMapClick);
                            else map.on('click', onMapClick);
                        }
                    }

                    function fillForm(terreno, mode) {
                        if (!terreno) return;

                        document.getElementById('nombre').value = terreno.nombre || '';
                        if (document.getElementById('ubicacion')) document.getElementById('ubicacion').value = terreno.ubicacion || '';
                        document.getElementById('Ancho').value = terreno.Ancho || '';
                        document.getElementById('Largo').value = terreno.Largo || terreno.Alto || '';

                        if (document.getElementById('departamento')) document.getElementById('departamento').value = terreno.departamento || '';
                        if (document.getElementById('ciudad')) document.getElementById('ciudad').value = terreno.ciudad || '';
                        if (document.getElementById('codigo_postal')) document.getElementById('codigo_postal').value = terreno.codigo_postal || '';

                        // Manejar latidud y longitud con checks de nulidad explícitos
                        // Buscamos latitud/longitud en varios formatos posibles de propiedad (case insensitive / snake_case)
                        const lat = (terreno.latitud !== null && terreno.latitud !== undefined) ? terreno.latitud :
                            (terreno.Latitud !== null && terreno.Latitud !== undefined) ? terreno.Latitud : '';
                        const lng = (terreno.longitud !== null && terreno.longitud !== undefined) ? terreno.longitud :
                            (terreno.Longitud !== null && terreno.Longitud !== undefined) ? terreno.Longitud : '';

                        document.getElementById('latitud').value = lat !== '' ? parseFloat(lat).toFixed(8) : '';
                        document.getElementById('longitud').value = lng !== '' ? parseFloat(lng).toFixed(8) : '';

                        // Disparar evento input para sincronizar el mapa si es necesario (vía syncMapFromInputs)
                        document.getElementById('latitud').dispatchEvent(new Event('input'));
                        document.getElementById('longitud').dispatchEvent(new Event('input'));

                        // Preservar y mostrar descripción de ubicación si existe
                        const ubicacionInput = document.getElementById('ubicacion');
                        const ubicacionPreview = document.getElementById('ubicacionPreview');
                        const ubicacionText = document.getElementById('ubicacionText');

                        if (ubicacionInput) {
                            const val = terreno.ubicacion || '';
                            ubicacionInput.value = val;
                            if (ubicacionPreview && ubicacionText) {
                                if (val) {
                                    ubicacionText.innerText = val;
                                    ubicacionPreview.classList.remove('hidden');
                                } else {
                                    ubicacionPreview.classList.add('hidden');
                                }
                            }
                        }

                        if (map && marker) {
                            const parsedLat = parseFloat(lat);
                            const parsedLng = parseFloat(lng);

                            if (!isNaN(parsedLat) && !isNaN(parsedLng)) {
                                const pos = [parsedLat, parsedLng];
                                marker.setLatLng(pos);
                                map.flyTo(pos, 16, { animate: true, duration: 1.5 });
                                fetchMapWeather(parsedLat, parsedLng);
                            } else {
                                console.warn("Terreno sin coordenadas válidas, usando ubicación por defecto", { lat, lng });
                                marker.setLatLng(defaultLocation);
                                map.setView(defaultLocation, 13);
                            }

                            // Forzar redibujado progresivo para asegurar que el mapa se vea bien
                            [100, 300, 800].forEach(time => {
                                setTimeout(() => {
                                    if (map) map.invalidateSize();
                                }, time);
                            });
                        }

                        if (document.getElementById('id_tipo_suelo')) {
                            document.getElementById('id_tipo_suelo').value = terreno.id_tipo_suelo || '';
                        }

                        if (document.getElementById('id_estado')) {
                            document.getElementById('id_estado').value = terreno.id_estado || '';
                        }

                        const estadoContainer = document.getElementById('estadoContainer');
                        if (estadoContainer) estadoContainer.classList.remove('hidden');

                        const baseUrl = "{{ route('admin.terrenos.store') }}";

                        if (mode === 'edit') {
                            terrenoForm.action = `${baseUrl}/${terreno.id_terreno}`;
                            methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
                            formTitle.innerText = 'Editar Terreno';
                            btnSubmit.innerText = 'Actualizar Datos';
                            btnSubmit.classList.remove('bg-emerald-600', 'hidden');
                            btnSubmit.classList.add('bg-amber-600');
                            toggleReadOnly(false); // Enable ALL fields, including location
                        } else if (mode === 'view') {
                            terrenoForm.action = '#';
                            methodField.innerHTML = '';
                            formTitle.innerText = 'Detalle del Terreno';
                            btnSubmit.classList.add('hidden'); // Hide submit button for viewing
                            toggleReadOnly(true); // Disable ALL fields
                        }

                        btnCancel.classList.remove('hidden');
                        terrenoForm.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }

                    function resetForm() {
                        terrenoForm.reset();

                        // Limpiar previsualización de ubicación
                        const ubicacionPreview = document.getElementById('ubicacionPreview');
                        if (ubicacionPreview) ubicacionPreview.classList.add('hidden');
                        if (document.getElementById('ubicacion')) document.getElementById('ubicacion').value = '';
                        if (document.getElementById('departamento')) document.getElementById('departamento').value = '';
                        if (document.getElementById('ciudad')) document.getElementById('ciudad').value = '';
                        if (document.getElementById('codigo_postal')) document.getElementById('codigo_postal').value = '';

                        if (map && marker) {
                            marker.setLatLng(defaultLocation);
                            map.setView(defaultLocation, 13);

                            // Forzar redibujado progresivo
                            [100, 300, 800].forEach(time => {
                                setTimeout(() => {
                                    if (map) map.invalidateSize();
                                }, time);
                            });
                        }

                        const estadoContainer = document.getElementById('estadoContainer');
                        if (estadoContainer) estadoContainer.classList.add('hidden');

                        toggleReadOnly(false); // Restore all fields to writable state

                        terrenoForm.action = '{{ route("admin.terrenos.store") }}';
                        methodField.innerHTML = '';
                        formTitle.innerText = 'Registrar Terreno';
                        btnSubmit.innerText = 'Guardar Terreno';
                        btnSubmit.classList.remove('bg-amber-600', 'hidden');
                        btnSubmit.classList.add('bg-emerald-600');
                        btnCancel.classList.add('hidden');
                    }

                    // Inicializar cuando el DOM esté listo
                    document.addEventListener('DOMContentLoaded', initMap);
                </script>
        @endpush
@endsection