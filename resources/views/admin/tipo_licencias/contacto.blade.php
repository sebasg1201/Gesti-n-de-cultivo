@extends('layouts.admin')

@section('title', 'Contacto Soporte - Licencias')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="mb-6">
        <a href="{{ route('admin.licencias.index') }}" class="inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 font-semibold transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Volver a Mi Plan
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-emerald-50">
        
        <div class="bg-gradient-to-br from-emerald-600 to-emerald-800 p-8 text-white text-center">
            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 backdrop-blur-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <h2 class="text-3xl font-extrabold mb-2">Envíanos un Mensaje</h2>
            <p class="text-emerald-100">Nos pondremos en contacto contigo a través de <strong>{{ $usuario->correo }}</strong>.</p>
        </div>

        <div class="p-10">
            <form action="{{ route('admin.licencias.enviar_contacto') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="asunto" class="block text-sm font-bold text-gray-700 mb-2">Asunto</label>
                    <input type="text" id="asunto" name="asunto" required 
                           value="{{ old('asunto', $asunto) }}"
                           placeholder="Ej. Renovación de mi plan mensual"
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 transition shadow-sm bg-gray-50 focus:bg-white text-gray-900">
                </div>

                <div>
                    <label for="mensaje" class="block text-sm font-bold text-gray-700 mb-2">Tu Mensaje</label>
                    <textarea id="mensaje" name="mensaje" rows="6" required
                              placeholder="Describe en detalle cómo podemos ayudarte..."
                              class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 transition shadow-sm bg-gray-50 focus:bg-white text-gray-900 resize-none">{{ old('mensaje', $mensaje) }}</textarea>
                </div>

                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-lg py-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center gap-3">
                    Enviar Mensaje
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                </button>

            </form>
        </div>
    </div>
</div>

@endsection
