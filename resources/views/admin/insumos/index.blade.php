@extends('layouts.admin')

@section('title', 'Inventario de Insumos')

@section('content')
    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Inventario de Insumos</h2>
                <p class="text-sm text-gray-500 mt-1">Gestión de insumos agrícolas registrados.</p>
            </div>
            <a href="{{ route('admin.insumos.create') }}"
                class="flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 text-sm font-medium shadow-md shadow-emerald-500/20 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nuevo Insumo
            </a>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg p-4 flex gap-3 items-start">
                <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Search --}}
        <form method="GET" action="{{ route('admin.insumos.index') }}" class="flex gap-3">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Buscar por nombre, tipo, calidad o descripción..."
                class="flex-1 px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 text-sm">
            <button type="submit"
                class="px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm hover:bg-emerald-700 transition-colors">
                Buscar
            </button>
            @if(request('search'))
                <a href="{{ route('admin.insumos.index') }}"
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
                        <th class="p-4 text-left">Producto</th>
                        <th class="p-4 text-left">Tipo</th>
                        <th class="p-4 text-left">Calidad</th>
                        <th class="p-4 text-left">Stock</th>
                        <th class="p-4 text-left">Proveedor</th>
                        <th class="p-4 text-left">Ingreso</th>
                        <th class="p-4 text-left">Vence</th>
                        <th class="p-4 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse ($insumos as $insumo)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-9 h-9 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-xs shrink-0">
                                        {{ strtoupper(substr($insumo->Nombre, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $insumo->Nombre }}</p>
                                        @if($insumo->descripcion)
                                            <p class="text-xs text-gray-400 truncate max-w-xs">{{ $insumo->descripcion }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">
                                    {{ $insumo->tipo ? $insumo->tipo->nombre_insumo : 'Sin tipo' }}
                                </span>
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-0.5 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">
                                    {{ $insumo->Calidad ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="p-4">
                                <p class="font-bold text-gray-800">{{ $insumo->cantidad_stock }}</p>
                            </td>
                            <td class="p-4 text-gray-600">
                                {{ $insumo->proveedor ? $insumo->proveedor->nombre : '—' }}
                            </td>
                            <td class="p-4 text-gray-500 text-xs">
                                {{ $insumo->Fecha_ingreso ? $insumo->Fecha_ingreso->format('d/m/Y') : '—' }}
                            </td>
                            <td class="p-4 text-xs">
                                @if($insumo->Fecha_vencimiento)
                                    <span
                                        class="{{ $insumo->Fecha_vencimiento->isPast() ? 'text-red-600 font-semibold' : 'text-gray-500' }}">
                                        {{ $insumo->Fecha_vencimiento->format('d/m/Y') }}
                                    </span>
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="p-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.insumos.edit', $insumo->ID_insumo) }}"
                                        class="p-1.5 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors"
                                        title="Editar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.insumos.destroy', $insumo->ID_insumo) }}" method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('¿Seguro que deseas eliminar este insumo?');">
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
                            <td colspan="7" class="p-8 text-center text-gray-400">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    <p>No se encontraron insumos.</p>
                                    <a href="{{ route('admin.insumos.create') }}"
                                        class="text-emerald-500 font-medium text-sm">Agregar uno aquí</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($insumos->hasPages())
            <div class="p-4">
                {{ $insumos->links() }}
            </div>
        @endif

    </div>
@endsection