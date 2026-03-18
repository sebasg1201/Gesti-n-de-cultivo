@extends('layouts.admin')

@section('content')
    <div class="min-h-[calc(100vh-4rem)] bg-emerald-50/30 p-4 md:p-8">
        <div class="max-w-7xl mx-auto space-y-8">

            <!-- Header con Botón de Regreso -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.cultivos.cosechaDetail', $cultivo->id_cosecha) }}"
                        class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-emerald-600 shadow-sm border border-emerald-100 hover:bg-emerald-50 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-3xl font-black text-emerald-950 flex items-center gap-3">
                            Resumen de Producción
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs rounded-full uppercase font-black tracking-widest">#{{ $cultivo->id_cultivo }}</span>
                        </h1>
                        <p class="text-emerald-600 font-bold mt-1">
                            Trazabilidad completa del ciclo de vida
                        </p>
                    </div>
                </div>

                <div class="hidden md:flex gap-3">
                    @if($cultivo->cosecha->id_estado != 14)
                        <a href="{{ route('admin.cosechas.show', $cultivo->id_cosecha) }}" class="px-6 py-2 bg-white text-emerald-700 border border-emerald-100 font-black rounded-xl hover:bg-emerald-50 transition-all text-sm uppercase tracking-wider flex items-center gap-2" title="Ir a la gestión técnica del lote">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                            Ver Lote Madre
                        </a>
                    @else
                        <a href="{{ route('admin.cultivos.cosechaDetail', $cultivo->id_cosecha) }}" class="px-6 py-2 bg-white text-emerald-700 border border-emerald-100 font-black rounded-xl hover:bg-emerald-50 transition-all text-sm uppercase tracking-wider flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                            Ver Dashboard de Producción
                        </a>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Columna Izquierda: Información de la Recolección -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Card de Producción Actual -->
                    <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-emerald-50 relative overflow-hidden">
                        <div class="absolute -right-20 -top-20 w-64 h-64 bg-emerald-50/50 rounded-full"></div>
                        
                        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
                            <div class="flex-grow">
                                <h4 class="text-[10px] font-black text-emerald-900 uppercase tracking-widest mb-2 opacity-60">Resultados de esta Entrada</h4>
                                @foreach($cultivo->detalles as $detalle)
                                    <h2 class="text-4xl font-black text-slate-800">{{ $detalle->producto->nombre }}</h2>
                                    <div class="flex items-center gap-3 mt-4">
                                        <span class="px-4 py-1.5 bg-amber-50 text-amber-700 text-xs font-black rounded-full uppercase tracking-tighter">Calidad: {{ $detalle->calidad }}</span>
                                        <span class="text-slate-400 font-bold text-xs uppercase tracking-widest leading-none border-l-2 border-slate-100 pl-3">Ref: {{ $detalle->producto->Codigo_Referencia }}</span>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="text-center md:text-right bg-emerald-600 p-8 rounded-[2rem] text-white shadow-xl shadow-emerald-100 min-w-[200px]">
                                <p class="text-[10px] font-black uppercase tracking-[0.2em] mb-1 opacity-80">Peso Neto</p>
                                <div class="flex items-baseline justify-center md:justify-end gap-1">
                                    <span class="text-5xl font-black">{{ number_format($cultivo->detalles->sum('cantidad'), 1) }}</span>
                                    <span class="text-base font-bold opacity-80">Kg</span>
                                </div>
                                <p class="text-[9px] font-bold mt-2 opacity-60 uppercase tracking-widest">Verificado en Báscula</p>
                            </div>
                        </div>
                    </div>

                    <!-- Todos los Retiros (Historial Sister) -->
                    <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-50">
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <h3 class="text-xl font-black text-slate-800">Historial de Recolección del Ciclo</h3>
                                <p class="text-sm font-bold mt-1 text-slate-500">Traceabilidad de todas las recolecciones de esta siembra</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            @foreach($historialCosecha as $reco)
                                <div class="flex items-center justify-between p-5 rounded-3xl border {{ $reco->id_cultivo == $cultivo->id_cultivo ? 'bg-emerald-50/50 border-emerald-200' : 'bg-slate-50/30 border-slate-50' }} transition-all">
                                    <div class="flex items-center gap-5">
                                        <div class="w-12 h-12 {{ $reco->id_cultivo == $cultivo->id_cultivo ? 'bg-emerald-600 text-white' : 'bg-white text-slate-400 border border-slate-100' }} rounded-2xl flex items-center justify-center shadow-sm">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="text-xs font-black text-slate-800 uppercase tracking-widest">Recolección #{{ $reco->id_cultivo }}</span>
                                                @if($reco->id_cultivo == $cultivo->id_cultivo)
                                                    <span class="text-[9px] bg-emerald-600 text-white px-2 py-0.5 rounded-full font-black uppercase">Viendo Ahora</span>
                                                @endif
                                            </div>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase mt-1">
                                                {{ \Carbon\Carbon::parse($reco->fecha_recoleccion)->translatedFormat('d \d\e F, Y') }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <p class="text-xl font-black text-slate-800 leading-none">
                                            {{ number_format($reco->detalles->sum('cantidad'), 1) }}
                                            <span class="text-xs font-bold text-slate-400">Kg</span>
                                        </p>
                                        <p class="text-[10px] font-black text-emerald-600 uppercase mt-1 tracking-tighter">
                                            {{ $reco->trabajador->nombre }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Columna Derecha: Detalles del Origen (Ciclo Madre) -->
                <div class="space-y-8">
                    <!-- Card de la Planta/Cosecha -->
                    <div class="bg-white rounded-[2rem] shadow-sm border border-emerald-50 overflow-hidden">
                        <div class="relative h-48 group">
                            @if($cultivo->cosecha->imagenes)
                                <img src="{{ asset('uploads/' . $cultivo->cosecha->imagenes) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            @else
                                <div class="w-full h-full bg-emerald-100 flex items-center justify-center text-emerald-300">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                            <div class="absolute bottom-6 left-6 text-white">
                                <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-80">Origen de Producción</p>
                                <h3 class="text-xl font-black">{{ $cultivo->cosecha->semilla->nombre_semilla }}</h3>
                            </div>
                        </div>
                        
                        <div class="p-8 space-y-6">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /></svg>
                                </div>
                                <div>
                                    <h5 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Localización</h5>
                                    <p class="text-sm font-bold text-slate-800">Lote: {{ $cultivo->cosecha->terreno->nombre }}</p>
                                    <p class="text-[10px] text-emerald-600 font-bold">{{ $cultivo->cosecha->terreno->ubicacion ?? 'Ubicación registrada' }}</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center text-amber-500 shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                                <div>
                                    <h5 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Datos Técnicos</h5>
                                    <p class="text-sm font-bold text-slate-800">Siembra: {{ \Carbon\Carbon::parse($cultivo->cosecha->fecha_siembra)->format('d/m/Y') }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold">Expectativa: {{ number_format($cultivo->cosecha->produccion_estimada, 1) }} Kg</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card del Responsable -->
                    <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-50">
                        <h4 class="text-[10px] font-black text-emerald-950 uppercase tracking-widest mb-6 border-b border-emerald-50 pb-4">Autor del Registro</h4>
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-emerald-500 to-green-600 text-white flex items-center justify-center font-black text-xl shadow-lg shadow-emerald-100">
                                {{ strtoupper(substr($cultivo->trabajador->nombre, 0, 1)) }}
                            </div>
                            <div>
                                <h5 class="text-base font-black text-slate-800">{{ $cultivo->trabajador->nombre }}</h5>
                                <p class="text-xs font-bold text-emerald-600 uppercase tracking-tighter">Documento: {{ $cultivo->trabajador->documento }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
