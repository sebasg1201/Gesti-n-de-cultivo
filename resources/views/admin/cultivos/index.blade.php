@extends('layouts.admin')

@section('content')
    <div class="min-h-[calc(100vh-4rem)] bg-emerald-50/30 p-4 md:p-8">
        <div class="max-w-7xl mx-auto space-y-8">

            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-black text-emerald-950 flex items-center gap-3">
                        @if(isset($semillaSeleccionada))
                            <a href="{{ route('admin.cultivos.index') }}" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-emerald-600 shadow-sm border border-emerald-100 hover:bg-emerald-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </a>
                            Producción: {{ $semillaSeleccionada->nombre_semilla }}
                        @else
                            Control de Producción
                        @endif
                        <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs rounded-full uppercase tracking-widest font-bold">Cultivo</span>
                    </h1>
                        <p class="text-emerald-600 font-medium mt-1">
                        @if(isset($semillaSeleccionada))
                            Listado de lotes para esta variedad.
                        @else
                            Selecciona una variedad para gestionar sus recolecciones e histórico.
                        @endif
                    </p>
                </div>
                
                <div class="flex flex-wrap items-center gap-3">
                    <form action="{{ route('admin.cultivos.index') }}" method="GET" class="flex items-center gap-2 bg-white p-1 rounded-2xl border border-emerald-100 shadow-sm shadow-emerald-100/50">
                        @if(request('id_semilla'))
                            <input type="hidden" name="id_semilla" value="{{ request('id_semilla') }}">
                        @endif
                        <select name="month" class="bg-transparent border-0 text-[10px] font-bold text-emerald-700 focus:ring-0 cursor-pointer">
                            <option value="">Mes...</option>
                            @php
                                $meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                            @endphp
                            @foreach($meses as $index => $mes)
                                <option value="{{ $index + 1 }}" {{ request('month') == ($index + 1) ? 'selected' : '' }}>{{ $mes }}</option>
                            @endforeach
                        </select>
                        <select name="year" class="bg-transparent border-0 text-[10px] font-bold text-emerald-700 focus:ring-0 cursor-pointer">
                            <option value="">Año...</option>
                            @for($y = date('Y'); $y >= 2024; $y--)
                                <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                        <button type="submit" class="p-1.5 bg-emerald-50 text-emerald-600 rounded-xl hover:bg-emerald-100 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </button>
                    </form>
                    
                    <a href="{{ route('admin.cultivos.export', request()->all()) }}" class="flex items-center gap-2 px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-[1.5rem] text-[10px] font-black uppercase tracking-widest shadow-lg shadow-emerald-100 transition-all transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        Exportar CSV
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-lg shadow-sm animate-fade-in-down" role="alert">
                    <p class="font-bold">¡Éxito!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if(!isset($semillaSeleccionada))
                <!-- VISTA A: CATEGORÍAS (VARIEDADES) - TARJETAS CON IMAGEN -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($categorias as $cat)
                        <div class="group bg-white rounded-[2.5rem] overflow-hidden shadow-sm border border-emerald-50 hover:shadow-xl hover:shadow-emerald-100/50 transition-all duration-500 hover:-translate-y-1 cursor-pointer flex flex-col" 
                             onclick="window.location.href='{{ route('admin.cultivos.index', ['id_semilla' => $cat->id_semilla]) }}'">
                            
                            <!-- Imagen de la Categoría -->
                            <div class="relative h-56 overflow-hidden">
                                @if($cat->imagen_portada)
                                    <img src="{{ asset('uploads/' . $cat->imagen_portada) }}" alt="{{ $cat->nombre_semilla }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                @else
                                    <div class="w-full h-full bg-emerald-50 flex items-center justify-center text-emerald-200">
                                        <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-emerald-950/90 via-emerald-950/20 to-transparent"></div>
                                <div class="absolute bottom-6 left-6 right-6">
                                    <span class="px-3 py-1 bg-emerald-500 text-white text-[10px] font-black rounded-full uppercase tracking-widest mb-3 inline-block">
                                        {{ $cat->cosechas_count }} Lotes en Historial
                                    </span>
                                    <h3 class="text-3xl font-black text-white truncate">{{ $cat->nombre_semilla }}</h3>
                                </div>
                            </div>

                            <div class="p-8 flex-grow">
                                <p class="text-sm font-bold text-slate-400 mb-6 line-clamp-2">{{ $cat->descripcion ?: 'Gestión integral de producción para esta variedad de cultivo.' }}</p>
                                
                                <div class="flex items-center justify-between mt-auto">
                                    <div class="flex items-center text-emerald-600 font-black text-xs uppercase tracking-widest gap-2 group-hover:gap-4 transition-all">
                                        Ver Producción
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                        </svg>
                                    </div>
                                    <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-20 text-center bg-white rounded-[3rem] border-2 border-dashed border-emerald-100">
                            <h3 class="text-xl font-black text-emerald-950">No hay variedades con registros de cosecha</h3>
                        </div>
                    @endforelse
                </div>
            @else
                <!-- VISTA B: LISTADO EN TABLA "HERMOSA" -->
                <div class="bg-white rounded-[3rem] shadow-sm border border-emerald-50 overflow-hidden">
                    <div class="p-8 border-b border-emerald-50 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-emerald-50/10">
                        <div>
                            <h2 class="text-xl font-black text-emerald-950 capitalize">Listado de Lotes: {{ $semillaSeleccionada->nombre_semilla }}</h2>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Gestión técnica y recolección por unidad</p>
                        </div>
                        <div class="flex items-center gap-2">
                             <span class="px-4 py-2 bg-emerald-600 text-white text-xs font-black rounded-full shadow-lg shadow-emerald-100">
                                {{ count($cosechas) }} LOTES REGISTRADOS
                             </span>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/50">
                                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Identificación</th>
                                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Ubicación / Terreno</th>
                                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Estado de Ciclo</th>
                                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-emerald-50">
                                @forelse($cosechas as $cosecha)
                                    <tr class="hover:bg-emerald-50/30 transition-all duration-300 group">
                                        <td class="px-8 py-6">
                                            <div class="flex items-center gap-4">
                                                <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-black text-sm shadow-sm border border-emerald-200">
                                                    #{{ $cosecha->id_cosecha }}
                                                </div>
                                                <div>
                                                    <p class="text-sm font-black text-emerald-950">Siembra {{ \Carbon\Carbon::parse($cosecha->fecha_siembra)->format('d/m/Y') }}</p>
                                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">{{ number_format($cosecha->Cantidad, 0) }} Plantas registradas</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-6">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-bold text-slate-700 capitalize group-hover:text-emerald-700 transition-colors">{{ $cosecha->terreno->nombre }}</p>
                                                    <p class="text-[10px] text-slate-400 font-medium">Lote Principal</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-6">
                                            @php 
                                                $progreso = $cosecha->porcentaje_crecimiento;
                                                $fase = $cosecha->fase_actual;
                                            @endphp
                                            <div class="w-48 space-y-2">
                                                <div class="flex justify-between items-center text-[10px] font-black uppercase tracking-tighter">
                                                    <span class="text-emerald-700">{{ $fase }}</span>
                                                    <span class="text-slate-400">{{ number_format($progreso, 0) }}%</span>
                                                </div>
                                                <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                                                    <div class="h-full bg-emerald-500 rounded-full transition-all duration-1000" style="width: {{ $progreso }}%"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-6">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('admin.cultivos.cosechaDetail', $cosecha->id_cosecha) }}" 
                                                   class="px-4 py-2 bg-emerald-50 text-emerald-700 text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-emerald-600 hover:text-white transition-all shadow-sm border border-emerald-100">
                                                    Gestionar Producción
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-8 py-20 text-center">
                                            <p class="text-slate-400 font-bold">No hay lotes registrados para esta variedad.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
