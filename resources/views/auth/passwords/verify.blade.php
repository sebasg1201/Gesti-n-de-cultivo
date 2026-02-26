<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Código - AgriControl</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md bg-white shadow-xl rounded-2xl overflow-hidden">

        <div class="p-8">

            <div class="text-center mb-8">
                <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-8 h-8 text-green-600">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Verificar Código</h2>
                <p class="text-gray-500 text-sm mt-2">Hemos enviado un código de 6 dígitos a tu correo:
                    <strong>{{ $email ?? old('email') }}</strong>
                </p>
            </div>

            @if (session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative mb-6 text-sm"
                role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
            @endif

            <form method="POST" action="{{ route('password.verify.code') }}" class="space-y-6 validate-form">
                @csrf
                <input type="hidden" name="email" value="{{ $email ?? old('email') }}">

                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700 mb-1">Código de
                        Verificación</label>
                    <div class="relative">
                        <input id="code" type="text" name="code" required autofocus maxlength="6"
                            class="block w-full text-center tracking-[.5em] text-2xl rounded-lg border-gray-300 border focus:border-green-500 focus:ring-green-500 shadow-sm p-2.5"
                            placeholder="000000">
                    </div>
                    @error('code')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="text-sm text-center">
                    <p class="text-gray-500">¿No recibiste el código?</p>
                    <a href="{{ route('password.request') }}" class="font-medium text-green-600 hover:text-green-500">
                        Intentar de nuevo
                    </a>
                </div>

                <button type="submit"
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 cursor-pointer">
                    Verificar Código
                </button>
            </form>

        </div>
    </div>

    <script src="{{ asset('js/form-validation.js') }}"></script>
    <script>
        // Prevent Back-Forward Cache (BFCache) to ensure strict security flow
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    </script>
</body>

</html>