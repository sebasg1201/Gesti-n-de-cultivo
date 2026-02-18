<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>AgriManager</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gradient-to-br from-emerald-50 via-white to-green-100 min-h-screen text-gray-800">

    <div class="flex min-h-screen">

        <!-- SIDEBAR -->
        <aside id="sidebar"
            class="w-72 bg-gradient-to-b from-emerald-900 via-emerald-800 to-emerald-900 text-emerald-100 shadow-2xl transition-all duration-300 flex flex-col overflow-hidden">

            <!-- LOGO -->
            <div class="p-6 border-b border-emerald-700/40">
                <h1 class="text-2xl font-extrabold tracking-wide">
                    <span class="text-white">Agri</span>
                    <span class="text-emerald-300">Manager</span>
                </h1>
                <p class="text-xs text-emerald-300 mt-1 opacity-80">Sistema Administrativo</p>
            </div>

            <!-- NAV -->
            <nav class="flex-1 px-4 py-6 space-y-2">

                @php
                    function active($pattern)
                    {
                        return request()->routeIs($pattern)
                            ? 'bg-white/10 text-white shadow-lg border border-white/10'
                            : 'hover:bg-white/10 hover:text-white';
                    }
                @endphp

                <a href="{{ route('reportes.index') }}"
                    class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ active('reportes.*') }}">
                    <div class="w-1.5 h-6 bg-emerald-300 rounded-full opacity-0 group-hover:opacity-100 transition-all">
                    </div>
                    <span class="font-medium">Reportes</span>
                </a>

                <a href="{{ route('dashboard') }}"
                    class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ active('dashboard') }}">
                    <div class="w-1.5 h-6 bg-emerald-300 rounded-full opacity-0 group-hover:opacity-100 transition-all">
                    </div>
                    <span class="font-medium">Licencias</span>
                </a>

                <a href="{{ route('SuperAdmin.index') }}"
                    class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ active('SuperAdmin.*') }}">
                    <div class="w-1.5 h-6 bg-emerald-300 rounded-full opacity-0 group-hover:opacity-100 transition-all">
                    </div>
                    <span class="font-medium">Empresas</span>
                </a>

                <a href="{{ route('licencias.index') }}"
                    class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ active('licencias.*') }}">
                    <div class="w-1.5 h-6 bg-emerald-300 rounded-full opacity-0 group-hover:opacity-100 transition-all">
                    </div>
                    <span class="font-medium">Tipo de Licencias</span>
                </a>

                <a href="{{ route('solicitudes.index') }}"
                    class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ active('solicitudes.*') }}">
                    <div class="w-1.5 h-6 bg-emerald-300 rounded-full opacity-0 group-hover:opacity-100 transition-all">
                    </div>
                    <span class="font-medium">Solicitudes</span>
                </a>

            </nav>

            <!-- FOOTER SIDEBAR -->
            <div class="p-4 border-t border-emerald-700/40 text-xs text-emerald-300 opacity-70">
                © {{ date('Y') }} AgriManager
            </div>
        </aside>


        <!-- CONTENIDO -->
        <div class="flex-1 flex flex-col">

            <!-- HEADER -->
            <header class="relative z-50">

                <!-- Fondo decorativo -->
                <div class="absolute inset-0 bg-gradient-to-r from-emerald-600 via-green-500 to-emerald-600 opacity-90">
                </div>
                <div
                    class="absolute inset-0 bg-[radial-gradient(circle_at_30%_20%,rgba(255,255,255,0.25),transparent_60%)]">
                </div>

                <div class="relative px-12 py-8 flex justify-between items-center text-white">

                    <!-- IZQUIERDA -->
                    <div class="flex items-center gap-8">

                        <!-- Botón Sidebar -->
                        <button onclick="toggleSidebar()" class="p-3 rounded-xl bg-white/10 hover:bg-white/20 
                       backdrop-blur-md transition-all duration-200">

                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>

                        <!-- Título fuerte -->
                        <div>
                            <h1 class="text-3xl font-extrabold tracking-tight">
                                Panel de Administración
                            </h1>
                            <p class="text-emerald-100 text-sm mt-1 opacity-90">
                                Gestión avanzada del sistema AgriManager
                            </p>
                        </div>

                    </div>

                    <!-- DERECHA -->
                    <div class="flex items-center gap-6">

                        <!-- Fecha -->
                        <div class="hidden md:flex items-center gap-2 
                        bg-white/10 backdrop-blur-md 
                        px-4 py-2 rounded-xl text-sm">

                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10m-13 9h16a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z" />
                            </svg>

                            {{ now()->format('d M, Y') }}
                        </div>

                        <!-- Usuario -->
                        <div class="relative group">

                            <div class="flex items-center gap-4 
                            bg-white text-gray-800
                            px-5 py-3 rounded-2xl
                            shadow-2xl hover:scale-[1.03]
                            transition-all duration-300 cursor-pointer">

                                <div class="w-11 h-11 rounded-xl 
                                bg-gradient-to-tr from-emerald-500 to-green-600
                                text-white flex items-center justify-center font-bold shadow-md">
                                    {{ strtoupper(substr(auth()->user()->nombre, 0, 1)) }}
                                </div>

                                <div>
                                    <p class="font-semibold text-sm">
                                        {{ Auth::guard('superadmin')->user()->nombre ?? 'Super Admin' }}
                                    </p>
                                    <p class="text-xs text-emerald-600 font-medium">
                                        SuperAdmin
                                    </p>
                                </div>

                                <svg class="w-4 h-4 text-emerald-600 
                                transition-transform duration-300 
                                group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>

                            <!-- Dropdown -->
                            <div class="absolute right-0 mt-4 w-56 
                            bg-white rounded-2xl shadow-2xl 
                            border border-emerald-100
                            opacity-0 scale-95 
                            group-hover:opacity-100 group-hover:scale-100
                            transition-all duration-200 origin-top-right z-50">

                                <div class="p-4 border-b border-gray-100">
                                    <p class="text-sm font-semibold text-gray-800">
                                        {{ Auth::guard('superadmin')->user()->nombre ?? 'Super Admin' }}
                                    </p>
                                    <p class="text-xs text-emerald-600">
                                        Administrador del sistema
                                    </p>
                                </div>

                                <form action="{{ route('logout') }}" method="POST">
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

                <!-- Sombra inferior elegante -->
                <div class="absolute bottom-0 left-0 w-full h-6 
                bg-gradient-to-b from-transparent to-black/10">
                </div>

            </header>




            <!-- MAIN -->
            <main class="p-10 flex-1">

                <div class="bg-white rounded-3xl shadow-2xl p-10 border border-emerald-100 min-h-[70vh]">

                    <!-- Título decorativo -->
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-emerald-800">
                            @yield('title', 'AgroTech')
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

            if (sidebar.classList.contains("w-72")) {
                sidebar.classList.remove("w-72");
                sidebar.classList.add("w-0");
            } else {
                sidebar.classList.remove("w-0");
                sidebar.classList.add("w-72");
            }
        }
    </script>
@stack('scripts')
</body>

</html>