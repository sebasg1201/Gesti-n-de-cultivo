@extends('layouts.admin')

@section('title', 'Mis Tareas Asignadas')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">

    @if (session('success'))
        <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-r-lg shadow-sm">
            <p class="font-medium flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </p>
        </div>
    @endif

    <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-6 mb-6">
        <h2 class="text-xl font-bold text-emerald-900 mb-2">¡Bienvenido, {{ explode(' ', auth()->guard('usuario')->user()->nombre)[0] }}!</h2>
        <p class="text-emerald-700">Aquí puedes ver tus tareas asignadas y el estado de tu progreso.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($tareas as $fase)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:border-emerald-300 transition-all flex flex-col overflow-hidden relative group">
                
                {{-- Border left to indicate state --}}
                <div class="absolute left-0 top-0 bottom-0 w-1.5 
                    {{ $fase->estado == 'En Proceso' ? 'bg-orange-400' : 'bg-green-500' }}">
                </div>

                <div class="p-6 flex-1 flex flex-col">
                    <div class="flex justify-between items-start mb-4">
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider
                            {{ $fase->estado == 'En Proceso' ? 'bg-orange-100 text-orange-800' : 'bg-green-100 text-green-800' }}">
                            {{ $fase->estado }}
                        </span>
                        
                        <div class="text-right">
                            <p class="text-[10px] text-gray-400 font-bold uppercase">Programado para</p>
                            <p class="text-sm font-bold text-gray-700">{{ \Carbon\Carbon::parse($fase->fecha_programada)->format('d M, Y') }}</p>
                        </div>
                    </div>

                    <p class="text-sm text-gray-500 mb-3 font-medium bg-gray-50 self-start px-2 py-1 rounded">
                        Lote Cosecha: #{{ $fase->id_cosecha }} 
                        @php
                            $cultivoNombre = optional($fase->cosecha->semilla ?? null)->nombre_semilla 
                                          ?? optional($fase->cosecha->tipoCosecha->semilla ?? null)->nombre_semilla 
                                          ?? 'General';
                        @endphp
                        - {{ $cultivoNombre }}
                    </p>

                    <h3 class="text-lg font-bold text-gray-800 mb-2 flex-grow">
                        {{ $fase->descripcion }}
                    </h3>

                    <div class="mt-4 pt-4 border-t border-gray-100 flex items-center gap-3">
                        {{-- Ver Detalle --}}
                        @php
                            $cosecha = $fase->cosecha ?? null;
                            $terreno = optional($cosecha)->terreno ?? null;
                            
                            $details = [
                                'fase_id' => $fase->id_fase,
                                'estado' => $fase->estado,
                                'descripcion' => $fase->descripcion ?? 'Sin descripción',
                                'fecha' => $fase->fecha_programada ? \Carbon\Carbon::parse($fase->fecha_programada)->format('d/m/Y H:i') : 'No definida',
                                // Terreno
                                'parcela' => optional($terreno)->nombre ?? 'Sin Parcela',
                                'ubicacion' => optional($terreno)->ubicacion ?? 'No especificada',
                                'dimensiones' => $terreno ? (($terreno->Ancho ?? '?') . 'm x ' . ($terreno->Alto ?? '?') . 'm') : 'No detallado',
                                'suelo' => optional(optional($terreno)->tipoSuelo)->nombre ?? 'General',
                                // Cosecha/Cultivo
                                'cultivo' => $cultivoNombre ?? 'General',
                                'siembra' => $cosecha && $cosecha->fecha_siembra ? \Carbon\Carbon::parse($cosecha->fecha_siembra)->format('d/m/Y') : 'No registrada',
                                'estimada' => $cosecha && $cosecha->fecha_estimada ? \Carbon\Carbon::parse($cosecha->fecha_estimada)->format('d/m/Y') : 'Pendiente',
                                'cantidad' => ($cosecha->Cantidad ?? '0') . ' unidades',
                                'produccion' => ($cosecha->produccion_estimada ?? '0') . ' kg est.'
                            ];
                        @endphp
                        <button 
                                data-fase-id="{{ $details['fase_id'] }}"
                                data-estado="{{ $details['estado'] }}"
                                data-descripcion="{{ $details['descripcion'] }}"
                                data-fecha="{{ $details['fecha'] }}"
                                data-parcela="{{ $details['parcela'] }}"
                                data-ubicacion="{{ $details['ubicacion'] }}"
                                data-dimensiones="{{ $details['dimensiones'] }}"
                                data-suelo="{{ $details['suelo'] }}"
                                data-cultivo="{{ $details['cultivo'] }}"
                                data-siembra="{{ $details['siembra'] }}"
                                data-estimada="{{ $details['estimada'] }}"
                                data-cantidad="{{ $details['cantidad'] }}"
                                data-produccion="{{ $details['produccion'] }}"
                                onclick="showTaskDetails(this)" 
                                class="p-2.5 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors border border-blue-100 flex items-center justify-center"
                                title="Ver detalle">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>

                        {{-- Select de Estado --}}
                        <form id="form-estado-{{ $fase->id_fase }}" action="{{ route('trabajador.tareas.estado', $fase->id_fase) }}" method="POST" class="flex-1">
                            @csrf
                            <div class="relative group/select">
                                <select name="estado" onchange="this.form.submit()" 
                                        class="w-full appearance-none bg-emerald-50 border border-emerald-100 text-emerald-900 font-bold py-2.5 px-4 pr-10 rounded-xl focus:outline-none focus:border-emerald-500 transition-all cursor-pointer text-sm">
                                    <option value="Pendiente" {{ $fase->estado == 'Pendiente' ? 'selected' : 'disabled' }}>Pendiente</option>
                                    <option value="En Proceso" {{ $fase->estado == 'En Proceso' ? 'selected' : '' }}>En Proceso</option>
                                    <option value="Realizado" {{ $fase->estado == 'Realizado' ? 'selected' : '' }}>Realizado</option>
                                </select>
                                <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-emerald-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white border-2 border-dashed border-gray-200 rounded-3xl p-12 text-center">
                <div class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Sin tareas asignadas</h3>
                <p class="text-gray-500 max-w-sm mx-auto">No tienes ninguna fase programada en este momento. Cuando se te asigne trabajo, aparecerá aquí.</p>
            </div>
        @endforelse
    </div>

