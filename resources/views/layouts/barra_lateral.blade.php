<!DOCTYPE html>
<html lang="es" class="text-[85%]">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

                @php
                    $nuevasSolicitudes = \App\Models\SolicitudCompra::where('id_estado', 1)->count();
                    $notificacionesPendientes = \App\Models\SolicitudCompra::with(['empresa', 'tipoLicencia'])
                        ->where('id_estado', 1)
                        ->orderBy('fecha_solicitud', 'desc')
                        ->take(10)
                        ->get();
                @endphp
                <a href="{{ route('solicitudes.index') }}"
                    class="group flex justify-between items-center px-4 py-3 rounded-xl transition-all duration-200 {{ active('solicitudes.*') }}">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-1.5 h-6 bg-emerald-300 rounded-full opacity-0 group-hover:opacity-100 transition-all">
                        </div>
                        <span class="font-medium">Solicitudes</span>
                    </div>
                    @if($nuevasSolicitudes > 0 && !request()->routeIs('solicitudes.*'))
                        <span class="bg-green-500 text-white text-xs font-bold px-2 py-0.5 rounded-full shadow-md">
                            {{ $nuevasSolicitudes }}
                        </span>
                    @endif
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
                       backdrop-blur-md transition-all duration-200 cursor-pointer">

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

                        <!-- NOTIFICACIONES -->
                        <div class="relative" id="notif-wrapper">
                            <button onclick="toggleNotifPanel()" id="notif-btn"
                                class="relative p-3 rounded-xl bg-white/10 hover:bg-white/20 backdrop-blur-md transition-all duration-200 cursor-pointer focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                @if($nuevasSolicitudes > 0)
                                    <span id="notif-badge"
                                        class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center shadow-lg border-2 border-white/30 transition-all duration-300">
                                        {{ $nuevasSolicitudes }}
                                    </span>
                                @else
                                    <span id="notif-badge"
                                        class="hidden absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center shadow-lg border-2 border-white/30">0</span>
                                @endif
                            </button>

                            <!-- PANEL DE NOTIFICACIONES -->
                            <div id="notif-panel"
                                class="hidden absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-2xl border border-emerald-100 z-50 overflow-hidden">

                                <!-- Cabecera del panel -->
                                <div
                                    class="px-5 py-4 bg-gradient-to-r from-emerald-600 to-green-500 flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                        </svg>
                                        <span class="text-white font-bold text-sm">Solicitudes Pendientes</span>
                                    </div>
                                    <span id="notif-count-label"
                                        class="bg-white/20 text-white text-xs font-semibold px-2.5 py-0.5 rounded-full">
                                        {{ $nuevasSolicitudes }} {{ $nuevasSolicitudes == 1 ? 'nueva' : 'nuevas' }}
                                    </span>
                                </div>

                                <!-- Lista de notificaciones -->
                                <div id="notif-list" class="max-h-80 overflow-y-auto divide-y divide-gray-100">
                                    @forelse($notificacionesPendientes as $notif)
                                        <div class="notif-item flex items-start gap-3 px-4 py-3.5 hover:bg-emerald-50 transition-colors duration-150 group"
                                            data-notif-id="{{ $notif->id_solicitud ?? $loop->index }}">
                                            <!-- Icono empresa -->
                                            <div
                                                class="w-9 h-9 rounded-xl bg-gradient-to-tr from-emerald-500 to-green-400 text-white flex items-center justify-center font-bold text-sm flex-shrink-0 shadow-sm mt-0.5">
                                                {{ strtoupper(substr($notif->empresa->nombre_empresa ?? 'E', 0, 1)) }}
                                            </div>

                                            <!-- Info -->
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-semibold text-gray-800 truncate">
                                                    {{ $notif->empresa->nombre_empresa ?? 'Empresa desconocida' }}
                                                </p>
                                                <p class="text-xs text-emerald-600 font-medium mt-0.5">
                                                    {{ $notif->tipoLicencia->nombre_licencia ?? 'Plan desconocido' }}
                                                </p>
                                                <p class="text-xs text-gray-400 mt-1">
                                                    {{ \Carbon\Carbon::parse($notif->fecha_solicitud)->diffForHumans() }}
                                                </p>
                                            </div>

                                            <!-- Botón dismiss visual -->
                                            <button onclick="dismissNotif(this)" title="Descartar"
                                                class="opacity-0 group-hover:opacity-100 transition-opacity duration-150 text-gray-300 hover:text-red-400 hover:bg-red-50 rounded-lg p-1 flex-shrink-0 cursor-pointer focus:outline-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    @empty
                                        <div id="notif-empty"
                                            class="flex flex-col items-center justify-center py-10 text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mb-3 text-gray-200"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                            </svg>
                                            <p class="text-sm font-medium">Sin notificaciones nuevas</p>
                                        </div>
                                    @endforelse
                                </div>

                                <!-- Footer del panel -->
                                @if($nuevasSolicitudes > 0)
                                    <div class="px-4 py-3 bg-gray-50 border-t border-gray-100">
                                        <a href="{{ route('solicitudes.index') }}"
                                            class="flex items-center justify-center gap-2 w-full text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition-colors py-1">
                                            Ver todas las solicitudes
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

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

            <style>
                @layer utilities {
                    @keyframes loadingBar {
                        0% {
                            transform: translateX(-100%);
                        }

                        50% {
                            transform: translateX(30%);
                        }

                        100% {
                            transform: translateX(100%);
                        }
                    }

                    .animate-loading-bar {
                        animation: loadingBar 1.5s ease-in-out infinite;
                    }
                }
            </style>




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


    <!-- POPUP DE BIENVENIDA -->
    @if($nuevasSolicitudes > 0)
        <div id="welcome-notif-popup"
            class="fixed bottom-6 right-6 z-[9999] max-w-sm w-full bg-white rounded-2xl shadow-2xl border border-emerald-100 overflow-hidden"
            style="transform: translateY(120%); transition: transform 0.5s cubic-bezier(0.34,1.56,0.64,1);">

            <!-- Barra de progreso animada -->
            <div class="h-1 bg-gradient-to-r from-emerald-400 to-green-500">
                <div id="popup-progress" class="h-full bg-white/40 origin-left" style="transform: scaleX(0);"></div>
            </div>

            <div class="p-5">
                <div class="flex items-start gap-4">
                    <!-- Icono -->
                    <div
                        class="w-12 h-12 rounded-xl bg-gradient-to-tr from-emerald-500 to-green-400 flex items-center justify-center shadow-md flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>

                    <!-- Texto -->
                    <div class="flex-1">
                        <p class="font-bold text-gray-800 text-sm">¡Solicitudes pendientes!</p>
                        <p class="text-gray-500 text-xs mt-1">
                            Tienes <span class="font-semibold text-emerald-600">{{ $nuevasSolicitudes }}
                                {{ $nuevasSolicitudes == 1 ? 'solicitud' : 'solicitudes' }} de compra</span>
                            {{ $nuevasSolicitudes == 1 ? 'pendiente' : 'pendientes' }} por revisar.
                        </p>

                        <div class="flex gap-2 mt-3">
                            <a href="{{ route('solicitudes.index') }}" onclick="closeWelcomePopup()"
                                class="px-3 py-1.5 bg-emerald-500 text-white text-xs font-semibold rounded-lg hover:bg-emerald-600 transition-colors">
                                Ver solicitudes
                            </a>
                            <button onclick="closeWelcomePopup()"
                                class="px-3 py-1.5 bg-gray-100 text-gray-600 text-xs font-semibold rounded-lg hover:bg-gray-200 transition-colors cursor-pointer">
                                Ahora no
                            </button>
                        </div>
                    </div>

                    <!-- Cerrar -->
                    <button onclick="closeWelcomePopup()"
                        class="text-gray-300 hover:text-gray-500 transition-colors cursor-pointer flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <script>
        /* ==================== SIDEBAR ==================== */
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

        /* ==================== NOTIFICACIONES ==================== */
        let notifPanelOpen = false;

        function toggleNotifPanel() {
            const panel = document.getElementById('notif-panel');
            notifPanelOpen = !notifPanelOpen;
            if (notifPanelOpen) {
                panel.classList.remove('hidden');
                // Pequeña animación de entrada
                panel.style.opacity = '0';
                panel.style.transform = 'translateY(-8px)';
                requestAnimationFrame(() => {
                    panel.style.transition = 'opacity 0.2s ease, transform 0.2s ease';
                    panel.style.opacity = '1';
                    panel.style.transform = 'translateY(0)';
                });
            } else {
                panel.style.opacity = '0';
                panel.style.transform = 'translateY(-8px)';
                setTimeout(() => panel.classList.add('hidden'), 200);
            }
        }

        // Cerrar panel al hacer clic fuera
        document.addEventListener('click', function (e) {
            const wrapper = document.getElementById('notif-wrapper');
            if (wrapper && !wrapper.contains(e.target) && notifPanelOpen) {
                toggleNotifPanel();
            }
        });

        // Descartar notificación (solo visual)
        function dismissNotif(btn) {
            const item = btn.closest('.notif-item');
            item.style.transition = 'opacity 0.3s ease, max-height 0.3s ease, padding 0.3s ease';
            item.style.opacity = '0';
            item.style.maxHeight = item.offsetHeight + 'px';
            requestAnimationFrame(() => {
                item.style.maxHeight = '0';
                item.style.paddingTop = '0';
                item.style.paddingBottom = '0';
            });
            setTimeout(() => {
                item.remove();
                updateBadge();
            }, 320);
        }

        function updateBadge() {
            const remaining = document.querySelectorAll('.notif-item').length;
            const badge = document.getElementById('notif-badge');
            const countLabel = document.getElementById('notif-count-label');

            if (badge) {
                if (remaining === 0) {
                    badge.classList.add('hidden');
                    // Mostrar estado vacío
                    const list = document.getElementById('notif-list');
                    if (list && !list.querySelector('#notif-empty')) {
                        list.innerHTML = `<div id="notif-empty" class="flex flex-col items-center justify-center py-10 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mb-3 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <p class="text-sm font-medium">Sin notificaciones nuevas</p>
                        </div>`;
                    }
                } else {
                    badge.textContent = remaining;
                    badge.classList.remove('hidden');
                }
            }

            if (countLabel) {
                countLabel.textContent = remaining + (remaining === 1 ? ' nueva' : ' nuevas');
            }
        }

        /* ==================== POPUP BIENVENIDA ==================== */
        const POPUP_SESSION_KEY = 'agri_notif_shown';

        function closeWelcomePopup() {
            const popup = document.getElementById('welcome-notif-popup');
            if (!popup) return;
            popup.style.transform = 'translateY(120%)';
            popup.style.opacity = '0';
            setTimeout(() => popup.remove(), 500);
            sessionStorage.setItem(POPUP_SESSION_KEY, '1');
        }

        document.addEventListener('DOMContentLoaded', function () {
            const popup = document.getElementById('welcome-notif-popup');

            // Auto-dismiss para alertas del sistema
            document.querySelectorAll('.auto-dismiss').forEach(function (el) {
                setTimeout(function () {
                    el.style.transition = 'opacity 0.6s ease';
                    el.style.opacity = '0';
                    setTimeout(function () { el.remove(); }, 600);
                }, 10000);
            });

            // Mostrar popup solo una vez por sesión de pestaña
            if (popup && !sessionStorage.getItem(POPUP_SESSION_KEY)) {
                setTimeout(() => {
                    popup.style.transform = 'translateY(0)';
                }, 600);

                // Auto-dismiss tras 8 segundos
                setTimeout(closeWelcomePopup, 8600);
            } else if (popup) {
                popup.remove();
            }
        });
    </script>
    <script src="{{ asset('js/form-validation.js') }}"></script>
    @stack('scripts')
</body>

</html>