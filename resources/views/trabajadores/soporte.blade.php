@extends('layouts.admin')

@section('title', 'Soporte y Dudas')

@section('content')

<div class="max-w-4xl mx-auto space-y-8">
    
    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-emerald-600 to-emerald-800 rounded-3xl p-8 text-white shadow-xl relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-20 -mt-20 blur-3xl"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center gap-6">
            <div class="w-20 h-20 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-md shadow-inner">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div class="text-center md:text-left">
                <h2 class="text-3xl font-black tracking-tight">Centro de Ayuda</h2>
                <p class="text-emerald-100 opacity-90 mt-1 max-w-lg">¿Tienes dudas sobre tus pagos o tareas? Envía un mensaje a la administración y te responderemos lo antes posible.</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Formulario de Envío -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-3xl shadow-xl border border-emerald-50 p-6 sticky top-8">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <span class="w-8 h-8 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                        </svg>
                    </span>
                    Nuevo Mensaje
                </h3>

                <form action="{{ route('trabajador.soporte.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Asunto</label>
                        <input type="text" name="asunto" required placeholder="Ej. Duda con mi último pago"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none bg-gray-50">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Mensaje</label>
                        <textarea name="mensaje" rows="5" required placeholder="Describe tu duda detalladamente..."
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none bg-gray-50 resize-none"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-emerald-200/50 transition-all duration-300 transform active:scale-95">
                        Enviar Consulta
                    </button>
                </form>
            </div>
        </div>

        <!-- Historial de Consultas -->
        <div class="lg:col-span-2 space-y-4">
            <h3 class="text-xl font-bold text-gray-800 px-2 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Tus Mensajes Previos
            </h3>

            @forelse($mensajes as $msg)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex flex-wrap justify-between items-start gap-4 mb-4">
                            <div>
                                <h4 class="font-bold text-lg text-gray-900 group-hover:text-emerald-700 transition-colors">{{ $msg->asunto }}</h4>
                                <span class="text-xs text-gray-400 flex items-center gap-1 mt-1">
                                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10m-13 9h16a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z"/></svg>
                                    {{ $msg->created_at->format('d/m/Y h:i A') }}
                                </span>
                            </div>
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider 
                                {{ $msg->estado == 'Respondido' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                {{ $msg->estado }}
                            </span>
                        </div>
                        
                        <p class="text-gray-600 text-sm leading-relaxed mb-4 bg-gray-50 p-4 rounded-xl border-l-4 border-gray-200">
                            {{ $msg->mensaje }}
                        </p>

                        @if($msg->respuesta)
                            <div class="bg-emerald-50 rounded-2xl p-4 border border-emerald-100 relative mt-6">
                                <div class="absolute -top-3 left-6 px-2 bg-emerald-600 text-white text-[10px] font-bold rounded">
                                    Respuesta del Admin
                                </div>
                                <p class="text-emerald-800 text-sm italic">
                                    "{{ $msg->respuesta }}"
                                </p>
                            </div>
                        @else
                            <div class="flex items-center gap-2 text-amber-600 text-xs font-medium mt-4">
                                <svg class="w-4 h-4 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Esperando respuesta...
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-3xl p-12 text-center border-2 border-dashed border-gray-200">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                    </div>
                    <h3 class="text-gray-500 font-bold">No tienes consultas activas</h3>
                    <p class="text-gray-400 text-sm mt-1">Usa el formulario de la izquierda para empezar.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

@endsection
