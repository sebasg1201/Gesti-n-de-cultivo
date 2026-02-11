@extends('layouts.barra_lateral')

@section('content')

<div class="space-y-6">

    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Gestión de Licencias y Empresas</h1>
        <div class="flex items-center gap-2">
            <span class="text-sm text-gray-500">{{ now()->format('d M, Y') }}</span>
        </div>
    </div>

    <!-- SECCION REPORTES -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Licencias Por Vencer -->
        <div class="bg-red-100 p-6 rounded-lg shadow-sm border-l-4 border-red-500 relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-red-800 font-semibold mb-1">Licencias Por Vencer</p>
                <h2 class="text-3xl font-bold text-red-900">{{ $licenciasPorVencer ?? 0 }}</h2>
            </div>
            <div class="absolute right-4 top-4 opacity-20">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 text-red-700">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
            </div>
        </div>

        <!-- Renovadas este mes -->
        <div class="bg-yellow-100 p-6 rounded-lg shadow-sm border-l-4 border-yellow-500 relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-yellow-800 font-semibold mb-1">Renovadas este mes</p>
                <h2 class="text-3xl font-bold text-yellow-900">{{ $renovadasEsteMes ?? 0 }}</h2>
            </div>
            <div class="absolute right-4 top-4 opacity-20">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 text-yellow-700">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
            </div>
        </div>

        <!-- Total Licencias -->
        <div class="bg-blue-100 p-6 rounded-lg shadow-sm border-l-4 border-blue-500 relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-blue-800 font-semibold mb-1">Total Licencias</p>
                <h2 class="text-3xl font-bold text-blue-900">{{ $totalLicencias ?? 0 }}</h2>
            </div>
            <div class="absolute right-4 top-4 opacity-20">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 text-blue-700">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                </svg>
            </div>
        </div>

    </div>

    <!-- SECCION FORMULARIOS -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-start">

        <!-- 1 CREAR EMPRESA -->
        <div class="bg-white p-6 rounded-xl shadow">
    <div class="flex justify-between items-center mb-6">

        <!-- Título -->
        <div class="flex items-center gap-3">
            <div class="bg-green-100 p-2 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 21h18M5 21V7a2 2 0 012-2h10a2 2 0 012 2v14M9 9h6M9 13h6"/>
                </svg>
            </div>

            <h3 class="text-lg font-semibold text-gray-800">Crear empresa</h3>
        </div>

        @if(session('success') && session('form') == 'empresa')
        <span class="text-xs text-green-600 font-semibold bg-green-100 px-3 py-1 rounded-full">
            Guardado
        </span>
        @endif
    </div>

    <form action="{{ route('empresas.store') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="form" value="empresa">

        <!-- NIT -->
        <div class="relative">
            <label class="block text-sm font-medium text-gray-600 mb-1">Nit de la empresa</label>

            <div class="absolute left-3 top-9 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v14l-5-3-5 3V6a2 2 0 012-2z"/>
                </svg>
            </div>

            <input type="number" name="id_empresa"
                class="w-full border-gray-300 rounded-lg pl-10 p-2 text-sm focus:ring-green-500 focus:border-green-500"
                placeholder="9088123456" required>
        </div>

        <!-- Nombre -->
        <div class="relative">
            <label class="block text-sm font-medium text-gray-600 mb-1">Nombre de la empresa</label>

            <div class="absolute left-3 top-9 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.5 21V7.5a3 3 0 013-3h9a3 3 0 013 3V21"/>
                </svg>
            </div>

            <input type="text" name="nombre_empresa"
                class="w-full border-gray-300 rounded-lg pl-10 p-2 text-sm focus:ring-green-500 focus:border-green-500"
                placeholder="Ej: Agricola Sena" required>
        </div>

        <!-- Representante -->
        <div class="relative">
            <label class="block text-sm font-medium text-gray-600 mb-1">Representante Legal</label>

            <div class="absolute left-3 top-9 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0"/>
                </svg>
            </div>

            <input type="text" name="nombre_repre_legal"
                class="w-full border-gray-300 rounded-lg pl-10 p-2 text-sm focus:ring-green-500 focus:border-green-500"
                placeholder="Nombre completo" required>
        </div>

        <!-- Teléfono / Dirección -->
        <div class="grid grid-cols-2 gap-3">

            <div class="relative">
                <label class="block text-sm font-medium text-gray-600 mb-1">Teléfono</label>

                <div class="absolute left-3 top-9 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 6.75l3.75 3.75m0 0l3.75-3.75M6 10.5v7.5a2.25 2.25 0 002.25 2.25h7.5"/>
                    </svg>
                </div>

                <input type="text" name="telefono"
                    class="w-full border-gray-300 rounded-lg pl-10 p-2 text-sm focus:ring-green-500 focus:border-green-500"
                    placeholder="123456789" required>
            </div>

            <div class="relative">
                <label class="block text-sm font-medium text-gray-600 mb-1">Dirección</label>

                <div class="absolute left-3 top-9 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 10.5c0 7.5-7.5 11.25-7.5 11.25S4.5 18 4.5 10.5a7.5 7.5 0 1115 0z"/>
                    </svg>
                </div>

                <input type="text" name="direccion"
                    class="w-full border-gray-300 rounded-lg pl-10 p-2 text-sm focus:ring-green-500 focus:border-green-500"
                    placeholder="MZ CRA #" required>
            </div>

        </div>

        <!-- Correo -->
        <div class="relative">
            <label class="block text-sm font-medium text-gray-600 mb-1">Correo</label>

            <div class="absolute left-3 top-9 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21.75 6.75L12 13.5 2.25 6.75"/>
                </svg>
            </div>

            <input type="email" name="correo"
                class="w-full border-gray-300 rounded-lg pl-10 p-2 text-sm focus:ring-green-500 focus:border-green-500"
                placeholder="adso@sena.edu.co" required>
        </div>

        <!-- Botón -->
        <button type="submit"
            class="w-full flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 rounded-lg transition">

            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>

            Crear Empresa
        </button>
    </form>
