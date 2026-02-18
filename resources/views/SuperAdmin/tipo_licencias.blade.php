@extends('layouts.barra_lateral')

@section('content')

<div class="max-w-6xl mx-auto bg-white shadow-lg rounded-2xl p-8">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-2">

            {{-- ICONO LISTA --}}
            <svg xmlns="http://www.w3.org/2000/svg" 
                 class="w-8 h-8 text-green-600" 
                 fill="none" viewBox="0 0 24 24" 
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 5h12M9 12h12M9 19h12M5 5h.01M5 12h.01M5 19h.01"/>
            </svg>

            Planes creados
        </h2>

        {{-- BOTON CREAR --}}
        <a href="{{ route('licencias.create') }}"
           class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-xl shadow-md transition duration-300">

            {{-- ICONO PLUS --}}
            <svg xmlns="http://www.w3.org/2000/svg" 
                 class="w-5 h-5" 
                 fill="none" viewBox="0 0 24 24" 
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 4v16m8-8H4"/>
            </svg>

            Crear Plan
        </a>
    </div>

    {{-- ALERTA --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLA --}}
    <div class="overflow-x-auto">
        <table class="w-full border border-gray-200 rounded-xl overflow-hidden">

            {{-- ENCABEZADO --}}
            <thead class="bg-gray-100 text-gray-700 uppercase text-sm">
                <tr>
                    <th class="p-4 text-left">Nombre</th>
                    <th class="p-4 text-left">Tiempo</th>
                    <th class="p-4 text-left">Precio</th>
                    <th class="p-4 text-center">Acciones</th>
                </tr>
            </thead>

            {{-- CUERPO --}}
            <tbody class="text-gray-600">

                @foreach($licencias as $licencia)
                <tr class="border-t hover:bg-gray-50 transition duration-200">

                    <td class="p-4 font-medium">
                        {{ $licencia->nombre_licencia }}
                    </td>

                    <td class="p-4">
                        {{ $licencia->tiempo }}
                    </td>

                    <td class="p-4 font-semibold text-green-600">
                        ${{ number_format($licencia->precio) }}
                    </td>

                    <td class="p-4 text-center">
                        <div class="flex justify-center gap-3">

                            {{-- BOTON EDITAR --}}
                            <a href="{{ route('licencias.edit', $licencia->id_tipo_licencia) }}"
                               class="flex items-center gap-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow-sm transition duration-300">

                                {{-- ICONO EDITAR --}}
                                <svg xmlns="http://www.w3.org/2000/svg" 
                                     class="w-4 h-4" 
                                     fill="none" viewBox="0 0 24 24" 
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>

                                Editar
                            </a>

                            {{-- BOTON ELIMINAR --}}
                            <form action="{{ route('licencias.destroy', $licencia->id_tipo_licencia) }}"
                                  method="POST"
                                  onsubmit="return confirm('¿Seguro que deseas eliminar este plan?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="flex items-center gap-1 bg-gray-300 hover:bg-gray-400 text-white px-4 py-2 rounded-lg shadow-sm transition duration-300 cursor-pointer">

                                    {{-- ICONO ELIMINAR --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" 
                                         class="w-4 h-4" 
                                         fill="none" viewBox="0 0 24 24" 
                                         stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4"/>
                                    </svg>

                                    Eliminar
                                </button>
                            </form>

                        </div>
                    </td>

                </tr>
                @endforeach

            </tbody>
        </table>
    </div>

</div>

@endsection
