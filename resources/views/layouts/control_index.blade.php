<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Proyecto Agrícola')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
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

    <script src="{{ asset('js/validation.js') }}"></script>
</body>

</html>