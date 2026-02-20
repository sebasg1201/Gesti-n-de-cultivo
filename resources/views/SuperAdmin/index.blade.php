@extends('layouts.barra_lateral')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Administración de Empresas</h1>

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

<<<<<<< HEAD
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
                        {{ \Carbon\Carbon::parse($empresa->fecha_creacion)->format('d M, Y') }}
                    </div>
                    <div class="text-xs text-gray-500">
                        {{ \Carbon\Carbon::parse($empresa->fecha_creacion)->locale('es')->diffForHumans() }}
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
                        <form action="{{ route('SuperAdmin.activar', $empresa->id_empresa) }}" method="POST"
                            class="inline">
                            @csrf
                            @method('PUT')
                            <button type="submit"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-xs flex items-center gap-1"
                                onclick="return confirm('¿Estás seguro de activar esta empresa?')">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
                                </svg>
                                Activar Acceso
                            </button>
                        </form>
                        @else
                        <button disabled
                            class="bg-gray-300 text-gray-500 font-bold py-1 px-3 rounded text-xs flex items-center gap-1 cursor-not-allowed">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-4 h-4">
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
                                stroke="currentColor" class="w-4 h-4">
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
                                stroke="currentColor" class="w-4 h-4">
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

<div class="flex justify-center mt-6">
    {{ $empresas->withQueryString()->links() }}
</div>
</div>


<!-- DETAILS MODAL -->
<div id="detailsModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <!-- Background backdrop -->
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div
            class="relative z-10 inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl sm:my-8 sm:align-middle sm:max-w-lg w-full">
            <div class="bg-gray-100 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div
                        class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0Z" />
=======
    <!-- SEARCH & FILTERS -->
    <div class="bg-white p-4 rounded shadow mb-6">
        <div class="flex flex-col lg:flex-row justify-between items-center gap-4">
            <form action="{{ route('SuperAdmin.index') }}" method="GET" class="flex gap-4 w-full lg:w-1/2">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <div class="relative flex-grow">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
