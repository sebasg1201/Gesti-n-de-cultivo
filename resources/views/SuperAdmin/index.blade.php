@extends('layouts.barra_lateral')

@section('content')

<h1 class="text-2xl font-bold mb-6">Administración de Empresas</h1>

<!-- STATS CARDS -->
<div class="grid grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded shadow flex items-center justify-between">
        <div>
            <p class="text-gray-500">Nuevas por Activar</p>
            <h2 class="text-3xl font-bold">{{ $stats['nuevas'] }} <span
                    class="text-sm font-normal text-green-500 bg-green-100 px-2 py-1 rounded-full">Recientes</span></h2>
        </div>
        <div class="p-3 bg-green-100 rounded-full text-green-600">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
        </div>
    </div>

    <div class="bg-white p-6 rounded shadow flex items-center justify-between">
        <div>
            <p class="text-gray-500">Empresas Suspendidas</p>
            <h2 class="text-3xl font-bold">{{ $stats['suspendidas'] }} <span
                    class="text-sm font-normal text-red-500 bg-red-100 px-2 py-1 rounded-full">Acceso Restringido</span>
            </h2>
        </div>
        <div class="p-3 bg-orange-100 rounded-full text-orange-600">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
            </svg>
        </div>
    </div>

    <div class="bg-white p-6 rounded shadow flex items-center justify-between">
        <div>
            <p class="text-gray-500">Empresas Activas</p>
            <h2 class="text-3xl font-bold">{{ $stats['activaciones'] }} <span
                    class="text-sm font-normal text-green-500 bg-green-100 px-2 py-1 rounded-full">Total Activas</span></h2>
        </div>
        <div class="p-3 bg-green-100 rounded-full text-green-600">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </div>
    </div>
</div>

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
                    </svg>
                </div>
                <input type="search" name="search" value="{{ request('search') }}"
                    class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-green-500 focus:border-green-500"
                    placeholder="Buscar por Nombre de Empresa o NIT...">
            </div>
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Buscar
            </button>
        </form>

        <div class="flex flex-wrap gap-2">
            <a href="{{ route('SuperAdmin.index', ['search' => request('search')]) }}"
                class="px-4 py-2 text-sm font-medium rounded-lg {{ !request('status') ? 'bg-gray-800 text-white' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50' }}">
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
                        <form action="{{ route('SuperAdmin.activar', $empresa->id_empresa) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <button type="submit"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-xs flex items-center gap-1"
                                onclick="return confirm('¿Estás seguro de activar esta empresa?')">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-4 h-4">
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
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            Activa
                        </button>
                        @endif

                        {{-- Botón Ver Detalles --}}
                        <button
                            type="button"
                            data-empresa="{{ json_encode($empresa) }}"
                            onclick="openModal(JSON.parse(this.getAttribute('data-empresa')))"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-xs flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            Ver Detalles
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
<div id="detailsModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Background backdrop -->
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="relative z-10 inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl sm:my-8 sm:align-middle sm:max-w-lg w-full">
            <div class="bg-gray-100 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0Z" />
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
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" id="modal-representante"></dd>
                                </div>
                                <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">Teléfono</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" id="modal-telefono"></dd>
                                </div>
                                <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">Correo</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" id="modal-correo"></dd>
                                </div>
                                <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">Dirección</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" id="modal-direccion"></dd>
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
            <div class="bg-blue-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="closeModal()">
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
</script>

@endsection