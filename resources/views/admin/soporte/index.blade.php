@extends('layouts.admin')

@section('title', 'Bandeja de Soporte')

@section('content')

<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-black text-emerald-900 tracking-tight">Consultas de Trabajadores</h2>
            <p class="text-emerald-600 font-medium">Gestiona y responde las dudas de tu personal.</p>
        </div>
        <div class="bg-white px-4 py-2 rounded-2xl shadow-sm border border-emerald-100 flex items-center gap-3">
            <span class="flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
            </span>
            <span class="text-sm font-bold text-emerald-800">{{ $mensajes->where('estado', 'Pendiente')->count() }} Pendientes</span>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6">
        @forelse($mensajes as $msg)
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:border-emerald-200 transition-all duration-300">
                <div class="p-6 md:p-8">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                        
                        <!-- Info del Trabajador -->
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 bg-emerald-100 rounded-2xl flex items-center justify-center text-emerald-600 font-black text-xl shadow-inner uppercase">
                                {{ substr($msg->trabajador->nombre, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-black text-gray-900 leading-tight">{{ $msg->trabajador->nombre }}</h4>
                                <p class="text-xs text-emerald-600 font-semibold uppercase tracking-wider mt-1">{{ $msg->trabajador->tipoUsuario->tipo_usuario }}</p>
                                <span class="text-[10px] text-gray-400 flex items-center gap-1 mt-1">
                                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10m-13 9h16a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z"/></svg>
                                    Enviado el {{ $msg->created_at->format('d/m/Y h:i A') }}
                                </span>
                            </div>
                        </div>

                        <!-- Asunto y Estado -->
                        <div class="flex-1 md:px-8">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest 
                                    {{ $msg->estado == 'Respondido' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ $msg->estado }}
                                </span>
                                <h5 class="text-lg font-bold text-gray-800">{{ $msg->asunto }}</h5>
                            </div>
                            <p class="text-gray-600 text-sm leading-relaxed line-clamp-2 italic">
                                "{{ $msg->mensaje }}"
                            </p>
                        </div>

                        <!-- Acción -->
                        <div>
                            @if($msg->estado == 'Pendiente')
                                <button onclick="openResponderModal('{{ $msg->id_soporte }}', '{{ addslashes($msg->asunto) }}', '{{ addslashes($msg->mensaje) }}')"
                                    class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-3 rounded-2xl shadow-lg hover:shadow-emerald-200/50 transition-all transform active:scale-95 flex items-center gap-2">
                                    Responder
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                                </button>
                            @else
                                <div class="text-right">
                                    <span class="text-xs font-bold text-emerald-600 block mb-2">Respuesta enviada:</span>
                                    <p class="text-gray-400 text-xs italic line-clamp-1 max-w-[200px]">{{ $msg->respuesta }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-3xl p-16 text-center border-2 border-dashed border-gray-100">
                <div class="w-24 h-24 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                </div>
                <h3 class="text-xl font-black text-gray-400">Bandeja Vacía</h3>
                <p class="text-gray-300 mt-2">No hay nuevas consultas por ahora.</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Modal Responder -->
<div id="responderModal" class="fixed inset-0 z-[100] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeResponderModal()"></div>
        
        <div class="relative bg-white rounded-[2rem] shadow-2xl w-full max-w-lg transform transition-all overflow-hidden border border-emerald-50">
            <div class="bg-gradient-to-br from-emerald-600 to-emerald-800 p-8 text-white">
                <button onclick="closeResponderModal()" class="absolute top-6 right-6 text-white/60 hover:text-white transition">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
                <h3 class="text-2xl font-black mb-1">Responder Consulta</h3>
                <p class="text-emerald-100 text-sm opacity-90" id="modalAsunto"></p>
            </div>

            <div class="p-8">
                <div class="bg-gray-50 rounded-2xl p-4 mb-6 border border-gray-100">
                    <label class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-2">Mensaje del Trabajador</label>
                    <p class="text-sm text-gray-600 italic leading-relaxed" id="modalMensaje"></p>
                </div>

                <form id="responderForm" action="" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-sm font-black text-gray-700 mb-2">Tu Respuesta</label>
                        <textarea name="respuesta" rows="5" required placeholder="Escribe aquí tu respuesta para el trabajador..."
                            class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none bg-gray-50 resize-none"></textarea>
                    </div>

                    <div class="flex gap-3">
                        <button type="button" onclick="closeResponderModal()" class="flex-1 px-6 py-4 rounded-xl font-bold text-gray-500 hover:bg-gray-100 transition">Cancelar</button>
                        <button type="submit" class="flex-[2] bg-emerald-600 hover:bg-emerald-700 text-white font-black py-4 rounded-xl shadow-lg shadow-emerald-200 transition transform active:scale-95">
                            Enviar Respuesta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openResponderModal(id, asunto, mensaje) {
        const modal = document.getElementById('responderModal');
        const form = document.getElementById('responderForm');
        const textAsunto = document.getElementById('modalAsunto');
        const textMensaje = document.getElementById('modalMensaje');

        form.action = `/admin/soporte/${id}/responder`;
        textAsunto.innerText = asunto;
        textMensaje.innerText = `"${mensaje}"`;

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeResponderModal() {
        const modal = document.getElementById('responderModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>
@endpush

@endsection
