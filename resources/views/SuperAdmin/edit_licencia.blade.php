@extends('layouts.barra_lateral')

@section('content')

<div class="max-w-3xl mx-auto bg-white shadow-xl rounded-2xl p-8 border border-gray-100">

    {{-- TITULO --}}
    <h2 class="text-2xl font-bold text-gray-700 mb-6 flex items-center gap-2">
        
        {{-- Icono editar --}}
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-green-600" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M11 5h2M12 20h9M16.5 3.5l4 4L7 21H3v-4L16.5 3.5z" />
        </svg>

        Editar Plan de Licencia
    </h2>

    {{-- ERRORES --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-700 p-4 rounded-lg mb-5">
            <ul class="space-y-1">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('licencias.update', $licencia->id_tipo_licencia) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        {{-- Nombre --}}
        <div>
            <label class="block text-gray-600 font-medium mb-2">Nombre</label>
            <input type="text"
                   name="nombre_licencia"
                   value="{{ $licencia->nombre_licencia }}"
                   class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-green-300 focus:outline-none transition"
                   required>
        </div>

        {{-- Tiempo --}}
        <div>
            <label class="block text-gray-600 font-medium mb-2">Tiempo</label>
            <input type="text"
                   name="tiempo"
                   value="{{ $licencia->tiempo }}"
                   class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-green-300 focus:outline-none transition"
                   required>
        </div>

        {{-- Descripción --}}
        <div>
            <label class="block text-gray-600 font-medium mb-2">Descripción</label>
            <textarea name="descripcion"
                      rows="3"
                      class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-green-300 focus:outline-none transition">{{ $licencia->descripcion }}</textarea>
        </div>

        {{-- Precio --}}
        <div>
            <label class="block text-gray-600 font-medium mb-2">Precio</label>
            <input type="number"
                   name="precio"
                   value="{{ $licencia->precio }}"
                   class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-green-300 focus:outline-none transition"
                   required>
        </div>

        {{-- BOTONES --}}
        <div class="flex justify-between items-center pt-4">

            {{-- VOLVER --}}
            <a href="{{ route('licencias.index') }}"
               class="flex items-center gap-2 bg-gray-400 hover:bg-gray-500 text-white px-5 py-2 rounded-lg shadow transition duration-300">

                {{-- Icono flecha --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 19l-7-7 7-7" />
                </svg>

                Volver
            </a>

            {{-- ACTUALIZAR --}}
            <button type="submit"
                class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg shadow-md transition duration-300 cursor-pointer">

                {{-- Icono guardar --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5 13l4 4L19 7" />
                </svg>

                Actualizar Plan
            </button>

        </div>

    </form>

</div>

@endsection