</div>


 <!-- 2 ASIGNAR LICENCIA -->
<div class="bg-white p-6 rounded-lg shadow">
    <div class="flex justify-between items-center mb-4">
        <h3 class="flex items-center gap-2 text-lg font-bold text-gray-800">
            
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M9 12l2 2 4-4m5-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>

            Asignar Licencia
        </h3>
    </div>

    <form action="{{ route('licencias.asignar') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="form" value="licencia">

        <div>
            <label class="block text-sm font-medium text-gray-600">Empresa</label>
            <select name="id_empresa" class="w-full border-gray-300 rounded p-2 text-sm focus:ring-green-500 focus:border-green-500" required>
                <option value="">Seleccione Empresa</option>
                @foreach($empresas as $empresa)
                <option value="{{ $empresa->id_empresa }}">{{ $empresa->nombre_empresa }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600">Tipo de Licencia</label>
            <select name="id_tipo_licencia" class="w-full border-gray-300 rounded p-2 text-sm focus:ring-green-500 focus:border-green-500" required>
                <option value="">Seleccione Plan</option>
                @foreach($tiposLicencia as $tipo)
                <option value="{{ $tipo->id_tipo_licencia }}">{{ $tipo->nombre_licencia }} ({{ $tipo->tiempo }})</option>
                @endforeach
            </select>
        </div>

        <div class="p-3 bg-gray-50 rounded text-sm text-gray-500">
            <p>La fecha de inicio se establecerá hoy automáticamente. La fecha fin se calculará según el plan elegido.</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600">Estado</label>
            <input type="text" value="Activo" disabled class="w-full bg-gray-100 border-gray-300 rounded p-2 text-sm text-green-600">
        </div>

        <button type="submit" class="w-full flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition">
            
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M5 13l4 4L19 7"/>
            </svg>

            Asignar
        </button>
    </form>
</div>


 <!-- 3 CREAR ADMINISTRADOR -->
<div class="bg-white p-6 rounded-lg shadow">

    <h3 class="flex items-center gap-2 text-lg font-bold text-gray-800 mb-4">
        
        <!-- Icono Administrador -->
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
            d="M5.121 17.804A9 9 0 1118.88 6.196 9 9 0 015.12 17.804z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>

        Crear administrador
    </h3>

    <form action="{{ route('administradores.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <input type="hidden" name="form" value="admin">

        <!-- Imagen Upload -->
        <div>
            <label class="flex items-center gap-1 text-sm font-medium text-gray-600">
                
                <!-- Icono Foto -->
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M3 7h4l2-2h6l2 2h4v12H3V7z"/>
                </svg>

                Foto
            </label>
            <input type="file" name="imagen" accept="image/*" required class="w-full border-gray-300 rounded p-2 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
        </div>

        <div>
            <label class="flex items-center gap-1 text-sm font-medium text-gray-600">
                
                <!-- Icono Empresa -->
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M3 21h18M9 8h6M9 12h6M9 16h6M5 21V5a2 2 0 012-2h10a2 2 0 012 2v16"/>
                </svg>

                Empresa
            </label>
            <select name="id_empresa" class="w-full border-gray-300 rounded p-2 text-sm focus:ring-green-500 focus:border-green-500" required>
                <option value="">Seleccione Empresa</option>
                @foreach($empresas as $empresa)
                <option value="{{ $empresa->id_empresa }}">{{ $empresa->nombre_empresa }}</option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-2">
            <div>
                <label class="flex items-center gap-1 text-sm font-medium text-gray-600">
                    
                    <!-- Icono Documento -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M9 12h6M9 16h6M7 4h10l2 2v14H5V4h2z"/>
                    </svg>

                    Documento
                </label>
                <input type="number" name="documento" class="w-full border-gray-300 rounded p-2 text-sm focus:ring-green-500 focus:border-green-500" placeholder="1231312312" required>
            </div>

            <div>
                <label class="flex items-center gap-1 text-sm font-medium text-gray-600">
                    
                    <!-- Icono Teléfono -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M3 5a2 2 0 012-2h3l2 5-2 1a11 11 0 005 5l1-2 5 2v3a2 2 0 01-2 2h-1C9.163 19 5 14.837 5 9V8a2 2 0 00-2-2z"/>
                    </svg>

                    Teléfono
                </label>
                <input type="text" name="telefono" class="w-full border-gray-300 rounded p-2 text-sm focus:ring-green-500 focus:border-green-500" placeholder="123456789" required>
            </div>
        </div>

        <div>
            <label class="flex items-center gap-1 text-sm font-medium text-gray-600">
                
                <!-- Icono Usuario -->
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M5.121 17.804A9 9 0 1118.88 6.196 9 9 0 015.12 17.804z"/>
                </svg>

                Nombre
            </label>
            <input type="text" name="nombre" class="w-full border-gray-300 rounded p-2 text-sm focus:ring-green-500 focus:border-green-500" placeholder="Oscar Murcia" required>
        </div>

        <div>
            <label class="flex items-center gap-1 text-sm font-medium text-gray-600">
                
                <!-- Icono Correo -->
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M16 12H8m8 0l-4 4m4-4l-4-4M4 6h16M4 18h16"/>
                </svg>

                Correo
            </label>
            <input type="email" name="correo" class="w-full border-gray-300 rounded p-2 text-sm focus:ring-green-500 focus:border-green-500" placeholder="oscar@gmail.com" required>
        </div>

        <div>
            <label class="flex items-center gap-1 text-sm font-medium text-gray-600">
                
                <!-- Icono Contraseña -->
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M12 11c1.657 0 3 1.343 3 3v3H9v-3c0-1.657 1.343-3 3-3z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M7 11V8a5 5 0 0110 0v3"/>
                </svg>

                Contraseña
            </label>
            <input type="password" name="contrasena" class="w-full border-gray-300 rounded p-2 text-sm focus:ring-green-500 focus:border-green-500" placeholder="**********" required>
        </div>

        <button type="submit" class="w-full flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition">
            
            <!-- Icono Crear -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M12 4v16m8-8H4"/>
            </svg>

            Crear
        </button>
    </form>
</div>

@if(session('success'))
<div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded shadow-lg animate-bounce">
    {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded shadow-lg">
    <ul class="list-disc pl-5">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@endsection