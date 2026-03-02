@extends('layouts.barra_lateral')

@section('content')

    <div class="max-w-6xl mx-auto bg-white shadow-lg rounded-2xl p-8">

        {{-- HEADER --}}
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5h12M9 12h12M9 19h12M5 5h.01M5 12h.01M5 19h.01" />
                </svg>
                Planes creados
            </h2>

            <a href="{{ route('licencias.create') }}"
                class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-xl shadow-md transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Crear Plan
            </a>
        </div>

        {{-- ALERTAS --}}
        @if(session('success'))
            <div class="auto-dismiss fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg animate-fade-in-up z-50">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="auto-dismiss fixed bottom-4 right-4 bg-red-500 text-white px-6 py-4 rounded-xl shadow-lg animate-fade-in-up z-50 max-w-sm">
                <div class="flex items-start gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 flex-shrink-0 mt-0.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>
                    <span class="text-sm leading-snug">{{ session('error') }}</span>
                </div>
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
                        @php $enUso = $idsEnUso->contains($licencia->id_tipo_licencia); @endphp
                        <tr class="border-t hover:bg-gray-50 transition duration-200">

                            <td class="p-4 font-medium">
                                {{ $licencia->nombre_licencia }}
                                @if($enUso)
                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        En uso
                                    </span>
                                @endif
                            </td>

                            <td class="p-4">{{ $licencia->tiempo }}</td>

                            <td class="p-4 font-semibold text-green-600">
                                ${{ number_format($licencia->precio) }}
                            </td>

                            <td class="p-4 text-center">
                                <div class="flex justify-center gap-3">

                                    {{-- BOTON EDITAR --}}
                                    @if($enUso)
                                        <div class="relative group">
                                            <button type="button" disabled
                                                class="flex items-center gap-1 bg-gray-300 text-gray-500 px-4 py-2 rounded-lg shadow-sm cursor-not-allowed">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                                </svg>
                                                Editar
                                            </button>
                                            <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-64 hidden group-hover:block z-10 pointer-events-none">
                                                <div class="bg-gray-800 text-white text-xs rounded-lg py-2 px-3 text-center shadow-lg leading-relaxed">
                                                    No se puede editar: este plan tiene solicitudes de compra o licencias asignadas a empresas.
                                                    <div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-gray-800"></div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <a href="{{ route('licencias.edit', $licencia->id_tipo_licencia) }}"
                                            class="flex items-center gap-1 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg shadow-sm transition duration-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                            </svg>
                                            Editar
                                        </a>
                                    @endif

                                    {{-- BOTON ELIMINAR --}}
                                    @if($enUso)
                                        {{-- Plan en uso: deshabilitado con tooltip --}}
                                        <div class="relative group">
                                            <button type="button" disabled
                                                class="flex items-center gap-1 bg-gray-300 text-gray-500 px-4 py-2 rounded-lg shadow-sm cursor-not-allowed">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                </svg>
                                                Eliminar
                                            </button>
                                            {{-- Tooltip informativo --}}
                                            <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-64 hidden group-hover:block z-10 pointer-events-none">
                                                <div class="bg-gray-800 text-white text-xs rounded-lg py-2 px-3 text-center shadow-lg leading-relaxed">
                                                    No se puede eliminar: este plan tiene solicitudes de compra o licencias asignadas a empresas.
                                                    <div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-gray-800"></div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        {{-- Plan libre: botón eliminar normal --}}
                                        <form action="{{ route('licencias.destroy', $licencia->id_tipo_licencia) }}"
                                            method="POST"
                                            onsubmit="return confirm('Seguro que deseas eliminar el plan {{ addslashes($licencia->nombre_licencia) }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="flex items-center gap-1 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow-sm transition duration-300 cursor-pointer">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                                                </svg>
                                                Eliminar
                                            </button>
                                        </form>
                                    @endif

                                </div>
                            </td>

                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        {{-- PAGINACION --}}
        <div class="flex justify-center mt-6">
            {{ $licencias->withQueryString()->links() }}
        </div>

    </div>

@endsection