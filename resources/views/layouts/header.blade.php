<header class="w-full sticky top-0 z-50">
    <div class="w-full backdrop-blur-md bg-white/80 border-b border-white/20">

        <div class="max-w-8xl mx-auto px-6 py-4
                    flex items-center justify-between">

            {{-- LOGO --}}
            <div class="flex items-center gap-3 font-bold text-xl text-gray-900">
                {{-- Icono --}}
                <div class="w-9 h-9 rounded-xl bg-green-500/90 flex items-center justify-center shadow-sm">
                    <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 20V10M12 10c-4 0-7-3-7-7 4 0 7 3 7 7zm0 0c4 0 7-3 7-7-4 0-7 3-7 7z" />
                    </svg>
                </div>

                {{-- Nombre --}}
                <span class="font-extrabold tracking-tight">
                    Agro<span class="text-green-600">Tech</span>
                </span>

            </div>


            {{-- NAV --}}
            <nav class="hidden md:flex items-center gap-8 text-gray-700 font-medium">
                <a href="#" class="hover:text-green-600 transition">Funciones</a>
                <a href="#" class="hover:text-green-600 transition">Beneficios</a>
                <a href="#" class="hover:text-green-600 transition">Precios</a>
            </nav>

            {{-- ACTIONS --}}
            <div class="flex items-center gap-3">
<<<<<<< HEAD
                <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl text-gray-800 font-medium hover:bg-gray-100 transition">
=======
                <a href="/login" class="px-4 py-2 rounded-xl text-gray-800 font-medium hover:bg-gray-100 transition">
>>>>>>> ceface9825d6c91e5c11f8390b8116f462d8ff87
                    Iniciar sesión
                </a>

                <a href="/register" class="px-4 py-2 rounded-xl bg-green-500 text-white font-semibold
                          hover:bg-green-600 transition shadow-sm">
                    Comenzar ahora
                </a>
            </div>

        </div>
    </div>
</header>