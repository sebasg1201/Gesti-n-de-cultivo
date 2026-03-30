@extends('layouts.admin')

@section('title', 'Configuración del Sistema')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 animate-fade-in-up">

    <!-- SECCIÓN DE PREFERENCIAS (MODO OSCURO) -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl p-8 shadow-xl border border-emerald-100 dark:border-emerald-900/40 relative overflow-hidden group">
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-emerald-500/5 rounded-full blur-3xl group-hover:bg-emerald-500/10 transition-all duration-700"></div>
        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 relative z-10">
            <div>
                <h4 class="text-xl font-bold text-emerald-900 dark:text-emerald-300 flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    Apariencia del Sistema
                </h4>
                <p class="text-gray-500 dark:text-emerald-100/60 text-sm mt-1">Personaliza cómo ves tu panel administrativo.</p>
            </div>

            <div class="flex items-center gap-4 bg-emerald-50 dark:bg-slate-900/80 p-2 rounded-2xl border border-emerald-100 dark:border-emerald-900/30 transition-colors">
                <span id="label-light" class="text-sm font-semibold text-gray-600 dark:text-emerald-500 ml-2 transition-opacity duration-300">Modo Claro</span>
                <button id="theme-toggle" type="button" class="relative inline-flex h-8 w-16 items-center rounded-full transition-all duration-300 focus:outline-none bg-gray-300 dark:bg-emerald-600">
                    <span id="theme-toggle-dot" class="inline-block h-6 w-6 transform rounded-full bg-white shadow-lg transition-all duration-300 translate-x-1 dark:translate-x-9"></span>
                </button>
                <span id="label-dark" class="text-sm font-semibold text-gray-400 dark:text-emerald-50 transition-opacity duration-300">Modo Oscuro</span>
            </div>
        </div>
    </div>

    <!-- SECCIÓN DE PERFIL -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-2xl border border-emerald-100 dark:border-emerald-900/40 overflow-hidden">
        <div class="bg-gradient-to-r from-emerald-600 to-green-500 p-8 text-white relative">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_20%,rgba(255,255,255,0.15),transparent_60%)]"></div>
            <div class="relative z-10 flex flex-col md:flex-row items-center gap-6">
                <!-- Avatar -->
                <div class="relative group">
                    <div class="w-32 h-32 rounded-3xl bg-white/20 backdrop-blur-md border-4 border-white/30 flex items-center justify-center text-5xl font-bold shadow-2xl overflow-hidden">
                        @if($usuario->imagen)
                            <img id="avatar-preview" src="{{ asset('uploads/'.$usuario->imagen) }}" class="w-full h-full object-cover">
                        @else
                            <span id="avatar-initials">{{ strtoupper(substr($usuario->nombre, 0, 1)) }}</span>
                            <img id="avatar-preview" src="#" class="hidden w-full h-full object-cover">
                        @endif
                    </div>
                </div>
                <!-- Info -->
                <div class="text-center md:text-left">
                    <h4 class="text-3xl font-extrabold">{{ $usuario->nombre }}</h4>
                    <p class="text-emerald-100 opacity-90">{{ $usuario->tipoUsuario->tipo_usuario }} • {{ $usuario->id_empresa }}</p>
                    <div class="mt-4 flex flex-wrap gap-2 justify-center md:justify-start">
                        <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-xs font-semibold">
                            Cuenta @if($usuario->id_estado == 3) Activa @else {{ optional($usuario->estado)->nombre_estado ?? 'Estado desconocido' }} @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.configuracion.update') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nombre -->
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700 dark:text-emerald-200">Nombre Completo</label>
                    <div class="relative group">
                        <input type="text" name="nombre" value="{{ old('nombre', $usuario->nombre) }}" 
                            class="w-full pl-10 pr-4 py-3 bg-gray-50 dark:bg-slate-900 border @error('nombre') border-red-500 @else border-emerald-100 dark:border-emerald-900/30 @enderror rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all dark:text-emerald-50"
                            placeholder="Tu nombre completo">
                        <svg class="absolute left-3 top-3.5 w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    @error('nombre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Correo -->
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700 dark:text-emerald-200">Correo Electrónico</label>
                    <div class="relative group">
                        <input type="email" name="correo" value="{{ old('correo', $usuario->correo) }}" 
                            class="w-full pl-10 pr-4 py-3 bg-gray-50 dark:bg-slate-900 border @error('correo') border-red-500 @else border-emerald-100 dark:border-emerald-900/30 @enderror rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all dark:text-emerald-50"
                            placeholder="ejemplo@correo.com">
                        <svg class="absolute left-3 top-3.5 w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    @error('correo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Teléfono -->
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700 dark:text-emerald-200">Teléfono / WhatsApp</label>
                    <div class="relative group">
                        <input type="text" name="telefono" value="{{ old('telefono', $usuario->telefono) }}" 
                            class="w-full pl-10 pr-4 py-3 bg-gray-50 dark:bg-slate-900 border @error('telefono') border-red-500 @else border-emerald-100 dark:border-emerald-900/30 @enderror rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all dark:text-emerald-50"
                            placeholder="+57 300 000 0000">
                        <svg class="absolute left-3 top-3.5 w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    @error('telefono') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Foto de Perfil -->
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700 dark:text-emerald-200">Foto de Perfil</label>
                    <div class="relative group">
                        <input type="file" name="imagen" id="avatar-input"
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-slate-900 border @error('imagen') border-red-500 @else border-emerald-100 dark:border-emerald-900/30 @enderror rounded-2xl file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-emerald-100 dark:file:bg-emerald-900/50 file:text-emerald-700 dark:file:text-emerald-400 hover:file:bg-emerald-200 dark:hover:file:bg-emerald-900 cursor-pointer dark:text-emerald-100 transition-all">
                        <svg class="absolute left-3 top-3 w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    @error('imagen') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <hr class="border-emerald-50 dark:border-emerald-900/20">

            <div class="bg-amber-50 dark:bg-amber-900/10 p-4 rounded-2xl border border-amber-100 dark:border-amber-900/30 flex items-start gap-4">
                <div class="bg-amber-100 dark:bg-amber-800 p-2 rounded-xl text-amber-600 dark:text-amber-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v1a1 1 0 01-1 1H9a1 1 0 01-1-1v-1m3 0a1 1 0 011 1v1a1 1 0 01-1 1h-2a1 1 0 01-1-1v-1m3-3V9a3 3 0 00-6 0v6m6 0H6"/></svg>
                </div>
                <div>
                    <h5 class="text-sm font-bold text-amber-800 dark:text-amber-400 uppercase tracking-wider">Cambio de Seguridad</h5>
                    <p class="text-xs text-amber-700 dark:text-amber-500/80 mt-1">Solo completa estos campos si deseas cambiar tu contraseña actual.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Contraseña -->
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700 dark:text-emerald-200">Nueva Contraseña</label>
                    <div class="relative group">
                        <input type="password" name="contrasena" 
                            class="w-full pl-10 pr-4 py-3 bg-gray-50 dark:bg-slate-900 border @error('contrasena') border-red-500 @else border-emerald-100 dark:border-emerald-900/30 @enderror rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all dark:text-emerald-50"
                            placeholder="Mínimo 6 caracteres">
                        <svg class="absolute left-3 top-3.5 w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
    @error('contrasena') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

