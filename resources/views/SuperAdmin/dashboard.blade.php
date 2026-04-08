@extends('layouts.barra_lateral')

@section('content')

<div class="space-y-6">

    <div class="relative flex flex-col lg:flex-row lg:items-center justify-between gap-6 pb-8 border-b border-slate-100">

        <div class="relative">
            <div class="flex items-center gap-2 mb-2">
                <span class="flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-2 w-2 rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                <span class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.3em] bg-emerald-50 px-3 py-1 rounded-full">
                    Sistema de Control Real-time
                </span>
            </div>

            <h1 class="text-4xl md:text-5xl font-black text-green-700 dark:text-emerald-500 tracking-tighter">
                Gestión de <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-green-500">Licencias</span>
                <span class="text-[#006b58] dark:text-emerald-400">.</span>
            </h1>

            <p class="text-slate-500 dark:text-slate-400 font-medium mt-2 max-w-md leading-relaxed">
                Administra, vincula y monitorea los estados empresariales y planes activos de <span class="font-bold text-slate-700 dark:text-slate-200">AgriManager</span>.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-4">

            <div class="hidden md:flex flex-col items-end">
                <span class="text-[10px] font-bold text-gray-400 dark:text-slate-500 uppercase">Fecha de corte</span>
                <span class="text-sm font-semibold text-slate-700 dark:text-slate-300 italic">{{ now()->format('d M, Y') }}</span>
            </div>

            <button id="downloadPdfBtn"
                onclick="document.getElementById('exportModal').classList.remove('hidden')"
                class="group inline-flex items-center justify-center
           h-11 px-6
           text-sm font-bold uppercase tracking-wider
           text-white rounded-xl
           transition-all duration-300
           bg-gradient-to-r from-[#34d399] via-[#22c55e] to-[#16a34a]
           hover:from-[#22c55e] hover:via-[#16a34a] hover:to-[#15803d]
           shadow-md hover:shadow-lg
           active:scale-95">

                <svg class="w-4 h-4 mr-2 transition-transform group-hover:rotate-6"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>

                Exportar Informe
            </button>

        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

        <!-- 1. ASIGNAR LICENCIA FORM (Left Side) -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-slate-900 p-8 rounded-[2rem] shadow-xl shadow-slate-200/60 dark:shadow-none border border-slate-100 dark:border-emerald-900/10 sticky top-4 transition-colors duration-300">
                <div class="flex items-center gap-4 mb-8 border-b border-slate-50 dark:border-emerald-950/20 pb-6">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-r from-[#34d399] via-[#22c55e] to-[#16a34a] hover:from-[#22c55e] hover:via-[#16a34a] hover:to-[#15803d] flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold text-green-800 dark:text-emerald-100 tracking-tight">Asignar <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-green-500">Licencia</span></h3>
                        <p class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mt-0.5">Vincular plan a empresa activa</p>
                    </div>
                </div>

                <form action="{{ route('licencias.asignar') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- Campo NIT --}}
                    <div>
                        <label class="block text-xs font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2 ml-1">NIT de la Empresa</label>
                        <div class="relative group">
                            <input type="text" id="nitBusqueda" placeholder="Ingrese el NIT..."
                                class="w-full border-2 border-slate-50 dark:border-emerald-950/20 bg-slate-50 dark:bg-slate-950 rounded-2xl p-4 text-sm font-medium dark:text-emerald-50 focus:bg-white dark:focus:bg-slate-900 focus:border-[#006b58] dark:focus:border-emerald-500 focus:ring-4 focus:ring-emerald-50 dark:focus:ring-emerald-500/10 transition-all outline-none pr-12"
                                autocomplete="off">

                            {{-- Spinner --}}
                            <div id="nitSpinner" class="hidden absolute right-4 top-4">
                                <svg class="animate-spin h-5 w-5 text-[#006b58]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                                </svg>
                            </div>
                        </div>
                        <input type="hidden" id="id_empresa" name="id_empresa">
                    </div>

                    {{-- ALERTAS (Mantienen tus IDs para el JS) --}}
                    <div id="empresaInfo" class="hidden p-4 bg-gradient-to-r from-emerald-50 to-green-50/50 dark:from-emerald-900/10 dark:to-emerald-950/10 rounded-xl border border-emerald-200/60 dark:border-emerald-500/20 shadow-sm flex items-start gap-3.5 transition-all">
                        <div class="p-2.5 bg-emerald-100 dark:bg-emerald-950 rounded-lg shadow-inner mt-0.5">
                            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-extrabold text-emerald-900 dark:text-emerald-50" id="empresaNombre"></p>
                            <p class="text-xs font-medium text-emerald-600 dark:text-emerald-500 mt-0.5" id="empresaNit"></p>
                        </div>
                    </div>

                    <div id="empresaNoEncontrada" class="hidden p-4 bg-gradient-to-r from-red-50 to-rose-50/50 rounded-xl border border-red-200/60 shadow-sm flex items-center gap-3.5 transition-all">
                        <div class="p-2.5 bg-red-100 rounded-lg shadow-inner">
                            <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <p class="text-sm font-bold text-red-800">No se encontró ninguna empresa con ese NIT.</p>
                    </div>

                    <div id="empresaConLicencia" class="hidden p-4 bg-gradient-to-r from-amber-50 to-orange-50/50 dark:from-amber-900/10 dark:to-amber-950/10 rounded-xl border border-amber-200/60 dark:border-amber-500/20 shadow-sm flex items-start gap-3.5 transition-all">
                        <div class="p-2.5 bg-amber-100 dark:bg-amber-950 rounded-lg shadow-inner mt-0.5">
                            <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-extrabold text-amber-900 dark:text-emerald-50">Atención</p>
                            <p class="text-xs font-medium text-amber-700 dark:text-amber-500 mt-1">Esta empresa ya cuenta con una licencia Asignada.</p>
                        </div>
                    </div>

                    <div id="solicitudNoAprobada" class="hidden p-4 bg-gradient-to-r from-rose-50 to-pink-50/30 rounded-xl border border-rose-200/60 shadow-sm flex items-start gap-3.5 transition-all">
                        <div class="p-2.5 bg-rose-100 rounded-lg shadow-inner mt-0.5">
                            <svg class="w-5 h-5 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-extrabold text-rose-900">Acción Requerida</p>
                            <p class="text-xs font-medium text-rose-700 mt-1 leading-relaxed">Debes aprobar la solicitud de la empresa antes de asignarle una licencia.</p>
                        </div>
                    </div>

                    {{-- Plan --}}
                    <div>
                        <label class="block text-xs font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2 ml-1">Plan de Licencia</label>
                        <input type="text" id="planNombre"
                            class="w-full bg-slate-100 dark:bg-slate-950 border-none rounded-2xl p-4 text-sm text-slate-400 dark:text-slate-500 font-bold italic cursor-not-allowed"
                            placeholder="Se llenará automáticamente..." readonly>
                        <input type="hidden" id="id_tipo_licencia" name="id_tipo_licencia">
                    </div>

                    {{-- Nota Informativa --}}
                    <div class="p-4 bg-blue-50/50 dark:bg-blue-900/10 rounded-2xl flex gap-3 items-start border border-blue-100/50 dark:border-blue-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-blue-500 dark:text-blue-400 flex-shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                        <p class="text-[11px] text-blue-700 dark:text-blue-400 font-medium leading-relaxed">
                            El plan se asigna automáticamente según la solicitud. La vigencia inicia hoy.
                        </p>
                    </div>

                    <button type="submit" id="btnAsignar" disabled
                        class="w-full group relative flex items-center justify-center gap-3 bg-gradient-to-r from-[#34d399] via-[#22c55e] to-[#16a34a] hover:from-[#22c55e] hover:via-[#16a34a] hover:to-[#15803d] disabled:from-emerald-100 disabled:via-emerald-50 disabled:to-green-100 dark:disabled:from-slate-800 dark:disabled:to-slate-900 disabled:shadow-none disabled:text-emerald-400/80 dark:disabled:text-slate-700 disabled:cursor-not-allowed text-white font-black py-4 rounded-2xl shadow-xl shadow-emerald-200/50 dark:shadow-none transition-all transform hover:-translate-y-0.5 active:scale-95 uppercase tracking-widest text-xs cursor-pointer">
                        <span>Confirmar Asignación</span>
                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- 2. TABLE AND STATS (Right Side) -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-slate-900 rounded-[2rem] shadow-sm border border-slate-100 dark:border-emerald-900/10 overflow-hidden transition-colors duration-300">
                <div class="p-8 border-b border-slate-50 dark:border-emerald-950/20 flex flex-col sm:flex-row justify-between items-center gap-6 bg-slate-50/30 dark:bg-slate-950/30">
                    <h3 class="text-xl font-black tracking-tight">

                        <span class="text-slate-800 dark:text-emerald-50">
                            Historial
                        </span>

                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-green-500">
                            de Licencias
                        </span>

                    </h3>

                    <form action="{{ route('dashboard') }}" method="GET" class="relative w-full sm:w-80">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por empresa o NIT..."
                            class="w-full pl-12 pr-4 py-3 bg-white dark:bg-slate-950 border-none dark:border dark:border-emerald-900/20 rounded-2xl shadow-sm text-sm dark:text-emerald-50 focus:ring-2 focus:ring-[#006b58]/20 transition-all">
                        <svg class="w-5 h-5 text-slate-400 absolute left-4 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2.5" />
                        </svg>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50/50 dark:bg-slate-950/50 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">
                            <tr>
                                <th class="px-8 py-5">Empresa</th>
                                <th class="px-8 py-5">Plan de Servicio</th>
                                <th class="px-8 py-5">Fecha Inicio</th>
                                <th class="px-8 py-5">Estado Actual</th>
                                <th class="px-8 py-5 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 dark:divide-emerald-950/20">
                            @forelse($licencasTable as $licencia)
                            <tr class="hover:bg-emerald-50/30 dark:hover:bg-emerald-500/5 transition-colors group">
                                <td class="px-8 py-5">
                                    <div class="font-bold text-slate-800 dark:text-emerald-50 group-hover:text-[#006b58] dark:group-hover:text-emerald-400 transition-colors">
                                        {{ $licencia->empresa->nombre_empresa ?? 'N/A' }}
                                    </div>
                                    <div class="text-[10px] font-bold text-slate-400 dark:text-slate-500 tracking-widest mt-0.5">NIT: {{ $licencia->id_empresa }}</div>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase bg-indigo-50 dark:bg-indigo-950/30 text-indigo-600 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-900/30">
                                        {{ $licencia->tipoLicencia->nombre_licencia ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="text-sm font-bold text-slate-600 dark:text-slate-400">
                                        {{ \Carbon\Carbon::parse($licencia->fecha_inicio)->format('d M, Y') }}
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    @php
                                    $statusClass = match ($licencia->id_estado) {
                                    3 => 'bg-emerald-100 dark:bg-emerald-950/30 text-emerald-700 dark:text-emerald-400 border-emerald-200 dark:border-emerald-900/30',
                                    1 => 'bg-amber-100 dark:bg-amber-950/30 text-amber-700 dark:text-amber-400 border-amber-200 dark:border-amber-900/30',
                                    2 => 'bg-rose-100 dark:bg-rose-950/30 text-rose-700 dark:text-rose-400 border-rose-200 dark:border-rose-900/30',
                                    default => 'bg-slate-100 dark:bg-slate-950/30 text-slate-700 dark:text-slate-400 border-slate-200 dark:border-slate-900/30'
                                    };
                                    $statusText = match ($licencia->id_estado) { 3 => 'Activa', 1 => 'Pendiente', 2 => 'Inactiva', default => 'Desconocido' };
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-black uppercase border {{ $statusClass }}">
                                        <span class="w-1.5 h-1.5 rounded-full bg-current mr-2 animate-pulse"></span>
                                        {{ $statusText }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <button data-licencia="{{ json_encode($licencia) }}"
                                        onclick="openEditModal(JSON.parse(this.getAttribute('data-licencia')))"
                                        class="p-2.5 bg-white dark:bg-slate-950 border border-slate-200 dark:border-emerald-900/20 rounded-xl text-slate-400 dark:text-slate-500 hover:text-[#006b58] dark:hover:text-emerald-400 hover:border-[#006b58] dark:hover:border-emerald-500 hover:shadow-lg dark:hover:shadow-emerald-500/10 transition-all active:scale-90">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-8 bg-slate-50/30 dark:bg-slate-950/30 flex justify-center border-t border-slate-50 dark:border-emerald-950/20">
                    {{ $licencasTable->withQueryString()->links() }}
                </div>
            </div>
        </div>

    </div>

</div>

<!-- EXPORT MODAL -->
<div id="exportModal" class="fixed inset-0 z-[9999] hidden" aria-modal="true">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/50" onclick="document.getElementById('exportModal').classList.add('hidden')">
    </div>
    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-2xl w-full max-w-sm z-10 border border-transparent dark:border-emerald-900/20 transition-colors duration-300">
            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-emerald-950/30">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600 dark:text-emerald-400" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                    <h3 class="text-base font-semibold text-gray-900 dark:text-emerald-50">Descargar Reporte</h3>
                </div>
                <button onclick="document.getElementById('exportModal').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-600 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <!-- Body -->
            <form action="{{ route('licencias.exportar') }}" method="GET">
                <div class="px-6 py-5 space-y-4">
                    <p class="text-sm text-gray-500">Selecciona el mes y año para filtrar el reporte de licencias
                        asignadas.</p>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mes</label>
                        <select name="month"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500">
                            <option value="">Todo el año</option>
                            @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ now()->month == $m ? 'selected' : '' }}>
                                {{ ucfirst(\Carbon\Carbon::createFromDate(2024, (int) $m, 1)->locale('es')->monthName) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Año</label>
                        <select name="year"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500">
                            @foreach(range(now()->year, 2024) as $y)
                            <option value="{{ $y }}" {{ now()->year == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- Footer -->
                <div class="px-6 py-4 bg-gray-50 dark:bg-slate-950 rounded-b-xl flex justify-end gap-3 border-t border-gray-200 dark:border-emerald-950/30">
                    <button type="button" onclick="document.getElementById('exportModal').classList.add('hidden')"
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

<!-- EDIT MODAL -->
<div id="editModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-lg bg-white dark:bg-slate-900 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-transparent dark:border-emerald-950/30">

                <form id="editForm" method="POST" action="">
                    @csrf
                    @method('PUT')

                    <div class="bg-white dark:bg-slate-900 px-4 pb-4 pt-5 sm:p-6 sm:pb-4 transition-colors duration-300">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-green-100 dark:bg-emerald-950 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-green-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-emerald-50" id="modal-title">Editar
                                    Licencia</h3>
                                <div class="mt-4 space-y-4">

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-400">Plan de Licencia</label>
                                        <select id="edit_id_tipo_licencia" name="id_tipo_licencia"
                                            onchange="updateEditFechaFin()"
                                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-emerald-900/30 dark:bg-slate-950 dark:text-emerald-50 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm transition-colors">
                                            @foreach($tiposLicencia as $tipo)
                                            @php
                                            $meses = (int) filter_var($tipo->tiempo, FILTER_SANITIZE_NUMBER_INT);
                                            if (stripos($tipo->tiempo, 'año') !== false || stripos($tipo->tiempo, 'year') !== false) {
                                            $meses = $meses * 12;
                                            }
                                            if ($meses == 0)
                                            $meses = 12;
                                            @endphp
                                            <option value="{{ $tipo->id_tipo_licencia }}" data-meses="{{ $meses }}">
                                                {{ $tipo->nombre_licencia }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-400">Fecha de
                                                Inicio</label>
                                            <input type="date" id="edit_fecha_inicio" name="fecha_inicio" readonly
                                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-emerald-900/10 bg-gray-100 dark:bg-slate-950 text-gray-500 dark:text-slate-500 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm cursor-not-allowed">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-400">Fecha de Fin</label>
                                            <input type="date" id="edit_fecha_fin" disabled
                                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-emerald-900/10 bg-gray-100 dark:bg-slate-950 shadow-sm sm:text-sm text-gray-500 dark:text-slate-600 cursor-not-allowed">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-400">Estado</label>
                                        <select id="edit_id_estado" name="id_estado" disabled
                                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-emerald-900/10 bg-gray-100 dark:bg-slate-950 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm cursor-not-allowed text-gray-500">
                                            <option value="3">Activa</option>
                                            <option value="1">Pendiente</option>
                                            <option value="2">Inactiva</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-slate-950 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 border-t border-gray-100 dark:border-emerald-950/30">
                        <button type="submit"
                            class="inline-flex w-full justify-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 sm:ml-3 sm:w-auto transition-colors">Guardar
                            Cambios</button>
                        <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')"
                            class="mt-3 inline-flex w-full justify-center rounded-md bg-white dark:bg-slate-900 px-3 py-2 text-sm font-semibold text-gray-900 dark:text-slate-400 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-emerald-900/30 hover:bg-gray-50 dark:hover:bg-slate-800 sm:mt-0 sm:w-auto transition-colors">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




@if(session('success'))
<div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded shadow-lg animate-fade-in-up z-50">
    <div class="flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        {{ session('success') }}
    </div>
</div>
@endif

@if($errors->any())
<div class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded shadow-lg z-50">
    <ul class="list-disc pl-5">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- Hidden element to pass data to JS safely -->
<div id="tipos-licencia-data" data-json="{{ json_encode($tiposLicencia->keyBy('id_tipo_licencia')) }}" class="hidden">
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // ===== AUTO-FILL NIT -> EMPRESA + PLAN =====
        const nitInput = document.getElementById('nitBusqueda');
        const idEmpresaHidden = document.getElementById('id_empresa');
        const idTipoLicenciaHidden = document.getElementById('id_tipo_licencia');
        const planNombreInput = document.getElementById('planNombre');
        const empresaInfo = document.getElementById('empresaInfo');
        const empresaNoEncontrada = document.getElementById('empresaNoEncontrada');
        const empresaConLicencia = document.getElementById('empresaConLicencia');
        const solicitudNoAprobada = document.getElementById('solicitudNoAprobada');
        const empresaNombreEl = document.getElementById('empresaNombre');
        const empresaNitEl = document.getElementById('empresaNit');
        const btnAsignar = document.getElementById('btnAsignar');
        const spinner = document.getElementById('nitSpinner');

        // Mapa de tipos de licencia para mostrar el nombre
        const tiposLicenciasDataStr = document.getElementById('tipos-licencia-data').getAttribute('data-json');
        const tiposLicencia = tiposLicenciasDataStr ? JSON.parse(tiposLicenciasDataStr) : {};

        let debounceTimer;

        nitInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            const nit = this.value.trim();

            // Resetear estado
            empresaInfo.classList.add('hidden');
            empresaNoEncontrada.classList.add('hidden');
            empresaConLicencia.classList.add('hidden');
            solicitudNoAprobada.classList.add('hidden');
            idEmpresaHidden.value = '';
            idTipoLicenciaHidden.value = '';
            planNombreInput.value = '';
            btnAsignar.disabled = true;

            if (nit.length < 3) return;

            debounceTimer = setTimeout(() => {
                spinner.classList.remove('hidden');

                fetch(`${window.APP_URL}/empresa/buscar/${nit}`)
                    .then(res => res.json())
                    .then(data => {
                        spinner.classList.add('hidden');

                        if (!data || !data.id_empresa) {
                            empresaNoEncontrada.classList.remove('hidden');
                            return;
                        }

                        // Empresa encontrada
                        idEmpresaHidden.value = data.id_empresa;
                        empresaNombreEl.textContent = data.nombre_empresa;
                        empresaNitEl.textContent = 'NIT: ' + data.id_empresa;
                        empresaInfo.classList.remove('hidden');

                        if (data.tiene_licencia_activa) {
                            empresaConLicencia.classList.remove('hidden');
                            planNombreInput.value = 'Licencia ya activa';
                            btnAsignar.disabled = true;
                            return;
                        }

                        if (!data.solicitud_aprobada && !data.es_creada_admin) {
                            solicitudNoAprobada.classList.remove('hidden');
                            planNombreInput.value = 'Solicitud pendiente de aprobación';
                            btnAsignar.disabled = true;
                            return;
                        }

                        // Llenar plan si existe
                        if (data.id_tipo_licencia && tiposLicencia[data.id_tipo_licencia]) {
                            const tipo = tiposLicencia[data.id_tipo_licencia];
                            idTipoLicenciaHidden.value = data.id_tipo_licencia;
                            planNombreInput.value = tipo.nombre_licencia + ' (' + tipo.tiempo + ')';
                            btnAsignar.disabled = false;
                        } else {
                            planNombreInput.value = 'Sin plan en solicitud';
                            btnAsignar.disabled = true;
                        }
                    })
                    .catch(() => {
                        spinner.classList.add('hidden');
                        empresaNoEncontrada.classList.remove('hidden');
                    });
            }, 500);
        });
    });

    function updateEditFechaFin() {
        const fechaInicio = document.getElementById('edit_fecha_inicio').value;
        const selectPlan = document.getElementById('edit_id_tipo_licencia');
        const selectedOption = selectPlan.options[selectPlan.selectedIndex];

        if (!fechaInicio || !selectedOption) return;

        let meses = parseInt(selectedOption.getAttribute('data-meses')) || 12;

        // Se asume la fecha a medio día para evitar problemas de zona horaria
        let date = new Date(fechaInicio + 'T12:00:00');
        date.setMonth(date.getMonth() + meses);

        const day = ("0" + date.getDate()).slice(-2);
        const month = ("0" + (date.getMonth() + 1)).slice(-2);
        const year = date.getFullYear();

        document.getElementById('edit_fecha_fin').value = `${year}-${month}-${day}`;
    }

    function openEditModal(licencia) {
        const modal = document.getElementById('editModal');
        const form = document.getElementById('editForm');

        // Set Action URL
        form.action = `/dashboard/licencias/${licencia.id_key}`;

        // Fill Data
        document.getElementById('edit_id_tipo_licencia').value = licencia.id_tipo_licencia;

        // Format date for input type="date"
        const date = new Date(licencia.fecha_inicio);
        const day = ("0" + date.getDate()).slice(-2);
        const month = ("0" + (date.getMonth() + 1)).slice(-2);
        const year = date.getFullYear();
        document.getElementById('edit_fecha_inicio').value = `${year}-${month}-${day}`;

        document.getElementById('edit_id_estado').value = licencia.id_estado;

        updateEditFechaFin();

        modal.classList.remove('hidden');
    }
</script>
<style>
    @keyframes fade-in-up {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in-up {
        animation: fade-in-up 0.5s ease-out forwards;
    }
</style>
@endpush