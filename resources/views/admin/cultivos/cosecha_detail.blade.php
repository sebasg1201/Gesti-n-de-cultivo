@extends('layouts.admin')

@section('content')
    <div class="min-h-screen bg-slate-50/50 pb-12">
        <!-- Header Principal -->
        <div class="bg-white border-b border-emerald-100 shadow-sm mb-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-emerald-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-black text-slate-800 tracking-tight">Detalle de Producción</h1>
                            <p class="text-sm font-bold text-slate-400 mt-1 uppercase tracking-widest">Siembra #{{ $cosecha->id_cosecha }} - {{ $cosecha->semilla->nombre_semilla }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.cultivos.index', ['id_semilla' => $cosecha->id_semilla]) }}"
                            class="px-6 py-3 bg-white border border-slate-200 text-slate-600 font-bold rounded-xl hover:bg-slate-50 transition-all text-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Sidebar: Información de la Siembra -->
                <div class="lg:col-span-1 space-y-8">
                    <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-emerald-50 relative overflow-hidden group">
                        @if($cosecha->imagenes)
                            <img src="{{ asset('uploads/' . $cosecha->imagenes) }}" 
                                 class="w-full h-64 object-cover rounded-3xl shadow-md group-hover:scale-105 transition-transform duration-700" 
                                 alt="Imagen de la Siembra">
                        @else
                            <div class="w-full h-64 bg-slate-50 rounded-3xl flex items-center justify-center text-slate-200">
                                <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                        
                        <div class="mt-6 space-y-4">
                            <h3 class="text-xl font-black text-slate-800">{{ $cosecha->semilla->nombre_semilla }}</h3>
                            <div class="flex items-center gap-3 p-3 bg-emerald-50/50 rounded-2xl border border-emerald-50">
                                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-emerald-600 shadow-sm font-bold">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-emerald-900 uppercase">Terreno</p>
                                    <p class="text-sm font-bold text-slate-700">{{ $cosecha->terreno->nombre }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-emerald-50">
                        <h4 class="font-black text-emerald-950 uppercase tracking-widest text-xs mb-6 px-1">Detalles de Siembra</h4>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center py-2 border-b border-emerald-50">
                                <span class="text-sm font-bold text-slate-400">Fecha Plantación</span>
                                <span class="text-sm font-black text-slate-700">{{ \Carbon\Carbon::parse($cosecha->fecha_siembra)->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-emerald-50">
                                <span class="text-sm font-bold text-slate-400">Cantidad Total</span>
                                <span class="text-sm font-black text-slate-700">{{ number_format($cosecha->Cantidad, 0) }} und</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-emerald-50">
                                <span class="text-sm font-bold text-slate-400">Prod. Estimada</span>
                                <span class="text-sm font-black text-emerald-600">{{ number_format($cosecha->produccion_estimada, 1) }} kg</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main: Tabla de Recolecciones (The view the user wanted back) -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-[2.5rem] shadow-sm border border-emerald-50 overflow-hidden min-h-[500px] flex flex-col">
                        <div class="p-8 border-b border-emerald-50 flex items-center justify-between bg-white sticky top-0 z-10">
                            <div>
                                <h2 class="text-lg font-black text-slate-800">Historial de Recolecciones</h2>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Registros de producción detallados</p>
                            </div>
                            @if(count($cosecha->cultivos) > 0)
                                <div class="px-4 py-2 bg-emerald-50 text-emerald-700 text-xs font-black rounded-full border border-emerald-100 uppercase">
                                    {{ count($cosecha->cultivos) }} RECOLECCIONES
                                </div>
                            @endif
                        </div>

                        <div class="flex-grow overflow-x-auto">
                            @if(count($cosecha->cultivos) > 0)
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-slate-50/50">
                                            <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Fecha / ID</th>
                                            <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Producto / Calidad</th>
                                            <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Cantidad</th>
                                            <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Trabajador</th>
                                            <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Detalle</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-50">
                                        @foreach($cosecha->cultivos as $recoleccion)
                                            <tr class="hover:bg-emerald-50/20 transition-colors group">
                                                <td class="px-8 py-5">
                                                    <div class="flex flex-col">
                                                        <span class="text-sm font-black text-slate-800">{{ \Carbon\Carbon::parse($recoleccion->fecha_recoleccion)->format('d/m/Y') }}</span>
                                                        <span class="text-[11px] font-bold text-emerald-600">ID #{{ $recoleccion->id_cultivo }}</span>
                                                    </div>
                                                </td>
                                                <td class="px-8 py-5">
                                                    <div class="flex flex-col gap-1">
                                                        @foreach($recoleccion->detalles as $det)
                                                            <span class="text-sm font-black text-slate-800">{{ $det->producto->nombre }}</span>
                                                            <span class="inline-flex px-2 py-0.5 bg-amber-50 text-amber-600 rounded text-[9px] font-black uppercase w-fit">{{ $det->calidad }}</span>
                                                        @endforeach
                                                    </div>
                                                </td>
                                                <td class="px-8 py-5">
                                                    @foreach($recoleccion->detalles as $det)
                                                        <div class="flex items-baseline gap-1">
                                                            <span class="text-lg font-black text-emerald-600">{{ number_format($det->cantidad, 2) }}</span>
                                                            <span class="text-[10px] font-bold text-slate-400 uppercase">Kg/Und</span>
                                                        </div>
                                                    @endforeach
                                                </td>
                                                <td class="px-8 py-5">
                                                    <div class="flex items-center gap-2">
                                                        <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-[10px] font-black text-slate-500 border border-white">
                                                            {{ strtoupper(substr($recoleccion->trabajador->nombre, 0, 1)) }}
                                                        </div>
                                                        <span class="text-sm font-bold text-slate-700 capitalize">{{ $recoleccion->trabajador->nombre }}</span>
                                                    </div>
                                                </td>
                                                <td class="px-8 py-5 text-center">
                                                    <a href="{{ route('admin.cultivos.show', $recoleccion->id_cultivo) }}" 
                                                       class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white transition-all shadow-sm group-hover:scale-110">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="flex-grow flex flex-col items-center justify-center text-center py-20">
                                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-200 mb-6">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-black text-slate-800 mb-2">Sin recolecciones registradas</h3>
                                    <p class="text-sm font-bold text-slate-400 max-w-xs mx-auto mb-8">Este ciclo de siembra aún no cuenta con ingresos de producción registrados.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
