@extends('layouts.admin')

@section('title', 'Proveedores')

@section('content')
    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Proveedores</h2>
                <p class="text-sm text-gray-500 mt-1">Gestión de proveedores registrados.</p>
            </div>
            <a href="{{ route('admin.proveedores.create') }}"
                class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium shadow-md shadow-blue-500/20 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nuevo Proveedor
            </a>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="bg-blue-50 border border-blue-200 text-blue-700 rounded-lg p-4 flex gap-3 items-start">
                <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Search --}}
        <form method="GET" action="{{ route('admin.proveedores.index') }}" class="flex gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nombre o correo..."
                class="flex-1 px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm">
            <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 transition-colors">
                Buscar
            </button>
            @if(request('search'))
                <a href="{{ route('admin.proveedores.index') }}"
                    class="px-4 py-2 border border-gray-200 text-gray-600 rounded-lg text-sm hover:bg-gray-50 transition-colors">
                    Limpiar
                </a>
            @endif
        </form>

        {{-- Table --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr
                        class="bg-gray-50 border-b border-gray-100 text-xs text-gray-500 uppercase font-semibold tracking-wider">
                        <th class="p-4 text-left">Proveedor</th>
                        <th class="p-4 text-left">Correo / Teléfono</th>
                        <th class="p-4 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse ($proveedores as $prov)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-9 h-9 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs shrink-0">
                                        {{ strtoupper(substr($prov->nombre, 0, 2)) }}
                                    </div>
                                    <p class="font-semibold text-gray-800">{{ $prov->nombre }}</p>
                                </div>
                            </td>
                            <td class="p-4">
                                <p class="text-gray-600">{{ $prov->correo ?? '—' }}</p>
                                <p class="text-xs text-gray-400">{{ $prov->telefono ?? '' }}</p>
                            </td>
                            <td class="p-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.proveedores.edit', $prov->id_proveedor) }}"
                                        class="p-1.5 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors"
                                        title="Editar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.proveedores.destroy', $prov->id_proveedor) }}" method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('¿Seguro que deseas eliminar este proveedor?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                            title="Eliminar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-400">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z">
                                        </path>
                                    </svg>
                                    <p>No se encontraron proveedores.</p>
                                    <a href="{{ route('admin.proveedores.create') }}"
                                        class="text-blue-500 font-medium text-sm">Agregar uno aquí</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($proveedores->hasPages())
            <div class="p-4">
                {{ $proveedores->links() }}
            </div>
        @endif

    </div>
@endsection