@extends('layouts.barra_lateral')

@section('content')

    <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-xl p-8 border border-gray-100">

        {{-- TITULO --}}
        <h2 class="text-3xl font-semibold text-gray-700 mb-8 border-b pb-3 flex items-center gap-2">

            {{-- ICONO --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-green-600" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>

            Crear Plan de Licencia
        </h2>

        {{-- ERRORES --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-6">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('licencias.store') }}" method="POST" class="space-y-6 validate-form">
            @csrf

            {{-- NOMBRE --}}
            <div>
                <label class="text-sm font-medium text-gray-600 mb-2 flex items-center gap-2">

                    {{-- ICONO --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" />
                    </svg>

                    Nombre del Plan
                </label>

                <input type="text" pattern="[A-Za-zÁÉÍÓÚáéíóúñÑ ]+" name="nombre_licencia"
                    value="{{ old('nombre_licencia') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-400 focus:border-green-400 outline-none transition"
                    placeholder="Ej: Plan Premium" required>
            </div>

            {{-- TIEMPO --}}
            <div>
                <label class="text-sm font-medium text-gray-600 mb-2 flex items-center gap-2">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" />
                        <circle cx="12" cy="12" r="10" />
                    </svg>

                    Tiempo de Duración
                </label>

                <input type="text" name="tiempo" value="{{ old('tiempo') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-400 focus:border-green-400 outline-none transition"
                    placeholder="Ej: 1 año, 6 meses, 30 días" required>
            </div>

            {{-- DESCRIPCION --}}
            <div>
                <label class="text-sm font-medium text-gray-600 mb-2 flex items-center gap-2">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z" />
                    </svg>

                    Descripción
                </label>

                <textarea name="descripcion" rows="3"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-400 focus:border-green-400 outline-none transition"
                    placeholder="Describe el plan...">{{ old('descripcion') }}</textarea>
            </div>

            {{-- PRECIO --}}
            <div>
                <label class="text-sm font-medium text-gray-600 mb-2 flex items-center gap-2">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.5 0-3 .5-3 2s1.5 2 3 2 3 .5 3 2-1.5 2-3 2m0-8V6m0 12v-2" />
                    </svg>

                    Precio
                </label>

                <div class="relative">
                    <span class="absolute left-3 top-2.5 text-gray-400">$</span>

                    <input type="number" name="precio" value="{{ old('precio') }}"
                        class="w-full pl-8 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-400 focus:border-green-400 outline-none transition"
                        placeholder="Ej: 50000" required>
                </div>
            </div>

            {{-- BOTONES --}}
            <div class="flex justify-between items-center pt-4">

                <a href="{{ route('licencias.index') }}"
                    class="flex items-center gap-2 bg-gray-400 hover:bg-gray-500 text-white px-5 py-2 rounded-lg shadow transition duration-200">

                    {{-- ICONO --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>

                    Volver
                </a>

                <button type="submit"
                    class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-7 py-2 rounded-lg shadow-md hover:shadow-lg transition duration-200">

                    {{-- ICONO --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>

                    Guardar Plan
                </button>

            </div>

        </form>

    </div>

@endsection