<!-- Confirmar Contraseña -->
<div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700 dark:text-emerald-200">Confirmar Nueva Contraseña</label>
                    <div class="relative group">
                        <input type="password" name="contrasena_confirmation" 
                            class="w-full pl-10 pr-4 py-3 bg-gray-50 dark:bg-slate-900 border border-emerald-100 dark:border-emerald-900/30 rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all dark:text-emerald-50"
                            placeholder="Repite la contraseña">
                        <svg class="absolute left-3 top-3.5 w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                </div>
            </div>

            <!-- BOTONES -->
            <div class="pt-6 flex flex-col sm:flex-row gap-4">
                <button type="submit" 
                    class="flex-1 bg-gradient-to-r from-emerald-600 to-green-500 text-white font-bold py-4 rounded-2xl shadow-lg shadow-emerald-200 dark:shadow-none hover:scale-[1.02] active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-2 group">
                    <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Guardar Cambios permanentemente
                </button>
                <a href="{{ route(auth()->guard('usuario')->user()->id_tipo_usuario == 3 ? 'trabajador.dashboard' : 'admin.dashboard') }}" 
                    class="px-8 py-4 bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-emerald-100 font-bold rounded-2xl hover:bg-gray-200 dark:hover:bg-slate-600 transition-all text-center">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggle = document.getElementById('theme-toggle');
        const dot = document.getElementById('theme-toggle-dot');
        const html = document.documentElement;

        // Función para actualizar el UI del toggle
        function updateToggleUI(isDark) {
            if (isDark) {
                dot.classList.add('translate-x-9');
                dot.classList.remove('translate-x-1');
                toggle.classList.add('bg-emerald-600');
                toggle.classList.remove('bg-gray-300');
            } else {
                dot.classList.add('translate-x-1');
                dot.classList.remove('translate-x-9');
                toggle.classList.add('bg-gray-300');
                toggle.classList.remove('bg-emerald-600');
            }
        }

        // Cargar estado inicial
        const initialIsDark = html.classList.contains('dark');
        updateToggleUI(initialIsDark);

        // Evento click
        toggle.addEventListener('click', function() {
            const isCurrentlyDark = html.classList.contains('dark');
            if (isCurrentlyDark) {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
                updateToggleUI(false);
            } else {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
                updateToggleUI(true);
            }
            // Sincronizar el header si está presente
            window.dispatchEvent(new Event('themeChanged'));
        });

        // Preview del Avatar
        const avatarInput = document.getElementById('avatar-input');
        const avatarPreview = document.getElementById('avatar-preview');
        const avatarInitials = document.getElementById('avatar-initials');

        avatarInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    avatarPreview.src = e.target.result;
                    avatarPreview.classList.remove('hidden');
                    if (avatarInitials) avatarInitials.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>
<style>
    @keyframes fade-in-up {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
        animation: fade-in-up 0.6s ease-out forwards;
    }
</style>
@endpush

@endsection
