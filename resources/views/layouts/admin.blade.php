<!DOCTYPE html>
<html lang="es" class="text-[85%]">
<head>
    <meta charset="UTF-8">
    <script>
        // Inmediatamente aplicar el tema para evitar destellos blancos
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    @php
        $isWorker = in_array(auth()->guard('usuario')->user()->id_tipo_usuario, [2, 3]);
        $inicioRoute = $isWorker ? 'trabajador.dashboard' : 'admin.dashboard';
    @endphp
    <link rel="icon" type="image/jpeg" href="{{ asset('img/agrotech/logo.jpeg') }}">
    <title>AgroTech</title>
    @inject('notificationService', 'App\Services\NotificationService')
    @php
        $adminNotifications = $notificationService->getNotifications();
        $notifCount = count($adminNotifications);
    @endphp


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
        /* Animación para desaparecer alertas */
        @keyframes fadeOut {
            from { opacity: 1; transform: translateY(0); }
            to { opacity: 0; transform: translateY(-10px); }
        }
        .animate-fadeOut {
            animation: fadeOut 0.5s ease-out forwards;
        }

        /* Toasts */
        .toast-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-left: 4px solid #10b981;
            padding: 1rem;
            width: 320px;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            animation: slideInRight 0.4s ease-out forwards;
            pointer-events: auto;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .toast-card:hover { transform: scale(1.02); }
        .toast-card.hide { animation: slideOutRight 0.4s ease-in forwards; }

        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOutRight {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }

    </style>
</head>

