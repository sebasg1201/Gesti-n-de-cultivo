@extends('layouts.admin')

@section('content')
    <div class="min-h-[calc(100vh-4rem)] bg-emerald-50/30 p-4 md:p-8">
        <div class="max-w-7xl mx-auto space-y-8">

            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-black text-emerald-950 flex items-center gap-3">
                        Módulo de Recolección (Cultivo)
                        <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs rounded-full uppercase tracking-widest font-bold">Producción</span>
                    </h1>
                    <p class="text-emerald-600 font-medium mt-1">Selecciona una siembra activa para ver su historial y registrar producción.</p>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-lg shadow-sm animate-fade-in-down" role="alert">
                    <p class="font-bold">¡Éxito!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <!-- Grid de Cosechas Disponibles para Recolectar -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($cosechas as $cosecha)
                    <div class="group bg-white rounded-[2.5rem] overflow-hidden shadow-sm border border-emerald-50 hover:shadow-xl hover:shadow-emerald-100/50 transition-all duration-500 hover:-translate-y-1 flex flex-col">
                        <!-- Imagen/Header -->
                        <div class="relative h-48 overflow-hidden cursor-pointer" onclick="window.location.href='{{ route('admin.cultivos.cosechaDetail', $cosecha->id_cosecha) }}'">
                            @if($cosecha->imagenes)
                                <img src="{{ asset('uploads/' . $cosecha->imagenes) }}" alt="Cultivo" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="w-full h-full bg-emerald-50 flex items-center justify-center text-emerald-200">
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-emerald-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end p-6">
                                <span class="text-white font-black uppercase tracking-widest text-xs flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Ver Producción Detallada
                                </span>
                            </div>
                            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full shadow-sm border border-emerald-100">
                                <span class="text-[10px] font-black text-emerald-700 uppercase">#{{ $cosecha->id_cosecha }}</span>
                            </div>
                        </div>

                        <!-- Contenido -->
                        <div class="p-6 flex-grow flex flex-col">
                            <div class="mb-4">
                                <h3 class="text-xl font-black text-emerald-950 capitalize truncate">{{ $cosecha->semilla->nombre_semilla }}</h3>
                                <p class="text-xs font-bold text-slate-400 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $cosecha->terreno->nombre }}
                                </p>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div class="bg-emerald-50/50 p-3 rounded-2xl">
                                    <p class="text-[9px] font-black text-emerald-800 uppercase tracking-tighter">Siembra</p>
                                    <p class="text-xs font-black text-emerald-600">{{ \Carbon\Carbon::parse($cosecha->fecha_siembra)->format('d M, y') }}</p>
                                </div>
                                <div class="bg-blue-50/50 p-3 rounded-2xl">
                                    <p class="text-[9px] font-black text-blue-800 uppercase tracking-tighter">Cantidad</p>
                                    <p class="text-xs font-black text-blue-600">{{ number_format($cosecha->Cantidad, 0) }} und</p>
                                </div>
                            </div>

                            <div class="mt-auto pt-4 border-t border-emerald-50">
                                <a href="{{ route('admin.cultivos.cosechaDetail', $cosecha->id_cosecha) }}" 
                                   class="w-full flex items-center justify-center py-3 bg-emerald-50 text-emerald-700 font-black text-xs uppercase tracking-widest rounded-xl hover:bg-emerald-600 hover:text-white transition-all transform active:scale-95 group/btn">
                                    Ver Detalle Producción
                                    <svg class="w-4 h-4 ml-2 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center bg-white rounded-[3rem] border-2 border-dashed border-emerald-100">
                        <div class="w-24 h-24 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-200 mx-auto mb-6">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-black text-emerald-950">No hay cosechas activas</h3>
                        <p class="text-slate-400 font-bold mt-2">Inicia una nueva siembra desde el módulo de Cosechas.</p>
                        <a href="{{ route('admin.cosechas.index') }}" class="mt-6 inline-flex items-center gap-2 text-emerald-600 font-black uppercase text-xs tracking-widest hover:gap-4 transition-all">
                            Ir a Siembras
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
