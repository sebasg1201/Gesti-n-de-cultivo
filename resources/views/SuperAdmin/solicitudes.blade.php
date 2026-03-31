@extends('layouts.barra_lateral')

@section('content')
    <div class="px-6 pb-6 pt-0 bg-slate-50/50 dark:bg-slate-950/20 transition-colors duration-300">

        {{-- HEADER & ACTIONS INTEGRATED --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="text-3xl font-black text-green-800 dark:text-emerald-500 tracking-tight">Solicitudes De <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-green-500">Compra</span>
                </h2>
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Gestiona y supervisa las suscripciones entrantes.</p>
            </div>

            <div class="flex items-center gap-3">
                {{-- SEARCH COMPACTA --}}
                <form action="{{ route('solicitudes.index') }}" method="GET" class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400 group-focus-within:text-emerald-500 transition-colors"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="search" name="search" value="{{ request('search') }}"
                        class="block w-full md:w-64 pl-10 pr-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-emerald-900/20 rounded-xl text-sm font-bold text-slate-700 dark:text-emerald-50 placeholder-slate-400 focus:ring-4 focus:ring-emerald-50 dark:focus:ring-emerald-500/10 focus:border-emerald-500 focus:w-80 outline-none transition-all"
                        placeholder="Empresa o NIT...">

                    @if(request('search'))
                        <a href="{{ route('solicitudes.index') }}"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-rose-500 transition-colors"
                            title="Limpiar filtro">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif
                </form>

                {{-- EXPORT BUTTON --}}
                <button onclick="document.getElementById('exportSolicitudesModal').classList.remove('hidden')" class="bg-gradient-to-r from-emerald-400 via-green-500 to-emerald-600
                                                   hover:from-emerald-500 hover:via-green-600 hover:to-emerald-700
                                                   text-white border border-emerald-500/30
                                                   px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest
                                                   flex items-center gap-2 shadow-md transition-all duration-300
                                                   active:scale-95 cursor-pointer">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                        stroke="currentColor" class="w-4 h-4 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>

                    Exportar
                </button>
            </div>
        </div>

        {{-- TABLE CONTAINER --}}
        <div class="bg-white dark:bg-slate-900 rounded-[2rem] shadow-[0_10px_40px_rgba(0,0,0,0.03)] dark:shadow-none border border-slate-100 dark:border-emerald-900/10 overflow-hidden transition-colors duration-300">
            <div class="overflow-x-auto text-left">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 dark:bg-slate-950/50">
                            <th
                                class="px-6 py-5 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] border-b border-slate-100 dark:border-emerald-950/20">
                                Empresa</th>
                            <th
                                class="px-6 py-5 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] border-b border-slate-100 dark:border-emerald-950/20">
                                Contacto</th>
                            <th
                                class="px-6 py-5 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] border-b border-slate-100 dark:border-emerald-950/20 text-center">
                                Plan</th>
                            <th
                                class="px-6 py-5 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] border-b border-slate-100 dark:border-emerald-950/20">
                                Fecha Solicitud</th>
                            <th
                                class="px-6 py-5 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] border-b border-slate-100 dark:border-emerald-950/20 text-center">
                                Estado</th>
                            <th
                                class="px-6 py-5 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] border-b border-slate-100 dark:border-emerald-950/20 text-right">
                                Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-emerald-950/10">
                        @forelse($solicitudes as $solicitud)
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-emerald-500/5 transition-all group">
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-sm font-bold text-slate-800 dark:text-emerald-50 transition-colors">{{ $solicitud->empresa->nombre_empresa ?? 'N/A' }}</span>
                                        <div class="flex items-center gap-1.5 mt-0.5">
                                            <span class="text-[11px] font-medium text-slate-400 dark:text-slate-500">NIT:
                                                {{ $solicitud->id_empresa }}</span>

                                            {{-- BOTÓN DE COPIADO --}}
                                            <button type="button"
                                                onclick="copyToClipboard('{{ $solicitud->id_empresa }}', this)"
                                                class="text-slate-300 hover:text-emerald-500 transition-all duration-300 opacity-0 group-hover:opacity-100 focus:outline-none"
                                                title="Copiar NIT">

                                                {{-- Icono Default (Papeles) --}}
                                                <svg class="w-3.5 h-3.5 icon-copy" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                        d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                </svg>

                                                {{-- Icono Check (Oculto por defecto) --}}
                                                <svg class="w-3.5 h-3.5 hidden text-emerald-500 icon-check" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-sm font-bold text-slate-700 dark:text-slate-200 leading-none transition-colors">{{ $solicitud->empresa->nombre_repre_legal ?? 'N/A' }}</span>
                                        <span
                                            class="text-[11px] font-medium text-slate-400 dark:text-slate-500 mt-1 italic">{{ $solicitud->empresa->correo ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-center">
                                    <span
                                        class="inline-block px-3 py-1 text-[10px] font-black tracking-widest uppercase rounded-lg bg-indigo-50 dark:bg-indigo-950/30 text-indigo-600 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-900/30">
                                        {{ $solicitud->tipoLicencia->nombre_licencia ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-slate-700 dark:text-slate-300 uppercase leading-none transition-colors">
                                            {{ \Carbon\Carbon::parse($solicitud->fecha_solicitud)->format('d M, Y') }}
                                        </span>
                                        <span class="text-[10px] font-medium text-slate-400 dark:text-slate-500 mt-1 uppercase tracking-tighter">
                                            Hace
                                            {{ \Carbon\Carbon::parse($solicitud->fecha_solicitud)->diffForHumans(null, true) }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-center">
                                    @php
                                        $statusClasses = $solicitud->id_estado == 1
                                            ? 'bg-amber-50 dark:bg-amber-950/30 text-amber-600 dark:text-amber-400 ring-amber-100 dark:ring-amber-900/30'
                                            : 'bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 ring-emerald-100 dark:ring-emerald-900/30';
                                    @endphp
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-black uppercase tracking-tighter ring-1 {{ $statusClasses }}">
                                        <span class="w-1.5 h-1.5 rounded-full bg-current animate-pulse"></span>
                                        {{ $solicitud->estado->nombre_estado ?? '?' }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-right">
                                    <button onclick="openModal('{{ $solicitud->id_solicitud }}')"
                                        class="inline-flex items-center gap-2 bg-gradient-to-r from-[#34d399] via-[#22c55e] to-[#16a34a] hover:from-[#22c55e] hover:via-[#16a34a] hover:to-[#15803d] text-white px-4 py-2 rounded-xl text-xs font-black shadow-lg shadow-emerald-100 transition-all hover:-translate-y-0.5 active:translate-y-0 cursor-pointer">
                                        DETALLE
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="bg-slate-50 dark:bg-slate-800 p-4 rounded-full mb-4">
                                            <svg class="w-12 h-12 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <span class="text-slate-400 dark:text-slate-500 font-bold uppercase tracking-widest text-xs">Sin registros
                                            encontrados</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{-- PAGINACIÓN --}}
        @if($solicitudes->hasPages())
            <div class="flex justify-center mt-6">
                {{ $solicitudes->withQueryString()->links() }}
            </div>
        @endif
    </div>

    {{-- MODAL --}}
    <div id="modalDetalle" class="fixed inset-0 z-[9999] hidden overflow-y-auto" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 py-6">
            <div class="fixed inset-0 bg-black/40 backdrop-blur-sm" onclick="closeModal()"></div>
            <div class="relative bg-white dark:bg-slate-900 rounded-2xl text-left shadow-2xl transform transition-all w-full max-w-2xl border border-transparent dark:border-emerald-950/30 transition-colors duration-300">

                {{-- HEADER --}}
                <div class="bg-gradient-to-r from-green-500 to-emerald-400 px-6 py-5 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-white">Solicitud de Compra</h3>
                                <p class="text-green-100 text-xs">Detalle completo de la solicitud</p>
                            </div>
                        </div>
                        <button onclick="closeModal()"
                            class="text-white/80 hover:text-white transition-colors p-1 rounded-lg hover:bg-white/10">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- COMPANY BANNER --}}
                <div class="px-6 py-5 flex items-center gap-4 border-b border-gray-100 dark:border-emerald-950/20">
                    <div id="modal-sol-avatar"
                        class="w-14 h-14 rounded-full bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center text-white font-bold text-xl shadow-md flex-shrink-0">
                    </div>
                    <div class="min-w-0">
                        <p class="text-base font-bold text-gray-900 dark:text-emerald-50" id="modal-sol-empresa"></p>
                        <div class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-2 mt-1">
                            NIT: <span id="modal-sol-nit" class="font-medium text-gray-700 dark:text-emerald-400"></span>
                            <button type="button"
                                onclick="copyToClipboard(document.getElementById('modal-sol-nit').innerText, this)"
                                title="Copiar NIT"
                                class="text-gray-400 dark:text-slate-500 hover:text-green-600 dark:hover:text-emerald-400 transition-colors cursor-pointer focus:outline-none">
                                <svg class="w-4 h-4 icon-copy" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                                <svg class="w-4 h-4 hidden text-green-500 icon-check" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="ml-auto flex-shrink-0" id="modal-sol-estado"></div>
                </div>

                {{-- CONTENT GRID --}}
                <div class="px-6 py-5 grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <div class="bg-gray-50 dark:bg-slate-950 rounded-xl p-4 flex items-start gap-3">
                        <div class="mt-0.5 p-2 bg-green-100 dark:bg-emerald-950 rounded-lg flex-shrink-0">
                            <svg class="w-4 h-4 text-green-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-gray-400 dark:text-slate-500 font-medium">Representante</p>
                            <p class="text-sm font-semibold text-gray-800 dark:text-emerald-50" id="modal-sol-repre"></p>
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-slate-950 rounded-xl p-4 flex items-start gap-3">
                        <div class="mt-0.5 p-2 bg-green-100 dark:bg-emerald-950 rounded-lg flex-shrink-0">
                            <svg class="w-4 h-4 text-green-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-gray-400 dark:text-slate-500 font-medium">Correo</p>
                            <p class="text-sm font-semibold text-gray-800 break-all dark:text-emerald-50" id="modal-sol-correo"></p>
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-slate-950 rounded-xl p-4 flex items-start gap-3 sm:col-span-2">
                        <div class="mt-0.5 p-2 bg-green-100 dark:bg-emerald-950 rounded-lg flex-shrink-0">
                            <svg class="w-4 h-4 text-green-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-gray-400 dark:text-slate-500 font-medium">Teléfono</p>
                            <p class="text-sm font-semibold text-gray-800 dark:text-emerald-50" id="modal-sol-telefono"></p>
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-slate-950 rounded-xl p-4 flex items-start gap-3">
                        <div class="mt-0.5 p-2 bg-blue-100 dark:bg-blue-950 rounded-lg flex-shrink-0">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-gray-400 dark:text-slate-500 font-medium">Plan / Licencia</p>
                            <p class="text-sm font-semibold text-gray-800 dark:text-emerald-50" id="modal-sol-plan"></p>
                            <p class="text-xs text-gray-500 dark:text-gray-400" id="modal-sol-precio"></p>
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-slate-950 rounded-xl p-4 flex items-start gap-3">
                        <div class="mt-0.5 p-2 bg-green-100 dark:bg-emerald-950 rounded-lg flex-shrink-0">
                            <svg class="w-4 h-4 text-green-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-gray-400 dark:text-slate-500 font-medium">Fecha de Solicitud</p>
                            <p class="text-sm font-semibold text-gray-800 dark:text-emerald-50" id="modal-sol-fecha"></p>
                        </div>
                    </div>

                    {{-- Comprobante de pago --}}
                    <div class="sm:col-span-2">
                        <p class="text-xs text-gray-400 dark:text-slate-500 font-medium uppercase tracking-wide mb-2">Comprobante de Pago</p>
                        <div id="modal-sol-comprobante-wrap"
                            class="border border-gray-200 dark:border-emerald-950/20 rounded-xl overflow-hidden bg-gray-50 dark:bg-slate-950 flex items-center justify-center h-56">
                            {{-- filled by JS --}}
                        </div>
                        <a id="modal-sol-comprobante-link" href="#" target="_blank"
                            class="hidden mt-1.5 text-xs text-green-600 dark:text-emerald-400 hover:underline">Ver imagen original</a>
                    </div>

                </div>

                {{-- FOOTER --}}
                <div
                    class="bg-gray-50 dark:bg-slate-950 border-t border-gray-100 dark:border-emerald-950/30 px-6 py-4 rounded-b-2xl flex flex-wrap items-center justify-between gap-2">
                    {{-- Botón Reportar (Eliminar) --}}
                    <form id="formReportar" action="" method="POST"
                        onsubmit="if(confirm('¿Estás seguro? Esta acción eliminará la solicitud y el registro de la empresa. No se puede deshacer.')) { sendWhatsApp('reject'); return true; } return false;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" id="btnReportar"
                            class="inline-flex items-center gap-1 bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-xl text-sm transition cursor-pointer shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                            </svg>
                            Reportar
                        </button>
                    </form>

                    <div class="flex gap-2 items-center">
                        {{-- Botón Aprobar: visible solo si está pendiente --}}
                        <form id="formAprobar" action="" method="POST" onsubmit="sendWhatsApp('approve')">
                            @csrf
                            @method('PUT')
                            <button id="btnAprobar" type="submit"
                                class="hidden inline-flex items-center gap-1 bg-gradient-to-r from-green-500 to-emerald-400 hover:from-green-600 hover:to-emerald-500 text-white font-bold py-2 px-5 rounded-xl text-sm transition cursor-pointer shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                                Aprobar Solicitud
                            </button>
                        </form>

                        {{-- Badge Aprobada: visible solo si ya fue aprobada --}}
                        <span id="badgeAprobada"
                            class="hidden inline-flex items-center gap-1 bg-green-100 dark:bg-emerald-950/30 text-green-700 dark:text-emerald-400 font-semibold py-2 px-4 rounded-xl text-sm border border-green-300 dark:border-emerald-900/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            Aprobada
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Hidden element to pass data to JS without syntax errors -->
    <div id="solicitudes-data" data-json="{{ json_encode($solicitudes->items()) }}" class="hidden"></div>

    <script>
        // Retrieve data safely from DOM
        const solicitudesData = document.getElementById('solicitudes-data').getAttribute('data-json');
        const solicitudes = solicitudesData ? JSON.parse(solicitudesData) : [];
        const baseUrl = "{{ url('/dashboard/solicitudes') }}";
        let currentPhoneNumber = '';

        function sendWhatsApp(type) {
            if (!currentPhoneNumber) return;

            let message = '';
            if (type === 'approve') {
                message = "¡Hola! 👋🌱\n\nNos complace informarte que tu solicitud de compra en Gestión de Cultivo ha sido *aprobada* ✅.\n\nEn breve uno de nuestros asesores se pondrá en contacto contigo para continuar con el proceso.\n\n¡Gracias por confiar en nosotros! 🤝";
            } else if (type === 'reject') {
                message = "Hola 👋🌱\n\nHemos revisado tu solicitud de compra en Gestión de Cultivo, pero presenta *inconsistencias en la información suministrada* ❌.\n\nPor esta razón, no fue posible procesarla. Te recomendamos verificar los datos y realizar nuevamente la solicitud.\n\nSi necesitas ayuda, estaremos atentos a apoyarte 🤝.";
            }

            const encodedMessage = encodeURIComponent(message);
            const whatsappUrl = `https://wa.me/57${currentPhoneNumber}?text=${encodedMessage}`;
            window.open(whatsappUrl, '_blank');
        }

        function openModal(id) {
            const solicitud = solicitudes.find(s => s.id_solicitud == id);
            if (!solicitud) return;

            const modal = document.getElementById('modalDetalle');
            const empresa = solicitud.empresa || {};
            const fullComprobanteUrl = "{{ asset('') }}" + solicitud.comprobante_pago;

            // Avatar
            const nombreEmpresa = empresa.nombre_empresa || 'N/A';
            document.getElementById('modal-sol-avatar').innerText = nombreEmpresa.substring(0, 2).toUpperCase();

            // Basic fields
            document.getElementById('modal-sol-empresa').innerText = nombreEmpresa;
            document.getElementById('modal-sol-nit').innerText = solicitud.id_empresa || 'N/A';
            document.getElementById('modal-sol-repre').innerText = empresa.nombre_repre_legal || 'N/A';
            document.getElementById('modal-sol-correo').innerText = empresa.correo || 'N/A';
            document.getElementById('modal-sol-telefono').innerText = empresa.telefono || 'N/A';
            currentPhoneNumber = empresa.telefono || '';

            // Plan
            document.getElementById('modal-sol-plan').innerText = solicitud.tipo_licencia ? solicitud.tipo_licencia.nombre_licencia : 'N/A';
            document.getElementById('modal-sol-precio').innerText = solicitud.tipo_licencia ?
                '$' + new Intl.NumberFormat('es-CO').format(solicitud.tipo_licencia.precio) :
                '';

            // Fecha
            const fecha = new Date(solicitud.fecha_solicitud);
            document.getElementById('modal-sol-fecha').innerText = fecha.toLocaleDateString('es-ES', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                timeZone: 'America/Bogota'
            });

            // Estado badge
            const estadoEl = document.getElementById('modal-sol-estado');
            const esPendiente = solicitud.id_estado == 1;
            estadoEl.innerHTML = esPendiente ?
                '<span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-yellow-100 dark:bg-amber-950/30 text-yellow-800 dark:text-amber-400 border border-amber-200 dark:border-amber-900/30">Pendiente</span>' :
                '<span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 dark:bg-emerald-950/30 text-green-800 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-900/30">Aprobada</span>';

            // Comprobante
            const comprobanteWrap = document.getElementById('modal-sol-comprobante-wrap');
            const comprobanteLink = document.getElementById('modal-sol-comprobante-link');
            if (solicitud.comprobante_pago) {
                comprobanteWrap.innerHTML = `<img src="${fullComprobanteUrl}" alt="Comprobante" class="max-w-full max-h-full object-contain">`;
                comprobanteLink.href = fullComprobanteUrl;
                comprobanteLink.classList.remove('hidden');
            } else {
                comprobanteWrap.innerHTML = '<span class="text-gray-400 italic text-sm">Sin comprobante de pago (registro manual)</span>';
                comprobanteLink.classList.add('hidden');
            }

            // Configurar formulario Reportar
            document.getElementById('formReportar').action = baseUrl + '/' + solicitud.id_solicitud;

            // Configurar formulario Aprobar
            const formAprobar = document.getElementById('formAprobar');
            const btnAprobar = document.getElementById('btnAprobar');
            const badgeAprobada = document.getElementById('badgeAprobada');
            const btnReportar = document.getElementById('btnReportar');

            if (esPendiente) {
                formAprobar.action = baseUrl + '/' + solicitud.id_solicitud + '/aprobado';
                btnAprobar.style.display = 'inline-flex';
                badgeAprobada.style.display = 'none';
                btnReportar.disabled = false;
                btnReportar.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                btnAprobar.style.display = 'none';
                badgeAprobada.style.display = 'inline-flex';
                btnReportar.disabled = true;
                btnReportar.classList.add('opacity-50', 'cursor-not-allowed');
            }

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('modalDetalle').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function copyToClipboard(text, btn) {
            if (!text) return;
            navigator.clipboard.writeText(text).then(() => {
                const iconCopy = btn.querySelector('.icon-copy');
                const iconCheck = btn.querySelector('.icon-check');
                if (iconCopy) iconCopy.classList.add('hidden');
                if (iconCheck) iconCheck.classList.remove('hidden');
                setTimeout(() => {
                    if (iconCopy) iconCopy.classList.remove('hidden');
                    if (iconCheck) iconCheck.classList.add('hidden');
                }, 2000);
            });
        }
    </script>
    <!-- EXPORT SOLICITUDES MODAL -->
    <div id="exportSolicitudesModal" class="fixed inset-0 z-[9999] hidden" aria-modal="true">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/50"
            onclick="document.getElementById('exportSolicitudesModal').classList.add('hidden')"></div>
        <div class="relative flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-sm z-10">
                <!-- Header -->
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                        <h3 class="text-base font-semibold text-gray-900">Descargar Reporte de Solicitudes</h3>
                    </div>
                    <button onclick="document.getElementById('exportSolicitudesModal').classList.add('hidden')"
                        class="text-gray-400 hover:text-gray-600 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <!-- Body -->
                <form method="GET" action="{{ route('solicitudes.exportar') }}">
                        <div class="px-6 py-5 space-y-4 bg-white dark:bg-slate-900 transition-colors duration-300">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Selecciona el mes y año para filtrar el reporte de solicitudes de
                                compra.</p>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-400 mb-1">Mes</label>
                                <select name="month"
                                    class="w-full border border-gray-300 dark:border-emerald-900/30 bg-white dark:bg-slate-950 text-gray-700 dark:text-emerald-50 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500">
                                    <option value="">Todo el año</option>
                                    @foreach(range(1, 12) as $m)
                                        <option value="{{ $m }}" {{ now()->month == $m ? 'selected' : '' }}>
                                            {{ ucfirst(\Carbon\Carbon::createFromDate(2024, (int) $m, 1)->locale('es')->monthName) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-400 mb-1">Año</label>
                                <select name="year"
                                    class="w-full border border-gray-300 dark:border-emerald-900/30 bg-white dark:bg-slate-950 text-gray-700 dark:text-emerald-50 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500">
                                    @foreach(range(now()->year, 2024) as $y)
                                        <option value="{{ $y }}" {{ now()->year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- Footer -->
                        <div class="px-6 py-4 bg-gray-50 dark:bg-slate-950 rounded-b-xl flex justify-end gap-3 border-t border-gray-200 dark:border-emerald-950/30">
                            <button type="button"
                                onclick="document.getElementById('exportSolicitudesModal').classList.add('hidden')"
                                class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-slate-400 bg-white dark:bg-slate-900 border border-gray-300 dark:border-emerald-900/30 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-800 cursor-pointer transition-colors">Cancelar</button>
                            <button type="submit"
                                class="flex items-center gap-2 px-4 py-2 text-sm font-bold text-white bg-green-600 hover:bg-green-700 rounded-lg transition cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                            Descargar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection