@extends('layouts.admin')

@section('title', 'Editar Insumo')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">

        <div class="mb-2">
            <a href="{{ route('admin.insumos.index') }}"
                class="text-emerald-600 hover:text-emerald-700 font-medium text-sm flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver al inventario
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-8">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Editar Insumo</h2>
                    <p class="text-gray-500 text-sm mt-1">Modifique los datos del insumo.</p>
                </div>
                <div class="w-12 h-12 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold font-mono text-lg">
                    {{ strtoupper(substr($insumo->Nombre, 0, 2)) }}
                </div>
            </div>

            @if($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 rounded-lg p-4">
                    <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.insumos.update', $insumo->ID_insumo) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Nombre --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nombre del Insumo <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="Nombre" value="{{ old('Nombre', $insumo->Nombre) }}"
                            placeholder="Ej: Semillas de Maíz Híbrido"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 @error('Nombre') border-red-500 @enderror"
                            required>
                        @error('Nombre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Tipo --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Tipo de Insumo <span class="text-red-500">*</span>
                        </label>
                        <select name="id_tipo_insumo"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 @error('id_tipo_insumo') border-red-500 @enderror"
                            required>
                            <option value="">-- Seleccione un tipo --</option>
                            @foreach($tiposInsumo as $tipo)
                                <option value="{{ $tipo->id_tipo_insumo }}" {{ old('id_tipo_insumo', $insumo->id_tipo_insumo) == $tipo->id_tipo_insumo ? 'selected' : '' }}>
                                    {{ $tipo->nombre_insumo }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_tipo_insumo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Calidad --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Calidad</label>
                        <input type="text" name="Calidad" value="{{ old('Calidad', $insumo->Calidad) }}"
                            placeholder="Ej: Alta, Premium, Estándar"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                    </div>

                    {{-- Cantidad Stock --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Cantidad en Stock <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="cantidad_stock" value="{{ old('cantidad_stock', $insumo->cantidad_stock) }}" min="0"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 @error('cantidad_stock') border-red-500 @enderror"
                            required>
                        @error('cantidad_stock') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Fecha Ingreso --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Ingreso</label>
                        <input type="date" name="Fecha_ingreso"
                            value="{{ old('Fecha_ingreso', $insumo->Fecha_ingreso ? $insumo->Fecha_ingreso->format('Y-m-d') : '') }}"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                    </div>

                    {{-- Fecha Vencimiento --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Vencimiento</label>
                        <input type="date" name="Fecha_vencimiento"
                            value="{{ old('Fecha_vencimiento', $insumo->Fecha_vencimiento ? $insumo->Fecha_vencimiento->format('Y-m-d') : '') }}"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                    </div>

                    {{-- Proveedor --}}
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Proveedor (Opcional)</label>
                        <select name="id_proveedor"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                            <option value="">-- Sin proveedor asignado --</option>
                            @foreach($proveedores as $prov)
                                <option value="{{ $prov->id_proveedor }}"
                                    {{ old('id_proveedor', $insumo->id_proveedor) == $prov->id_proveedor ? 'selected' : '' }}>
                                    {{ $prov->nombre }} {{ $prov->producto ? '(' . $prov->producto . ')' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Descripcion --}}
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                        <textarea name="descripcion" rows="3" placeholder="Descripción adicional del insumo..."
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 resize-none">{{ old('descripcion', $insumo->descripcion) }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <a href="{{ route('admin.insumos.index') }}"
                        class="px-5 py-2.5 rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50 font-medium transition-colors text-sm">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="px-5 py-2.5 rounded-lg bg-emerald-600 text-white hover:bg-emerald-700 font-medium shadow-md shadow-emerald-500/20 transition-all text-sm">
                        Actualizar Insumo
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection