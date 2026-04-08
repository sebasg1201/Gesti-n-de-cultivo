@extends('layouts.admin')

@section('title', 'Mis Pagos y Salario')

@section('content')
<div class="max-w-6xl mx-auto pb-20 space-y-12">
    {{-- Header de Bienvenida --}}
    <div class="relative overflow-hidden bg-gradient-to-br from-gray-900 via-emerald-900 to-emerald-800 rounded-3xl lg:rounded-[3rem] p-6 lg:p-16 shadow-2xl group transition-all duration-700 hover:shadow-emerald-200/20">
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
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-3xl lg:rounded-[2.5rem] blur-2xl opacity-20 group-hover/card:opacity-40 transition-opacity"></div>
                <div class="relative bg-white/10 backdrop-blur-3xl border border-white/20 rounded-3xl lg:rounded-[2.5rem] p-6 lg:p-10 shadow-2xl w-full sm:min-w-[340px] text-center">
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
            <div class="bg-white dark:bg-slate-800 rounded-3xl lg:rounded-[2.5rem] p-6 lg:p-10 border border-gray-100 dark:border-emerald-900/20 shadow-xl shadow-gray-200/50 dark:shadow-none relative overflow-hidden group/info transition-all duration-300">
                <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 dark:bg-emerald-900/10 rounded-full -mr-16 -mt-16 transition-all duration-500 group-hover/info:scale-110"></div>
                
                <h3 class="text-xl font-black text-gray-900 dark:text-emerald-50 mb-8 flex items-center gap-4 relative">
                    <div class="w-10 h-10 bg-emerald-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-emerald-200 dark:shadow-none">
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
                        <p class="text-[10px] font-black text-gray-400 dark:text-emerald-700 uppercase tracking-widest ml-1">Frecuencia / Tipo</p>
                        <div class="bg-gray-50 dark:bg-slate-900 border border-gray-100 dark:border-emerald-900/10 p-6 rounded-[2rem]">
                            <p id="detalle_tipo" class="text-2xl font-black text-gray-900 dark:text-emerald-50 leading-none">{{ $tipoSalario }}</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <p class="text-[10px] font-black text-gray-400 dark:text-emerald-700 uppercase tracking-widest ml-1">Fecha de Reporte</p>
                        <div class="bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-100 dark:border-emerald-800 p-6 rounded-[2rem]">
                            <p id="detalle_fecha" class="text-2xl font-black text-emerald-900 dark:text-emerald-400 leading-none">{{ $fechaUltimo }}</p>
                        </div>
                    </div>

                    <div id="container_monto" class="space-y-3 hidden">
                        <p class="text-[10px] font-black text-gray-400 dark:text-emerald-700 uppercase tracking-widest ml-1">Monto Seleccionado</p>
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 p-6 rounded-[2rem]">
                            <p id="detalle_monto" class="text-2xl font-black text-blue-900 dark:text-blue-300 leading-none"></p>
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
            
            <a href="{{ route('trabajador.soporte') }}" class="block group">
                <div class="bg-emerald-600 rounded-3xl lg:rounded-[2.5rem] p-6 lg:p-10 text-white shadow-2xl shadow-emerald-200 relative overflow-hidden transition-all duration-300 hover:scale-[1.02] hover:shadow-emerald-300/50">
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
                    <h4 class="text-xl font-black mb-4 relative">Soporte y Dudas</h4>
                    <p class="text-emerald-50 opacity-80 text-sm leading-relaxed mb-6 relative">Si tienes alguna duda sobre tus pagos, contacta directamente con el administrador de la empresa.</p>
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                </div>
            </a>
        </div>

        {{-- Listado Detallado --}}
        <div class="lg:col-span-8 animate-fade-in-up delay-150">
            <div class="bg-white dark:bg-slate-800 rounded-3xl lg:rounded-[2.5rem] p-6 lg:p-10 border border-gray-100 dark:border-emerald-900/20 shadow-xl shadow-gray-200/50 dark:shadow-none h-full transition-all duration-300">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mb-12">
                    <div class="flex items-center gap-5">
                        <div class="w-14 h-14 bg-gray-900 dark:bg-slate-900 rounded-[1.5rem] flex items-center justify-center text-white border border-transparent dark:border-emerald-900/30 shadow-xl shadow-gray-300 dark:shadow-none">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-gray-900 dark:text-emerald-50 tracking-tight">Historial de Transacciones</h3>
                            <p class="text-[10px] font-black text-gray-400 dark:text-emerald-700 uppercase tracking-widest">Todos los pagos registrados por la empresa</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    @forelse($pagos as $pago)
                        <div class="group/item relative bg-white dark:bg-slate-900/40 p-4 lg:p-7 rounded-2xl lg:rounded-[2.2rem] border border-gray-100 dark:border-emerald-900/10 hover:border-emerald-300 dark:hover:border-emerald-700 transition-all duration-300 flex flex-col sm:flex-row sm:items-center justify-between gap-4 lg:gap-6 hover:shadow-2xl hover:shadow-emerald-100/30 dark:hover:shadow-none cursor-pointer payment-history-card"
                             data-tipo="{{ $pago->tipoSalario ? $pago->tipoSalario->tipo_salario : 'Standard' }}"
                             data-fecha="{{ \Carbon\Carbon::parse($pago->fecha_pago)->translatedFormat('d \d\e F, Y') }}"
                             data-monto="${{ number_format($pago->cantidad_pago, 0, ',', '.') }} {{ $pago->unidad_pago }}">
                            {{-- Línea Lateral Decorativa --}}
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-12 bg-emerald-500 rounded-r-full opacity-0 group-hover/item:opacity-100 transition-opacity"></div>
                            
                            <div class="flex items-center gap-6">
                                <div class="w-14 h-14 bg-gray-50 dark:bg-slate-800 group-hover/item:bg-emerald-50 dark:group-hover/item:bg-emerald-900/30 rounded-2xl flex items-center justify-center text-gray-400 dark:text-emerald-700 group-hover/item:text-emerald-600 dark:group-hover/item:text-emerald-400 transition-all duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-lg font-black text-gray-900 dark:text-emerald-50 group-hover/item:text-emerald-700 dark:group-hover/item:text-emerald-400 transition-colors">{{ $pago->descripcion_pago }}</p>
                                    <div class="flex items-center gap-3 mt-1">
                                        <span class="text-[10px] font-black text-gray-400 dark:text-emerald-800 uppercase tracking-[0.15em]">{{ \Carbon\Carbon::parse($pago->fecha_pago)->translatedFormat('l, d F Y') }}</span>
                                        <span class="w-1 h-1 bg-gray-300 dark:bg-emerald-900 rounded-full"></span>
                                        <span class="text-[10px] font-black text-emerald-600 dark:text-emerald-500 uppercase tracking-widest">Confirmado</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-6 text-right border-t dark:border-emerald-900/20 sm:border-t-0 pt-6 sm:pt-0">
                                <div class="bg-emerald-50 dark:bg-emerald-900/30 px-6 py-4 rounded-[1.5rem] border border-emerald-100 dark:border-emerald-800 group-hover/item:bg-emerald-500 group-hover/item:border-emerald-500 transition-all duration-300">
                                    <p class="text-xl font-black text-emerald-800 dark:text-emerald-300 group-hover/item:text-white transition-colors leading-none">
                                        ${{ number_format($pago->cantidad_pago, 0, ',', '.') }}
                                    </p>
                                    <p class="text-[8px] font-black text-emerald-600 dark:text-emerald-500 uppercase tracking-[0.2em] mt-1 group-hover/item:text-emerald-100 transition-colors">
                                        {{ $pago->unidad_pago }} / {{ $pago->tipoSalario ? $pago->tipoSalario->tipo_salario : 'Standard' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="py-24 text-center">
                            <div class="w-24 h-24 bg-gray-50 dark:bg-slate-900 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 dark:text-emerald-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h4 class="text-xl font-black text-gray-900 dark:text-emerald-50 mb-2">Sin actividad financiera</h4>
                            <p class="text-gray-400 dark:text-emerald-700 max-w-sm mx-auto">Aún no se han registrado pagos en tu cuenta. Se mostrarán aquí una vez que el administrador los asigne.</p>
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
<script>
    document.querySelectorAll('.payment-history-card').forEach(card => {
        card.addEventListener('click', function() {
            const tipo = this.dataset.tipo;
            const fecha = this.dataset.fecha;
            const monto = this.dataset.monto;

            // Actualizar Sidebar
            const elementTipo = document.getElementById('detalle_tipo');
            const elementFecha = document.getElementById('detalle_fecha');
            const elementMonto = document.getElementById('detalle_monto');
            const containerMonto = document.getElementById('container_monto');

            // Feedback Visual
            [elementTipo, elementFecha, elementMonto].forEach(el => {
                el.parentElement.classList.add('ring-4', 'ring-emerald-500/20');
                setTimeout(() => el.parentElement.classList.remove('ring-4', 'ring-emerald-500/20'), 500);
            });

            elementTipo.innerText = tipo;
            elementFecha.innerText = fecha;
            elementMonto.innerText = monto;
            containerMonto.classList.remove('hidden');

            // Scroll al sidebar en movil si es necesario
            if (window.innerWidth < 1024) {
                document.querySelector('.lg\\:col-span-4').scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
</script>
@endsection
