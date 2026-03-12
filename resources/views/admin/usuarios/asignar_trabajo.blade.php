@extends('layouts.admin')

@section('title', 'Asignar Pago')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">

    <div class="mb-4">
        <a href="{{ route('admin.usuarios.index') }}" class="inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 font-semibold transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Volver a la Gestión de Personal
        </a>
    </div>

    @if (session('success'))
        <div class="auto-dismiss bg-emerald-100 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-r-lg shadow-sm">
            <p class="font-medium flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        {{-- COLUMNA IZQUIERDA: FORMULARIO AGREGAR PAGO --}}
        <div class="lg:col-span-1 bg-white rounded-3xl shadow-lg border border-emerald-100 overflow-hidden sticky top-8">
            <div class="bg-gradient-to-br from-emerald-600 to-green-500 p-6 text-white">
                <h3 class="text-xl font-bold flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Asignar Pago
                </h3>
                <p class="text-sm text-emerald-100 mt-1">Registra un pago o salario para {{ explode(' ', $usuario->nombre)[0] }}</p>
            </div>

            <div class="p-6">
                @if ($errors->any())
                    <div class="bg-red-50 text-red-600 text-sm p-3 rounded-lg mb-4">
                        <ul class="list-disc pl-4 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.usuarios.store_trabajo', $usuario->documento) }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label for="descripcion_pago" class="block text-sm font-bold text-gray-700 mb-1">Descripción del Pago</label>
                        <textarea name="descripcion_pago" id="descripcion_pago" rows="2"
                                  placeholder="Ej: Pago de semana, Bono de productividad..."
                                  class="w-full px-3 py-2.5 rounded-lg border @error('descripcion_pago') border-red-500 @else border-gray-300 @enderror focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 bg-gray-50 text-sm resize-none">{{ old('descripcion_pago') }}</textarea>
                        @error('descripcion_pago') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="cantidad_pago" class="block text-sm font-bold text-gray-700 mb-1">Monto <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 font-bold">$</span>
                                <input type="number" step="0.01" name="cantidad_pago" id="cantidad_pago" value="{{ old('cantidad_pago') }}" required
                                       class="w-full pl-7 pr-3 py-2.5 rounded-lg border @error('cantidad_pago') border-red-500 @else border-gray-300 @enderror focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 bg-gray-50 text-sm">
                            </div>
                            @error('cantidad_pago') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="unidad_pago" class="block text-sm font-bold text-gray-700 mb-1">Unidad</label>
                            <input type="text" name="unidad_pago" id="unidad_pago" value="{{ old('unidad_pago') }}" placeholder="Ej: COP, USD"
                                   class="w-full px-3 py-2.5 rounded-lg border @error('unidad_pago') border-red-500 @else border-gray-300 @enderror focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 bg-gray-50 text-sm">
                            @error('unidad_pago') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="id_tipo_salario" class="block text-sm font-bold text-gray-700 mb-1">Frecuencia / Tipo</label>
                        <select name="id_tipo_salario" id="id_tipo_salario"
                                class="w-full px-3 py-2.5 rounded-lg border @error('id_tipo_salario') border-red-500 @else border-gray-300 @enderror focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 bg-gray-50 text-sm">
                            <option value="">-- Selecciona un Tipo --</option>
                            @foreach($tiposSalario as $tipo)
                                <option value="{{ $tipo->id_tipo_salario }}" {{ old('id_tipo_salario') == $tipo->id_tipo_salario ? 'selected' : '' }}>
                                    {{ $tipo->tipo_salario }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_tipo_salario') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 mt-2 rounded-lg shadow-md transition-colors text-sm flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Guardar Pago
                    </button>
                </form>
            </div>
        </div>

        {{-- COLUMNA DERECHA: LISTADO DE PAGOS --}}
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-emerald-100 flex items-center gap-6">
                 @if($usuario->imagen)
                    <img src="{{ asset('uploads/' . $usuario->imagen) }}" alt="Avatar" class="w-16 h-16 rounded-full object-cover border-2 border-emerald-200">
                @else
                    <div class="w-16 h-16 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 text-2xl font-bold border-2 border-emerald-200">
                        {{ strtoupper(substr($usuario->nombre, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $usuario->nombre }}</h2>
                    <p class="text-gray-500 text-sm font-medium">Doc: {{ $usuario->documento }} • {{ $usuario->id_tipo_usuario == 2 ? 'Supervisor' : 'Trabajador' }}</p>
                </div>
            </div>

            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Historial de Pagos / Salarios
                </h3>
                <a href="{{ route('admin.usuarios.exportar_pagos', $usuario->documento) }}" 
                class="bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200 px-4 py-2 rounded-xl text-sm font-bold transition flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Descargar Reporte Excel
                </a>
            </div>

            @forelse($salarios as $salario)
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:border-emerald-300 transition-colors relative overflow-hidden group">
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 {{ $salario->estado == 'activo' ? 'bg-emerald-500' : 'bg-gray-300' }}"></div>
                    
                    <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-1">
                                <h4 class="text-lg font-bold text-emerald-900">
                                    {{ $salario->tipoSalario ? $salario->tipoSalario->tipo_salario : 'Pago General' }}
                                </h4>
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider
                                    {{ $salario->estado == 'activo' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($salario->estado) }}
                                </span>
                            </div>
                            <p class="text-gray-700 mt-2">{{ $salario->descripcion_pago ?: 'Sin descripción adicional' }}</p>
                        </div>
                        
                        <div class="text-right whitespace-nowrap bg-emerald-50 p-3 rounded-xl border border-emerald-100 min-w-[140px]">
                            <p class="text-[10px] text-emerald-600 font-bold uppercase mb-1">
                                {{ $salario->fecha_pago ? \Carbon\Carbon::parse($salario->fecha_pago)->format('d/m/Y') : 'Sin fecha' }}
                            </p>
                            <p class="font-black text-emerald-800 text-xl">
                                ${{ number_format($salario->cantidad_pago, 0, ',', '.') }} 
                                <span class="text-xs font-normal text-emerald-600 italic underline">{{ $salario->unidad_pago }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white border-2 border-dashed border-gray-200 rounded-2xl p-10 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-gray-800 font-bold text-lg">Sin pagos registrados</p>
                    <p class="text-gray-500 text-sm mt-1">Aún no se han asignado montos salariales a este empleado.</p>
                </div>
            @endforelse

        </div>

    </div>

</div>
@endsection
