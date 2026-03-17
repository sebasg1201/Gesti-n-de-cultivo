@extends('layouts.admin')

@section('title', 'Entradas de Proveedores')

@section('content')
<div class="space-y-8 animate-in fade-in duration-500">
    <!-- Header Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Entradas -->
        <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-emerald-50 relative overflow-hidden group hover:scale-[1.02] transition-all duration-300">
            <div class="absolute top-0 right-0 p-6 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-20 h-20 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10m-13 9h16a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z" />
                </svg>
            </div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2 bg-emerald-100 rounded-xl text-emerald-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10m-13 9h16a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="text-[10px] font-black text-emerald-400 uppercase tracking-[0.2em]">
                        {{ isset($proveedorMasActivo->is_selection) ? 'Total Entradas Históricas' : 'Total Entradas Mes' }}
                    </span>
                </div>
                <div class="flex items-baseline gap-2">
                    <h2 class="text-5xl font-black text-emerald-950">{{ $totalEntradasMes }}</h2>
                </div>
                <p class="text-xs font-bold {{ $porcentajeCrecimiento >= 0 ? 'text-emerald-500' : 'text-red-500' }} mt-2 flex items-center gap-1 min-h-[1.5rem]">
                    @if(!isset($proveedorMasActivo->is_selection))
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="{{ $porcentajeCrecimiento >= 0 ? 'M5 10l7-7 7 7' : 'M19 14l-7 7-7-7' }}" />
                        </svg>
                        {{ number_format(abs($porcentajeCrecimiento), 1) }}% vs mes anterior
                    @endif
                </p>
            </div>
        </div>

        <!-- Proveedor Más Activo -->
        <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-emerald-50 relative overflow-hidden group hover:scale-[1.02] transition-all duration-300">
            <div class="absolute top-0 right-0 p-6 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-20 h-20 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2 bg-emerald-100 rounded-xl text-emerald-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                     <span class="text-[10px] font-black text-emerald-400 uppercase tracking-[0.2em]">
                        {{ isset($proveedorMasActivo->is_selection) ? 'Proveedor Detallado' : 'Proveedor más Activo' }}
                    </span>
                </div>
                <h2 class="text-3xl font-black text-emerald-950 truncate">{{ $proveedorMasActivo->nombre ?? 'N/A' }}</h2>
                <p class="text-xs font-bold text-emerald-600 mt-2">
                    {{ $proveedorMasActivo->total ?? 0 }} recepciones {{ isset($proveedorMasActivo->is_selection) ? 'en total' : 'este mes' }}
                </p>
            </div>
        </div>

        <!-- Valor Total Recibido -->
        <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-emerald-50 relative overflow-hidden group hover:scale-[1.02] transition-all duration-300">
            <div class="absolute top-0 right-0 p-6 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-20 h-20 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2z" />
                </svg>
            </div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2 bg-emerald-100 rounded-xl text-emerald-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3z" />
                        </svg>
                    </div>
                    <span class="text-[10px] font-black text-emerald-400 uppercase tracking-[0.2em]">Valor Total Recibido</span>
                </div>
                <h2 class="text-4xl font-black text-emerald-950">${{ number_format($valorTotalRecibido, 2) }}</h2>
                <p class="text-xs font-bold text-emerald-600 mt-2">
                    Promedio ${{ number_format($promedioPorEntrada, 2) }} por entrada
                </p>
            </div>
        </div>
    </div>

    <!-- Filters and Data Table -->
    <div class="bg-white rounded-[2.5rem] shadow-2xl border border-emerald-50 overflow-hidden">
        <!-- Filters Area -->
        <div class="p-8 border-b border-emerald-50 bg-gray-50/30 flex flex-wrap items-center justify-between gap-6">
            <form action="{{ route('admin.proveedores.entradas_dashboard') }}" method="GET" class="flex flex-wrap items-center gap-4">
                <!-- Date Filter -->
                <div class="relative">
                    <select name="fecha" onchange="this.form.submit()" class="pl-10 pr-8 py-3 rounded-2xl border-2 border-emerald-50 focus:border-emerald-500 focus:ring-0 bg-white text-xs font-bold text-emerald-950 transition-all appearance-none cursor-pointer">
                        <option value="">Fecha: Todas</option>
                        <option value="7" {{ request('fecha') == '7' ? 'selected' : '' }}>Últimos 7 días</option>
                        <option value="30" {{ request('fecha') == '30' ? 'selected' : '' }}>Últimos 30 días</option>
                    </select>
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-emerald-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10m-13 9h16a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>

                <!-- Provider Filter -->
                <div class="relative">
                    <select name="proveedor" onchange="this.form.submit()" class="pl-10 pr-8 py-3 rounded-2xl border-2 border-emerald-50 focus:border-emerald-500 focus:ring-0 bg-white text-xs font-bold text-emerald-950 transition-all appearance-none cursor-pointer">
                        <option value="">Proveedor: Todos</option>
                        @foreach($proveedores as $p)
                            <option value="{{ $p->id_proveedor }}" {{ request('proveedor') == $p->id_proveedor ? 'selected' : '' }}>{{ $p->nombre }}</option>
                        @endforeach
                    </select>
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-emerald-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
            </form>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.proveedores.exportar_entradas', request()->query()) }}" class="p-3 bg-white border-2 border-emerald-50 text-emerald-400 rounded-xl hover:text-emerald-600 hover:border-emerald-200 transition-all" title="Descargar Reporte PDF">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                </a>
                <button onclick="window.print()" class="p-3 bg-white border-2 border-emerald-50 text-emerald-400 rounded-xl hover:text-emerald-600 hover:border-emerald-200 transition-all" title="Imprimir Plantilla">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="overflow-x-auto min-h-[400px]">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 text-[10px] font-black text-emerald-400 uppercase tracking-[0.2em] border-b border-emerald-50">
                        @if($isGrouped)
                            <th class="px-8 py-6">Proveedor</th>
                            <th class="px-8 py-6">Especialidad</th>
                            <th class="px-8 py-6 text-center">Entradas Totales</th>
                            <th class="px-8 py-6 text-right">Valor Acumulado</th>
                            <th class="px-8 py-6 text-right">Última Actividad</th>
                        @else
                            <th class="px-8 py-6">Fecha</th>
                            <th class="px-8 py-6">Proveedor</th>
                            <th class="px-8 py-6">Producto</th>
                            <th class="px-8 py-6 text-center">Cant.</th>
                            <th class="px-8 py-6 text-right">Val. Unit.</th>
                            <th class="px-8 py-6 text-right">Val. Total</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-emerald-50/50">
                    @forelse($entradas as $entrada)
                        @if($isGrouped)
                            <tr class="hover:bg-emerald-50/30 transition-all cursor-pointer group" onclick="window.location.href='{{ route('admin.proveedores.entradas_dashboard', ['proveedor' => $entrada->id_proveedor]) }}'">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-700 font-black">
                                            {{ strtoupper(substr($entrada->nombre, 0, 1)) }}
                                        </div>
                                        <span class="text-xs font-black text-emerald-950 group-hover:text-emerald-600 transition-colors">{{ $entrada->nombre }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6 font-medium text-xs text-emerald-600">
                                    {{ $entrada->especialidad ?? 'General' }}
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <span class="px-3 py-1 bg-emerald-50 text-emerald-700 rounded-lg text-xs font-bold">{{ $entrada->total_registros }}</span>
                                </td>
                                <td class="px-8 py-6 text-right font-black text-sm text-emerald-950">
                                    ${{ number_format($entrada->valor_total, 2) }}
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">{{ \Carbon\Carbon::parse($entrada->ultima_fecha)->diffForHumans() }}</span>
                                </td>
                            </tr>
                        @else
                            @php
                                $isSemilla = !!$entrada->id_semilla;
                                $nombreProducto = $isSemilla ? ($entrada->semilla->nombre_semilla ?? 'Semilla Desconocida') : ($entrada->insumo->Nombre ?? 'Insumo Desconocido');
                                $unidad = $isSemilla ? 'KG' : 'UNID';
                            @endphp
                            <tr class="hover:bg-emerald-50/20 transition-all group">
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <span class="text-xs font-bold text-emerald-950">{{ \Carbon\Carbon::parse($entrada->fecha_entrada)->format('d M Y') }}</span>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="text-xs font-extrabold text-emerald-950">{{ $entrada->proveedor->nombre ?? 'N/A' }}</span>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="text-xs font-medium text-emerald-600">{{ $nombreProducto }}</span>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <div class="flex flex-col">
                                        <span class="text-xs font-black text-emerald-950">{{ number_format($entrada->cantidad_recibida, 0) }}</span>
                                        <span class="text-[10px] font-bold text-emerald-400 uppercase tracking-tighter">{{ $unidad }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <span class="text-xs font-bold text-emerald-600">${{ number_format($entrada->precio_unitario, 2) }}</span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <span class="text-sm font-black text-emerald-950">${{ number_format($entrada->cantidad_recibida * $entrada->precio_unitario, 2) }}</span>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="6" class="px-8 py-20 text-center">
                                <p class="text-emerald-300 italic font-medium">No se encontraron registros de entradas...</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-8 bg-gray-50/50 border-t border-emerald-50">
            {{ $entradas->links() }}
        </div>
    </div>
</div>
@endsection
