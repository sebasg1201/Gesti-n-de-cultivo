@extends('layouts.control_index')

@section('content')
    @if(session('success'))
        <div class="auto-dismiss fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded shadow-lg z-50">
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="auto-dismiss fixed bottom-20 right-4 bg-red-500 text-white px-6 py-3 rounded shadow-lg z-50">
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <section id="index" class="max-w-7xl mx-auto px-6 py-12 md:py-20 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        {{-- TEXTO --}}
        <div>
            <span class="text-green-500 font-semibold uppercase text-sm">
                Transformación digital
            </span>

            <h1 class="mt-4 text-5xl md:text-5xl font-extrabold text-gray-900 leading-tight">
                El Futuro de tu <br class="hidden md:block">
                Finca, <span class="text-green-500">Hoy</span>
            </h1>

            <p class="mt-6 text-gray-600 max-w-lg">
                Optimiza la gestión de tus cosechas, terrenos y personal con
                inteligencia artificial y datos en tiempo real.
            </p>

            <div class="mt-8 flex gap-4">
                <a href="#precios"
                    class="px-6 py-4 bg-green-500 text-black rounded-xl font-semibold hover:bg-green-600 hover:shadow-lg hover:-translate-y-0.5">
                    Comenzar Ahora
                </a>

                <a href="#" class="px-6 py-3 border border-gray-200 rounded-xl font-semibold flex items-center gap-3
                            hover:bg-gray-50 transition">

                    <span class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100">
                        <svg class="w-4 h-4 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z" />
                        </svg>
                    </span>
                    Ver Demo
                </a>


            </div>

            <div class="mt-6 flex items-center gap-4">

                <!-- AVATARES -->
                <div class="flex -space-x-3 py-3">
                    <img class="w-10 h-10 rounded-full border-2 border-white object-cover hover:scale-105 transition"
                        src="{{ asset('img/users/user1.jpg') }}"
                        class="w-10 h-10 rounded-full border-2 border-white object-cover">

                    <img class="w-10 h-10 rounded-full border-2 border-white object-cover hover:scale-105 transition"
                        src="{{ asset('img/users/user2.jpg') }}"
                        class="w-10 h-10 rounded-full border-2 border-white object-cover">

                    <img class="w-10 h-10 rounded-full border-2 border-white object-cover hover:scale-105 transition"
                        src="{{ asset('img/users/user3.jpg') }}"
                        class="w-10 h-10 rounded-full border-2 border-white object-cover">
                </div>

                <!-- TEXTO -->
                <p class="text-sm text-gray-500">
                    <span class="font-semibold text-gray-700">+500 agricultores</span>
                    ya confían en nosotros
                </p>

            </div>

        </div>

        {{-- IMAGEN --}}
        <div class="relative rounded-2xl overflow-hidden shadow-lg ring-7 ring-white">
            <img src="{{ asset('img/img-agro.jpg') }}" alt="Agricultura moderna" class="w-full h-full object-cover">
        </div>


    </section>
    <section id="funciones" class="bg-gray-100 py-20">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold text-gray-900">
                Soluciones Integrales para el Agro
            </h2>

            <p class="mt-4 text-gray-600 max-w-2xl mx-auto">
                Diseñamos herramientas modernas para cada etapa de tu proceso productivo.
            </p>

            <div class="mt-14 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 text-left">
                {{-- CARD 1 --}}
                <div
                    class="bg-white border border-gray-200 rounded-2xl p-8 hover:shadow-md transition hover:shadow-lg hover:-translate-y-0.5">
                    <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-green-100 mb-4">
                        {{-- Planta --}}
                        <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M12 22V10" />
                            <path d="M8 10c-3 0-5-2-5-5 3 0 5 2 5 5z" />
                            <path d="M16 10c3 0 5-2 5-5-3 0-5 2-5 5z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg text-gray-900">
                        Control de Cosechas
                    </h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Gestión desde la siembra hasta la recolección con trazabilidad completa por lote.
                    </p>
                </div>

                {{-- CARD 2 --}}
                <div
                    class="bg-white border border-gray-200 rounded-2xl p-8 hover:shadow-md transition hover:shadow-lg hover:-translate-y-0.5">
                    <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-green-100 mb-4">
                        {{-- Gota --}}
                        <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M12 3C12 3 5 11 5 15a7 7 0 0014 0c0-4-7-12-7-12z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg text-gray-900">
                        Inteligencia de Terreno
                    </h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Monitoreo de humedad y predicciones inteligentes para uso óptimo de insumos.
                    </p>
                </div>

                {{-- CARD 3 --}}
                <div
                    class="bg-white border border-gray-200 rounded-2xl p-8 hover:shadow-md transition hover:shadow-lg hover:-translate-y-0.5">
                    <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-green-100 mb-4">
                        {{-- Maletín --}}
                        <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="7" width="18" height="13" rx="2" />
                            <path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg text-gray-900">
                        Gestión de Personal
                    </h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Control de nómina, roles y asistencia digital para todos tus trabajadores.
                    </p>
                </div>

                {{-- CARD 4 --}}
                <div
                    class="bg-white border border-gray-200 rounded-2xl p-8 hover:shadow-md transition hover:shadow-lg hover:-translate-y-0.5">
                    <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-green-100 mb-4">
                        {{-- Gráfico --}}
                        <svg class="w-6 h-6 text-green-600 " xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M4 19h16" />
                            <path d="M8 17V9" />
                            <path d="M12 17V5" />
                            <path d="M16 17v-3" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg text-gray-900">
                        Analítica Financiera
                    </h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Seguimiento de proveedores y ganancias con reportes automáticos en tiempo real.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section id="beneficios" class="max-w-7xl mx-auto px-6 py-20 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

        {{-- IMAGEN --}}
        <div class="relative w-full">
            {{-- Imagen --}}
            <img src="{{ asset('img/agro.jpg') }}" class="rounded-2xl shadow-lg w-full object-cover">

            {{-- Info flotante --}}
            <div
                class="absolute bottom-6 left-6 right-6 md:right-auto md:w-80 bg-white/95 backdrop-blur
                            rounded-xl shadow-lg px-5 py-4 flex items-center gap-4 hover:scale-105 transition-transform duration-300">

                {{-- Icono --}}
                <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 17l6-6 4 4 8-8" />
                    </svg>
                </div>

                {{-- Texto --}}
                <div>
                    <p class="font-semibold text-gray-900">Eficiencia</p>
                    <p class="text-sm text-gray-500">Incremento promedio en producción</p>
                </div>
            </div>
        </div>


        {{-- TEXTO --}}
        <div>
            <h2 class="text-2xl md:text-4xl font-bold text-gray-900 leading-tight">
                Diseñado para <br>
                <span class="text-green-600">Maximizar tu Rentabilidad</span>
            </h2>

            <ul class="mt-8 space-y-5">
                {{-- ITEM --}}
                <li class="flex items-start gap-4">
                    <div class="w-7 h-7 flex items-center justify-center rounded-full bg-green-100 mt-1">
                        <svg class="w-4 h-4 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <span class="text-gray-700">
                        Ahorro de tiempo operativo
                    </span>
                </li>

                <li class="flex items-start gap-4">
                    <div class="w-7 h-7 flex items-center justify-center rounded-full bg-green-100 mt-1">
                        <svg class="w-4 h-4 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <span class="text-gray-700">
                        Reducción de costos
                    </span>
                </li>

                <li class="flex items-start gap-4">
                    <div class="w-7 h-7 flex items-center justify-center rounded-full bg-green-100 mt-1">
                        <svg class="w-4 h-4 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <span class="text-gray-700">
                        Decisiones basadas en datos reales
                    </span>
                </li>
            </ul>
        </div>

    </section>

    <section id="precios" class="bg-gray-100 py-20">

        <div class="max-w-7xl mx-auto px-6 text-center">

            <h2 class="text-4xl font-bold text-gray-900">
                Planes que Crecen Contigo
            </h2>

            <p class="mt-4 text-gray-600">
                Transparencia total, sin costos ocultos.
            </p>

            <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8 text-left">

                @foreach($licencias as $licencia)

                        <div class="relative bg-white rounded-2xl p-8 transition
                                                    {{ $loop->iteration == 2
                    ? 'border-2 border-green-500 shadow-xl scale-105'
                    : 'border border-gray-200 hover:shadow-lg' }}">
                            @if($loop->iteration == 2)
                                <span class="absolute -top-4 left-1/2 -translate-x-1/2
                                                                bg-green-500 text-white text-xs font-semibold
                                                                px-4 py-1 rounded-full shadow-md">
                                    Más popular
                                </span>
                            @endif

                            {{-- BADGE OPCIONAL --}}
                            @if(strtolower($licencia->nombre_licencia) == 'profesional')

                            @endif


                            {{-- TITULO --}}
                            <h3 class="font-semibold text-lg text-green-600">
                                {{ $licencia->nombre_licencia }}
                            </h3>

                            {{-- PRECIO --}}
                            <p class="mt-4 text-4xl font-extrabold text-black-600">
                                ${{ number_format($licencia->precio) }}
                            </p>

                            {{-- DESCRIPCION --}}
                            <p class="mt-4 text-gray-600">
                                {{ $licencia->descripcion }}
                            </p>

                            <div class="my-6 h-px bg-gray-200/70"></div>

                            {{-- DURACION --}}
                            <p class="text-gray-500">
                                Duración: {{ $licencia->tiempo }}
                            </p>


                            {{-- LISTA ESTETICA --}}
                            <ul class="mt-6 space-y-4">

                                <li class="flex items-start gap-4">
                                    <div class="w-7 h-7 flex items-center justify-center rounded-full bg-green-100 mt-1">
                                        <svg class="w-4 h-4 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span class="text-gray-700">
                                        Acceso completo al sistema
                                    </span>
                                </li>

                                <li class="flex items-start gap-4">
                                    <div class="w-7 h-7 flex items-center justify-center rounded-full bg-green-100 mt-1">
                                        <svg class="w-4 h-4 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span class="text-gray-700">
                                        Soporte técnico
                                    </span>
                                </li>

                            </ul>


                            {{-- BOTON --}}
                            <a href="{{ route('solicitud.create', ['licencia' => $licencia->id_tipo_licencia]) }}" class="mt-8 block text-center py-3 rounded-xl font-semibold transition
                                                        {{ $loop->iteration == 2
                    ? 'bg-green-500 text-white hover:bg-green-600'
                    : 'border-2 border-green-500 text-green-600 hover:bg-green-100' }}">
                                Seleccionar Plan
                            </a>


                        </div>

                @endforeach

            </div>

        </div>
    </section>


@endsection