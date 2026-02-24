@extends('layouts.barra_lateral')

@section('content')

    <div class="space-y-6">

        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Gestión de Licencias</h1>
                <p class="text-sm text-gray-500">Administra las licencias y asignaciones del sistema</p>
            </div>
            <div class="flex items-center gap-2">
                <!-- REPORT BUTTON -->
                <button onclick="document.getElementById('exportModal').classList.remove('hidden')"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 shadow-sm transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    Exportar Reporte
                </button>

                <span
                    class="text-sm text-gray-500 bg-white px-3 py-2 rounded shadow-sm border border-gray-100 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4 text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 9v7.5" />
                    </svg>
                    {{ now()->format('d M, Y') }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

            <!-- 1. ASIGNAR LICENCIA FORM (Left Side) -->
            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 sticky top-4">
                    <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-4">
                        <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Asignar Licencia</h3>
                            <p class="text-xs text-gray-400">Vincular plan a empresa</p>
                        </div>
                    </div>

                    <form action="{{ route('licencias.asignar') }}" method="POST" class="space-y-5">
                        @csrf

                        {{-- Campo NIT --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">NIT de la Empresa</label>
                            <div class="relative">
                                <input type="text" id="nitBusqueda" placeholder="Ingrese el NIT..."
                                    class="w-full border border-gray-200 bg-gray-50 rounded-lg p-2.5 text-sm focus:ring-green-500 focus:border-green-500 transition-colors pr-10"
                                    autocomplete="off">
                                <div id="nitSpinner" class="hidden absolute right-3 top-3">
                                    <svg class="animate-spin h-4 w-4 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                                    </svg>
                                </div>
                            </div>
                            {{-- Campo oculto que envía el id_empresa real --}}
                            <input type="hidden" id="id_empresa" name="id_empresa">
                        </div>

                        {{-- Info empresa encontrada --}}
                        <div id="empresaInfo" class="hidden p-3 bg-green-50 rounded-lg border border-green-100">
                            <p class="text-xs font-semibold text-green-800" id="empresaNombre"></p>
                            <p class="text-xs text-green-600" id="empresaNit"></p>
                        </div>

                        {{-- Empresa no encontrada --}}
                        <div id="empresaNoEncontrada" class="hidden p-3 bg-red-50 rounded-lg border border-red-100">
                            <p class="text-xs text-red-700">No se encontró ninguna empresa con ese NIT.</p>
                        </div>

                        {{-- Plan (readonly, se llena automáticamente) --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Plan de Licencia</label>
                            <div class="relative">
                                <input type="text" id="planNombre"
                                    class="w-full border border-gray-200 bg-gray-100 rounded-lg p-2.5 text-sm text-gray-500 cursor-not-allowed"
                                    placeholder="Se llenará automáticamente..." readonly>
                            </div>
                            {{-- Campo oculto que envía el id_tipo_licencia real --}}
                            <input type="hidden" id="id_tipo_licencia" name="id_tipo_licencia">
                        </div>

                        <div class="p-3 bg-blue-50 rounded-lg flex gap-3 items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5 text-blue-500 flex-shrink-0">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                            </svg>
                            <p class="text-xs text-blue-700 leading-relaxed">
                                El plan se asigna automáticamente según la solicitud de la empresa. La fecha de inicio será
                                el día de hoy.
                            </p>
                        </div>

                        <button type="submit" id="btnAsignar" disabled
                            class="w-full bg-green-600 hover:bg-green-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-bold py-3 px-4 rounded-lg transform active:scale-95 transition-all shadow-md hover:shadow-lg flex justify-center items-center gap-2">
                            <span>Confirmar Asignación</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- 2. TABLE AND STATS (Right Side) -->
            <div class="lg:col-span-2 space-y-6">

                <!-- LICENSES TABLE -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                        <h3 class="font-bold text-gray-800">Historial de Licencias</h3>

                        <!-- Search -->
                        <form action="{{ route('dashboard') }}" method="GET" class="relative w-full sm:w-64">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar empresa..."
                                class="w-full pl-10 pr-4 py-2 bg-gray-50 border-none rounded-lg text-sm focus:ring-2 focus:ring-green-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-4 h-4 text-gray-400 absolute left-3 top-2.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                <tr>
                                    <th class="px-6 py-4">Empresa</th>
                                    <th class="px-6 py-4">Plan</th>
                                    <th class="px-6 py-4">Fecha Inicio</th>
                                    <th class="px-6 py-4">Estado</th>
                                    <th class="px-6 py-4 text-right">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($licencasTable as $licencia)
                                    <tr class="hover:bg-gray-50 transition-colors group">
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-gray-900">
                                                {{ $licencia->empresa->nombre_empresa ?? 'N/A' }}
                                            </div>
                                            <div class="text-xs text-gray-400">NIT: {{ $licencia->id_empresa }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $licencia->tipoLicencia->nombre_licencia ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            {{ \Carbon\Carbon::parse($licencia->fecha_inicio)->format('d M, Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @php
                                                $statusClass = match ($licencia->id_estado) {
                                                    3 => 'bg-green-100 text-green-700',
                                                    1 => 'bg-yellow-100 text-yellow-700',
                                                    2 => 'bg-red-100 text-red-700',
                                                    default => 'bg-gray-100 text-gray-700'
                                                };
                                                $statusText = match ($licencia->id_estado) {
                                                    3 => 'Activa',
                                                    1 => 'Pendiente',
                                                    2 => 'Inactiva',
                                                    default => 'Desconocido'
                                                };
                                            @endphp
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">
                                                <span class="w-1.5 h-1.5 rounded-full bg-current mr-1.5"></span>
                                                {{ $statusText }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <button data-licencia="{{ json_encode($licencia) }}"
                                                onclick="openEditModal(JSON.parse(this.getAttribute('data-licencia')))"
                                                class="text-gray-400 hover:text-green-600 transition-colors p-2 rounded-full hover:bg-green-50">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                            <div class="flex flex-col items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-300">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                                </svg>
                                                <p>No se encontraron licencias recientes</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="flex justify-center mt-6">
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
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-sm z-10">
                <!-- Header -->
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                        <h3 class="text-base font-semibold text-gray-900">Descargar Reporte de Licencias</h3>
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
                    <div class="px-6 py-4 bg-gray-50 rounded-b-xl flex justify-end gap-3 border-t border-gray-200">
                        <button type="button" onclick="document.getElementById('exportModal').classList.add('hidden')"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">Cancelar</button>
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
                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">

                    <form id="editForm" method="POST" action="">
                        @csrf
                        @method('PUT')

                        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                    <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Editar
                                        Licencia</h3>
                                    <div class="mt-4 space-y-4">

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Plan de Licencia</label>
                                            <select id="edit_id_tipo_licencia" name="id_tipo_licencia"
                                                onchange="updateEditFechaFin()"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
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
                                                <label class="block text-sm font-medium text-gray-700">Fecha de
                                                    Inicio</label>
                                                <input type="date" id="edit_fecha_inicio" name="fecha_inicio" readonly
                                                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm cursor-not-allowed">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Fecha de Fin</label>
                                                <input type="date" id="edit_fecha_fin" disabled
                                                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm sm:text-sm text-gray-500 cursor-not-allowed">
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Estado</label>
                                            <select id="edit_id_estado" name="id_estado" disabled
                                                class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm cursor-not-allowed">
                                                <option value="3">Activa</option>
                                                <option value="1">Pendiente</option>
                                                <option value="2">Inactiva</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                            <button type="submit"
                                class="inline-flex w-full justify-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 sm:ml-3 sm:w-auto">Guardar
                                Cambios</button>
                            <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')"
                                class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancelar</button>
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
        document.addEventListener('DOMContentLoaded', function () {

            // ===== AUTO-FILL NIT -> EMPRESA + PLAN =====
            const nitInput = document.getElementById('nitBusqueda');
            const idEmpresaHidden = document.getElementById('id_empresa');
            const idTipoLicenciaHidden = document.getElementById('id_tipo_licencia');
            const planNombreInput = document.getElementById('planNombre');
            const empresaInfo = document.getElementById('empresaInfo');
            const empresaNoEncontrada = document.getElementById('empresaNoEncontrada');
            const empresaNombreEl = document.getElementById('empresaNombre');
            const empresaNitEl = document.getElementById('empresaNit');
            const btnAsignar = document.getElementById('btnAsignar');
            const spinner = document.getElementById('nitSpinner');

            // Mapa de tipos de licencia para mostrar el nombre
            const tiposLicenciasDataStr = document.getElementById('tipos-licencia-data').getAttribute('data-json');
            const tiposLicencia = tiposLicenciasDataStr ? JSON.parse(tiposLicenciasDataStr) : {};

            let debounceTimer;

            nitInput.addEventListener('input', function () {
                clearTimeout(debounceTimer);
                const nit = this.value.trim();

                // Resetear estado
                empresaInfo.classList.add('hidden');
                empresaNoEncontrada.classList.add('hidden');
                idEmpresaHidden.value = '';
                idTipoLicenciaHidden.value = '';
                planNombreInput.value = '';
                btnAsignar.disabled = true;

                if (nit.length < 3) return;

                debounceTimer = setTimeout(() => {
                    spinner.classList.remove('hidden');

                    fetch(`/empresa/buscar/${nit}`)
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