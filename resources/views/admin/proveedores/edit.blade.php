@extends('layouts.admin')

@section('title', 'Editar Proveedor')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">

        <div class="mb-2">
            <a href="{{ route('admin.proveedores.index') }}"
                class="text-blue-600 hover:text-blue-700 font-medium text-sm flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Volver a proveedores
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-8">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Editar Proveedor</h2>
                    <p class="text-gray-500 text-sm mt-1">Modifique los datos del proveedor.</p>
                </div>
                <div
                    class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-lg">
                    {{ strtoupper(substr($proveedor->nombre, 0, 2)) }}
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

            <form action="{{ route('admin.proveedores.update', $proveedor->id_proveedor) }}" method="POST"
                class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Nombre --}}
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nombre del Proveedor <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nombre" value="{{ old('nombre', $proveedor->nombre) }}"
                            placeholder="Ej: AgroSuministros del Norte"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 @error('nombre') border-red-500 @enderror"
                            required>
                        @error('nombre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Correo --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                        <input type="email" name="correo" value="{{ old('correo', $proveedor->correo) }}"
                            placeholder="contacto@proveedor.com"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    </div>

                    {{-- Telefono --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                        <input type="text" name="telefono" value="{{ old('telefono', $proveedor->telefono) }}"
                            placeholder="Ej: 300 123 4567"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <a href="{{ route('admin.proveedores.index') }}"
                        class="px-5 py-2.5 rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50 font-medium transition-colors text-sm">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="px-5 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 font-medium shadow-md shadow-blue-500/20 transition-all text-sm">
                        Actualizar Proveedor
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection