@extends('layouts.barra_lateral')

@section('content')

<div class="space-y-6">

    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Gestión de Licencias y Empresas</h1>
        <div class="flex items-center gap-2">
            <span class="text-sm text-gray-500">{{ now()->format('d M, Y') }}</span>
        </div>
    </div>

    <!-- SECCION FORMULARIOS -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-start">

    <!-- 1. CREAR EMPRESA -->
    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Crear empresa</h3>
        </div>

        <form action="{{ route('empresas.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-600">Nit de la empresa</label>
                <input type="number" id="nit_empresa" name="id_empresa"
                    class="w-full border-gray-300 rounded p-2 text-sm focus:ring-green-500 focus:border-green-500 @error('id_empresa') border-red-500 @enderror"
                    placeholder="9088123456" value="{{ old('id_empresa') }}" required>
                @error('id_empresa') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600">Nombre de la empresa</label>
                <input type="text" id="nombre_empresa" name="nombre_empresa"
                    class="w-full border-gray-300 rounded p-2 text-sm focus:ring-green-500 focus:border-green-500 @error('nombre_empresa') border-red-500 @enderror" 
                    value="{{ old('nombre_empresa') }}" required>
                @error('nombre_empresa') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600">Representante Legal</label>
                <input type="text" id="nombre_repre_legal" name="nombre_repre_legal"
                    class="w-full border-gray-300 rounded p-2 text-sm focus:ring-green-500 focus:border-green-500 @error('nombre_repre_legal') border-red-500 @enderror" 
                    value="{{ old('nombre_repre_legal') }}" required>
                @error('nombre_repre_legal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-sm font-medium text-gray-600">Teléfono</label>
                    <input type="text" id="telefono" name="telefono"
                        class="w-full border-gray-300 rounded p-2 text-sm focus:ring-green-500 focus:border-green-500 @error('telefono') border-red-500 @enderror" 
                        value="{{ old('telefono') }}" required>
                    @error('telefono') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Dirección</label>
                    <input type="text" id="direccion" name="direccion"
                        class="w-full border-gray-300 rounded p-2 text-sm focus:ring-green-500 focus:border-green-500 @error('direccion') border-red-500 @enderror" 
                        value="{{ old('direccion') }}" required>
                    @error('direccion') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600">Correo</label>
                <input type="email" id="correo" name="correo"
                    class="w-full border-gray-300 rounded p-2 text-sm focus:ring-green-500 focus:border-green-500 @error('correo') border-red-500 @enderror" 
                    value="{{ old('correo') }}" required>
                @error('correo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit"
                class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition">
                Crear Empresa
            </button>
        </form>
    </div>


    <!-- 2. ASIGNAR LICENCIA -->
<div class="bg-white p-6 rounded-lg shadow">
    <h3 class="text-lg font-bold text-gray-800 mb-4">Asignar Licencia</h3>

    <form action="{{ route('licencias.asignar') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-600">Empresa</label>
            <select id="empresaLicencia" name="id_empresa"
                class="w-full border-gray-300 rounded p-2 text-sm focus:ring-green-500 focus:border-green-500"
                required>
                <option value="">Seleccione Empresa</option>
                @foreach($empresas as $empresa)
                    <option value="{{ $empresa->id_empresa }}">{{ $empresa->nombre_empresa }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600">Tipo de Licencia</label>
            <select name="id_tipo_licencia"
                class="w-full border-gray-300 rounded p-2 text-sm focus:ring-green-500 focus:border-green-500"
                required>
                <option value="">Seleccione Plan</option>
                @foreach($tiposLicencia as $tipo)
                    <option value="{{ $tipo->id_tipo_licencia }}">
                        {{ $tipo->nombre_licencia }} ({{ $tipo->tiempo }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="p-3 bg-gray-50 rounded text-sm text-gray-500">
            La fecha inicio se asigna automáticamente.
        </div>

        <button type="submit"
            class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition">
            Asignar
        </button>
    </form>
</div>



    <!-- 3. CREAR ADMINISTRADOR -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Crear administrador</h3>

        <form action="{{ route('administradores.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-600">Foto</label>
                <input type="file" name="imagen" accept="image/*" required
                    class="w-full border-gray-300 rounded p-2 text-sm @error('imagen') border-red-500 @enderror">
                @error('imagen') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600">Empresa</label>
                <select name="id_empresa"
                    class="w-full border-gray-300 rounded p-2 text-sm focus:ring-green-500 focus:border-green-500 @error('id_empresa') border-red-500 @enderror"
                    required>
                    <option value="">Seleccione Empresa</option>
                    @foreach($empresas as $empresa)
                        <option value="{{ $empresa->id_empresa }}" {{ old('id_empresa') == $empresa->id_empresa ? 'selected' : '' }}>{{ $empresa->nombre_empresa }}</option>
                    @endforeach
                </select>
                @error('id_empresa') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-2">
                <input type="number" name="documento" placeholder="Documento"
                    class="border-gray-300 rounded p-2 text-sm @error('documento') border-red-500 @enderror" 
                    value="{{ old('documento') }}" required>
                
                <input type="text" name="telefono" placeholder="Teléfono"
                    class="border-gray-300 rounded p-2 text-sm @error('telefono') border-red-500 @enderror" 
                    value="{{ old('telefono') }}" required>
            </div>
            @error('documento') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            @error('telefono') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

            <input type="text" name="nombre" placeholder="Nombre"
                class="w-full border-gray-300 rounded p-2 text-sm @error('nombre') border-red-500 @enderror" 
                value="{{ old('nombre') }}" required>
            @error('nombre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

            <input type="email" name="correo" placeholder="Correo"
                class="w-full border-gray-300 rounded p-2 text-sm @error('correo') border-red-500 @enderror" 
                value="{{ old('correo') }}" required>
            @error('correo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

            <input type="password" name="contrasena" placeholder="Contraseña"
                class="w-full border-gray-300 rounded p-2 text-sm @error('contrasena') border-red-500 @enderror" required>
            @error('contrasena') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

            <button type="submit"
                class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition">
                Crear
            </button>
        </form>
    </div>

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
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const nitInput = document.getElementById('nit_empresa');

    nitInput.addEventListener('keyup', function () {

        let nit = this.value;

        if (nit.length < 3) return;

        fetch(`/empresa/buscar/${nit}`)
        .then(res => res.json())
        .then(data => {

            if (!data) return;

            // ===== FORM CREAR EMPRESA =====
            document.getElementById('nombre_empresa').value = data.nombre_empresa ?? '';
            document.getElementById('nombre_repre_legal').value = data.nombre_repre_legal ?? '';
            document.getElementById('telefono').value = data.telefono ?? '';
            document.getElementById('direccion').value = data.direccion ?? '';
            document.getElementById('correo').value = data.correo ?? '';

            // ===== FORM ASIGNAR LICENCIA =====
            let empresaSelect = document.querySelector('select[name="id_empresa"]');
            let licenciaSelect = document.querySelector('select[name="id_tipo_licencia"]');

            if (empresaSelect) {
                empresaSelect.value = data.id_empresa ?? '';
            }

            if (licenciaSelect && data.id_tipo_licencia) {
                licenciaSelect.value = data.id_tipo_licencia;
            }

        });

    });

});
</script>
@endpush

