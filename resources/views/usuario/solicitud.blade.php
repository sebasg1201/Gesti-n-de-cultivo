@extends('layouts.control_index')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-green-600 px-8 py-6 text-white">
                <h2 class="text-3xl font-bold">Solicitud de Compra - {{ $licencia->nombre_licencia }}</h2>
                <p class="mt-2 opacity-90">Completa el formulario para adquirir tu licencia.</p>
            </div>

            <div class="p-8 grid md:grid-cols-2 gap-12">

                {{-- MENSAJES DE ERROR/EXITO --}}
                <div class="md:col-span-2">
                    @if(session('success'))
                    <div id="toast-success" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded shadow-lg z-50">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <strong>¡Éxito!</strong>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                    @endif

                    @if ($errors->any())
                    <div id="toast-errors" class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded shadow-lg z-50">
                        <strong class="font-bold">Por favor corrige los siguientes errores:</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>

                {{-- FORMULARIO --}}
                <form action="{{ route('solicitud.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6 validate-form">
                    @csrf
                    <input type="hidden" name="licencia_id" value="{{ $licencia->id_tipo_licencia }}">

                    <!-- NIT / ID Empresa -->
                    <div>
                        <label for="id_empresa" class="block text-sm font-medium text-gray-700">NIT Empresa</label>
                        <input type="text" name="id_empresa" id="id_empresa" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm p-3 border">
                    </div>

                    <!-- Nombre Empresa -->
                    <div>
                        <label for="nombre_empresa" class="block text-sm font-medium text-gray-700">Nombre
                            Empresa</label>
                        <input type="text" name="nombre_empresa" id="nombre_empresa" required
                            value="{{ old('nombre_empresa') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm p-3 border @error('nombre_empresa') border-red-500 @enderror">
                        @error('nombre_empresa') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Cedula Representante -->
                    <div>
                        <label for="nombre_empresa" class="block text-sm font-medium text-gray-700">Cedula
                            Representante</label>
                        <input type="number" name="cedula_repre" id="cedula_repre" required
                            value="{{ old('cedula_repre') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm p-3 border @error('cedula_repre') border-red-500 @enderror">
                        @error('cedula_repre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Representante Legal -->
                    <div>
                        <label for="nombre_repre_legal" class="block text-sm font-medium text-gray-700">Representante
                            Legal</label>
                        <input type="text" name="nombre_repre_legal" id="nombre_repre_legal" required
                            value="{{ old('nombre_repre_legal') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm p-3 border @error('nombre_repre_legal') border-red-500 @enderror">
                        @error('nombre_repre_legal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Teléfono -->
                    <div>
                        <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                        <input type="text" name="telefono" id="telefono" required
                            value="{{ old('telefono') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm p-3 border @error('telefono') border-red-500 @enderror">
                        @error('telefono') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Correo -->
                    <div>
                        <label for="correo" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                        <input type="email" name="correo" id="correo" required
                            value="{{ old('correo') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm p-3 border @error('correo') border-red-500 @enderror">
                        @error('correo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Dirección -->
                    <div>
                        <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección</label>
                        <input type="text" name="direccion" id="direccion" required
                            value="{{ old('direccion') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm p-3 border @error('direccion') border-red-500 @enderror">
                        @error('direccion') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Comprobante de Pago -->
                    <div>
                        <label for="comprobante_pago" class="block text-sm font-medium text-gray-700">Comprobante de
                            Pago</label>
                        <input type="file" name="comprobante_pago" id="comprobante_pago" required accept="image/*"
                            class="mt-1 block w-full text-sm text-gray-500
                                                                file:mr-4 file:py-2 file:px-4
                                                                file:rounded-full file:border-0
                                                                file:text-sm file:font-semibold
                                                                file:bg-green-50 file:text-green-700
                                                                hover:file:bg-green-100 file:cursor-pointer">
                        <p class="mt-1 text-xs text-gray-500">Sube una imagen clara del comprobante.</p>
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors cursor-pointer">
                            Enviar Solicitud
                        </button>
                    </div>
                </form>

                {{-- INFO PAGO & QR --}}
                <div class="flex flex-col items-center justify-start space-y-8">

                    <div class="text-center">
                        <h3 class="text-lg font-bold text-gray-900">Pago por Nequi</h3>
                        <div class="mt-3 bg-blue-50 border border-blue-200 rounded-lg p-3 text-sm text-blue-800 text-left">
                            <p class="font-semibold flex items-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 10-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1a1 1 0 112 0v1a1 1 0 11-2 0zM13.536 14.243a1 1 0 101.414-1.414l-.707-.707a1 1 0 10-1.414 1.414l.707.707zM16 18a1 1 0 100-2 1 1 0 000 2z"></path>
                                </svg>
                                Instrucciones:
                            </p>
                            <ul class="mt-1 list-decimal list-inside space-y-1 ml-1">
                                <li>Abre tu aplicación <b>Nequi</b></li>
                                <li>Selecciona la opción <b>$</b> y luego <b>Escanear QR</b></li>
                                <li>Captura el código de abajo y confirma los datos</li>
                            </ul>
                        </div>
                    </div>

                    <!-- QR Code Image -->
                    <div class="bg-white p-4 rounded-2xl shadow-xl border-4 border-green-500/20 relative group">
                        <img src="{{ asset('img/qr-nequi.jpeg') }}" alt="Código QR Nequi Agrotech"
                            class="w-64 h-auto rounded-lg transition-transform group-hover:scale-[1.02]">
                        <div class="absolute -top-3 -right-3 bg-green-500 text-white text-[10px] font-bold px-2 py-1 rounded-full shadow-lg">
                            OFICIAL
                        </div>
                    </div>

                    <div class="w-full bg-emerald-50/50 p-6 rounded-xl border border-emerald-200">
                        <h4 class="font-bold text-gray-900 mb-3 flex items-center gap-2">
                            <span class="w-2 h-6 bg-green-500 rounded-full"></span>
                            Detalles de la Cuenta
                        </h4>
                        <dl class="space-y-3 text-sm">
                            <div class="flex justify-between items-center group">
                                <dt class="text-gray-500">Banco:</dt>
                                <dd class="font-bold text-gray-900 px-2 py-0.5 bg-white rounded border border-gray-100">Nequi</dd>
                            </div>
                            <div class="flex justify-between items-center group">
                                <dt class="text-gray-500">Tipo:</dt>
                                <dd class="font-bold text-gray-900 px-2 py-0.5 bg-white rounded border border-gray-100">Llave / Nequi Negocios</dd>
                            </div>
                            <div class="flex justify-between items-center group">
                                <dt class="text-gray-500">Número:</dt>
                                <dd class="font-bold text-green-700 font-mono text-base bg-white px-2 py-0.5 rounded border border-green-100 italic">0092412894</dd>
                            </div>
                            <div class="flex justify-between items-center group">
                                <dt class="text-gray-500">Titular:</dt>
                                <dd class="font-bold text-gray-900">Jhoan Garcia</dd>
                            </div>
                            <div class="flex justify-between pt-3 border-t border-emerald-200 mt-2">
                                <dt class="font-extrabold text-gray-900 text-base uppercase">Total a Pagar:</dt>
                                <dd class="font-extrabold text-green-600 text-lg tabular-nums transform scale-110 origin-right transition-transform hover:scale-125">${{ number_format($licencia->precio) }}</dd>
                            </div>
                        </dl>
                    </div>
                    <div class="mt-6 flex justify-center">
                        <a href="{{ url('/') }}" class="inline-flex items-center gap-2
                                        bg-gray-100 text-gray-700
                                        px-6 py-2
                                        rounded-xl
                                        shadow-sm
                                        border border-gray-200
                                        hover:bg-gray-200
                                        hover:text-gray-900
                                        hover:shadow-md
                                        active:scale-95
                                        transition-all duration-200
                                        cursor-pointer">
                            <span class="text-lg"></span>
                            <span class="text-sm font-semibold">Volver al Inicio</span>
                        </a>
                    </div>


                </div>

            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/form-validation.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        ['toast-success', 'toast-errors'].forEach(function(id) {
            var el = document.getElementById(id);
            if (el) {
                setTimeout(function() {
                    el.style.transition = 'opacity 0.6s ease';
                    el.style.opacity = '0';
                    setTimeout(function() {
                        el.remove();
                    }, 600);
                }, 10000);
            }
        });
    });
</script>
@endsection