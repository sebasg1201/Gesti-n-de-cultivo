<!DOCTYPE html>
<html lang="es" class="text-[85%]">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Proyecto Agrícola')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        // Inmediatamente aplicar el tema para evitar destellos blancos
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body>

    {{-- HEADER (se repite) --}}
    @include('layouts.header')

    {{-- CONTENIDO QUE CAMBIA --}}
    <main>

        @yield('content')

    </main>

    {{-- FOOTER (se repite) --}}
    @include('layouts.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.auto-dismiss').forEach(function (el) {
                setTimeout(function () {
                    el.style.transition = 'opacity 0.6s ease';
                    el.style.opacity = '0';
                    setTimeout(function () { el.remove(); }, 600);
                }, 10000);
            });
        });
    </script>
    @stack('scripts')

</body>

</html>