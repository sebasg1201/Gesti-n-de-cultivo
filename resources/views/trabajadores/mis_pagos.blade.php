@extends('layouts.admin')

@section('title', 'Mis Pagos y Salario')

@section('content')
<div class="max-w-6xl mx-auto pb-20 space-y-12">
    {{-- Header de Bienvenida --}}
    <div class="relative overflow-hidden bg-gradient-to-br from-gray-900 via-emerald-900 to-emerald-800 rounded-[3rem] p-10 lg:p-16 shadow-2xl group transition-all duration-700 hover:shadow-emerald-200/20">
        <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-emerald-500/10 rounded-full blur-[100px] group-hover:bg-emerald-500/20 transition-all duration-700"></div>
        <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-64 h-64 bg-teal-500/10 rounded-full blur-[80px] group-hover:bg-teal-500/20 transition-all duration-700"></div>
        
        <div class="relative flex flex-col lg:flex-row items-center justify-between gap-12">
            <div class="space-y-6 text-center lg:text-left">
                <div class="inline-flex items-center gap-3 bg-white/10 backdrop-blur-xl px-5 py-2 rounded-full border border-white/10">
                    <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse shadow-[0_0_10px_rgba(52,211,153,0.8)]"></span>
                    <span class="text-white text-[10px] font-black uppercase tracking-[0.3em]">Finanzas Personales</span>
                </div>
                <h2 class="text-4xl lg:text-6xl font-black text-white tracking-tight leading-none">
                    Resumen de <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-300 via-teal-200 to-emerald-100">Tus Ingresos</span>
                </h2>
                <p class="text-emerald-50/70 text-lg font-medium max-w-lg mx-auto lg:mx-0">
                    Gestiona y visualiza el historial de tus salarios devengados. Tu esfuerzo se ve reflejado aquí.
                </p>
            </div>

            {{-- Card de Resumen Rápido (Glassmorphism) --}}
            <div class="relative group/card">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-[2.5rem] blur-2xl opacity-20 group-hover/card:opacity-40 transition-opacity"></div>
                <div class="relative bg-white/10 backdrop-blur-3xl border border-white/20 rounded-[2.5rem] p-10 shadow-2xl w-full sm:min-w-[340px] text-center">
                    <p class="text-emerald-300 text-[10px] font-black uppercase tracking-[0.4em] mb-4">Total Acumulado</p>
                    <h3 class="text-5xl font-black text-white mb-2 leading-none">
                        ${{ number_format($pagos->sum('cantidad_pago'), 0, ',', '.') }}
                    </h3>
                    <div class="inline-flex items-center gap-2 bg-white/10 px-4 py-1.5 rounded-full mt-4 border border-white/5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-emerald-100 text-[10px] font-bold uppercase tracking-widest">Cuenta Verificada</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Cuerpo de la Vista --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        {{-- Sidebar de Información --}}
        <div class="lg:col-span-4 space-y-8 animate-fade-in-up">
            <div class="bg-white rounded-[2.5rem] p-10 border border-gray-100 shadow-xl shadow-gray-200/50 relative overflow-hidden group/info">
                <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-full -mr-16 -mt-16 transition-all duration-500 group-hover/info:scale-110"></div>
                
                <h3 class="text-xl font-black text-gray-900 mb-8 flex items-center gap-4 relative">
                    <div class="w-10 h-10 bg-emerald-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    Información de Pago
                </h3>

                <div class="space-y-8 relative">
                    @php
                        $ultimoPago = $pagos->first();
                        $tipoSalario = $ultimoPago && $ultimoPago->tipoSalario ? $ultimoPago->tipoSalario->tipo_salario : 'Standard';
                        $fechaUltimo = $ultimoPago ? \Carbon\Carbon::parse($ultimoPago->fecha_pago)->format('d \d\e M, Y') : '---';
                    @endphp

                    <div class="space-y-3">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Frecuencia / Tipo</p>
                        <div class="bg-gray-50 border border-gray-100 p-6 rounded-[2rem]">
                            <p class="text-2xl font-black text-gray-900 leading-none">{{ $tipoSalario }}</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Último Reporte</p>
                        <div class="bg-emerald-50 border border-emerald-100 p-6 rounded-[2rem]">
                            <p class="text-2xl font-black text-emerald-900 leading-none">{{ $fechaUltimo }}</p>
                        </div>
                    </div>

                    <div class="pt-6">
                        <div class="bg-gray-900 rounded-[2rem] p-8 text-center shadow-2xl">
                            <p class="text-gray-400 text-[10px] font-black uppercase tracking-[0.2em] mb-2 text-center">Estado Laboral</p>
                            <span class="inline-flex items-center gap-2 bg-emerald-500 text-white px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest">
                                <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>
                                Vinculado Activo
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-emerald-600 rounded-[2.5rem] p-10 text-white shadow-2xl shadow-emerald-200 relative overflow-hidden group">
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
                <h4 class="text-xl font-black mb-4 relative">Soporte y Dudas</h4>
                <p class="text-emerald-50 opacity-80 text-sm leading-relaxed mb-6 relative">Si tienes alguna duda sobre tus pagos, contacta directamente con el administrador de la empresa.</p>
                <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Listado Detallado --}}
        <div class="lg:col-span-8 animate-fade-in-up delay-150">
            <div class="bg-white rounded-[2.5rem] p-10 border border-gray-100 shadow-xl shadow-gray-200/50 h-full">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mb-12">
                    <div class="flex items-center gap-5">
                        <div class="w-14 h-14 bg-gray-900 rounded-[1.5rem] flex items-center justify-center text-white shadow-xl shadow-gray-300">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-gray-900 tracking-tight">Historial de Transacciones</h3>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Todos los pagos registrados por la empresa</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    @forelse($pagos as $pago)
                        <div class="group/item relative bg-white p-7 rounded-[2.2rem] border border-gray-100 hover:border-emerald-300 transition-all duration-300 flex flex-col sm:flex-row sm:items-center justify-between gap-6 hover:shadow-2xl hover:shadow-emerald-100/30">
                            {{-- Línea Lateral Decorativa --}}
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-12 bg-emerald-500 rounded-r-full opacity-0 group-hover/item:opacity-100 transition-opacity"></div>
                            
                            <div class="flex items-center gap-6">
                                <div class="w-14 h-14 bg-gray-50 group-hover/item:bg-emerald-50 rounded-2xl flex items-center justify-center text-gray-400 group-hover/item:text-emerald-600 transition-all duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-lg font-black text-gray-900 group-hover/item:text-emerald-700 transition-colors">{{ $pago->descripcion_pago }}</p>
                                    <div class="flex items-center gap-3 mt-1">
                                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-[0.15em]">{{ \Carbon\Carbon::parse($pago->fecha_pago)->translatedFormat('l, d F Y') }}</span>
                                        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                        <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">Confirmado</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-6 text-right border-t sm:border-t-0 pt-6 sm:pt-0">
                                <div class="bg-emerald-50 px-6 py-4 rounded-[1.5rem] border border-emerald-100 group-hover/item:bg-emerald-500 group-hover/item:border-emerald-500 transition-all duration-300">
                                    <p class="text-xl font-black text-emerald-800 group-hover/item:text-white transition-colors leading-none">
                                        ${{ number_format($pago->cantidad_pago, 0, ',', '.') }}
                                    </p>
                                    <p class="text-[8px] font-black text-emerald-600 uppercase tracking-[0.2em] mt-1 group-hover/item:text-emerald-100 transition-colors">
                                        {{ $pago->unidad_pago }} / {{ $pago->tipoSalario ? $pago->tipoSalario->tipo_salario : 'Standard' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="py-24 text-center">
                            <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h4 class="text-xl font-black text-gray-900 mb-2">Sin actividad financiera</h4>
                            <p class="text-gray-400 max-w-sm mx-auto">Aún no se han registrado pagos en tu cuenta. Se mostrarán aquí una vez que el administrador los asigne.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fade-in-up {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
        animation: fade-in-up 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    .delay-150 { animation-delay: 150ms; }

    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #cbd5e1;
    }
</style>
@endsection