</div>

<!-- Modal de Detalle de Tarea -->
<div id="modalTarea" class="fixed inset-0 z-[60] hidden">
    <!-- Overlay backdrop -->
    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeTaskModal()"></div>
    
    <!-- Modal Container -->
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            
            <div class="relative transform overflow-hidden rounded-[2.5rem] bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">
                <div class="bg-white p-8 lg:p-10">
                    <div class="flex justify-between items-start mb-8">
                        <div class="flex items-center gap-4">
                            <div class="bg-emerald-100 p-4 rounded-2xl text-emerald-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase font-black text-emerald-600 tracking-widest">Detalle de Trabajo</p>
                                <h2 class="text-2xl font-black text-gray-900" id="modalFaseId"></h2>
                                <input type="hidden" id="currentFaseId">
                                <input type="hidden" id="currentFaseEstado">
                            </div>
                        </div>
                        <button onclick="closeTaskModal()" class="text-gray-400 hover:text-gray-600 p-3 rounded-2xl hover:bg-gray-100 transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-8">
                        {{-- Descripción Principal --}}
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 mb-3 underline decoration-emerald-500/30">Descripción de la Fase</h3>
                            <p class="text-gray-600 text-lg leading-relaxed" id="modalDescripcion"></p>
                            <p class="mt-4 inline-flex items-center gap-2 bg-emerald-50 text-emerald-700 px-4 py-2 rounded-xl font-bold text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Programado: <span id="modalFecha"></span>
                            </p>
                        </div>

                        {{-- Grid de Información --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Columna 1: Terreno --}}
                            <div class="space-y-4">
                                <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest flex items-center gap-2">
                                    <span class="w-2 h-2 bg-blue-500 rounded-full"></span> Terreno / Parcela
                                </h4>
                                <div class="bg-gray-50 p-5 rounded-3xl border border-gray-100 space-y-3">
                                    <div>
                                        <p class="text-[10px] text-gray-400 font-bold uppercase">Nombre</p>
                                        <p class="font-bold text-gray-800" id="modalParcela"></p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] text-gray-400 font-bold uppercase">Ubicación</p>
                                        <p class="text-sm text-gray-600" id="modalUbicacion"></p>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <p class="text-[10px] text-gray-400 font-bold uppercase">Área</p>
                                            <p class="text-sm font-bold text-gray-700" id="modalDimensiones"></p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] text-gray-400 font-bold uppercase">Suelo</p>
                                            <p class="text-sm font-bold text-gray-700" id="modalSuelo"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Columna 2: Cultivo --}}
                            <div class="space-y-4">
                                <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest flex items-center gap-2">
                                    <span class="w-2 h-2 bg-orange-500 rounded-full"></span> Detalle del Cultivo
                                </h4>
                                <div class="bg-gray-50 p-5 rounded-3xl border border-gray-100 space-y-3">
                                    <div>
                                        <p class="text-[10px] text-gray-400 font-bold uppercase">Semilla / Variedad</p>
                                        <p class="font-bold text-gray-800" id="modalCultivo"></p>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <p class="text-[10px] text-gray-400 font-bold uppercase">Siembra</p>
                                            <p class="text-sm font-bold text-gray-700" id="modalSiembra"></p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] text-gray-400 font-bold uppercase">Cosecha Est.</p>
                                            <p class="text-sm font-bold text-gray-700" id="modalEstimada"></p>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <p class="text-[10px] text-gray-400 font-bold uppercase">Cantidad</p>
                                            <p class="text-sm font-bold text-emerald-600" id="modalCantidad"></p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] text-gray-400 font-bold uppercase">Producción</p>
                                            <p class="text-sm font-bold text-emerald-600" id="modalProduccion"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10">
                        <button onclick="closeTaskModalWithUpdate()" class="w-full bg-gray-900 text-white font-bold py-5 rounded-[1.5rem] hover:bg-black transition-all shadow-xl shadow-gray-200 hover:-translate-y-1">
                            Entendido, cerrar detalles
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showTaskDetails(btn) {
        try {
            const ds = btn.dataset;
            console.log('Cargando datos...', ds);

            document.getElementById('modalFaseId').innerText = 'Fase #' + (ds.faseId || '---');
            document.getElementById('currentFaseId').value = ds.faseId || '';
            document.getElementById('currentFaseEstado').value = ds.estado || '';
            
            document.getElementById('modalDescripcion').innerText = ds.descripcion || 'Sin descripción';
            document.getElementById('modalFecha').innerText = ds.fecha || 'No definida';
            document.getElementById('modalParcela').innerText = ds.parcela || 'N/A';
            document.getElementById('modalUbicacion').innerText = ds.ubicacion || 'N/A';
            document.getElementById('modalDimensiones').innerText = ds.dimensiones || 'N/A';
            document.getElementById('modalSuelo').innerText = ds.suelo || 'N/A';
            document.getElementById('modalCultivo').innerText = ds.cultivo || 'N/A';
            document.getElementById('modalSiembra').innerText = ds.siembra || 'N/A';
            document.getElementById('modalEstimada').innerText = ds.estimada || 'N/A';
            document.getElementById('modalCantidad').innerText = ds.cantidad || 'N/A';
            document.getElementById('modalProduccion').innerText = ds.produccion || 'N/A';
            
            const modal = document.getElementById('modalTarea');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        } catch (e) {
            console.error('Error al abrir detalles:', e);
        }
    }

    function closeTaskModal() {
        document.getElementById('modalTarea').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function closeTaskModalWithUpdate() {
        const faseId = document.getElementById('currentFaseId').value;
        const estadoActual = document.getElementById('currentFaseEstado').value;

        if (faseId && estadoActual === 'Pendiente') {
            const form = document.getElementById('form-estado-' + faseId);
            if (form) {
                const select = form.querySelector('select[name="estado"]');
                if (select) {
                    select.value = 'En Proceso';
                    form.submit();
                    return; // El formulario recargará la página
                }
            }
        }
        
        closeTaskModal();
    }
</script>
@endsection