<body class="bg-gradient-to-br from-emerald-50 via-white to-green-100 dark:from-slate-950 dark:via-slate-900 dark:to-emerald-950 min-h-screen text-gray-800 dark:text-emerald-50 transition-colors duration-300">

    <div class="flex min-h-screen">

        <!-- SIDEBAR -->
        @php
            // Clases dinámicas para sincronizar colores
            $sidebarClass = $isWorker 
                ? 'bg-gradient-to-b from-gray-900 via-emerald-950 to-gray-900 text-emerald-100 shadow-[20px_0_50px_rgba(0,0,0,0.3)]' 
                : 'bg-gradient-to-b from-emerald-900 via-emerald-800 to-emerald-900 text-emerald-100 shadow-2xl transition-all duration-300';
                
            $navbarClass = $isWorker
                ? 'bg-gradient-to-r from-gray-900 via-emerald-950 to-gray-900'
                : 'bg-gradient-to-r from-emerald-600 via-green-500 to-emerald-600 dark:from-emerald-900 dark:via-slate-900 dark:to-emerald-900 opacity-90';
        @endphp
        <aside id="sidebar" class="z-50 {{ $sidebarClass }} flex flex-col overflow-hidden shrink-0 relative transition-all duration-500">
            
            {{-- Elementos Decorativos de Fondo --}}
            <div class="absolute top-0 left-0 w-full h-1/2 bg-gradient-to-b from-emerald-500/10 to-transparent pointer-events-none"></div>
            <div class="absolute -left-20 top-40 w-40 h-40 bg-emerald-400/10 rounded-full blur-[80px] pointer-events-none"></div>
            <div class="absolute -right-20 bottom-40 w-40 h-40 bg-teal-400/5 rounded-full blur-[80px] pointer-events-none"></div>

            <!-- LOGO -->
            <div class="p-6 border-b border-emerald-700/40 shrink-0 relative">
                <h1 class="text-2xl font-black text-white tracking-widest leading-none">
                    Agri<span class="text-emerald-300">Manager</span>
                </h1>
                <p class="text-[10px] text-emerald-300 mt-1 opacity-80 uppercase tracking-[0.2em] font-black">
                    {{ $isWorker ? 'Portal del Trabajador' : 'Gestión de Cultivo' }}
                </p>
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
                        request()->routeIs('tipo_insumos.*') ||
                        request()->routeIs('tipo_suelos.*') ||
                        request()->routeIs('insumos.*') ||
                        request()->routeIs('estados.*') ||
                        request()->routeIs('admin.terrenos.*');

                    $seguimientoActive = request()->routeIs('admin.cosechas.*');
                @endphp

                <a href="{{ route($inicioRoute) }}"
                    class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 relative {{ active($inicioRoute) }}">
                    <div class="w-1.5 h-6 bg-emerald-300 rounded-full {{ request()->routeIs($inicioRoute) ? 'opacity-100' : 'opacity-0' }} group-hover:opacity-100 transition-all">
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
                                <span class="font-medium whitespace-nowrap dark:text-emerald-50">Gestión y Control</span>
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
                                <span class="whitespace-nowrap font-medium">Tipos de Riego</span>
                            </a>

                            <a href="{{ route('tipo_semillas.index') }}"
                                class="group flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all duration-200 {{ active('tipo_semillas.*') }}">
                                <div class="w-1 h-1 bg-emerald-400 rounded-full shrink-0"></div>
                                <span class="whitespace-nowrap font-medium">Tipos de Semilla</span>
                            </a>

                            <a href="{{ route('tipo_insumos.index') }}"
                                class="group flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all duration-200 {{ active('tipo_insumos.*') }}">
                                <div class="w-1 h-1 bg-emerald-400 rounded-full shrink-0"></div>
                                <span class="whitespace-nowrap font-medium">Tipos de Insumo</span>
                            </a>

                            <a href="{{ route('tipo_suelos.index') }}"
                                class="group flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all duration-300 {{ active('tipo_suelos.*') }}">
                                <div class="w-1 h-1 bg-emerald-400 rounded-full shrink-0 shadow-[0_0_5px_rgba(52,211,153,0.5)]"></div>
                                <span class="whitespace-nowrap font-medium">Tipos de Suelo</span>
                            </a>

                            <a href="{{ route('insumos.index') }}"
                                class="group flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all duration-200 {{ active('insumos.*') }}">
                                <div class="w-1 h-1 bg-emerald-400 rounded-full shrink-0"></div>
                                <span class="whitespace-nowrap font-medium">Inventario de Suministros</span>
                            </a>



                            <a href="{{ route('estados.index') }}"
                                class="group flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all duration-200 {{ active('estados.*') }}">
                                <div class="w-1 h-1 bg-emerald-400 rounded-full shrink-0"></div>
                                <span class="whitespace-nowrap dark:text-emerald-100">Estados</span>
                            </a>



                            <a href="{{ route('admin.terrenos.index') }}"
                                class="group flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all duration-200 {{ active('admin.terrenos.*') }}">
                                <div class="w-1 h-1 bg-emerald-400 rounded-full shrink-0"></div>
                                <span class="whitespace-nowrap dark:text-emerald-100">Gestión de Terrenos</span>
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
                                <span class="font-medium whitespace-nowrap">Cosechas</span>
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
                                <span class="whitespace-nowrap dark:text-emerald-100">Control de Cosechas</span>
                            </a>
                            <a href="{{ route('admin.tareas.index') }}"
                                class="group flex items-center gap-3 px-4 py-2 rounded-lg text-sm transition-all duration-200 {{ active('admin.tareas.index') }}">
                                <div class="w-1 h-1 bg-emerald-400 rounded-full shrink-0"></div>
                                <span class="whitespace-nowrap dark:text-emerald-100">Gestión de Tareas</span>
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('admin.usuarios.index') }}"
                        class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 relative {{ active('admin.usuarios.*') }}">
                        <div class="w-1.5 h-6 bg-emerald-300 rounded-full {{ request()->routeIs('admin.usuarios.*') ? 'opacity-100' : 'opacity-0' }} group-hover:opacity-100 transition-all">
                        </div>
                        <span class="font-medium whitespace-nowrap">Personal</span>
                    </a>

                    <a href="{{ route('admin.cultivos.index') }}"
                        class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 relative {{ active('admin.cultivos.*') }}">
                        <div class="w-1 h-5 bg-emerald-400 rounded-full {{ request()->routeIs('admin.cultivos.*') ? 'opacity-100' : 'opacity-0' }} group-hover:opacity-100 transition-all shadow-[0_0_10px_rgba(52,211,153,0.8)]">
                        </div>
                        <span class="font-bold whitespace-nowrap tracking-tight">Cultivos</span>
                    </a>

                    <a href="{{ route('admin.proveedores.index') }}"
                        class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 relative {{ active('admin.proveedores.*') }}">
                        <div class="w-1.5 h-6 bg-emerald-300 rounded-full {{ request()->routeIs('admin.proveedores.*') ? 'opacity-100' : 'opacity-0' }} group-hover:opacity-100 transition-all">
                        </div>
                        <span class="font-medium whitespace-nowrap">Proveedores</span>
                    </a>

                    <a href="{{ route('admin.licencias.index') }}"
                        class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 relative {{ active('admin.licencias.*') }}">
                        <div class="w-1.5 h-6 bg-emerald-300 rounded-full {{ request()->routeIs('admin.licencias.*') ? 'opacity-100' : 'opacity-0' }} group-hover:opacity-100 transition-all">
                        </div>
                        <span class="font-medium whitespace-nowrap">Mi Plan de Licencia</span>
                    </a>

                    {{-- Soporte para Admin --}}
                    <a href="{{ route('admin.soporte.index') }}"
                        class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 relative {{ active('admin.soporte.*') }}">
                        <div class="w-1.5 h-6 bg-emerald-300 rounded-full {{ request()->routeIs('admin.soporte.*') ? 'opacity-100' : 'opacity-0' }} group-hover:opacity-100 transition-all">
                        </div>
                        <span class="font-medium whitespace-nowrap">Bandeja de Soporte</span>
                    </a>
                @endif

                @if(auth()->guard('usuario')->user()->id_tipo_usuario == 3)
                    <a href="{{ route('trabajador.calendario') }}"
                        class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 relative {{ active('trabajador.calendario') }}">
                        <div class="w-1 h-5 bg-emerald-400 rounded-full {{ request()->routeIs('trabajador.calendario') ? 'opacity-100' : 'opacity-0' }} group-hover:opacity-100 transition-all shadow-[0_0_10px_rgba(52,211,153,0.8)]">
                        </div>
                        <span class="font-bold whitespace-nowrap tracking-tight">Mi Calendario</span>
                    </a>

                    <a href="{{ route('trabajador.pagos') }}"
                        class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 relative {{ active('trabajador.pagos') }}">
                        <div class="w-1 h-5 bg-emerald-400 rounded-full {{ request()->routeIs('trabajador.pagos') ? 'opacity-100' : 'opacity-0' }} group-hover:opacity-100 transition-all shadow-[0_0_10px_rgba(52,211,153,0.8)]">
                        </div>
                        <span class="font-bold whitespace-nowrap tracking-tight">Mis Pagos</span>
                    </a>

                    <a href="{{ route('trabajador.soporte') }}"
                        class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 relative {{ active('trabajador.soporte') }}">
                        <div class="w-1 h-5 bg-emerald-400 rounded-full {{ request()->routeIs('trabajador.soporte') ? 'opacity-100' : 'opacity-0' }} group-hover:opacity-100 transition-all shadow-[0_0_10px_rgba(52,211,153,0.8)]">
                        </div>
                        <span class="font-bold whitespace-nowrap tracking-tight">Soporte y Dudas</span>
                    </a>
                @endif

                <a href="{{ route('admin.configuracion') }}"
                    class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 relative {{ active('admin.configuracion') }}">
                    <div class="w-1 h-5 bg-emerald-400 rounded-full {{ request()->routeIs('admin.configuracion') ? 'opacity-100' : 'opacity-0' }} group-hover:opacity-100 transition-all shadow-[0_0_10px_rgba(52,211,153,0.8)]">
                    </div>
                    <span class="font-bold whitespace-nowrap tracking-tight">Configuración</span>
                </a>

            </nav>

            <!-- FOOTER -->
            <div class="p-4 border-t border-emerald-700/40 text-xs text-emerald-300 opacity-70 shrink-0">
                © {{ date('Y') }} AgroTech
            </div>
        </aside>

        <!-- Overlay for mobile -->
        <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-40 hidden"></div>

        <!-- CONTENIDO -->
        <div class="flex-1 min-w-0 flex flex-col min-h-screen">

            <!-- HEADER -->
            <header class="relative z-50">

                <!-- Fondo -->
                <div class="absolute inset-0 {{ $navbarClass }} shadow-lg"></div>
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

                        <div class="flex items-center gap-3">
                            <img src="{{ asset('img/agrotech/logo.jpeg') }}" class="w-10 h-10 object-contain rounded-xl shadow-sm" alt="AgroTech Logo">
                            <div>
                                <h1 class="text-xl lg:text-3xl font-extrabold tracking-tight leading-none text-white">
                                    Agro<span class="text-emerald-300">Tech</span>
                                </h1>
                            </div>
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

                        <!-- Theme Toggle Header -->
                        <button id="theme-toggle-header" type="button" class="hidden md:flex p-2.5 lg:p-3 rounded-xl bg-white/10 hover:bg-white/20 backdrop-blur-md transition-all duration-200 cursor-pointer focus:outline-none border border-white/20 shadow-lg" title="Cambiar Tema">
                            <svg class="w-5 h-5 lg:w-6 lg:h-6 text-white hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            <svg class="w-5 h-5 lg:w-6 lg:h-6 text-white block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        </button>

                        <!-- Notificaciones -->
                        <div class="relative" id="notif-wrapper">
                            <button onclick="toggleNotifPanel()" id="notif-btn"
                                class="relative p-2.5 lg:p-3 rounded-xl bg-white/10 hover:bg-white/20 backdrop-blur-md transition-all duration-200 cursor-pointer focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 lg:w-6 lg:h-6 text-white" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                @if($notifCount > 0)
                                    <span id="notif-badge"
                                        class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold w-4 h-4 lg:w-5 lg:h-5 rounded-full flex items-center justify-center shadow-lg border-2 border-white/30 transition-all duration-300">
                                        {{ $notifCount }}
                                    </span>
                                @endif
                            </button>

                            <!-- PANEL DE NOTIFICACIONES -->
                            <div id="notif-panel"
                                class="hidden absolute right-0 mt-3 w-80 bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-emerald-100 dark:border-emerald-900/50 z-[100] overflow-hidden">

                                
                                <div class="px-5 py-4 bg-gradient-to-r from-emerald-600 to-green-500 flex items-center justify-between">
                                    <span class="text-white font-bold text-sm">Alertas del Sistema</span>
                                    <span class="bg-white/20 text-white text-[10px] font-semibold px-2 py-0.5 rounded-full">
                                        {{ $notifCount }} {{ $notifCount == 1 ? 'pendiente' : 'pendientes' }}
                                    </span>
                                </div>

                                <div class="max-h-80 overflow-y-auto divide-y divide-gray-100">
                                    @forelse($adminNotifications as $notif)
                                        <a href="{{ $notif['url'] }}" class="flex items-start gap-3 px-4 py-3.5 hover:bg-emerald-50 transition-colors duration-150 decoration-none group">
                                            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm mt-0.5 
                                                {{ $notif['type'] == 'irrigation' ? 'bg-blue-100 text-blue-600' : ($notif['type'] == 'stock' ? 'bg-amber-100 text-amber-600' : 'bg-red-100 text-red-600') }}">
                                                @if($notif['type'] == 'irrigation')
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4a2 2 0 012-2m16 0h-2M4 13H6m10-4V7a1 1 0 00-1-1H9a1 1 0 00-1 1v2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                @elseif($notif['type'] == 'stock')
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                @else
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-semibold text-gray-800 group-hover:text-emerald-700 transition-colors">{{ $notif['title'] }}</p>
                                                <p class="text-xs text-gray-500 mt-0.5 leading-relaxed">{{ $notif['message'] }}</p>
                                                <p class="text-[10px] text-emerald-600 font-medium mt-1 uppercase tracking-wider">
                                                    {{ $notif['date']->diffForHumans() }}
                                                </p>
                                            </div>
                                        </a>
                                    @empty
                                        <div class="py-10 text-center">
                                            <svg class="w-10 h-10 mx-auto text-gray-200 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4a2 2 0 012-2m16 0h-2M4 13H6m10-4V7a1 1 0 00-1-1H9a1 1 0 00-1 1v2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            <p class="text-sm text-gray-400">No hay alertas pendientes</p>
                                        </div>
                                    @endforelse
                                </div>

                                @if($notifCount > 0)
                                    <div class="p-3 bg-gray-50 border-t border-gray-100 text-center">
                                        <p class="text-[10px] text-gray-400 font-medium italic">Mantén tus cultivos al día</p>
                                    </div>
                                @endif
                            </div>
                        </div>


                        <!-- Usuario -->
                        <div class="relative group">
                            <div
                                class="flex items-center gap-3 lg:gap-4 bg-white dark:bg-slate-800 text-gray-800 dark:text-emerald-100 px-3 lg:px-5 py-2 lg:py-3 rounded-xl lg:rounded-2xl shadow-xl dark:shadow-slate-900/50 hover:scale-[1.02] transition-all duration-300 cursor-pointer border dark:border-emerald-900/30">

                                <div
                                    class="w-8 h-8 lg:w-11 lg:h-11 rounded-lg lg:rounded-xl bg-gradient-to-tr from-emerald-500 to-green-600 text-white flex items-center justify-center font-bold shadow-md">
                                    {{ strtoupper(substr(auth()->guard('usuario')->user()->nombre ?? 'A', 0, 1)) }}
                                </div>

                                <div class="hidden sm:block text-left">
                                    <p class="font-semibold text-xs lg:text-sm dark:text-emerald-50">
                                        {{ Auth::guard('usuario')->user()->nombre ?? 'Admin' }}
                                    </p>
                                    <p class="text-[10px] lg:text-xs text-emerald-600 dark:text-emerald-400 font-medium">
                                        {{ Auth::guard('usuario')->user()->tipoUsuario->tipo_usuario ?? 'Usuario' }}
                                    </p>
                                </div>

                            </div>

                            <!-- Dropdown -->
                            <div
                                class="absolute right-0 top-full pt-2 w-56 opacity-0 scale-95 group-hover:opacity-100 group-hover:scale-100 transition-all duration-200 origin-top-right z-50 pointer-events-none group-hover:pointer-events-auto">
                                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-emerald-100 dark:border-emerald-800/50">

                                    <div class="p-4 border-b border-gray-100 dark:border-emerald-900/30">
                                        <p class="text-sm font-semibold text-gray-800 dark:text-emerald-50">
                                            {{ Auth::guard('usuario')->user()->nombre ?? 'Admin' }}
                                        </p>
                                        <p class="text-xs text-emerald-600 dark:text-emerald-400">
                                            {{ Auth::guard('usuario')->user()->correo ?? '' }}
                                        </p>
                                    </div>

                                    <a href="{{ route('admin.configuracion') }}"
                                        class="w-full block text-left px-4 py-3 text-sm text-gray-700 dark:text-emerald-100 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 transition">
                                        Configuración del Perfil
                                    </a>


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
                    class="bg-white dark:bg-slate-800/50 dark:backdrop-blur-sm rounded-2xl lg:rounded-3xl shadow-2xl p-4 lg:p-8 border border-emerald-100 dark:border-emerald-900/30 min-h-[70vh]">

                    <div class="mb-8">
                        <h3 class="text-xl lg:text-2xl font-bold text-emerald-800 dark:text-emerald-300">
                            @yield('title', 'AgriManager')
                        </h3>
                        <div class="w-16 h-1 bg-gradient-to-r from-emerald-400 to-green-500 rounded-full mt-2"></div>
                    </div>

                    @if(session('success'))
                        <div class="auto-dismiss mb-6 p-4 bg-emerald-100 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center gap-3 shadow-sm animate-fade-in-down">
                            <svg class="h-5 w-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span class="font-bold text-sm">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="auto-dismiss mb-6 p-4 bg-red-100 border border-red-200 text-red-800 rounded-2xl flex items-center gap-3 shadow-sm animate-shake">
                            <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            <span class="font-bold text-sm">{{ session('error') }}</span>
                        </div>
                    @endif

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

            setTimeout(() => {
                window.dispatchEvent(new Event('resize'));
            }, 350);
        }

        function closeSidebar() {
            const sidebar = document.getElementById("sidebar");
            const overlay = document.getElementById("sidebar-overlay");
            sidebar.classList.remove("sidebar-open");
            overlay.classList.add("hidden");
        }

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

        // Auto-dismiss alerts
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('.auto-dismiss');
                alerts.forEach(function(alert) {
                    alert.classList.add('fadeOut');
                    setTimeout(() => alert.remove(), 500);
                });
            }, 5000);
        });

        /* ==================== NOTIFICACIONES ==================== */
        let notifPanelOpen = false;

        function toggleNotifPanel() {
            const panel = document.getElementById('notif-panel');
            if(!panel) return;
            
            notifPanelOpen = !notifPanelOpen;
            if (notifPanelOpen) {
                panel.classList.remove('hidden');
                panel.style.opacity = '0';
                panel.style.transform = 'translateY(-10px)';
                requestAnimationFrame(() => {
                    panel.style.transition = 'all 0.2s ease-out';
                    panel.style.opacity = '1';
                    panel.style.transform = 'translateY(0)';
                });
            } else {
                panel.style.opacity = '0';
                panel.style.transform = 'translateY(-10px)';
                setTimeout(() => panel.classList.add('hidden'), 200);
            }
        }

        document.addEventListener('click', function (e) {
            const wrapper = document.getElementById('notif-wrapper');
            if (wrapper && !wrapper.contains(e.target) && notifPanelOpen) {
                toggleNotifPanel();
            }
        });

        /* ==================== TOASTS ==================== */
        function showToast(notif) {
            const container = document.getElementById('toast-container');
            if(!container) return;

            const toast = document.createElement('div');
            toast.className = 'toast-card';
            if (notif.type === 'stock') toast.style.borderLeftColor = '#f59e0b';
            if (notif.type === 'insecticide') toast.style.borderLeftColor = '#ef4444';
            if (notif.type === 'irrigation') toast.style.borderLeftColor = '#3b82f6';

            toast.innerHTML = `
                <div class="flex-1">
                    <p class="text-sm font-bold text-gray-800">${notif.title}</p>
                    <p class="text-xs text-gray-500 mt-0.5">${notif.message}</p>
                </div>
            `;

            toast.onclick = () => window.location.href = notif.url;
            container.appendChild(toast);

            setTimeout(() => {
                toast.classList.add('hide');
                setTimeout(() => toast.remove(), 400);
            }, 10000);
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Sincronización del Tema
            const toggleHeader = document.getElementById('theme-toggle-header');
            if (toggleHeader) {
                toggleHeader.addEventListener('click', () => {
                    const html = document.documentElement;
                    if (html.classList.contains('dark')) {
                        html.classList.remove('dark');
                        localStorage.setItem('theme', 'light');
                    } else {
                        html.classList.add('dark');
                        localStorage.setItem('theme', 'dark');
                    }
                    window.dispatchEvent(new Event('themeChanged'));
                });
            }

            const notifications = {!! json_encode($adminNotifications) !!};
            const shownToasts = JSON.parse(sessionStorage.getItem('shownToasts') || '[]');
            
            let shownCount = 0;
            notifications.forEach(n => {
                const notifId = n.type + '-' + n.id;
                if (!shownToasts.includes(notifId) && shownCount < 3) {
                    setTimeout(() => showToast(n), shownCount * 500);
                    shownToasts.push(notifId);
                    shownCount++;
                }
            });
            sessionStorage.setItem('shownToasts', JSON.stringify(shownToasts));
        });
    </script>


    <div id="toast-container" class="fixed bottom-6 right-6 z-[1000] flex flex-col gap-3 pointer-events-none"></div>

    @stack('scripts')
    <script src="{{ asset('js/validation.js') }}"></script>
</body>


</html>
