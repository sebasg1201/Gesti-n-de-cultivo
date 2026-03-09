<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>AgriManager - Admin</title>
    @vite('resources/css/app.css')
    <style>
        /* Estilos base para el Sidebar */
        #sidebar {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: width, transform, opacity;
        }

        /* Comportamiento MÓVIL (por defecto) */
        @media (max-width: 1023px) {
            #sidebar {
                position: fixed !important;
                inset: 0 auto 0 0;
                /* inset-y-0 left-0 */
                transform: translateX(-100%);
                width: 18rem;
                /* w-72 */
            }

            #sidebar.sidebar-open {
                transform: translateX(0);
            }
        }

        /* Comportamiento ESCRITORIO */
        @media (min-width: 1024px) {
            #sidebar {
                position: relative !important;
                transform: translateX(0);
                width: 18rem;
                /* w-72 */
                opacity: 1;
            }

            #sidebar.sidebar-collapsed {
                width: 0 !important;
                transform: translateX(-100%);
                opacity: 0;
            }
        }

        /* Scrollbar personalizada para el nav */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-emerald-50 via-white to-green-100 min-h-screen text-gray-800">

    <div class="flex min-h-screen">

        <!-- SIDEBAR -->
        <aside id="sidebar"
            class="z-50 bg-gradient-to-b from-emerald-900 via-emerald-800 to-emerald-900 text-emerald-100 shadow-2xl flex flex-col overflow-hidden shrink-0">

            <!-- LOGO -->
            <div class="p-6 border-b border-emerald-700/40 shrink-0">
                <h1 class="text-2xl font-extrabold tracking-wide">
                    <span class="text-white">Agri</span>
                    <span class="text-emerald-300">Manager</span>
                </h1>
                <p class="text-xs text-emerald-300 mt-1 opacity-80">Panel Administrativo</p>
            </div>

            <!-- NAV -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto custom-scrollbar">

                @php
                    function active($pattern)
                    {
                        return request()->routeIs($pattern)
                            ? 'bg-white/10 text-white shadow-lg border border-white/10'
                            : 'hover:bg-white/10 hover:text-white';
                    }

                    $gestionActive = request()->routeIs('tipo_cosechas.*') ||
                        request()->routeIs('tipo_riegos.*') ||
                        request()->routeIs('tipo_semillas.*') ||
                        request()->routeIs('tipo_suelos.*') ||
                        request()->routeIs('tipo_insumos.*') ||
                        request()->routeIs('estados.*') ||
                        request()->routeIs('admin.usuarios.*') ||
                        request()->routeIs('admin.terrenos.*');

                    $seguimientoActive = request()->routeIs('admin.cosechas.*');
                @endphp

                <a href="{{ route('admin.dashboard') }}"
                    class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ active('admin.dashboard') }}">
                    <div class="w-1.5 h-6 bg-emerald-300 rounded-full opacity-0 group-hover:opacity-100 transition-all">
                    </div>
                    <span class="font-medium whitespace-nowrap">Inicio</span>
                </a>

                @if(auth()->guard('usuario')->user()->id_tipo_usuario != 3)
                    <!-- ACORDEÓN GESTIÓN Y CONTROL -->
                    <div class="space-y-1">
                        <button onclick="toggleAccordion('gestion-menu')"
                            class="w-full group flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 {{ $gestionActive ? 'bg-white/5 text-white' : 'hover:bg-white/10 hover:text-white' }}">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-1.5 h-6 bg-emerald-300 rounded-full {{ $gestionActive ? 'opacity-100' : 'opacity-0' }} group-hover:opacity-100 transition-all">
                                </div>
                                <span class="font-medium whitespace-nowrap">Gestión y Control</span>
                            </div>
                            <svg id="arrow-gestion-menu" xmlns="http://www.w3.org/2000/svg"
                                class="w-4 h-4 transition-transform duration-200 shrink-0 {{ $gestionActive ? 'rotate-180' : '' }}"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div id="gestion-menu"
                            class="{{ $gestionActive ? 'block' : 'hidden' }} pl-4 space-y-1 overflow-hidden transition-all duration-300">



                            <a href="{{ route('tipo_riegos.index') }}"
                                class="group flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all duration-200 {{ active('tipo_riegos.*') }}">
                                <div class="w-1 h-1 bg-emerald-400 rounded-full shrink-0"></div>
                                <span class="whitespace-nowrap">Tipos de Riego</span>
                            </a>

                            <a href="{{ route('tipo_semillas.index') }}"
                                class="group flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all duration-200 {{ active('tipo_semillas.*') }}">
                                <div class="w-1 h-1 bg-emerald-400 rounded-full shrink-0"></div>
                                <span class="whitespace-nowrap">Tipos de Semilla</span>
                            </a>

                            <a href="{{ route('tipo_suelos.index') }}"
                                class="group flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all duration-200 {{ active('tipo_suelos.*') }}">
                                <div class="w-1 h-1 bg-emerald-400 rounded-full shrink-0"></div>
                                <span class="whitespace-nowrap">Tipos de Suelo</span>
                            </a>

                            <a href="{{ route('admin.tipo_insumos.index') }}"
                                class="group flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all duration-200 {{ active('tipo_insumos.*') }}">
                                <div class="w-1 h-1 bg-emerald-400 rounded-full shrink-0"></div>
                                <span class="whitespace-nowrap">Tipos de Insumo</span>
                            </a>

                            <a href="{{ route('estados.index') }}"
                                class="group flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all duration-200 {{ active('estados.*') }}">
                                <div class="w-1 h-1 bg-emerald-400 rounded-full shrink-0"></div>
                                <span class="whitespace-nowrap">Estados</span>
                            </a>

                            <a href="{{ route('admin.usuarios.index') }}"
                                class="group flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all duration-200 {{ active('admin.usuarios.*') }}">
                                <div class="w-1 h-1 bg-emerald-400 rounded-full shrink-0"></div>
                                <span class="whitespace-nowrap">Gestión de Personal</span>
                            </a>

                            <a href="{{ route('admin.terrenos.index') }}"
                                class="group flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all duration-200 {{ active('admin.terrenos.*') }}">
                                <div class="w-1 h-1 bg-emerald-400 rounded-full shrink-0"></div>
                                <span class="whitespace-nowrap">Gestión de Terrenos</span>
                            </a>
                        </div>
                    </div>

                    <!-- ACORDEÓN SEGUIMIENTO DE CULTIVOS -->
                    <div class="space-y-1">
                        <button onclick="toggleAccordion('seguimiento-menu')"
                            class="w-full group flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 {{ $seguimientoActive ? 'bg-white/5 text-white' : 'hover:bg-white/10 hover:text-white' }}">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-1.5 h-6 bg-emerald-300 rounded-full {{ $seguimientoActive ? 'opacity-100' : 'opacity-0' }} group-hover:opacity-100 transition-all">
                                </div>
                                <span class="font-medium whitespace-nowrap">Seguimiento de Cultivos</span>
                            </div>
                            <svg id="arrow-seguimiento-menu" xmlns="http://www.w3.org/2000/svg"
                                class="w-4 h-4 transition-transform duration-200 shrink-0 {{ $seguimientoActive ? 'rotate-180' : '' }}"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div id="seguimiento-menu"
                            class="{{ $seguimientoActive ? 'block' : 'hidden' }} pl-4 space-y-1 overflow-hidden transition-all duration-300">
                            <a href="{{ route('admin.cosechas.index') }}"
                                class="group flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all duration-200 {{ active('admin.cosechas.*') }}">
                                <div class="w-1 h-1 bg-emerald-400 rounded-full shrink-0"></div>
                                <span class="whitespace-nowrap">Control de Cosechas</span>
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('admin.insumos.index') }}"
                        class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ active('admin.insumos.*') }}">
                        <div class="w-1.5 h-6 bg-emerald-300 rounded-full opacity-0 group-hover:opacity-100 transition-all">
                        </div>
                        <span class="font-medium whitespace-nowrap">Insumos</span>
                    </a>

                    <a href="{{ route('admin.proveedores.index') }}"
                        class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ active('admin.proveedores.*') }}">
                        <div class="w-1.5 h-6 bg-emerald-300 rounded-full opacity-0 group-hover:opacity-100 transition-all">
                        </div>
                        <span class="font-medium whitespace-nowrap">Proveedores</span>
                    </a>

                    <a href="{{ route('admin.licencias.index') }}"
                        class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ active('admin.licencias.*') }}">
                        <div class="w-1.5 h-6 bg-emerald-300 rounded-full opacity-0 group-hover:opacity-100 transition-all">
                        </div>
                        <span class="font-medium whitespace-nowrap">Mi Plan de Licencia</span>
                    </a>
                @endif

            </nav>

            <!-- FOOTER -->
            <div class="p-4 border-t border-emerald-700/40 text-xs text-emerald-300 opacity-70 shrink-0">
                © {{ date('Y') }} AgriManager
            </div>
        </aside>

        <!-- Overlay for mobile -->
        <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-40 hidden"></div>

        <!-- CONTENIDO -->
        <div class="flex-1 min-w-0 flex flex-col min-h-screen">

            <!-- HEADER -->
            <header class="relative z-50">

                <!-- Fondo -->
                <div
                    class="absolute inset-0 bg-gradient-to-r from-emerald-600 via-green-500 to-emerald-600 opacity-90 shadow-lg">
                </div>
                <div
                    class="absolute inset-0 bg-[radial-gradient(circle_at_30%_20%,rgba(255,255,255,0.25),transparent_60%)]">
                </div>

                <div class="relative px-6 lg:px-12 py-6 lg:py-8 flex justify-between items-center text-white">

                    <!-- IZQUIERDA -->
                    <div class="flex items-center gap-4 lg:gap-8">

                        <button id="sidebar-toggle" onclick="toggleSidebar()"
                            class="p-3 rounded-xl bg-white/10 hover:bg-white/20 backdrop-blur-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-white/30 z-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>

                        <div>
                            <h1 class="text-xl lg:text-3xl font-extrabold tracking-tight">
                                Panel de Administración
                            </h1>
                            <p class="hidden sm:block text-emerald-100 text-xs lg:text-sm mt-1 opacity-90">
                                Gestión del sistema
                            </p>
                        </div>

                    </div>

                    <!-- DERECHA -->
                    <div class="flex items-center gap-4 lg:gap-6">

                        <!-- Fecha -->
                        <div
                            class="hidden md:flex items-center gap-2 bg-white/10 backdrop-blur-md px-4 py-2 rounded-xl text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10m-13 9h16a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z" />
                            </svg>
                            {{ now()->format('d M, Y') }}
                        </div>

                        <!-- Usuario -->
                        <div class="relative group">

                            <div
                                class="flex items-center gap-3 lg:gap-4 bg-white text-gray-800 px-3 lg:px-5 py-2 lg:py-3 rounded-xl lg:rounded-2xl shadow-xl hover:scale-[1.02] transition-all duration-300 cursor-pointer">

                                <div
                                    class="w-8 h-8 lg:w-11 lg:h-11 rounded-lg lg:rounded-xl bg-gradient-to-tr from-emerald-500 to-green-600 text-white flex items-center justify-center font-bold shadow-md">
                                    {{ strtoupper(substr(auth()->guard('usuario')->user()->nombre ?? 'A', 0, 1)) }}
                                </div>

                                <div class="hidden sm:block text-left">
                                    <p class="font-semibold text-xs lg:text-sm">
                                        {{ Auth::guard('usuario')->user()->nombre ?? 'Admin' }}
                                    </p>
                                    <p class="text-[10px] lg:text-xs text-emerald-600 font-medium">
                                        Administrador
                                    </p>
                                </div>

                            </div>

                            <!-- Dropdown -->
                            <div
                                class="absolute right-0 top-full pt-2 w-56 opacity-0 scale-95 group-hover:opacity-100 group-hover:scale-100 transition-all duration-200 origin-top-right z-50 pointer-events-none group-hover:pointer-events-auto">
                                <div class="bg-white rounded-2xl shadow-2xl border border-emerald-100">

                                    <div class="p-4 border-b border-gray-100">
                                        <p class="text-sm font-semibold text-gray-800">
                                            {{ Auth::guard('usuario')->user()->nombre ?? 'Admin' }}
                                        </p>
                                        <p class="text-xs text-emerald-600">
                                            {{ Auth::guard('usuario')->user()->correo ?? '' }}
                                        </p>
                                    </div>

                                    <form action="{{ route('usuario.logout') }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="w-full text-left px-4 py-3 text-sm text-red-500 hover:bg-red-50 hover:text-red-600 rounded-b-2xl transition cursor-pointer">
                                            Cerrar Sesión
                                        </button>
                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>

            </header>

            <!-- MAIN -->
            <main class="p-4 lg:p-8 flex-1 min-w-0">

                <div
                    class="bg-white rounded-2xl lg:rounded-3xl shadow-2xl p-4 lg:p-8 border border-emerald-100 min-h-[70vh]">

                    <div class="mb-8">
                        <h3 class="text-xl lg:text-2xl font-bold text-emerald-800">
                            @yield('title', 'Admin Dashboard')
                        </h3>
                        <div class="w-16 h-1 bg-gradient-to-r from-emerald-400 to-green-500 rounded-full mt-2"></div>
                    </div>

                    @yield('content')

                </div>

            </main>

        </div>

    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            const overlay = document.getElementById("sidebar-overlay");
            const isMobile = window.innerWidth < 1024;

            if (isMobile) {
                const isOpen = sidebar.classList.toggle("sidebar-open");
                if (isOpen) {
                    overlay.classList.remove("hidden");
                } else {
                    overlay.classList.add("hidden");
                }
            } else {
                sidebar.classList.toggle("sidebar-collapsed");
            }

            // Forzar redimensionado de componentes (como gráficas) tras la transición
            setTimeout(() => {
                window.dispatchEvent(new Event('resize'));
            }, 350);
        }

        // Cerrar sidebar al hacer clic en el overlay (móvil)
        function closeSidebar() {
            const sidebar = document.getElementById("sidebar");
            const overlay = document.getElementById("sidebar-overlay");
            sidebar.classList.remove("sidebar-open");
            overlay.classList.add("hidden");
        }

        // Asegurar estado consistente al redimensionar
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                closeSidebar();
            }
        });

        function toggleAccordion(id) {
            const menu = document.getElementById(id);
            const arrow = document.getElementById('arrow-' + id);

            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                menu.classList.add('block');
                arrow.classList.add('rotate-180');
            } else {
                menu.classList.add('hidden');
                menu.classList.remove('block');
                arrow.classList.remove('rotate-180');
            }
        }
    </script>

    @stack('scripts')
    <script src="{{ asset('js/validation.js') }}"></script>
</body>

</html>