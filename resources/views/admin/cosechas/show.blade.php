@extends('layouts.admin')

@section('content')
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

            <!-- 4 Cards de Métricas (Inspirado en Mockup del Usuario) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4">
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
                            {{ $diasRestantes > 0 ? $diasRestantes . ' Días' : 'Lista' }}
                        </h3>

                        <div
                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-rose-50 text-rose-600 text-xs font-bold">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            Faltan {{ $diasRestantes }} días
                        </div>
                    </div>
                </div>

                <!-- Card 4: Salud Cultivo (Mock) -->
                <div
                    class="bg-white rounded-[2rem] p-6 shadow-sm border border-emerald-50 relative overflow-hidden group hover:shadow-md transition-shadow">
                    <div
                        class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-50 rounded-full group-hover:scale-110 transition-transform duration-300">
                    </div>

                    <div class="relative z-10">
                        <div class="flex flex-col gap-1 mb-4">
                            <div
                                class="flex items-center gap-2 text-emerald-600 font-black uppercase tracking-widest text-[10px]">
                                <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                Salud Cultivo
                            </div>
                        </div>

                        <h3 class="text-3xl font-black text-slate-800 leading-none mb-3">
                            94/100
                        </h3>

                        <div
                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-emerald-50 text-emerald-600 text-xs font-bold">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            Excelente estado
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
                    <div class="text-3xl font-black text-slate-800">
                        {{ number_format($porcentaje, 0) }}%
                    </div>
                </div>

                <div class="relative pt-2">
                    <!-- Barra de progreso Track -->
                    <div class="h-4 w-full bg-slate-100 rounded-full overflow-hidden flex">
                        <!-- Segmentos de la barra (Visuales) -->
                        <div class="h-full border-r-2 border-white bg-[#00FF00] transition-all duration-1000 ease-out"
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

            <!-- Información Adicional (Opcional, estructurado abajo si se requiere) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-emerald-50">
                    <h4 class="font-black text-emerald-950 uppercase tracking-widest text-sm mb-6">Detalles Técnicos</h4>
                    <ul class="space-y-4">
                        <li class="flex justify-between items-center border-b border-emerald-50 pb-3">
                            <span class="text-sm font-medium text-slate-500">Variedad Sembrada</span>
                            <span class="text-sm font-bold text-slate-800">{{ $cosecha->semilla->nombre_semilla }}</span>
                        </li>
                        <li class="flex justify-between items-center border-b border-emerald-50 pb-3">
                            <span class="text-sm font-medium text-slate-500">Terreno Designado</span>
                            <span class="text-sm font-bold text-slate-800">{{ $cosecha->terreno->nombre }}</span>
                        </li>
                        <li class="flex justify-between items-center border-b border-emerald-50 pb-3">
                            <span class="text-sm font-medium text-slate-500">Cantidad Plantada</span>
                            <span class="text-sm font-bold text-slate-800">{{ number_format($cosecha->Cantidad, 0) }}
                                und</span>
                        </li>
                        <li class="flex justify-between items-center border-b border-emerald-50 pb-3">
                            <span class="text-sm font-medium text-slate-500">Rendimiento Esperado</span>
                            <span
                                class="text-sm font-bold text-emerald-600">{{ number_format($cosecha->produccion_estimada, 1) }}
                                kg</span>
                        </li>
                    </ul>
                </div>

                <div
                    class="bg-white rounded-[2rem] p-8 shadow-sm border border-emerald-50 flex flex-col items-center justify-center text-center">
                    @if($cosecha->imagenes)
                        <img src="{{ asset('uploads/' . $cosecha->imagenes) }}" alt="Foto Cultivo"
                            class="w-full max-h-64 object-cover rounded-2xl shadow-sm mb-4">
                    @else
                        <div
                            class="w-24 h-24 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-300 mb-4">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <p class="text-sm font-bold text-slate-400">Sin fotografía registrada para este lote.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection