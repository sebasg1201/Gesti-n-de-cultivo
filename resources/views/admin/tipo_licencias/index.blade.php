@extends('layouts.admin')

@section('title', 'Mi Plan de Licencia')

@section('content')

<div class="max-w-4xl mx-auto space-y-8">

    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 px-6 py-4 rounded-xl shadow-sm mb-6 flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if($licenciaActiva)
        {{-- CARD DE LICENCIA ACTIVA --}}
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-emerald-100">
            
            <div class="bg-gradient-to-r from-emerald-600 to-green-500 px-8 py-6 text-white flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-extrabold">{{ $licenciaActiva->tipoLicencia->nombre_licencia }}</h2>
                    <p class="text-emerald-100 mt-1">Plan Actual</p>
                </div>
                <div class="text-right">
                    <p class="text-4xl font-black">${{ number_format($licenciaActiva->tipoLicencia->precio) }}</p>
                    <p class="text-sm text-emerald-100 capitalize">{{ $licenciaActiva->tipoLicencia->tiempo ?? '1 Año' }}</p>
                </div>
            </div>

            <div class="p-8 grid md:grid-cols-2 gap-8 items-center bg-gray-50">
                
                {{-- INFO --}}
                <div class="space-y-6">
                    <div>
                        <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Descripción del Plan</h4>
                        <p class="text-gray-800 text-lg mt-1 font-medium">{{ $licenciaActiva->tipoLicencia->descripcion }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
                            <p class="text-xs text-gray-400 font-semibold uppercase">Fecha Inicio</p>
                            <p class="text-gray-800 font-bold mt-1">{{ \Carbon\Carbon::parse($licenciaActiva->fecha_inicio)->format('d M, Y') }}</p>
                        </div>
                        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
                            <p class="text-xs text-gray-400 font-semibold uppercase">Válido Hasta</p>
                            <p class="text-gray-800 font-bold mt-1">{{ $fechaFin ? $fechaFin->format('d M, Y') : 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                {{-- DIAS RESTANTES WIDGET --}}
                <div class="flex flex-col items-center justify-center p-6 bg-white rounded-3xl shadow-md border-2 {{ $diasRestantes <= 10 ? 'border-red-400' : 'border-emerald-400' }}">
                    <p class="text-gray-500 font-medium mb-2 uppercase tracking-widest text-sm">Tiempo Restante</p>
                    
                    <div class="relative w-40 h-40 flex items-center justify-center rounded-full bg-gray-50 shadow-inner">
                        {{-- Círculo animado (CSS tailwind para el borde) --}}
                        <div class="absolute inset-0 rounded-full border-8 {{ $diasRestantes <= 10 ? 'border-red-500' : 'border-emerald-500' }} border-t-transparent animate-spin" style="animation-duration: 3s;"></div>
                        
                        <div class="text-center z-10 bg-white w-32 h-32 rounded-full flex flex-col items-center justify-center shadow-md">
                            <span class="text-4xl font-black {{ $diasRestantes <= 10 ? 'text-red-500' : 'text-emerald-500' }}">{{ $diasRestantes }}</span>
                            <span class="text-xs text-gray-500 font-semibold uppercase mt-1">Días</span>
                        </div>
                    </div>

                    @if($diasRestantes <= 10)
                        <p class="mt-4 text-center text-sm font-bold text-red-500 bg-red-50 px-4 py-2 rounded-xl">¡Tu plan está por vencer!</p>
                    @else
                        <p class="mt-4 text-center text-sm font-medium text-emerald-600 bg-emerald-50 px-4 py-2 rounded-xl">Plan Activo y Vigente</p>
                    @endif
                </div>

            </div>
        </div>

    @else
        {{-- NO HAY LICENCIA --}}
        <div class="bg-white p-12 text-center rounded-3xl shadow-xl border border-gray-100">
            <div class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">No hay un plan de licencia activo</h3>
            <p class="text-gray-500 mt-2">Actualmente tu empresa no cuenta con una licencia activa en el sistema.</p>
        </div>
    @endif

    {{-- BOTON CONTACTO --}}
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-3xl shadow-2xl p-8 text-white flex flex-col md:flex-row items-center justify-between gap-6 transform hover:scale-[1.01] transition duration-300">
        <div>
            <h3 class="text-xl font-bold flex items-center gap-3">
                <span class="p-2 bg-emerald-500 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                </span>
                ¿Necesitas asistencia o renovar tu plan?
            </h3>
            <p class="text-gray-300 mt-2 ml-14">Contáctanos directamente y nuestro equipo te responderá a la brevedad.</p>
        </div>
        
        <a href="{{ route('admin.licencias.contacto') }}" class="flex items-center gap-2 bg-emerald-500 hover:bg-emerald-400 text-white px-8 py-4 rounded-xl font-bold text-lg shadow-lg shadow-emerald-500/30 transition-all duration-300 w-full md:w-auto justify-center">
            Contactar Soporte
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </a>
    </div>

    {{-- PLANES DISPONIBLES --}}
    <div class="mt-12">
        <div class="mb-6">
            <h3 class="text-2xl font-bold text-gray-800">Mejora tu Plan Actual</h3>
            <p class="text-gray-500">Explora las opciones disponibles y solicita un cambio de plan en cualquier momento.</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($planesDisponibles as $plan)
                <div class="bg-white rounded-3xl p-6 shadow-md border 
                            {{ ($licenciaActiva && $licenciaActiva->id_tipo_licencia == $plan->id_tipo_licencia) ? 'border-emerald-500 shadow-emerald-100 ring-2 ring-emerald-500/20' : 'border-gray-100 hover:shadow-lg transition' }}">
                    
                    @if($licenciaActiva && $licenciaActiva->id_tipo_licencia == $plan->id_tipo_licencia)
                        <span class="inline-block bg-emerald-100 text-emerald-700 text-xs font-bold px-3 py-1 rounded-full mb-3 uppercase tracking-wider">Tu Plan Actual</span>
                    @endif

                    <h4 class="text-xl font-bold text-gray-800">{{ $plan->nombre_licencia }}</h4>
                    <p class="text-3xl font-black text-emerald-600 mt-2">${{ number_format($plan->precio) }}</p>
                    <p class="text-sm text-gray-500 capitalize mb-4">Por {{ $plan->tiempo }}</p>
                    
                    <p class="text-gray-600 mb-6 text-sm h-12">{{ Str::limit($plan->descripcion, 80) }}</p>

                    @if($licenciaActiva && $licenciaActiva->id_tipo_licencia == $plan->id_tipo_licencia)
                        <button disabled class="w-full bg-gray-100 text-gray-400 font-bold py-3 rounded-xl cursor-not-allowed">Plan Activo</button>
                    @else
                        <a href="{{ route('admin.licencias.contacto', ['cambiar_plan' => $plan->id_tipo_licencia]) }}" 
                           class="w-full block text-center bg-white border-2 border-emerald-500 text-emerald-600 hover:bg-emerald-500 hover:text-white font-bold py-3 rounded-xl transition-colors duration-300">
                            Solicitar Cambio
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

</div>

@endsection
