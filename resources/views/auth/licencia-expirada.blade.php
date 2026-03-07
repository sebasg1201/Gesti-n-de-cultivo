<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Expirado - AgriManager</title>
    @vite('resources/css/app.css')
    <style>
        body {
            /* Mimetizar el fondo de la imagen, suave verdoso/grisáceo */
            background: linear-gradient(135deg, #e0ebd3 0%, #a4bfa3 100%);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

    <!-- Top line decorator (optional, based on some designs) -->
    <div class="fixed top-0 left-0 w-full h-1 bg-emerald-500"></div>

    <div class="bg-white rounded-xl shadow-2xl p-8 md:p-10 w-full max-w-lg relative overflow-hidden">
        
        <!-- Icon Container -->
        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <div class="relative text-gray-400">
                <!-- Lock Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 relative z-10" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z"/>
                </svg>
                <!-- Small Clock overlay -->
                <div class="absolute -bottom-2 -right-2 bg-gray-100 rounded-full p-1 z-20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Texts -->
        <h2 class="text-2xl md:text-3xl font-bold text-center text-[#111827] mb-4">
            Tu acceso ha expirado
        </h2>
        
        <p class="text-center text-gray-500 text-sm md:text-base leading-relaxed mb-6 px-2">
            El tiempo de uso contratado para su empresa ha finalizado. Por favor, póngase en contacto con el administrador del sistema para renovar el servicio y recuperar el acceso a sus datos de cosechas, terrenos e inventario.
        </p>

        <!-- Information Block -->
        <div class="bg-gray-50 rounded-lg p-5 mb-8 border border-gray-100">
            <div class="flex justify-between items-center mb-3 pb-3 border-b border-gray-200">
                <span class="text-sm font-medium text-gray-500">ID de Empresa</span>
                <span class="text-sm font-bold text-gray-800 tracking-wider">{{ $usuario->id_empresa ?? 'Desconocida' }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm font-medium text-gray-500">Fecha de Expiración</span>
                <span class="text-sm font-bold text-gray-800">{{ $fechaExpiracion ?? 'Desconocida' }}</span>
            </div>
        </div>

        <!-- Buttons -->
        <!-- MOCK Acción de contacto directo -->
        <a href="mailto:soporte@agrimanager.com?subject=Renovar%20Licencia%20-%20NIT%20{{ $usuario->id_empresa ?? '' }}" 
           class="w-full bg-[#10b981] hover:bg-[#059669] text-white font-bold py-3.5 px-4 rounded-lg flex items-center justify-center gap-2 transition-colors mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" />
            </svg>
            Contactar para Renovar
        </a>

        <div class="text-center space-y-4">
            <a href="#" class="text-sm font-medium text-gray-500 hover:text-gray-700 underline decoration-gray-300 underline-offset-4">
                Enviar Solicitud de Revisión
            </a>
            
            <form action="{{ route('usuario.logout') }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="text-xs font-bold text-red-500 hover:text-red-600 transition-colors">
                    Cerrar sesión actual
                </button>
            </form>
        </div>

    </div>

</body>
</html>
