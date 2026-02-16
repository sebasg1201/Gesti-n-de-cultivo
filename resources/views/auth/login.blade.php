<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - AgriControl</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-4xl bg-white shadow-lg rounded-2xl overflow-hidden flex flex-col md:flex-row">
        
        <!-- Left Side - Image -->
        <div class="w-full md:w-1/2 relative bg-green-600 hidden md:block">
            <img src="{{ asset('img/campo.jpg') }}" 
                 alt="Agriculture" 
                 class="absolute inset-0 w-full h-full object-cover mix-blend-multiply opacity-90">
            <div class="absolute inset-0 flex flex-col items-center justify-center text-white p-8 text-center">
                <div class="mb-4 bg-white/20 p-3 rounded-full backdrop-blur-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                    </svg>
                </div>
                <h2 class="text-3xl font-bold mb-2">Bienvenido a AgroTech</h2>
                <p class="text-green-50">Gestión eficiente para el campo. Controla cultivos, supervisa tareas y optimiza tu producción.</p>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
            
            <div class="mb-8 text-center md:text-left">
                <h3 class="text-2xl font-bold text-gray-800">Acceso a la Plataforma</h3>
                <p class="text-gray-500 text-sm">Ingresa tus credenciales para continuar.</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-400">
                                <path stroke-linecap="round" d="M16.5 12a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zm0 0c0 1.657 1.007 3 2.25 3S21 13.657 21 12a9 9 0 10-2.636 6.364M16.5 12V8.25" />
                            </svg>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="pl-10 block w-full rounded-lg border-gray-300 border focus:border-green-500 focus:ring-green-500 shadow-sm p-2.5 transition ease-in-out duration-150"
                            placeholder="usuario@agricontrol.com">
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                        <a href="{{ route('password.request') }}" class="text-sm text-green-600 hover:text-green-500 font-medium">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                        </div>
                        <input id="password" type="password" name="password" required
                            class="pl-10 block w-full rounded-lg border-gray-300 border focus:border-green-500 focus:ring-green-500 shadow-sm p-2.5 transition ease-in-out duration-150"
                            placeholder="••••••••">
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" 
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out transform hover:-translate-y-0.5">
                    Iniciar Sesión
                </button>

                <div class="mt-4 text-center">
                    <a href="{{ url('/') }}" class="text-sm font-medium text-green-600 hover:text-green-500 hover:underline">
                        &larr; Volver al Inicio
                    </a>
                </div>

            </form>
            
            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">
                            AgriControl System v1.0
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>
