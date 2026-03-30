@extends('layouts.admin')

@section('title', 'Añadir Nuevo Empleado')

@section('content')
<div class="max-w-4xl mx-auto">

    <div class="mb-6">
        <a href="{{ route('admin.usuarios.index') }}" class="inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 font-semibold transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Volver a la Gestión de Personal
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-emerald-50">
        
        <div class="bg-gradient-to-r from-emerald-600 to-green-500 p-8 text-white">
            <h2 class="text-3xl font-extrabold">Registrar Personal</h2>
            <p class="text-emerald-100 mt-2">Completa los datos para añadir un nuevo supervisor o trabajador a tu empresa.</p>
        </div>

        <div class="p-8">
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.usuarios.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    {{-- Documento --}}
                    <div>
                        <label for="documento" class="block text-sm font-bold text-gray-700 mb-2">Documento de Identidad <span class="text-red-500">*</span></label>
                        <input type="number" name="documento" id="documento" value="{{ old('documento') }}" required
                               class="w-full px-4 py-3 rounded-xl border @error('documento') border-red-500 @else border-gray-300 @enderror focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 transition shadow-sm">
                        <p id="error-documento" class="text-red-500 text-xs mt-1 hidden"></p>
                        @error('documento') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Nombre --}}
                    <div>
                        <label for="nombre" class="block text-sm font-bold text-gray-700 mb-2">Nombre Completo <span class="text-red-500">*</span></label>
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required
                               class="w-full px-4 py-3 rounded-xl border @error('nombre') border-red-500 @else border-gray-300 @enderror focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 transition shadow-sm">
                        <p id="error-nombre" class="text-red-500 text-xs mt-1 hidden"></p>
                        @error('nombre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Correo --}}
                    <div>
                        <label for="correo" class="block text-sm font-bold text-gray-700 mb-2">Correo Electrónico <span class="text-red-500">*</span></label>
                        <input type="email" name="correo" id="correo" value="{{ old('correo') }}" required
                               class="w-full px-4 py-3 rounded-xl border @error('correo') border-red-500 @else border-gray-300 @enderror focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 transition shadow-sm">
                        <p id="error-correo" class="text-red-500 text-xs mt-1 hidden"></p>
                        @error('correo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Teléfono --}}
                    <div>
                        <label for="telefono" class="block text-sm font-bold text-gray-700 mb-2">Teléfono <span class="text-red-500">*</span></label>
                        <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}" required
                               class="w-full px-4 py-3 rounded-xl border @error('telefono') border-red-500 @else border-gray-300 @enderror focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 transition shadow-sm"
                               placeholder="Ej: 3001234567">
                        <p id="error-telefono" class="text-red-500 text-xs mt-1 hidden"></p>
                        @error('telefono') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Contraseña --}}
                    <div>
                        <label for="contrasena" class="block text-sm font-bold text-gray-700 mb-2">Contraseña Temporal <span class="text-red-500">*</span></label>
                        <input type="password" name="contrasena" id="contrasena" required
                               class="w-full px-4 py-3 rounded-xl border @error('contrasena') border-red-500 @else border-gray-300 @enderror focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 transition shadow-sm"
                               placeholder="Mínimo 8 caracteres">
                        <p id="error-contrasena" class="text-red-500 text-xs mt-1 hidden"></p>
                        @error('contrasena') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Rol (Tipo Usuario) --}}
                    <div>
                        <label for="id_tipo_usuario" class="block text-sm font-bold text-gray-700 mb-2">Rol Asignado <span class="text-red-500">*</span></label>
                        <select name="id_tipo_usuario" id="id_tipo_usuario" required
                                class="w-full px-4 py-3 rounded-xl border @error('id_tipo_usuario') border-red-500 @else border-gray-300 @enderror focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 transition shadow-sm bg-white">
                            <option value="">-- Selecciona el Rol --</option>
                            @foreach($roles as $rol)
                                <option value="{{ $rol->id_tipo_usuario }}" {{ old('id_tipo_usuario') == $rol->id_tipo_usuario ? 'selected' : '' }}>
                                    {{ ucfirst($rol->tipo_usuario) }}
                                </option>
                            @endforeach
                        </select>
                        <p id="error-id_tipo_usuario" class="text-red-500 text-xs mt-1 hidden"></p>
                        @error('id_tipo_usuario') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                </div>

                {{-- Imagen (Opcional) --}}
                <div class="mt-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Foto de Perfil (Opcional)</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-emerald-400 transition-colors bg-gray-50">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600 justify-center">
                                <label for="imagen" class="relative cursor-pointer bg-white rounded-md font-medium text-emerald-600 hover:text-emerald-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-emerald-500 px-2 py-1">
                                    <span>Sube un archivo</span>
                                    <input id="imagen" name="imagen" type="file" class="sr-only" accept="image/*">
                                </label>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF hasta 2MB</p>
                        </div>
                    </div>
                    <p id="error-imagen" class="text-red-500 text-xs mt-1 hidden text-center"></p>
                </div>

                <div class="pt-6 flex justify-end gap-4">
                    <a href="{{ route('admin.usuarios.index') }}" class="px-6 py-3 text-gray-700 hover:bg-gray-100 rounded-xl font-bold transition">Cancelar</a>
                    <button type="submit" id="btn-submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Guardar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const submitBtn = document.getElementById('btn-submit');
        const inputs = {
            documento: document.getElementById('documento'),
            nombre: document.getElementById('nombre'),
            correo: document.getElementById('correo'),
            telefono: document.getElementById('telefono'),
            contrasena: document.getElementById('contrasena'),
            id_tipo_usuario: document.getElementById('id_tipo_usuario'),
            imagen: document.getElementById('imagen')
        };

        const validations = {
            documento: (val) => {
                if (!val) return 'El documento es obligatorio';
                if (!/^\d+$/.test(val)) return 'Solo se permiten números';
                if (val.length < 6 || val.length > 10) return 'El documento debe tener entre 6 y 10 dígitos';
                return true;
            },
            nombre: (val) => {
                if (!val) return 'El nombre es obligatorio';
                if (val.length > 150) return 'Máximo 150 caracteres';
                return true;
            },
            correo: (val) => {
                if (!val) return 'El correo es obligatorio';
                if (!/^[^\s@]+@gmail\.com$/.test(val)) return 'Usa @gmail.com (evita errores como "gmial")';
                return true;
            },
            telefono: (val) => {
                if (!val) return 'El teléfono es obligatorio';
                if (!/^\d+$/.test(val)) return 'Solo se permiten números';
                if (val.length !== 10) return 'El teléfono debe tener 10 dígitos';
                if (!val.startsWith('3')) return 'Debe empezar por 3';
                return true;
            },
            contrasena: (val) => {
                if (!val) return 'La contraseña es obligatoria';
                if (val.length < 8) return 'Mínimo 8 caracteres';
                return true;
            },
            id_tipo_usuario: (val) => {
                if (!val) return 'Debes seleccionar un rol';
                return true;
            },
            imagen: (input) => {
                if (input.files && input.files[0]) {
                    const file = input.files[0];
                    const size = file.size / 1024 / 1024;
                    const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    if (size > 2) return 'La imagen no debe superar los 2MB';
                    if (!allowedTypes.includes(file.type)) return 'Tipo de archivo no permitido (JPG, PNG, GIF)';
                }
                return true;
            }
        };

        function validateField(name, element) {
            const val = element.value;
            const result = validations[name](name === 'imagen' ? element : val);
            const errorElement = document.getElementById(`error-${name}`);
            
            // Remove previous classes
            element.classList.remove('border-gray-300', 'border-red-500', 'border-emerald-500');

            if (result === true) {
                element.classList.add('border-emerald-500');
                if (errorElement) errorElement.classList.add('hidden');
                return true;
            } else {
                element.classList.add('border-red-500');
                if (errorElement) {
                    errorElement.textContent = result;
                    errorElement.classList.remove('hidden');
                }
                return false;
            }
        }

        function checkFormValidity() {
            let isValid = true;
            for (const key in inputs) {
                if (key === 'imagen') {
                    const res = validations[key](inputs[key]);
                    if (res !== true) isValid = false;
                } else {
                    const res = validations[key](inputs[key].value);
                    if (res !== true) isValid = false;
                }
            }
            submitBtn.disabled = !isValid;
            submitBtn.style.opacity = isValid ? '1' : '0.5';
            submitBtn.style.cursor = isValid ? 'pointer' : 'not-allowed';
        }

        // Add listeners
        Object.keys(inputs).forEach(key => {
            const eventType = (key === 'id_tipo_usuario' || key === 'imagen') ? 'change' : 'input';
            inputs[key].addEventListener(eventType, () => {
                validateField(key, inputs[key]);
                checkFormValidity();
            });
        });

        // Run once on load to set initial state if needed
        checkFormValidity();
    });
</script>
@endpush
@endsection
