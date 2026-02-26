@extends('layouts.barra_lateral')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Gestión De Empresas</h1>

        <div class="flex items-center gap-4">
            <!-- EXCEL BUTTON -->
            <button onclick="openExcelModal()"
                class="bg-green-600 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-sm flex items-center gap-1 transition transform hover:scale-105 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
                Descargar Excel
            </button>

            <button onclick="openCreateModal()"
                class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center gap-2 cursor-pointer transition transform hover:scale-105">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-3 h-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Nueva Empresa
            </button>

            <button onclick="openAdminModal()"
                class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center gap-2 cursor-pointer transition transform hover:scale-105">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-3 h-3">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3.75 15a9.006 9.006 0 0 1 6-2.25h.008v.008h-.008A9.005 9.005 0 0 1 12.007 15l.006.058c.277 3.394-2.128 6.942-5.717 6.942H6.302c-3.13 0-5.618-2.585-5.98-5.717l-.006-.058Z" />
                </svg>
                Asignar Administrador
            </button>
        </div>
    </div>

    <!-- SEARCH AND FILTER -->
    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 mb-6 relative z-10">
        <form action="{{ route('SuperAdmin.index') }}" method="GET"
            class="flex flex-col lg:flex-row justify-between items-center gap-4">

            <!-- CONTROLES DE BÚSQUEDA -->
            <div class="flex w-full lg:w-1/2 gap-3">
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="search" name="search" value="{{ request('search') }}"
                        class="block w-full pl-11 pr-4 py-2.5 border border-gray-300 rounded-lg leading-5 bg-gray-50 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm transition-colors text-gray-700"
                        placeholder="Buscar por Empresa o NIT...">
                </div>
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 px-6 rounded-lg transition-colors flex items-center gap-2 shadow-sm whitespace-nowrap cursor-pointer">
                    Buscar
                </button>
            </div>

            <!-- FILTROS DE ESTADO -->
            <div class="flex flex-wrap items-center gap-2 w-full lg:w-auto justify-end">
                <a href="{{ route('SuperAdmin.index', ['search' => request('search')]) }}"
                    class="px-4 py-2 text-sm font-medium rounded-lg transition-all {{ !request('status') ? 'bg-gray-800 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200 hover:text-gray-900 border border-transparent' }}">
                    Todas
                </a>
                <a href="{{ route('SuperAdmin.index', ['status' => 'pendiente', 'search' => request('search')]) }}"
                    class="px-4 py-2 text-sm font-medium rounded-lg transition-all {{ request('status') == 'pendiente' ? 'bg-yellow-500 text-white shadow-md hover:bg-yellow-600' : 'bg-yellow-50 text-yellow-700 border border-yellow-200 hover:bg-yellow-100 hover:text-yellow-800' }}">
                    Pendientes
                </a>
                <a href="{{ route('SuperAdmin.index', ['status' => 'activa', 'search' => request('search')]) }}"
                    class="px-4 py-2 text-sm font-medium rounded-lg transition-all {{ request('status') == 'activa' ? 'bg-green-500 text-white shadow-md hover:bg-green-600' : 'bg-green-50 text-green-700 border border-green-200 hover:bg-green-100 hover:text-green-800' }}">
                    Activas
                </a>
                <a href="{{ route('SuperAdmin.index', ['status' => 'bloqueada', 'search' => request('search')]) }}"
                    class="px-4 py-2 text-sm font-medium rounded-lg transition-all {{ request('status') == 'bloqueada' ? 'bg-red-500 text-white shadow-md hover:bg-red-600' : 'bg-red-50 text-red-700 border border-red-200 hover:bg-red-100 hover:text-red-800' }}">
                    Bloqueadas
                </a>
            </div>

        </form>
    </div>

    <!-- COMPANIES TABLE -->
    <div class="bg-white rounded shadow overflow-hidden">
        <div class="p-4 border-b">
            <h3 class="font-bold">Solicitudes de Acceso <span
                    class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded">{{ $stats['nuevas'] }}
                    Pendientes</span></h3>
        </div>

        <table class="w-full text-left">
            <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                <tr>
                    <th class="p-4">Empresa y NIT</th>
                    <th class="p-4">Propietario</th>
                    <th class="p-4">Fecha Registro</th>
                    <th class="p-4">Estado</th>
                    <th class="p-4">Accion</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($empresas as $empresa)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold">
                                    {{ substr($empresa->nombre_empresa, 0, 2) }}
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900">{{ $empresa->nombre_empresa }}</div>
                                    <div class="text-sm text-gray-500">NIT: {{ $empresa->id_empresa }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="font-medium text-gray-900">{{ $empresa->nombre_repre_legal }}</div>
                            <div class="text-sm text-gray-500">{{ $empresa->correo }}</div>
                        </td>
                        <td class="p-4">
                            <div class="font-medium text-gray-900">
                                {{ \Carbon\Carbon::parse($empresa->fecha_creacion)->timezone('America/Bogota')->format('d M, Y') }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($empresa->fecha_creacion)->timezone('America/Bogota')->locale('es')->diffForHumans() }}
                            </div>
                        </td>
                        <td class="p-4">
                            @if($empresa->estado)
                                @php
                                    $color = match ($empresa->estado->id_estado) {
                                        1 => 'text-yellow-700 bg-yellow-100', // pendiente
                                        2 => 'text-red-700 bg-red-100', // bloqueada
                                        3 => 'text-green-700 bg-green-100', // activa
                                        default => 'text-gray-700 bg-gray-100',
                                    };
                                @endphp

                                <span class="px-2 py-1 font-semibold leading-tight rounded-full {{ $color }}">
                                    {{ ucfirst($empresa->estado->nombre_estado) }}
                                </span>
                            @else
                                <span class="px-2 py-1 font-semibold leading-tight text-gray-700 bg-gray-100 rounded-full">
                                    Desconocido
                                </span>
                            @endif
                        </td>

                        <td class="p-4">
                            <div class="flex gap-2">
                                {{-- Botón Activar --}}
                                @if($empresa->id_estado != 3)
                                    @if($empresa->licencia)
                                        <form action="{{ route('SuperAdmin.activar', $empresa->id_empresa) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit"
                                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-xs flex items-center gap-1 cursor-pointer"
                                                onclick="return confirm('¿Estás seguro de activar esta empresa?')">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
                                                </svg>
                                                Activar Acceso
                                            </button>
                                        </form>
                                    @else
                                        <button type="button"
                                            onclick="alert('Debes asignarle una licencia en el Dashboard a esta empresa antes de poder activarla.')"
                                            class="bg-gray-300 text-gray-500 hover:text-gray-600 font-bold py-1 px-3 rounded text-xs flex items-center gap-1 cursor-not-allowed"
                                            title="Requiere asignar licencia">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" class="w-3 h-3">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                            </svg>
                                            Activar Acceso
                                        </button>
                                    @endif
                                @else
                                    <button disabled
                                        class="bg-gray-300 text-gray-500 font-bold py-1 px-3 rounded text-xs flex items-center gap-1 cursor-not-allowed">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                            stroke="currentColor" class="w-3 h-3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                        </svg>
                                        Activa
                                    </button>
                                @endif

                                {{-- Botón Ver Detalles --}}
                                <button type="button" data-empresa="{{ json_encode($empresa) }}"
                                    onclick="openModal(JSON.parse(this.getAttribute('data-empresa')))"
                                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-xs flex items-center gap-1 cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" class="w-3 h-3">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                    Ver Detalles
                                </button>

                                {{-- Botón Editar --}}
                                <button type="button" data-empresa="{{ json_encode($empresa) }}"
                                    onclick="openEditModal(JSON.parse(this.getAttribute('data-empresa')))"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-3 rounded text-xs flex items-center gap-1 cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" class="w-3 h-3">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                    Editar
                                </button>
                            </div>
                            <!-- More actions could be added here -->
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-4 text-center text-gray-500">No se encontraron empresas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="flex justify-center mt-6 p-4">
            {{ $empresas->withQueryString()->links() }}
        </div>
    </div>

    <!-- DETAILS MODAL -->
    <div id="detailsModal" class="fixed inset-0 z-[9999] hidden overflow-y-auto" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 py-6">
            <div class="fixed inset-0 bg-black/40 backdrop-blur-sm" onclick="closeModal()"></div>
            <div class="relative bg-white rounded-2xl text-left shadow-2xl transform transition-all w-full max-w-lg">

                {{-- HEADER --}}
                <div class="bg-gradient-to-r from-green-500 to-emerald-400 px-6 py-5 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-white">Detalles de la Empresa</h3>
                                <p class="text-green-100 text-xs">Información completa del registro</p>
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

                {{-- COMPANY AVATAR + NAME BANNER --}}
                <div class="px-6 py-5 flex items-center gap-4 border-b border-gray-100">
                    <div class="w-14 h-14 rounded-full bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center text-white font-bold text-xl shadow-md"
                        id="modal-avatar"></div>
                    <div>
                        <p class="text-base font-bold text-gray-900" id="modal-nombre"></p>
                        <p class="text-sm text-gray-500">NIT: <span id="modal-nit" class="font-medium text-gray-700"></span>
                        </p>
                    </div>
                    <div class="ml-auto" id="modal-estado"></div>
                </div>

                {{-- DETAILS GRID --}}
                <div class="px-6 py-5 grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <div class="bg-gray-50 rounded-xl p-4 flex items-start gap-3">
                        <div class="mt-0.5 p-2 bg-green-100 rounded-lg">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium">Representante</p>
                            <p class="text-sm font-semibold text-gray-800" id="modal-representante"></p>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4 flex items-start gap-3">
                        <div class="mt-0.5 p-2 bg-green-100 rounded-lg">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium">Teléfono</p>
                            <p class="text-sm font-semibold text-gray-800" id="modal-telefono"></p>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4 flex items-start gap-3">
                        <div class="mt-0.5 p-2 bg-green-100 rounded-lg">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium">Correo</p>
                            <p class="text-sm font-semibold text-gray-800 break-all" id="modal-correo"></p>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4 flex items-start gap-3">
                        <div class="mt-0.5 p-2 bg-green-100 rounded-lg">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium">Dirección</p>
                            <p class="text-sm font-semibold text-gray-800" id="modal-direccion"></p>
                        </div>
                    </div>

                    <div class="sm:col-span-2 bg-gray-50 rounded-xl p-4 flex items-start gap-3">
                        <div class="mt-0.5 p-2 bg-green-100 rounded-lg">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium">Fecha de Registro</p>
                            <p class="text-sm font-semibold text-gray-800" id="modal-fecha"></p>
                        </div>
                    </div>

                </div>

                {{-- FOOTER --}}


            </div>
        </div>
    </div>

    <script>
        function openModal(empresa) {
            document.getElementById('modal-nombre').innerText = empresa.nombre_empresa;
            document.getElementById('modal-nit').innerText = empresa.id_empresa;
            document.getElementById('modal-representante').innerText = empresa.nombre_repre_legal || '-';
            document.getElementById('modal-telefono').innerText = empresa.telefono || '-';
            document.getElementById('modal-correo').innerText = empresa.correo || '-';
            document.getElementById('modal-direccion').innerText = empresa.direccion || '-';

            // Avatar
            document.getElementById('modal-avatar').innerText = (empresa.nombre_empresa || '?').substring(0, 2).toUpperCase();

            // Fecha
            let fechaOriginal = new Date(empresa.fecha_creacion);
            let opcionesFecha = {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                timeZone: 'America/Bogota'
            };
            document.getElementById('modal-fecha').innerText = fechaOriginal.toLocaleDateString('es-ES', opcionesFecha);

            // Estado badge
            const estadoSpan = document.getElementById('modal-estado');
            let estadoText = 'Desconocido';
            let estadoClass = 'text-gray-700 bg-gray-100';

            if (empresa.estado) {
                estadoText = empresa.estado.nombre_estado;
                if (empresa.estado.id_estado == 1) estadoClass = 'text-yellow-700 bg-yellow-100';
                else if (empresa.estado.id_estado == 2) estadoClass = 'text-red-700 bg-red-100';
                else if (empresa.estado.id_estado == 3) estadoClass = 'text-green-700 bg-green-100';
            }

            estadoSpan.innerHTML = `<span class="px-2.5 py-1 text-xs font-semibold leading-tight rounded-full ${estadoClass}">${estadoText}</span>`;

            document.getElementById('detailsModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('detailsModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // -- EXCEL MODAL --
        function openExcelModal() {
            document.getElementById('excelModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeExcelModal() {
            document.getElementById('excelModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    </script>

    @if(session('success'))
        <div
            class="auto-dismiss fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded shadow-lg animate-fade-in-up z-50">
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

    @if(session('error'))
        <div
            class="auto-dismiss fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded shadow-lg animate-fade-in-up z-50">
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                {{ session('error') }}
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="auto-dismiss fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded shadow-lg z-50">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

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

@endsection

<!-- EXCEL MODAL -->
<div id="excelModal" class="fixed inset-0 z-[9999] hidden" aria-modal="true">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/50" onclick="closeExcelModal()"></div>

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
                    <h3 class="text-base font-semibold text-gray-900">Descargar Reporte Excel</h3>
                </div>
                <button onclick="closeExcelModal()" class="text-gray-400 hover:text-gray-600 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Body -->
            <form action="{{ route('SuperAdmin.reporte.excel') }}" method="GET">
                <div class="px-6 py-5 space-y-4">
                    <p class="text-sm text-gray-500">Selecciona el mes y año para filtrar el reporte de empresas
                        registradas.</p>

                    <!-- Mes -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mes</label>
                        <select name="mes"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500">
                            @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}" {{ now()->month == $m ? 'selected' : '' }}>
                                    {{ ucfirst(\Carbon\Carbon::create()->month($m)->locale('es')->monthName) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Año -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Año</label>
                        <select name="anio"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500">
                            @foreach(range(now()->year, 2024) as $y)
                                <option value="{{ $y }}" {{ now()->year == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Footer -->
                <div class="px-6 py-4 bg-gray-50 rounded-b-xl flex justify-end gap-3 border-t border-gray-200">
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

<!-- CREATE EMPRESA MODAL -->
<div id="createModal" class="fixed inset-0 z-[9999] hidden overflow-y-auto" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 py-6">
        <div class="fixed inset-0 bg-black/40 backdrop-blur-sm" onclick="closeCreateModal()"></div>
        <div class="relative bg-white rounded-2xl text-left shadow-2xl transform transition-all w-full max-w-4xl">

            {{-- HEADER --}}
            <div class="bg-gradient-to-r from-green-500 to-emerald-400 px-6 py-5 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                            <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white">Registrar Nueva Empresa</h3>
                            <p class="text-green-100 text-xs">Completa los datos para dar de alta una empresa</p>
                        </div>
                    </div>
                    <button onclick="closeCreateModal()"
                        class="text-white/80 hover:text-white transition-colors p-1 rounded-lg hover:bg-white/10">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- BODY --}}
            <form action="{{ route('empresas.store') }}" method="POST" id="formEmpresa" class="validate-form">
                @csrf
                <div class="px-6 pt-6 pb-4 grid grid-cols-1 md:grid-cols-2 gap-5">

                    <!-- NIT -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0" />
                            </svg>
                            NIT / ID Empresa
                        </label>
                        <input type="text" name="id_empresa" id="create_nit"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-green-400 transition-all"
                            placeholder="Ej: 900123456" required>
                    </div>

                    <!-- Nombre -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Nombre de la Empresa
                        </label>
                        <input type="text" name="nombre_empresa" id="create_nombre"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-green-400 transition-all"
                            placeholder="Ej: AgroTech S.A.S" required>
                    </div>

                    <!-- Representante -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Representante Legal
                        </label>
                        <input type="text" name="nombre_repre_legal" id="create_representante"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-green-400 transition-all"
                            placeholder="Ej: Juan Pérez" required>
                    </div>

                    <!-- Cedula Representante -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0" />
                            </svg>
                            Cédula del Representante
                        </label>
                        <input type="text" name="cedula_repre" id="create_cedula_repre"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-green-400 transition-all"
                            placeholder="Ej: 10234567890" required>
                    </div>

                    <!-- Telefono -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            Teléfono
                        </label>
                        <input type="text" name="telefono" id="create_telefono"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-green-400 transition-all"
                            placeholder="Ej: 3001234567" required>
                    </div>

                    <!-- Correo -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Correo Electrónico
                        </label>
                        <input type="email" name="correo" id="create_correo"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-green-400 transition-all"
                            placeholder="contacto@empresa.com" required>
                        <span class="text-xs text-red-500 mt-1 hidden" id="error_create_correo">Correo inválido</span>
                    </div>

                    <!-- Direccion -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Dirección
                        </label>
                        <input type="text" name="direccion" id="create_direccion"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-green-400 transition-all"
                            placeholder="Ej: Calle 123 # 45-67" required>
                    </div>

                    <!-- Tipo de Licencia -->
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Tipo de Licencia
                        </label>
                        <select name="id_tipo_licencia"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-green-400 transition-all custom-select"
                            required>
                            <option value="">Seleccione un tipo de licencia...</option>
                            @foreach($tiposLicencia as $tipo)
                                <option value="{{ $tipo->id_tipo_licencia }}">{{ $tipo->nombre_licencia }} —
                                    ${{ number_format($tipo->precio, 0, ',', '.') }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- FOOTER --}}
                <div class="bg-gray-50 border-t border-gray-100 px-6 py-4 rounded-b-2xl flex justify-end gap-3">
                    <button type="submit"
                        class="px-6 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-green-500 to-emerald-400 rounded-xl hover:from-green-600 hover:to-emerald-500 transition-all shadow-md hover:shadow-lg cursor-pointer flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Guardar Empresa
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ADMIN MODAL -->
<div id="adminModal" class="fixed inset-0 z-[9999] hidden overflow-y-auto" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 py-6">
        <div class="fixed inset-0 bg-black/40 backdrop-blur-sm" onclick="closeAdminModal()"></div>
        <div class="relative bg-white rounded-2xl text-left shadow-2xl transform transition-all w-full max-w-4xl">

            {{-- HEADER --}}
            <div class="bg-gradient-to-r from-green-500 to-emerald-400 px-6 py-5 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                            <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white">Asignar Administrador</h3>
                            <p class="text-green-100 text-xs">Crea un usuario administrador para gestionar la empresa
                            </p>
                        </div>
                    </div>
                    <button onclick="closeAdminModal()"
                        class="text-white/80 hover:text-white transition-colors p-1 rounded-lg hover:bg-white/10">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- BODY --}}
            <form action="{{ route('administradores.store') }}" method="POST" enctype="multipart/form-data"
                id="formAdmin" class="space-y-6">
                @csrf
                <div class="px-6 pt-6 pb-4 grid grid-cols-1 md:grid-cols-2 gap-5">

                    <!-- Empresa NIT Search -->
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                            Buscar Empresa por NIT
                        </label>
                        <div class="relative">
                            <input type="text" id="admin_nit_busqueda" placeholder="Ingrese el NIT..."
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-green-400 transition-all pr-10"
                                autocomplete="off" required>
                            <div id="adminNitSpinner" class="hidden absolute right-3 top-2.5">
                                <svg class="animate-spin h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                                </svg>
                            </div>
                        </div>
                        <input type="hidden" id="admin_id_empresa" name="id_empresa" required>
                    </div>

                    <!-- Info empresa encontrada -->
                    <div id="adminEmpresaInfo"
                        class="hidden col-span-1 md:col-span-2 p-3 bg-green-50 rounded-xl border border-green-100 flex items-center gap-3">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-green-800" id="adminEmpresaNombre"></p>
                            <p class="text-xs text-green-600" id="adminEmpresaNit"></p>
                        </div>
                    </div>

                    <!-- Empresa no encontrada -->
                    <div id="adminEmpresaNoEncontrada"
                        class="hidden col-span-1 md:col-span-2 p-3 bg-red-50 rounded-xl border border-red-100 flex items-center gap-3">
                        <div class="p-2 bg-red-100 rounded-lg">
                            <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-red-800">No se encontró ninguna empresa con ese NIT.</p>
                    </div>

                    <!-- Empresa Inactiva -->
                    <div id="adminEmpresaInactiva"
                        class="hidden col-span-1 md:col-span-2 p-3 bg-amber-50 rounded-xl border border-amber-100 flex items-center gap-3">
                        <div class="p-2 bg-amber-100 rounded-lg">
                            <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-amber-800">Acción Requerida</p>
                            <p class="text-xs text-amber-700">La empresa debe estar activa para asignarle un
                                administrador. Actívala primero desde la tabla.</p>
                        </div>
                    </div>

                    <!-- Empresa ya tiene administrador -->
                    <div id="adminEmpresaConAdmin"
                        class="hidden col-span-1 md:col-span-2 p-3 bg-yellow-50 rounded-xl border border-yellow-100 flex items-center gap-3">
                        <div class="p-2 bg-yellow-100 rounded-lg">
                            <svg class="w-5 h-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-yellow-800">No permitido</p>
                            <p class="text-xs text-yellow-700">Esta empresa ya tiene un administrador.</p>
                        </div>
                    </div>

                    <!-- Documento -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0" />
                            </svg>
                            Documento de Identidad
                        </label>
                        <input type="text" name="documento" id="admin_documento"
                            class="w-full bg-gray-100 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-400 focus:outline-none cursor-not-allowed transition-all"
                            disabled required>
                    </div>

                    <!-- Nombre Admin -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Nombre Completo
                        </label>
                        <input type="text" name="nombre" id="admin_nombre"
                            class="w-full bg-gray-100 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-400 focus:outline-none cursor-not-allowed transition-all"
                            disabled required>
                    </div>

                    <!-- Correo Admin -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Correo Electrónico
                        </label>
                        <input type="email" name="correo" id="admin_correo"
                            class="w-full bg-gray-100 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-400 focus:outline-none cursor-not-allowed transition-all"
                            disabled required>
                    </div>

                    <!-- Telefono Admin -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            Teléfono
                        </label>
                        <input type="text" name="telefono" id="admin_telefono"
                            class="w-full bg-gray-100 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-400 focus:outline-none cursor-not-allowed transition-all"
                            disabled required>
                    </div>

                    <!-- Password (auto-generated, read-only) -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Contraseña
                            <span
                                class="ml-auto text-xs font-normal text-green-600 bg-green-50 px-2 py-0.5 rounded-full">Generada
                                automáticamente</span>
                        </label>
                        <!-- Hidden input sends the real value -->
                        <input type="hidden" name="contrasena" id="admin_contrasena">
                        <!-- Visual display + copy button -->
                        <div class="relative flex items-center">
                            <input type="text" id="admin_contrasena_display" readonly
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-500 font-mono focus:outline-none cursor-not-allowed tracking-widest transition-all"
                                placeholder="Se generará al buscar el NIT...">
                            <button type="button" id="btnCopiarContrasena" onclick="copiarContrasena()"
                                title="Copiar contraseña"
                                class="absolute right-3 text-gray-400 hover:text-green-600 transition-colors">
                                <svg id="iconCopy" class="w-4 h-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                                <svg id="iconCheck" class="w-4 h-4 hidden text-green-500" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                            </button>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Copia esta contraseña antes de crear el administrador.</p>
                    </div>

                    <!-- Foto -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Foto de Perfil
                        </label>
                        <input type="file" name="imagen" id="admin_imagen" accept="image/*"
                            class="w-full text-sm text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-400 transition-all focus:outline-none cursor-not-allowed"
                            disabled required>
                    </div>
                </div>

                {{-- FOOTER --}}
                <div class="bg-gray-50 border-t border-gray-100 px-6 py-4 rounded-b-2xl flex justify-end gap-3">
                    <button type="submit" id="btnCrearAdmin" disabled
                        class="px-6 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-green-500 to-emerald-400 rounded-xl hover:from-green-600 hover:to-emerald-500 transition-all shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        Crear Administrador
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- EDIT EMPRESA MODAL -->
<div id="editModal" class="fixed inset-0 z-[9999] hidden overflow-y-auto" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 py-6">
        <div class="fixed inset-0 bg-black/40 backdrop-blur-sm" onclick="closeEditModal()"></div>
        <div class="relative bg-white rounded-2xl text-left shadow-2xl transform transition-all w-full max-w-4xl">

            {{-- HEADER --}}
            <div class="bg-gradient-to-r from-amber-500 to-green-400 px-6 py-5 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                            <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white">Editar Empresa</h3>
                            <p class="text-amber-100 text-xs">Actualiza los datos del registro empresarial</p>
                        </div>
                    </div>
                    <button onclick="closeEditModal()"
                        class="text-white/80 hover:text-white transition-colors p-1 rounded-lg hover:bg-white/10">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- BODY --}}
            <form id="formEditEmpresa" action="" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="px-6 pt-6 pb-4 grid grid-cols-1 md:grid-cols-2 gap-5">

                    {{-- Nombre Empresa --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Nombre de la Empresa
                        </label>
                        <input type="text" name="nombre_empresa" id="edit_nombre"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition-all"
                            required>
                    </div>

                    {{-- Representante Legal --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Representante Legal
                        </label>
                        <input type="text" name="nombre_repre_legal" id="edit_representante"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition-all"
                            required>
                    </div>

                    {{-- Cédula --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0" />
                            </svg>
                            Cédula del Representante
                        </label>
                        <input type="text" name="cedula_repre" id="edit_cedula_repre"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition-all"
                            required>
                    </div>

                    {{-- Teléfono --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            Teléfono
                        </label>
                        <input type="text" name="telefono" id="edit_telefono"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition-all"
                            required>
                    </div>

                    {{-- Correo --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Correo Electrónico
                        </label>
                        <input type="email" name="correo" id="edit_correo"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition-all"
                            required>
                    </div>

                    {{-- Dirección --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Dirección
                        </label>
                        <input type="text" name="direccion" id="edit_direccion"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition-all"
                            required>
                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="bg-gray-50 border-t border-gray-100 px-6 py-4 rounded-b-2xl flex justify-end gap-3">
                    <button type="submit"
                        class="px-6 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-amber-500 to-yellow-400 rounded-xl hover:from-amber-600 hover:to-yellow-500 transition-all shadow-md hover:shadow-lg cursor-pointer flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Actualizar Empresa
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    // --- MODAL FUNCTIONS ---
    function openCreateModal() {
        document.getElementById('createModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
    }

    function closeCreateModal() {
        document.getElementById('createModal').classList.add('hidden');
        document.body.style.overflow = 'auto';

        // Clear forms
        document.getElementById('formEmpresa').reset();

        // Clear any error states
        document.querySelectorAll('.border-red-500').forEach(el => {
            el.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
            el.classList.add('border-gray-300', 'focus:border-green-500', 'focus:ring-green-500');
        });
        document.querySelectorAll('[id^="error_"]').forEach(el => el.classList.add('hidden'));
    }

    function openAdminModal() {
        document.getElementById('adminModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeAdminModal() {
        document.getElementById('adminModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        document.getElementById('formAdmin').reset();
    }

    // --- REAL-TIME VALIDATION ---
    const regexNumber = /^\d+$/;
    const regexText = /^[a-zA-Z\sñÑáéíóúÁÉÍÓÚ]+$/;
    // Simple email regex, HTML5 input type="email" handles most of it, but this adds extra layer
    const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    function validateInput(inputId, errorId, regex) {
        const input = document.getElementById(inputId);
        const error = document.getElementById(errorId);

        if (!input) return;

        input.addEventListener('input', function () {
            if (this.value && !regex.test(this.value)) {
                this.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
                this.classList.remove('border-gray-300', 'focus:border-green-500', 'focus:ring-green-500');
                error.classList.remove('hidden');
            } else {
                this.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
                this.classList.add('border-gray-300', 'focus:border-green-500', 'focus:ring-green-500');
                error.classList.add('hidden');
            }
        });
    }

    // Attach validations
    document.addEventListener('DOMContentLoaded', function () {
        // Empresa Form
        validateInput('create_nit', 'error_create_nit', regexNumber);
        validateInput('create_nombre', 'error_create_nombre', regexText);
        validateInput('create_representante', 'error_create_representante', regexText);
        validateInput('create_cedula_repre', 'error_create_cedula_repre', regexNumber);
        validateInput('create_telefono', 'error_create_telefono', regexNumber);

        // Admin Form
        validateInput('admin_documento', 'error_admin_documento', regexNumber);
        validateInput('admin_nombre', 'error_admin_nombre', regexText);
        validateInput('admin_telefono', 'error_admin_telefono', regexNumber);
    });

    // Auto-fill logic removed as requested for create modal but added for admin modal
    // ===== AUTO-FILL ADMIN NIT -> EMPRESA =====
    const adminNitInput = document.getElementById('admin_nit_busqueda');
    const adminIdEmpresaHidden = document.getElementById('admin_id_empresa');
    const adminEmpresaInfo = document.getElementById('adminEmpresaInfo');
    const adminEmpresaNoEncontrada = document.getElementById('adminEmpresaNoEncontrada');
    const adminEmpresaInactiva = document.getElementById('adminEmpresaInactiva');
    const adminEmpresaConAdmin = document.getElementById('adminEmpresaConAdmin');
    const adminEmpresaNombreEl = document.getElementById('adminEmpresaNombre');
    const adminEmpresaNitEl = document.getElementById('adminEmpresaNit');
    const btnCrearAdmin = document.getElementById('btnCrearAdmin');
    const adminSpinner = document.getElementById('adminNitSpinner');

    // Form fields to auto-fill
    const adminNombreInput = document.getElementById('admin_nombre');
    const adminTelefonoInput = document.getElementById('admin_telefono');
    const adminCorreoInput = document.getElementById('admin_correo');
    const adminDocumentoInput = document.getElementById('admin_documento');

    let adminDebounceTimer;

    if (adminNitInput) {
        adminNitInput.addEventListener('input', function () {
            clearTimeout(adminDebounceTimer);
            const nit = this.value.trim();

            // Resetear estado
            adminEmpresaInfo.classList.add('hidden');
            adminEmpresaNoEncontrada.classList.add('hidden');
            if (adminEmpresaInactiva) adminEmpresaInactiva.classList.add('hidden');
            if (adminEmpresaConAdmin) adminEmpresaConAdmin.classList.add('hidden');
            adminIdEmpresaHidden.value = '';

            // Lock all form fields when NIT changes or is empty
            lockAdminFields();
            if (btnCrearAdmin) btnCrearAdmin.disabled = true;

            if (nit.length < 3) return;

            adminDebounceTimer = setTimeout(() => {
                adminSpinner.classList.remove('hidden');

                fetch(`/empresa/buscar/${nit}`)
                    .then(res => res.json())
                    .then(data => {
                        adminSpinner.classList.add('hidden');

                        if (!data || !data.id_empresa) {
                            adminEmpresaNoEncontrada.classList.remove('hidden');
                            return;
                        }

                        if (!data.empresa_activa) {
                            if (adminEmpresaInactiva) adminEmpresaInactiva.classList.remove('hidden');
                            if (btnCrearAdmin) btnCrearAdmin.disabled = true;
                            return;
                        }

                        if (data.tiene_admin) {
                            if (adminEmpresaConAdmin) adminEmpresaConAdmin.classList.remove('hidden');
                            if (btnCrearAdmin) btnCrearAdmin.disabled = true;
                            return;
                        }

                        // Empresa válida encontrada → desbloquear campos
                        adminIdEmpresaHidden.value = data.id_empresa;
                        adminEmpresaNombreEl.textContent = data.nombre_empresa;
                        adminEmpresaNitEl.textContent = 'NIT: ' + data.id_empresa;
                        adminEmpresaInfo.classList.remove('hidden');

                        unlockAdminFields();

                        // Autocompletar con datos del representante
                        if (adminNombreInput && data.nombre_repre_legal) {
                            adminNombreInput.value = data.nombre_repre_legal;
                            adminNombreInput.setAttribute('readonly', true);
                        }
                        if (adminTelefonoInput && data.telefono) {
                            adminTelefonoInput.value = data.telefono;
                            adminTelefonoInput.setAttribute('readonly', true);
                        }
                        if (adminCorreoInput && data.correo) {
                            adminCorreoInput.value = data.correo;
                            adminCorreoInput.setAttribute('readonly', true);
                        }
                        if (adminDocumentoInput && data.cedula_repre) {
                            adminDocumentoInput.value = data.cedula_repre;
                            adminDocumentoInput.setAttribute('readonly', true);
                        }

                        if (btnCrearAdmin) btnCrearAdmin.disabled = false;
                    })
                    .catch(() => {
                        adminSpinner.classList.add('hidden');
                        adminEmpresaNoEncontrada.classList.remove('hidden');
                    });
            }, 500);
        });
    }

    function lockAdminFields() {
        const fields = [adminNombreInput, adminTelefonoInput, adminCorreoInput, adminDocumentoInput];
        const contrasenaHidden = document.getElementById('admin_contrasena');
        const contrasenaDisplay = document.getElementById('admin_contrasena_display');
        const imagenInput = document.getElementById('admin_imagen');

        fields.forEach(f => {
            if (!f) return;
            f.value = '';
            f.removeAttribute('readonly');
            f.disabled = true;
            f.classList.remove('bg-gray-50', 'text-gray-800', 'focus:ring-green-400', 'focus:border-green-400', 'cursor-not-allowed');
            f.classList.add('bg-gray-100', 'text-gray-400', 'cursor-not-allowed');
        });
        if (contrasenaHidden) contrasenaHidden.value = '';
        if (contrasenaDisplay) contrasenaDisplay.value = '';
        if (imagenInput) {
            imagenInput.disabled = true;
            imagenInput.classList.remove('file:bg-green-50', 'file:text-green-700', 'hover:file:bg-green-100');
            imagenInput.classList.add('file:bg-gray-100', 'file:text-gray-400', 'cursor-not-allowed');
        }
    }

    function unlockAdminFields() {
        const fields = [adminNombreInput, adminTelefonoInput, adminCorreoInput, adminDocumentoInput];
        const contrasenaHidden = document.getElementById('admin_contrasena');
        const contrasenaDisplay = document.getElementById('admin_contrasena_display');
        const imagenInput = document.getElementById('admin_imagen');

        fields.forEach(f => {
            if (!f) return;
            f.disabled = false;
            f.classList.remove('bg-gray-100', 'text-gray-400', 'cursor-not-allowed');
            f.classList.add('bg-gray-50', 'text-gray-800', 'focus:ring-green-400', 'focus:border-green-400');
        });

        // Auto-generate password and populate both hidden and display fields
        const pwd = generatePassword();
        if (contrasenaHidden) contrasenaHidden.value = pwd;
        if (contrasenaDisplay) contrasenaDisplay.value = pwd;

        if (imagenInput) {
            imagenInput.disabled = false;
            imagenInput.classList.remove('file:bg-gray-100', 'file:text-gray-400', 'cursor-not-allowed');
            imagenInput.classList.add('file:bg-green-50', 'file:text-green-700', 'hover:file:bg-green-100');
        }
    }

    function generatePassword() {
        const upper = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
        const lower = 'abcdefghijkmnopqrstuvwxyz';
        const digits = '23456789';
        const special = '!#$%&*+-./:=?@^_';
        const allChars = upper + lower + digits + special;

        // Guarantee at least one of each category
        let pwd = [
            upper[Math.floor(Math.random() * upper.length)],
            upper[Math.floor(Math.random() * upper.length)],
            lower[Math.floor(Math.random() * lower.length)],
            lower[Math.floor(Math.random() * lower.length)],
            digits[Math.floor(Math.random() * digits.length)],
            digits[Math.floor(Math.random() * digits.length)],
            special[Math.floor(Math.random() * special.length)],
            special[Math.floor(Math.random() * special.length)],
        ];

        // Fill up to 12 chars
        while (pwd.length < 12) {
            pwd.push(allChars[Math.floor(Math.random() * allChars.length)]);
        }

        // Shuffle
        return pwd.sort(() => Math.random() - 0.5).join('');
    }

    function copiarContrasena() {
        const display = document.getElementById('admin_contrasena_display');
        if (!display || !display.value) return;
        navigator.clipboard.writeText(display.value).then(() => {
            const iconCopy = document.getElementById('iconCopy');
            const iconCheck = document.getElementById('iconCheck');
            iconCopy.classList.add('hidden');
            iconCheck.classList.remove('hidden');
            setTimeout(() => {
                iconCopy.classList.remove('hidden');
                iconCheck.classList.add('hidden');
            }, 2000);
        });
    }

    function openEditModal(empresa) {
        document.getElementById('edit_nombre').value = empresa.nombre_empresa || '';
        document.getElementById('edit_representante').value = empresa.nombre_repre_legal || '';
        document.getElementById('edit_cedula_repre').value = empresa.cedula_repre || '';
        document.getElementById('edit_telefono').value = empresa.telefono || '';
        document.getElementById('edit_correo').value = empresa.correo || '';
        document.getElementById('edit_direccion').value = empresa.direccion || '';

        // Set form action dynamically to the correct PATCH route
        const form = document.getElementById('formEditEmpresa');
        form.action = '/SuperAdmin/' + empresa.id_empresa;

        document.getElementById('editModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        document.getElementById('formEditEmpresa').reset();
    }
</script>