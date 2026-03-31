@extends('layouts.admin')

@section('title', 'Resumen Estratégico de Cosecha')

@section('content')
<div class="min-h-screen bg-emerald-50/20 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto space-y-8">
        
        <!-- Header con Animación -->
        <div class="bg-white dark:bg-slate-800 p-8 rounded-[2.5rem] border border-emerald-100 dark:border-emerald-900/20 shadow-xl shadow-emerald-100/20 relative overflow-hidden">
            <div class="absolute -right-20 -top-20 w-64 h-64 bg-emerald-50 dark:bg-emerald-900/20 rounded-full blur-3xl opacity-60"></div>
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <span class="px-3 py-1 bg-emerald-600 text-white text-[10px] font-black rounded-full uppercase tracking-widest shadow-lg shadow-emerald-200">Ciclo Finalizado</span>
                        <span class="text-emerald-600 dark:text-emerald-400 text-xs font-bold uppercase tracking-widest">ID #{{ $cosecha->id_cosecha }}</span>
                    </div>
                    <h1 class="text-4xl font-black text-slate-900 dark:text-emerald-50 tracking-tight leading-tight">
                        Resumen de Desempeño: <br>
                        <span class="text-emerald-600">{{ $cosecha->semilla->nombre_semilla }}</span>
                    </h1>
                    <p class="text-slate-500 dark:text-emerald-400 mt-2 font-medium">Lote: {{ $cosecha->terreno->nombre }} • Duración: {{ $stats['dias_ciclo'] }} días</p>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.cosechas.pdf', $cosecha->id_cosecha) }}" 
                       class="flex items-center gap-3 bg-slate-900 hover:bg-slate-800 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest transition-all shadow-xl shadow-slate-200 active:scale-95">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Descargar Reporte PDF
                    </a>
                </div>
            </div>
        </div>

        <!-- KPI Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Card: Producción Total -->
            <div class="bg-white dark:bg-slate-800 p-8 rounded-[2rem] border border-emerald-50 dark:border-emerald-900/10 shadow-sm relative group overflow-hidden">
                <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-emerald-50 dark:bg-emerald-900/10 rounded-full group-hover:scale-110 transition-transform"></div>
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/30 rounded-2xl flex items-center justify-center text-emerald-600 mb-6">
                        <svg class="w-6 h-6 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Cosecha Real</span>
                    <h3 class="text-3xl font-black text-slate-900 dark:text-emerald-50 mt-1">{{ number_format($stats['total_recolectado'], 1) }} <span class="text-lg font-bold text-slate-400">UND</span></h3>
                    <div class="mt-4 flex items-center gap-2">
                        <span class="text-xs font-bold {{ $stats['cumplimiento'] >= 100 ? 'text-emerald-600' : 'text-amber-600' }}">
                            {{ number_format($stats['cumplimiento'], 1) }}% de la meta
                        </span>
                    </div>
                </div>
            </div>

            <!-- Card: Eficiencia Operativa -->
            <div class="bg-white dark:bg-slate-800 p-8 rounded-[2rem] border border-emerald-50 dark:border-emerald-900/10 shadow-sm relative group overflow-hidden">
                <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-blue-50 dark:bg-blue-900/10 rounded-full group-hover:scale-110 transition-transform"></div>
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center text-blue-600 mb-6">
                        <svg class="w-6 h-6 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    </div>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Ejecución Labores</span>
                    <h3 class="text-3xl font-black text-slate-900 dark:text-emerald-50 mt-1">{{ number_format($stats['tasa_exito'], 1) }} <span class="text-lg font-bold text-slate-400">%</span></h3>
                    <div class="mt-4 text-xs font-bold text-blue-600">
                        {{ $stats['tareas_completadas'] }} de {{ $stats['total_tareas'] }} tareas éxito
                    </div>
                </div>
            </div>

            <!-- Card: Meta Estratégica -->
            <div class="bg-slate-900 p-8 rounded-[2rem] border border-slate-800 shadow-xl shadow-slate-200 relative group overflow-hidden">
                <div class="absolute -right-4 -bottom-4 w-32 h-32 bg-emerald-500/10 rounded-full group-hover:scale-125 transition-transform duration-700"></div>
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-emerald-500/20 rounded-2xl flex items-center justify-center text-emerald-400 mb-6">
                        <svg class="w-6 h-6 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    </div>
                    <span class="text-[10px] font-black text-emerald-500/60 uppercase tracking-[0.2em]">Estimado Inicial</span>
                    <h3 class="text-3xl font-black text-white mt-1">{{ number_format($stats['estimado'], 1) }} <span class="text-lg font-bold text-emerald-500/40">UND</span></h3>
                    <p class="mt-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-relaxed line-clamp-2">Meta basada en rendimiento histórico y calidad de suelo.</p>
                </div>
            </div>
        </div>

        <!-- Detail Sections -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Producción por Recolección -->
            <div class="bg-white dark:bg-slate-800 p-8 rounded-[2.5rem] border border-emerald-50 dark:border-emerald-900/10 shadow-sm">
                <h4 class="text-xs font-black text-slate-400 uppercase tracking-[0.3em] mb-8 border-l-4 border-emerald-500 pl-4">Desglose de Producción</h4>
                <div class="space-y-6">
                    @forelse($cosecha->cultivos as $index => $cultivo)
                        <div class="flex items-center justify-between p-4 bg-emerald-50/50 dark:bg-emerald-900/10 rounded-2xl">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-white dark:bg-slate-800 rounded-xl flex items-center justify-center font-black text-emerald-600 shadow-sm">
                                    {{ $index + 1 }}
                                </div>
                                <div>
                                    <p class="text-sm font-black text-slate-900 dark:text-emerald-50">{{ \Carbon\Carbon::parse($cultivo->fecha_recoleccion)->format('d M, Y') }}</p>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Recoletado por: {{ $cultivo->trabajador->nombre }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-black text-emerald-600">{{ number_format($cultivo->detalles->sum('cantidad'), 1) }}</p>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Unidades</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center py-8 text-slate-400 font-bold uppercase tracking-widest text-[10px]">Sin recolecciones registradas</p>
                    @endforelse
                </div>
            </div>

            <!-- Impacto Operativo -->
            <div class="bg-white dark:bg-slate-800 p-8 rounded-[2.5rem] border border-emerald-50 dark:border-emerald-900/10 shadow-sm relative">
                <h4 class="text-xs font-black text-slate-400 uppercase tracking-[0.3em] mb-8 border-l-4 border-emerald-500 pl-4">Análisis Operativo</h4>
                
                <div class="space-y-8">
                    <!-- Progress Section -->
                    <div class="space-y-4">
                        <div class="flex justify-between items-end">
                            <span class="text-[10px] font-black text-slate-700 dark:text-emerald-50 uppercase tracking-widest">Cumplimiento de Riego</span>
                            <span class="text-lg font-black text-emerald-600">{{ number_format($stats['tasa_exito'], 0) }}%</span>
                        </div>
                        <div class="h-3 w-full bg-slate-100 dark:bg-emerald-900/20 rounded-full overflow-hidden">
                            <div class="h-full bg-emerald-500 transition-all duration-1000" style="width: {{ $stats['tasa_exito'] }}%"></div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-6 bg-slate-50 dark:bg-emerald-900/10 rounded-2xl border border-slate-100 dark:border-emerald-900/20">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Días de Ciclo</p>
                            <p class="text-2xl font-black text-slate-900 dark:text-emerald-50">{{ $stats['dias_ciclo'] }}</p>
                        </div>
                        <div class="p-6 bg-slate-50 dark:bg-emerald-900/10 rounded-2xl border border-slate-100 dark:border-emerald-900/20">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Variedad</p>
                            <p class="text-sm font-black text-slate-900 dark:text-emerald-50 truncate">{{ $cosecha->semilla->nombre_semilla }}</p>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-100 dark:border-emerald-900/20">
                        <p class="text-xs text-slate-500 dark:text-emerald-400 font-medium italic leading-relaxed">
                            "Este reporte resume todas las actividades y producción del ciclo. Los datos han sido validados y el terreno se encuentra ahora en estado <span class="bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 px-2 py-0.5 rounded font-black uppercase tracking-widest text-[9px]">Disponible</span> para una nueva siembra."
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botones de Acción Final -->
        <div class="flex items-center justify-center gap-6 pt-4">
            <a href="{{ route('admin.cosechas.index') }}" class="text-slate-400 hover:text-emerald-600 font-black text-xs uppercase tracking-[0.2em] transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                Volver a la Gestión de Cultivos
            </a>
        </div>
    </div>
</div>
@endsection
