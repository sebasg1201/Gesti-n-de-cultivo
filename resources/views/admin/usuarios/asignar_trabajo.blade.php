@extends('layouts.admin')

@section('title', 'Asignar Trabajo')

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
        <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-r-lg shadow-sm">
            <p class="font-medium flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        {{-- COLUMNA IZQUIERDA: FORMULARIO AGREGAR FASE --}}
        <div class="lg:col-span-1 bg-white rounded-3xl shadow-lg border border-emerald-100 overflow-hidden sticky top-8">
            <div class="bg-gradient-to-br from-emerald-600 to-green-500 p-6 text-white">
                <h3 class="text-xl font-bold flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Fase Programada
                </h3>
                <p class="text-sm text-emerald-100 mt-1">Asigna un nuevo trabajo a {{ explode(' ', $usuario->nombre)[0] }}</p>
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
                        <label for="id_cosecha" class="block text-sm font-bold text-gray-700 mb-1">Cosecha <span class="text-red-500">*</span></label>
                        <select name="id_cosecha" id="id_cosecha" required
                                class="w-full px-3 py-2.5 rounded-lg border @error('id_cosecha') border-red-500 @else border-gray-300 @enderror focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 bg-gray-50 text-sm">
                            <option value="">-- Selecciona una Cosecha --</option>
                            @foreach($cosechas as $cosecha)
                                <option value="{{ $cosecha->id_tipo_cosecha }}" {{ old('id_cosecha') == $cosecha->id_tipo_cosecha ? 'selected' : '' }}>
                                    Lote #{{ $cosecha->id_tipo_cosecha }} - {{ $cosecha->semilla ? $cosecha->semilla->Tipo_semilla : 'Sin semilla' }} (Tiempo: {{ $cosecha->tiempo }} días)
                                </option>
                            @endforeach
                        </select>
                        @error('id_cosecha') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="descripcion" class="block text-sm font-bold text-gray-700 mb-1">Descripción de la Fase <span class="text-red-500">*</span></label>
                        <textarea name="descripcion" id="descripcion" rows="3" required
                                  placeholder="Ej: Siembra, Fumigación, Riego o los detalles de la labor..."
                                  class="w-full px-3 py-2.5 rounded-lg border @error('descripcion') border-red-500 @else border-gray-300 @enderror focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 bg-gray-50 text-sm resize-none">{{ old('descripcion') }}</textarea>
                        @error('descripcion') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="estado" class="block text-sm font-bold text-gray-700 mb-1">Estado <span class="text-red-500">*</span></label>
                        <select name="estado" id="estado" required
                                class="w-full px-3 py-2.5 rounded-lg border @error('estado') border-red-500 @else border-gray-300 @enderror focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 bg-gray-50 text-sm">
                            <option value="Pendiente" {{ old('estado') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="En Progreso" {{ old('estado') == 'En Progreso' ? 'selected' : '' }}>En Progreso</option>
                        </select>
                        @error('estado') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="fecha_programada" class="block text-sm font-bold text-gray-700 mb-1">Fecha Programada <span class="text-red-500">*</span></label>
                        <input type="date" name="fecha_programada" id="fecha_programada" value="{{ old('fecha_programada') }}" required
                               class="w-full px-3 py-2.5 rounded-lg border @error('fecha_programada') border-red-500 @else border-gray-300 @enderror focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 bg-gray-50 text-sm">
                        @error('fecha_programada') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 mt-2 rounded-lg shadow-md transition-colors text-sm">
                        Asignar Trabajo
                    </button>
                </form>
            </div>
        </div>

        {{-- COLUMNA DERECHA: LISTADO DE ASIGNACIONES --}}
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-emerald-100 flex items-center gap-6">
                 @if($usuario->imagen)
                    <img src="{{ asset('storage/' . $usuario->imagen) }}" alt="Avatar" class="w-16 h-16 rounded-full object-cover border-2 border-emerald-200">
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

            <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                Fases de Trabajo Asignadas
            </h3>

            @forelse($fases as $fase)
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:border-emerald-300 transition-colors relative overflow-hidden group">
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 {{ $fase->estado == 'Pendiente' ? 'bg-yellow-400' : 'bg-emerald-500' }}"></div>
                    
                    <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-1">
                                <h4 class="text-lg font-bold text-emerald-900">Fase Programada</h4>
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider
                                    {{ $fase->estado == 'Pendiente' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $fase->estado }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-500 font-medium bg-gray-50 inline-block px-2 py-1 rounded">
                                Lote Cosecha: #{{ $fase->id_cosecha }} {{ $fase->cosecha && $fase->cosecha->semilla ? '- ' . $fase->cosecha->semilla->nombre : '' }}
                            </p>
                            
                            <p class="text-gray-700 mt-3">{{ $fase->descripcion }}</p>
                        </div>
                        
                        <div class="text-right whitespace-nowrap bg-gray-50 p-3 rounded-xl border border-gray-100">
                            <p class="text-xs text-gray-400 font-bold uppercase mb-1">Fecha Programada</p>
                            <p class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($fase->fecha_programada)->format('d M, Y') }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white border-2 border-dashed border-gray-200 rounded-2xl p-10 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-gray-800 font-bold text-lg">Sin trabajo asignado</p>
                    <p class="text-gray-500 text-sm mt-1">Este empleado no tiene fases programadas pendientes por el momento.</p>
                </div>
            @endforelse

        </div>

    </div>

</div>
@endsection
