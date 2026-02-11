<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>AgriManager</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">


    <div class="flex">

        <!-- SIDEBAR -->
        <aside id="sidebar" class="pb-8 w-64 bg-white shadow-md min-h-screen transition-all duration-300">

            <div class="p-6 text-xl font-bold text-green-600">
                AgriManager
            </div>

            <nav class="px-4 space-y-2">

                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 p-2 rounded
                    {{ request()->routeIs('dashboard') ? 'bg-green-100 text-green-700' : 'hover:bg-gray-100' }}">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 text-green-600">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 13h8V3H3v10zm10 8h8v-6h-8v6zm0-10h8V3h-8v8zM3 21h8v-6H3v6z" />
                    </svg>
                    Licencias
                </a>

                <a href="{{ route('SuperAdmin.index') }}" class="flex items-center gap-3 p-2 rounded
                    {{ request()->routeIs('SuperAdmin.*') ? 'bg-green-100 text-green-700' : 'hover:bg-gray-100' }}">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 text-blue-600">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 20h5V4H2v16h5m10 0v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6m10 0H7" />
                    </svg>
                    Empresas
                </a>

                <a href="{{ route('licencias.index') }}" class="flex items-center gap-3 p-2 rounded
                    {{ request()->routeIs('licencias.*') ? 'bg-green-100 text-green-700' : 'hover:bg-gray-100' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 text-yellow-600">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8c-3 0-5 1.5-5 3s2 3 5 3 5 1.5 5 3-2 3-5 3m0-12V4m0 16v-2" />
                    </svg>
                    Tipo de Licencias
                </a>

                <a href="{{ route('solicitudes.index') }}" class="flex items-center gap-3 p-2 rounded
                    {{ request()->routeIs('solicitudes.*') ? 'bg-green-100 text-green-700' : 'hover:bg-gray-100' }}">

                    <svg class="w-5 h-5 text-gray-400 group-hover:text-green-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                    Solicitudes De Compra
                </a>

            </nav>

        </aside>

        <!-- CONTENIDO -->
        <div class="flex-1">

            <!-- HEADER SUPERIOR  -->
            <header class="bg-white shadow p-4 flex justify-between items-center">

                <!-- IZQUIERDA -->
                <div class="flex items-center">

                    <button onclick="toggleSidebar()" class="mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-7 h-7">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                        </svg>
                    </button>

                    <h2 class="font-semibold">Panel de Administración</h2>

                </div>


                <!-- DERECHA → USUARIO -->
                <div class="flex items-center gap-3 bg-gray-50 p-2 pr-4 rounded shadow-sm">

                    <!-- FOTO -->
                    <img src="https://ui-avatars.com/api/?name=Usuario+Demo&background=16a34a&color=fff" alt="Usuario"
                        class="w-10 h-10 rounded-full object-cover">

                    <!-- DATOS -->
                    <div class="text-right w-20">
                        <p class="font-semibold">
                            {{ Auth::guard('superadmin')->user()->nombre ?? 'Super Admin' }}
                        </p>

                        <span class="text-xs text-gray-500 block">
                            SuperAdmin
                        </span>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-xs text-red-500 hover:text-red-700 underline">
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>

                </div>

            </header>

            <main class="p-8">
                @yield('content')
            </main>

        </div>

    </div>

    <!-- SCRIPT -->
    <script>
        function toggleSidebar() {

            const sidebar = document.getElementById("sidebar");

            if (sidebar.classList.contains("w-64")) {
                sidebar.classList.remove("w-64");
                sidebar.classList.add("w-0");
                sidebar.classList.add("overflow-hidden");
            } else {
                sidebar.classList.remove("w-0");
                sidebar.classList.remove("overflow-hidden");
                sidebar.classList.add("w-64");
            }
        }
    </script>

</body>

</html>