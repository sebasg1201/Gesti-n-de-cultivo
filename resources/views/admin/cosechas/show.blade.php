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
                            {{ $riegosCompletados }} de {{ $totalRiegosCiclo }} riego Realizado
                        </p>
                    </div>
                </div>

                <div class="relative pt-2">
                    <!-- Barra de progreso Track -->
                    <div class="h-4 w-full bg-slate-100 rounded-full overflow-hidden flex relative">
                        <!-- Sombra o barra guía indicando la meta de crecimiento -->
                        <div class="absolute left-0 top-0 bottom-0 bg-slate-200/50" style="width: {{ $porcentaje }}%"></div>
                        <!-- Segmentos de la barra Azul -->
                        <div class="h-full border-r-2 border-white bg-gradient-to-r from-cyan-400 to-blue-500 transition-all duration-1000 ease-out relative z-10 shadow-[0_0_10px_rgba(6,182,212,0.5)]"
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

            <!-- Línea de Tiempo del Cultivo (Historial) -->
            <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-emerald-50 relative overflow-hidden">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-xl font-black text-slate-800">Historial de Tratamiento</h3>
                        <p class="text-sm font-bold mt-1 text-slate-500">Registro de riegos, insumos y mantenimiento</p>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center text-slate-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                @if($historial->isEmpty())
                    <div class="text-center py-8">
                        <p class="text-slate-500 font-medium">No hay registros de actividades para este cultivo.</p>
                    </div>
                @else
                    <div class="space-y-6 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-200 before:to-transparent">
                        @foreach($historial as $item)
                        <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                            
                            <!-- Icon -->
                            <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10
                                {{ $item->tipo_historial == 'riego' ? 'bg-cyan-500' : ($item->tipo_historial == 'insumo' ? 'bg-purple-500' : 'bg-emerald-500') }} shadow-sm">
                                @if($item->tipo_historial == 'riego')
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" /></svg>
                                @elseif($item->tipo_historial == 'insumo')
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                                @else
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 15.536c-1.171 1.952-3.07 1.952-4.242 0-1.172-1.953-1.172-5.119 0-7.072 1.171-1.952 3.07-1.952 4.242 0M8 10.5h4m-4 3h4m9-1.5a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                @endif
                            </div>
                            
                            <!-- Card -->
                            <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-[1.5rem] border border-slate-100 bg-white shadow-sm hover:shadow-md transition-all">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-[10px] uppercase tracking-widest font-black 
                                        {{ $item->tipo_historial == 'riego' ? 'text-cyan-600' : ($item->tipo_historial == 'insumo' ? 'text-purple-600' : 'text-emerald-600') }}">
                                        {{ $item->titulo_historial }}
                                    </span>
                                    <span class="text-xs font-bold text-slate-400">{{ \Carbon\Carbon::parse($item->fecha_historial)->format('d/m/Y') }}</span>
                                </div>
                                <p class="text-slate-700 font-medium text-sm">{{ $item->descripcion_historial ?: 'Sin detalles adicionales' }}</p>
                                
                                <div class="mt-2 text-right">
                                    @if($item->estado_historial == 'Completado')
                                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg> Realizado
                                        </span>
                                    @elseif($item->estado_historial == 'En Proceso')
                                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded-md">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg> En Proceso
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-slate-500 bg-slate-50 px-2 py-1 rounded-md">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg> Programado
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection