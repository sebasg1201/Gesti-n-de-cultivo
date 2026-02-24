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
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                                role="alert">
                                <strong class="font-bold">¡Éxito!</strong>
                                <span class="block sm:inline">{{ session('success') }}</span>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
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
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm p-3 border">
                        </div>

                        <!-- Cedula Representante -->
                        <div>
                            <label for="nombre_empresa" class="block text-sm font-medium text-gray-700">Cedula
                                Representante</label>
                            <input type="number" name="cedula_repre" id="cedula_repre" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm p-3 border">
                        </div>

                        <!-- Representante Legal -->
                        <div>
                            <label for="nombre_repre_legal" class="block text-sm font-medium text-gray-700">Representante
                                Legal</label>
                            <input type="text" name="nombre_repre_legal" id="nombre_repre_legal" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm p-3 border">
                        </div>

                        <!-- Teléfono -->
                        <div>
                            <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                            <input type="text" name="telefono" id="telefono" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm p-3 border">
                        </div>

                        <!-- Correo -->
                        <div>
                            <label for="correo" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                            <input type="email" name="correo" id="correo" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm p-3 border">
                        </div>

                        <!-- Dirección -->
                        <div>
                            <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección</label>
                            <input type="text" name="direccion" id="direccion" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm p-3 border">
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
                            <h3 class="text-lg font-medium text-gray-900">Método de Pago</h3>
                            <p class="mt-1 text-sm text-gray-500">Escanea el código QR para realizar el pago de tu licencia.
                            </p>
                        </div>

                        <!-- QR Code Image -->
                        <div class="bg-white p-4 rounded-xl shadow-lg border border-gray-100">
                            <img src="{{ asset('img/qrfalso.png') }}" alt="Código QR Bancolombia"
                                class="w-64 h-64 object-contain">
                        </div>

                        <div class="w-full bg-gray-50 p-6 rounded-xl border border-gray-200">
                            <h4 class="font-semibold text-gray-900 mb-2">Detalles de la Cuenta</h4>
                            <dl class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <dt class="text-gray-500">Banco:</dt>
                                    <dd class="font-medium text-gray-900">Bancolombia</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-gray-500">Tipo:</dt>
                                    <dd class="font-medium text-gray-900">Ahorros</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-gray-500">Número:</dt>
                                    <dd class="font-medium text-gray-900">302-260-9743</dd>
                                </div>
                                <div class="flex justify-between pt-2 border-t border-gray-200 mt-2">
                                    <dt class="font-bold text-gray-900">Total a Pagar:</dt>
                                    <dd class="font-bold text-green-600">${{ number_format($licencia->precio) }}</dd>
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
@endsection