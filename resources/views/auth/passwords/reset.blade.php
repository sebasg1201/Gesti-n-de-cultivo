<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña - AgriControl</title>
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
                            d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Restablecer Contraseña</h2>
                <p class="text-gray-500 text-sm mt-2">Ingresa tu nueva contraseña para acceder a tu cuenta.</p>
            </div>

            <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <!-- El campo debe llamarse 'email' para que coincida con lo que espera el trait ResetsPasswords por defecto en la validacion,
                     aunque luego lo mapeemos a 'correo' en el controlador. 
                     O podemos cambiar validacion. Vamos a usar 'email' en el form para consistencia con el link. -->
                <div>
                    <label for="correo" class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                    <input id="correo" type="email" name="correo" value="{{ $email ?? old('correo') }}" required
                        autofocus readonly
                        class="block w-full rounded-lg border-gray-300 border bg-gray-100 text-gray-500 shadow-sm p-2.5">
                    @error('correo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Nueva Contraseña</label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                            class="block w-full rounded-lg border-gray-300 border focus:border-green-500 focus:ring-green-500 shadow-sm p-2.5"
                            placeholder="********">
                    </div>

                    <!-- Password Strength Indicator -->
                    <div class="mt-2" id="password-strength-container" style="display: none;">
                        <div class="flex items-center gap-2">
                            <div class="flex-1 bg-gray-200 rounded-full h-2 overflow-hidden">
                                <div id="password-strength-bar" class="h-full transition-all duration-300"
                                    style="width: 0%;"></div>
                            </div>
                            <span id="password-strength-text" class="text-xs font-medium"></span>
                        </div>
                        <p id="password-requirements" class="text-xs text-gray-500 mt-1">
                            Mínimo 8 caracteres, incluyendo mayúsculas, minúsculas, números y caracteres especiales
                            (@$!%*#?&)
                        </p>
                    </div>

                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password-confirm" class="block text-sm font-medium text-gray-700 mb-1">Confirmar
                        Contraseña</label>
                    <div class="relative">
                        <input id="password-confirm" type="password" name="password_confirmation" required
                            autocomplete="new-password"
                            class="block w-full rounded-lg border-gray-300 border focus:border-green-500 focus:ring-green-500 shadow-sm p-2.5"
                            placeholder="********">
                    </div>
                </div>

                <button type="submit"
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 cursor-pointer">
                    Restablecer Contraseña
                </button>
            </form>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const passwordInput = document.getElementById('password');
            const strengthContainer = document.getElementById('password-strength-container');
            const strengthBar = document.getElementById('password-strength-bar');
            const strengthText = document.getElementById('password-strength-text');

            passwordInput.addEventListener('input', function () {
                const password = this.value;

                if (password.length === 0) {
                    strengthContainer.style.display = 'none';
                    return;
                }

                strengthContainer.style.display = 'block';

                // Calculate password strength
                let strength = 0;
                let strengthLevel = '';
                let color = '';
                let width = 0;

                const hasLower = /[a-z]/.test(password);
                const hasUpper = /[A-Z]/.test(password);
                const hasNumber = /[0-9]/.test(password);
                const hasSpecial = /[@$!%*#?&]/.test(password);
                const hasMinLength = password.length >= 8;

                // Only numbers
                if (hasNumber && !hasLower && !hasUpper && !hasSpecial) {
                    strength = 1;
                    strengthLevel = 'Muy fácil';
                    color = '#ef4444'; // red
                    width = 25;
                }
                // Numbers and letters (no uppercase)
                else if (hasNumber && hasLower && !hasUpper && !hasSpecial) {
                    strength = 2;
                    strengthLevel = 'Débil';
                    color = '#f97316'; // orange
                    width = 50;
                }
                // Has lowercase, uppercase, and numbers
                else if (hasLower && hasUpper && hasNumber && !hasSpecial) {
                    strength = 3;
                    strengthLevel = 'Media';
                    color = '#eab308'; // yellow
                    width = 75;
                }
                // Has everything
                else if (hasLower && hasUpper && hasNumber && hasSpecial && hasMinLength) {
                    strength = 4;
                    strengthLevel = 'Fuerte';
                    color = '#22c55e'; // green
                    width = 100;
                }
                // Other combinations
                else {
                    if (hasMinLength && (hasLower || hasUpper) && (hasNumber || hasSpecial)) {
                        strength = 2;
                        strengthLevel = 'Débil';
                        color = '#f97316';
                        width = 50;
                    } else {
                        strength = 1;
                        strengthLevel = 'Muy fácil';
                        color = '#ef4444';
                        width = 25;
                    }
                }

                strengthBar.style.width = width + '%';
                strengthBar.style.backgroundColor = color;
                strengthText.textContent = strengthLevel;
                strengthText.style.color = color;
            });
        });
    </script>

</body>

</html>