>>>>>>> 52d9e2529c2b007bb5d70f6436482a8c5056dfa4
                        </svg>
                    </div>
                    <input type="search" name="search" value="{{ request('search') }}"
                        class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-green-500 focus:border-green-500"
                        placeholder="Buscar por Nombre de Empresa o NIT...">
                </div>
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded cursor-pointer">
                    Buscar
                </button>
            </form>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('SuperAdmin.index', ['search' => request('search')]) }}"
                    class="px-4 py-2 text-sm font-medium rounded-lg {{ !request('status') ? 'bg-gray-400 text-white' : 'bg-white text-gray-500 border border-gray-200 hover:bg-gray-100' }}">
                    Todas
                </a>
                <a href="{{ route('SuperAdmin.index', ['status' => 'pendiente', 'search' => request('search')]) }}"
                    class="px-4 py-2 text-sm font-medium rounded-lg {{ request('status') == 'pendiente' ? 'bg-yellow-500 text-white' : 'bg-yellow-50 text-yellow-700 border border-yellow-200 hover:bg-yellow-100' }}">
                    Pendientes
                </a>
                <a href="{{ route('SuperAdmin.index', ['status' => 'activa', 'search' => request('search')]) }}"
                    class="px-4 py-2 text-sm font-medium rounded-lg {{ request('status') == 'activa' ? 'bg-green-500 text-white' : 'bg-green-50 text-green-700 border border-green-200 hover:bg-green-100' }}">
                    Activas
                </a>
                <a href="{{ route('SuperAdmin.index', ['status' => 'bloqueada', 'search' => request('search')]) }}"
                    class="px-4 py-2 text-sm font-medium rounded-lg {{ request('status') == 'bloqueada' ? 'bg-red-500 text-white' : 'bg-red-50 text-red-700 border border-red-200 hover:bg-red-100' }}">
                    Bloqueadas
                </a>
            </div>
        </div>
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
                                {{ \Carbon\Carbon::parse($empresa->fecha_creacion)->format('d M, Y') }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($empresa->fecha_creacion)->locale('es')->diffForHumans() }}
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
                                    <form action="{{ route('SuperAdmin.activar', $empresa->id_empresa) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-xs flex items-center gap-1"
                                            onclick="return confirm('¿Estás seguro de activar esta empresa?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
                                            </svg>
                                            Activar Acceso
                                        </button>
                                    </form>
                                @else
                                    <button disabled
                                        class="bg-gray-300 text-gray-500 font-bold py-1 px-3 rounded text-xs flex items-center gap-1 cursor-not-allowed">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                            stroke="currentColor" class="w-4 h-4">
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
                                        stroke="currentColor" class="w-4 h-4">
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
                                        stroke="currentColor" class="w-4 h-4">
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

        <div class="p-4">
            {{ $empresas->links('pagination::simple-tailwind') }}
        </div>
    </div>


    <!-- DETAILS MODAL -->
    <div id="detailsModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <!-- Background backdrop -->
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div
                class="relative z-10 inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="bg-gray-100 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0Z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Detalles de la Empresa
                            </h3>
                            <div class="mt-4 border-t border-gray-200">
                                <dl class="divide-y divide-gray-200">
                                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                                        <dt class="text-sm font-medium text-gray-500">Nombre</dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" id="modal-nombre"></dd>
                                    </div>
                                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                                        <dt class="text-sm font-medium text-gray-500">NIT (ID)</dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" id="modal-nit"></dd>
                                    </div>
                                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                                        <dt class="text-sm font-medium text-gray-500">Representante</dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                                            id="modal-representante"></dd>
                                    </div>
                                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                                        <dt class="text-sm font-medium text-gray-500">Teléfono</dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" id="modal-telefono">
                                        </dd>
                                    </div>
                                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                                        <dt class="text-sm font-medium text-gray-500">Correo</dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" id="modal-correo"></dd>
                                    </div>
                                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                                        <dt class="text-sm font-medium text-gray-500">Dirección</dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" id="modal-direccion">
                                        </dd>
                                    </div>
                                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                                        <dt class="text-sm font-medium text-gray-500">Fecha Creación</dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" id="modal-fecha"></dd>
                                    </div>
                                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                                        <dt class="text-sm font-medium text-gray-500">Estado</dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" id="modal-estado"></dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-green-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm cursor-pointer"
                        onclick="closeModal()">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModal(empresa) {
            document.getElementById('modal-nombre').innerText = empresa.nombre_empresa;
            document.getElementById('modal-nit').innerText = empresa.id_empresa;
            document.getElementById('modal-representante').innerText = empresa.nombre_repre_legal;
            document.getElementById('modal-telefono').innerText = empresa.telefono;
            document.getElementById('modal-correo').innerText = empresa.correo;
            document.getElementById('modal-direccion').innerText = empresa.direccion;
            document.getElementById('modal-fecha').innerText = empresa.fecha_creacion;

            // Handle State Display
            const estadoSpan = document.getElementById('modal-estado');
            let estadoText = 'Desconocido';
            let estadoClass = 'text-gray-700 bg-gray-100';

            if (empresa.estado) {
                estadoText = empresa.estado.nombre_estado;
                if (empresa.estado.id_estado == 1) estadoClass = 'text-yellow-700 bg-yellow-100';
                else if (empresa.estado.id_estado == 2) estadoClass = 'text-red-700 bg-red-100';
                else if (empresa.estado.id_estado == 3) estadoClass = 'text-green-700 bg-green-100';
            }

            estadoSpan.innerHTML = `<span class="px-2 py-1 font-semibold leading-tight rounded-full ${estadoClass}">${estadoText}</span>`;

            document.getElementById('detailsModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('detailsModal').classList.add('hidden');
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
                    <button type="button" onclick="closeExcelModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">
                        Cancelar
                    </button>
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
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl w-full">

            <!-- HEADER MODAL -->
            <div class="bg-gray-50 px-4 py-3 border-b flex justify-between items-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Registrar Nueva Empresa</h3>
                <button onclick="closeCreateModal()"
                    class="h-6 w-6 flex items-center justify-center text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">

                <!-- FORM EMPRESA -->
                <div id="content-empresa" class="space-y-4">
                    <form action="{{ route('empresas.store') }}" method="POST" id="formEmpresa"
                        class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @csrf

                        <!-- NIT -->
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">NIT / ID Empresa</label>
                            <input type="text" name="id_empresa" id="create_nit"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"
                                placeholder="Ej: 900123456" required>
                            <span class="text-xs text-red-500 mt-1 hidden" id="error_create_nit">Solo números
                                permitidos</span>
                        </div>

                        <!-- Nombre -->
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre de la Empresa</label>
                            <input type="text" name="nombre_empresa" id="create_nombre"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"
                                placeholder="Ej: AgroTech S.A.S" required>
                            <span class="text-xs text-red-500 mt-1 hidden" id="error_create_nombre">Solo letras y
                                espacios permitidos</span>
                        </div>

                        <!-- Representante -->
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Representante Legal</label>
                            <input type="text" name="nombre_repre_legal" id="create_representante"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"
                                placeholder="Ej: Juan Pérez" required>
                            <span class="text-xs text-red-500 mt-1 hidden" id="error_create_representante">Solo letras y
                                espacios permitidos</span>
                        </div>

                        <!-- Cedula Representante -->
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Cédula del Representante</label>
                            <input type="text" name="cedula_repre" id="create_cedula_repre"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"
                                placeholder="Ej: 10234567890" required>
                            <span class="text-xs text-red-500 mt-1 hidden" id="error_create_cedula_repre">Solo números
                                permitidos</span>
                        </div>

                        <!-- Telefono -->
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                            <input type="text" name="telefono" id="create_telefono"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"
                                placeholder="Ej: 3001234567" required>
                            <span class="text-xs text-red-500 mt-1 hidden" id="error_create_telefono">Solo números
                                permitidos</span>
                        </div>

                        <!-- Correo -->
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                            <input type="email" name="correo" id="create_correo"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"
                                placeholder="contacto@empresa.com" required>
                            <span class="text-xs text-red-500 mt-1 hidden" id="error_create_correo">Correo
                                inválido</span>
                        </div>

                        <!-- Direccion -->
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                            <input type="text" name="direccion" id="create_direccion"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"
                                placeholder="Ej: Calle 123 # 45-67" required>
                        </div>

                        <!-- Tipo de Licencia -->
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Licencia</label>
                            <select name="id_tipo_licencia"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"
                                required>
                                <option value="">Seleccione un tipo de licencia...</option>
                                @foreach($tiposLicencia as $tipo)
                                    <option value="{{ $tipo->id_tipo_licencia }}">{{ $tipo->nombre_licencia }} —
                                        ${{ number_format($tipo->precio, 0, ',', '.') }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-span-2 flex justify-end mt-4">
                            <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg transition transform hover:scale-105">
                                Guardar Empresa
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ADMIN MODAL -->
<div id="adminModal" class="fixed inset-0 z-[9999] hidden overflow-y-auto" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl w-full">

            <!-- HEADER MODAL -->
            <div class="bg-gray-50 px-4 py-3 border-b flex justify-between items-center">
                <h3 class="text-lg leading-2 font-medium text-gray-900">Asignar Administrador</h3>
                <button onclick="closeAdminModal()"
                    class="h-6 w-6 flex items-center justify-center text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">

                <!-- FORM ADMIN -->
                <div id="content-admin" class="space-y-4">
                    <form action="{{ route('administradores.store') }}" method="POST" enctype="multipart/form-data"
                        id="formAdmin" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @csrf

                        <!-- Empresa Select -->
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Asignar a Empresa</label>
                            <select name="id_empresa"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"
                                required>
                                <option value="">Seleccione una empresa...</option>
                                @foreach($allEmpresas as $emp)
                                    <option value="{{ $emp->id_empresa }}">{{ $emp->nombre_empresa }} (NIT:
                                        {{ $emp->id_empresa }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Documento -->
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Documento de Identidad</label>
                            <input type="text" name="documento" id="admin_documento"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"
                                required>
                            <span class="text-xs text-red-500 mt-1 hidden" id="error_admin_documento">Solo números
                                permitidos</span>
                        </div>

                        <!-- Nombre Admin -->
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre Completo</label>
                            <input type="text" name="nombre" id="admin_nombre"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"
                                required>
                            <span class="text-xs text-red-500 mt-1 hidden" id="error_admin_nombre">Solo letras y
                                espacios permitidos</span>
                        </div>

                        <!-- Correo Admin -->
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                            <input type="email" name="correo" id="admin_correo"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"
                                required>
                        </div>

                        <!-- Telefono Admin -->
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                            <input type="text" name="telefono" id="admin_telefono"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"
                                required>
                            <span class="text-xs text-red-500 mt-1 hidden" id="error_admin_telefono">Solo números
                                permitidos</span>
                        </div>

                        <!-- Password -->
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                            <input type="password" name="contrasena"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"
                                required>
                        </div>

                        <!-- Foto -->
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Foto de Perfil</label>
                            <input type="file" name="imagen" accept="image/*"
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100"
                                required>
                        </div>

                        <div class="col-span-2 flex justify-end mt-4">
                            <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg transition transform hover:scale-105">
                                Crear Administrador
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- EDIT EMPRESA MODAL -->
<div id="editModal" class="fixed inset-0 z-[9999] hidden overflow-y-auto" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl w-full">

            <div class="bg-gray-50 px-4 py-3 border-b flex justify-between items-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Editar Empresa</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <form id="formEditEmpresa" action="" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @csrf
                    @method('PUT')

                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre de la Empresa</label>
                        <input type="text" name="nombre_empresa" id="edit_nombre"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"
                            required>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Representante Legal</label>
                        <input type="text" name="nombre_repre_legal" id="edit_representante"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"
                            required>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cédula del Representante</label>
                        <input type="text" name="cedula_repre" id="edit_cedula_repre"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"
                            required>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                        <input type="text" name="telefono" id="edit_telefono"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"
                            required>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                        <input type="email" name="correo" id="edit_correo"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"
                            required>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                        <input type="text" name="direccion" id="edit_direccion"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"
                            required>
                    </div>

                    <div class="col-span-2 flex justify-end mt-4">
                        <button type="button" onclick="closeEditModal()"
                            class="mr-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-6 rounded-lg transition">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-6 rounded-lg transition transform hover:scale-105">
                            Actualizar Empresa
                        </button>
                    </div>
                </form>
            </div>
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

        // Clear forms and unlock
        document.getElementById('formEmpresa').reset();
        unlock('create_nombre');
        unlock('create_representante');
        unlock('create_telefono');
        unlock('create_correo');
        unlock('create_direccion');

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

    // --- AUTO-FILL LOGIC ---
    document.getElementById('create_nit').addEventListener('input', function () {
        let nit = this.value;
        if (nit.length < 3) return;

        fetch(`/empresa/buscar/${nit}`)
            .then(res => res.json())
            .then(data => {
                if (data && Object.keys(data).length > 0) {
                    fillAndLock('create_nombre', data.nombre_empresa);
                    fillAndLock('create_representante', data.nombre_repre_legal);
                    fillAndLock('create_telefono', data.telefono);
                    fillAndLock('create_correo', data.correo);
                    fillAndLock('create_direccion', data.direccion);
                } else {
                    // Not found logic - keep unlocked
                    unlock('create_nombre');
                    unlock('create_representante');
                    unlock('create_telefono');
                    unlock('create_correo');
                    unlock('create_direccion');
                }
            })
            .catch(err => console.error(err));
    });

    // Handle manual clearing of NIT input
    document.getElementById('create_nit').addEventListener('keyup', function () { // keyup needed to catch backspace to empty
        if (this.value.length === 0) {
            unlock('create_nombre');
            unlock('create_representante');
            unlock('create_telefono');
            unlock('create_correo');
            unlock('create_direccion');

            // Clear values too
            document.getElementById('create_nombre').value = '';
            document.getElementById('create_representante').value = '';
            document.getElementById('create_telefono').value = '';
            document.getElementById('create_correo').value = '';
            document.getElementById('create_direccion').value = '';
        }
    });

    function fillAndLock(id, value) {
        const el = document.getElementById(id);
        if (el) {
            el.value = value || '';
            el.readOnly = true;
            el.classList.add('bg-gray-100', 'cursor-not-allowed');
        }
    }

    function unlock(id) {
        const el = document.getElementById(id);
        if (el) {
            el.readOnly = false;
            // el.value = ''; // Optional
            el.classList.remove('bg-gray-100', 'cursor-not-allowed');
        }
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