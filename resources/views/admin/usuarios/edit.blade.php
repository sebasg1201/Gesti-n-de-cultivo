@extends('layouts.admin')

@section('title', 'Editar Empleado')

@section('content')
<div class="max-w-4xl mx-auto">

    <div class="mb-6">
        <a href="{{ route('admin.usuarios.index') }}" class="inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 font-semibold transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Volver a la Gestión de Personal
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-emerald-50">
        
        <div class="bg-gradient-to-r from-emerald-600 to-green-500 p-8 text-white flex gap-6 items-center">
            @if($usuario->imagen)
                <img src="{{ asset('storage/' . $usuario->imagen) }}" alt="Avatar" class="w-20 h-20 rounded-full object-cover border-4 border-white/30 shadow-lg">
            @else
                <div class="w-20 h-20 rounded-full bg-white/20 flex items-center justify-center text-white text-2xl font-bold border-4 border-white/30 shadow-lg">
                    {{ strtoupper(substr($usuario->nombre, 0, 1)) }}
                </div>
            @endif

            <div>
                <h2 class="text-3xl font-extrabold">Editar a {{ explode(' ', $usuario->nombre)[0] }}</h2>
                <p class="text-emerald-100 mt-1">Actualizando datos de empleado (Doc: {{ $usuario->documento }})</p>
            </div>
        </div>

        <div class="p-8">
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.usuarios.update', $usuario->documento) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    {{-- Documento (readonly) --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-500 mb-2">Documento de Identidad (No modificable)</label>
                        <input type="text" value="{{ $usuario->documento }}" disabled
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-100 text-gray-500 cursor-not-allowed">
                    </div>

                    {{-- Nombre --}}
                    <div>
                        <label for="nombre" class="block text-sm font-bold text-gray-700 mb-2">Nombre Completo <span class="text-red-500">*</span></label>
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $usuario->nombre) }}" required
                               class="w-full px-4 py-3 rounded-xl border @error('nombre') border-red-500 @else border-gray-300 @enderror focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 transition shadow-sm">
                        @error('nombre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Correo --}}
                    <div>
                        <label for="correo" class="block text-sm font-bold text-gray-700 mb-2">Correo Electrónico <span class="text-red-500">*</span></label>
                        <input type="email" name="correo" id="correo" value="{{ old('correo', $usuario->correo) }}" required
                               class="w-full px-4 py-3 rounded-xl border @error('correo') border-red-500 @else border-gray-300 @enderror focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 transition shadow-sm">
                        @error('correo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Teléfono --}}
                    <div>
                        <label for="telefono" class="block text-sm font-bold text-gray-700 mb-2">Teléfono <span class="text-red-500">*</span></label>
                        <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $usuario->telefono) }}" required
                               class="w-full px-4 py-3 rounded-xl border @error('telefono') border-red-500 @else border-gray-300 @enderror focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 transition shadow-sm">
                        @error('telefono') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Rol --}}
                    <div>
                        <label for="id_tipo_usuario" class="block text-sm font-bold text-gray-700 mb-2">Rol Asignado <span class="text-red-500">*</span></label>
                        <select name="id_tipo_usuario" id="id_tipo_usuario" required
                                class="w-full px-4 py-3 rounded-xl border @error('id_tipo_usuario') border-red-500 @else border-gray-300 @enderror focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 transition shadow-sm bg-white">
                            @foreach($roles as $rol)
                                <option value="{{ $rol->id_tipo_usuario }}" {{ old('id_tipo_usuario', $usuario->id_tipo_usuario) == $rol->id_tipo_usuario ? 'selected' : '' }}>
                                    {{ ucfirst($rol->tipo_usuario) }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_tipo_usuario') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Estado --}}
                    <div>
                        <label for="id_estado" class="block text-sm font-bold text-gray-700 mb-2">Estado de Cuenta <span class="text-red-500">*</span></label>
                        <select name="id_estado" id="id_estado" required
                                class="w-full px-4 py-3 rounded-xl border @error('id_estado') border-red-500 @else border-gray-300 @enderror focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 transition shadow-sm bg-white">
                            @foreach($estados as $estado)
                                <option value="{{ $estado->id_estado }}" {{ old('id_estado', $usuario->id_estado) == $estado->id_estado ? 'selected' : '' }}>
                                    {{ ucfirst($estado->nombre_estado) }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_estado') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Contraseña (Opcional) --}}
                    <div>
                        <label for="contrasena" class="block text-sm font-bold text-gray-700 mb-2">Nueva Contraseña (Opcional)</label>
                        <input type="password" name="contrasena" id="contrasena"
                               class="w-full px-4 py-3 rounded-xl border @error('contrasena') border-red-500 @else border-gray-300 @enderror focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition shadow-sm"
                               placeholder="Dejar en blanco para no cambiar">
                        @error('contrasena') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                </div>

                {{-- Imagen (Opcional) --}}
                <div class="mt-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Actualizar Foto de Perfil</label>
                    <div class="mt-1 flex items-center justify-between px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-emerald-400 transition-colors bg-gray-50">
                        <div class="flex flex-col items-center">
                            <label for="imagen" class="relative cursor-pointer bg-white rounded-md font-medium text-emerald-600 hover:text-emerald-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-emerald-500 px-4 py-2 border border-emerald-200">
                                <span class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Seleccionar nueva imagen
                                </span>
                                <input id="imagen" name="imagen" type="file" class="sr-only" accept="image/*">
                            </label>
                            <p class="text-xs text-gray-500 mt-2">PNG, JPG, GIF hasta 2MB</p>
                        </div>
                    </div>
                </div>

                <div class="pt-6 flex justify-end gap-4">
                    <a href="{{ route('admin.usuarios.index') }}" class="px-6 py-3 text-gray-700 hover:bg-gray-100 rounded-xl font-bold transition">Cancelar</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Actualizar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
