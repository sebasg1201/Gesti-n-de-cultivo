<header class="w-full sticky top-0 z-50">
    <div class="w-full backdrop-blur-md bg-white/80 border-b border-white/20">

        <div class="max-w-8xl mx-auto px-6 py-4
                    flex items-center justify-between">

            {{-- LOGO --}}
            <a href="{{ route('index_welcome') }}" class="flex items-center gap-3 font-bold text-xl text-gray-900 cursor-pointer hover:scale-105 transition-transform duration-200">
                <img src="{{ asset('img/agrotech/logo.jpeg') }}" class="w-9 h-9 object-contain rounded-xl shadow-sm" alt="AgroTech Logo">
                <span class="font-extrabold tracking-tight">
                    Agro<span class="text-green-600">Tech</span>
                </span>
            </a>



            {{-- NAV --}}
            <nav class="hidden md:flex items-center gap-8 text-gray-700 font-medium">
                <a href="#funciones" class="hover:text-green-600 transition">Funciones</a>
                <a href="#beneficios" class="hover:text-green-600 transition">Beneficios</a>
                <a href="#precios" class="hover:text-green-600 transition">Precios</a>
            </nav>

            {{-- ACTIONS --}}
            <div class="flex items-center gap-3">
                <a href="{{ route('usuario.login') }}"
                    class="px-4 py-2 rounded-xl text-gray-800 font-medium hover:bg-gray-100 transition">
                    Iniciar sesión
                </a>

                <a href="#precios" class="px-4 py-2 rounded-xl bg-green-500 text-white font-semibold
                          hover:bg-green-600 transition shadow-sm">
                    Comenzar ahora
                </a>
            </div>

        </div>
    </div>
</header>