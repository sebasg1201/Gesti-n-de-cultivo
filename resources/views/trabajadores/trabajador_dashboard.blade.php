@extends('layouts.admin')

@section('title', 'Mis Tareas Asignadas')

@section('content')
<div class="max-w-6xl mx-auto space-y-8 pb-20">

    @if (session('success'))
        <div id="notification-alert" class="fixed top-24 right-8 z-[100] transform transition-all duration-500 translate-x-0">
            <div class="bg-emerald-500 text-white px-6 py-4 rounded-2xl shadow-2xl shadow-emerald-200/50 flex items-center gap-4 border border-emerald-400/20 backdrop-blur-md">
                <div class="bg-white/20 p-2 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <p class="font-bold">{{ session('success') }}</p>
                <button onclick="closeNotification()" class="ml-4 opacity-70 hover:opacity-100 transition-opacity">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    @endif

    <div class="relative overflow-hidden bg-gradient-to-br from-emerald-600 to-teal-700 rounded-[2.5rem] p-8 lg:p-12 shadow-2xl shadow-emerald-200/50 group">
        <div class="absolute top-0 right-0 -mt-20 -mr-20 w-64 h-64 bg-white/10 rounded-full blur-3xl group-hover:bg-white/20 transition-all duration-700"></div>
        <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-48 h-48 bg-emerald-400/20 rounded-full blur-2xl group-hover:bg-emerald-400/30 transition-all duration-700"></div>
        
        <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2">
                <span class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-md px-4 py-1.5 rounded-full text-white text-[10px] font-black uppercase tracking-[0.2em]">
                    <span class="w-2 h-2 bg-emerald-300 rounded-full animate-pulse"></span>
                    Sesión Activa
                </span>
                <h2 class="text-3xl md:text-5xl font-black text-white tracking-tight">¡Hola, {{ explode(' ', auth()->guard('usuario')->user()->nombre)[0] }}!</h2>
                <p class="text-emerald-50 text-lg opacity-90 max-w-md">Lleva el control de tu productividad. Tienes <span class="font-black underline decoration-emerald-300">{{ $tareas->flatten()->count() }}</span> acciones programadas hoy.</p>
            </div>
            <div class="flex gap-4">
                <div class="bg-white/10 backdrop-blur-md p-6 rounded-[2rem] border border-white/10 text-center flex-1 md:flex-none md:min-w-[140px]">
                    <p class="text-white/60 text-[10px] font-black uppercase mb-1">Pendientes</p>
                    <p class="text-3xl font-black text-white">{{ $tareas->flatten()->where('id_estado', 1)->count() }}</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md p-6 rounded-[2rem] border border-white/10 text-center flex-1 md:flex-none md:min-w-[140px]">
                    <p class="text-white/60 text-[10px] font-black uppercase mb-1">En Proceso</p>
                    <p class="text-3xl font-black text-white">{{ $tareas->flatten()->where('id_estado', 8)->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="space-y-16">
        @forelse($tareas as $id_cosecha => $grupoTareas)
            @php
                $primeraTarea = $grupoTareas->first();
                $cosecha = $primeraTarea->cosecha;
                $semillaNombre = optional($cosecha->semilla)->nombre_semilla ?? 'General';
                $parcelaNombre = optional($cosecha->terreno)->nombre ?? 'Sin Parcela';
            @endphp
            
            <div class="space-y-8">
                {{-- Harvest Header --}}
                <div class="flex items-center gap-6 px-4">
                    <h3 class="flex-none flex items-center gap-4 bg-white px-6 py-3 rounded-2xl shadow-xl shadow-gray-100/50 border border-gray-50">
                        <div class="w-10 h-10 bg-emerald-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none mb-1">Cosecha Activa</p>
                            <span class="text-xl font-black text-gray-900 leading-none">Lote #{{ $id_cosecha }} <span class="text-emerald-600">|</span> {{ $semillaNombre }}</span>
                        </div>
                    </h3>
                    <div class="h-px flex-1 bg-gradient-to-r from-gray-200 to-transparent"></div>
                    <div class="flex-none px-4 py-2 bg-emerald-50 rounded-xl text-emerald-700 font-black text-[10px] uppercase tracking-widest border border-emerald-100">
                        {{ $parcelaNombre }}
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($grupoTareas as $fase)
                        <div class="group/card bg-white rounded-[2.5rem] p-1 border border-gray-100 shadow-xl shadow-gray-100/50 hover:shadow-2xl hover:shadow-emerald-200/40 hover:-translate-y-2 transition-all duration-500">
                            <div class="bg-gray-50/50 rounded-[2.2rem] p-7 h-full flex flex-col relative overflow-hidden">
                                {{-- Background Pattern --}}
                                <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-500/5 rounded-full blur-2xl group-hover/card:bg-emerald-500/10 transition-colors"></div>

                                <div class="flex justify-between items-start mb-6">
                                    <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest shadow-sm
                                        {{ $fase->id_estado == 1 ? 'bg-amber-100 text-amber-700 border border-amber-200' : ($fase->id_estado == 17 ? 'bg-sky-100 text-sky-700 border border-sky-200' : 'bg-emerald-100 text-emerald-700 border border-emerald-200') }}">
                                        {{ $fase->id_estado == 1 ? 'Pendiente' : ($fase->id_estado == 17 ? 'En Proceso' : 'Realizado') }}
                                    </span>
                                    
                                    <div class="text-right">
                                        <p class="text-[9px] text-gray-400 font-black uppercase tracking-widest leading-none mb-1">Entrega</p>
                                        <p class="text-xs font-black text-gray-800 bg-white px-2 py-1 rounded-lg border border-gray-100 shadow-sm">{{ \Carbon\Carbon::parse($fase->fecha_programada)->format('d/m/Y') }}</p>
                                    </div>
                                </div>

                                <h3 class="text-xl font-black text-gray-900 mb-6 leading-tight flex-grow group-hover/card:text-emerald-700 transition-colors">
                                    {{ $fase->descripcion }}
                                </h3>

                                <div class="mt-auto flex items-center justify-between gap-4">
                                     @php
                                        $terreno = optional($cosecha)->terreno ?? null;
                                        $tipoEtiqueta = 'General';
                                        if($fase->tipo_tarea == 'riego') $tipoEtiqueta = 'Riego';
                                        elseif($fase->tipo_tarea == 'insumo') $tipoEtiqueta = 'Insumo';

                                        $details = [
                                            'fase_id' => $fase->tipo_tarea == 'riego' ? $fase->id_riego : ($fase->tipo_tarea == 'insumo' ? $fase->id_insumo_cosecha : $fase->id_fase),
                                            'tipo_tarea' => $fase->tipo_tarea,
                                            'tipo_label' => $tipoEtiqueta,
                                            'estado' => $fase->id_estado == 1 ? 'Pendiente' : ($fase->id_estado == 17 ? 'En Proceso' : ($fase->id_estado == 15 ? 'Realizado' : 'Otro')),
                                            'descripcion' => $fase->descripcion ?? 'Sin descripción',
                                            'obs_trabajador' => $fase->observacion_trabajador ?? '',
                                            'fecha' => $fase->fecha_programada ? \Carbon\Carbon::parse($fase->fecha_programada)->format('d/m/Y') : 'No definida',
                                            'parcela' => optional($terreno)->nombre ?? 'Sin Parcela',
                                            'ubicacion' => optional($terreno)->ubicacion ?? 'No especificada',
                                            'dimensiones' => $terreno ? (($terreno->Ancho ?? '?') . 'm x ' . ($terreno->Alto ?? '?') . 'm') : 'No detallado',
                                            'suelo' => optional(optional($terreno)->tipoSuelo)->nombre ?? 'General',
                                            'cultivo' => $semillaNombre,
                                            'siembra' => $cosecha && $cosecha->fecha_siembra ? \Carbon\Carbon::parse($cosecha->fecha_siembra)->format('d/m/Y') : 'No registrada',
                                            'estimada' => $cosecha && $cosecha->fecha_estimada ? \Carbon\Carbon::parse($cosecha->fecha_estimada)->format('d/m/Y') : 'Pendiente',
                                            'cantidad' => ($cosecha->Cantidad ?? '0') . ' unidades',
                                            'produccion' => ($cosecha->produccion_estimada ?? '0') . ' kg est.'
                                        ];
                                    @endphp
                                    
                                    <button 
                                        data-fase-id="{{ $details['fase_id'] }}" data-tipo-tarea="{{ $details['tipo_tarea'] }}"
                                        data-tipo-label="{{ $details['tipo_label'] }}" data-estado="{{ $details['estado'] }}"
                                        data-descripcion="{{ $details['descripcion'] }}" data-obs-trabajador="{{ $details['obs_trabajador'] }}"
                                        data-fecha="{{ $details['fecha'] }}"
                                        data-parcela="{{ $details['parcela'] }}" data-ubicacion="{{ $details['ubicacion'] }}"
                                        data-dimensiones="{{ $details['dimensiones'] }}" data-suelo="{{ $details['suelo'] }}"
                                        data-cultivo="{{ $details['cultivo'] }}" data-siembra="{{ $details['siembra'] }}"
                                        data-estimada="{{ $details['estimada'] }}" data-cantidad="{{ $details['cantidad'] }}"
                                        data-produccion="{{ $details['produccion'] }}" data-id-estado="{{ $fase->id_estado }}"
                                        data-update-url="{{ route('trabajador.tareas.estado', ['id' => $details['fase_id'], 'tipo' => $fase->tipo_tarea]) }}"
                                        onclick="showTaskDetails(this)" 
                                        class="flex-1 bg-white hover:bg-emerald-600 text-gray-900 hover:text-white font-black py-4 px-6 rounded-2xl transition-all duration-300 border border-gray-100 hover:border-emerald-600 text-xs uppercase tracking-widest shadow-sm hover:shadow-xl hover:shadow-emerald-200">
                                        Detalles de Tarea
                                    </button>

                                    <a href="{{ route('trabajador.calendario', ['date' => $fase->fecha_programada]) }}" 
                                       title="Ver en Mi Calendario"
                                       class="w-12 h-12 rounded-2xl bg-white border border-gray-100 flex items-center justify-center text-emerald-600 shadow-sm hover:scale-110 hover:shadow-emerald-100 hover:border-emerald-200 transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002-2z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="bg-white border-2 border-dashed border-gray-200 rounded-[3rem] p-16 text-center max-w-2xl mx-auto shadow-2xl shadow-gray-100">
                <div class="w-32 h-32 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-8 animate-bounce">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <h3 class="text-3xl font-black text-gray-900 mb-4">Todo al día</h3>
                <p class="text-gray-500 text-lg">No tienes fases o tareas programadas actualmente. ¡Buen trabajo!</p>
            </div>
        @endforelse
    </div>

</div>

<!-- Modal de Detalle de Tarea -->
<div id="modalTarea" class="fixed inset-0 z-[60] hidden">
    <div class="fixed inset-0 bg-gray-900/80 backdrop-blur-md transition-opacity" onclick="closeTaskModal()"></div>
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative bg-white rounded-[3rem] p-8 lg:p-12 w-full max-w-2xl shadow-2xl transform transition-all overflow-hidden">
                {{-- Modal Header --}}
                <div class="flex justify-between items-start mb-10">
                    <div class="flex items-center gap-6">
                        <div class="bg-emerald-600 p-5 rounded-[1.5rem] text-white shadow-xl shadow-emerald-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase font-black text-emerald-600 tracking-[0.2em]" id="modalTipoTarea"></p>
                            <h2 class="text-3xl font-black text-gray-900 tracking-tight" id="modalFaseId"></h2>
                            <input type="hidden" id="currentFaseId">
                        </div>
                    </div>
                    <button onclick="closeTaskModal()" class="bg-gray-50 text-gray-400 hover:text-gray-600 p-4 rounded-2xl hover:bg-gray-100 transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <div class="space-y-10">
                    <div>
                        <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-3 ml-1" id="modalTituloTipo">Descripción de la Tarea</h3>
                        <p class="text-gray-700 text-xl font-bold leading-snug bg-gray-50 p-6 rounded-[2rem] border border-gray-100 shadow-inner" id="modalDescripcion"></p>
                    </div>


                    <div class="grid grid-cols-2 gap-8">
                        <div class="space-y-4">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Ubicación</p>
                            <div class="bg-emerald-50/50 p-6 rounded-[2rem] border border-emerald-100">
                                <p class="font-black text-emerald-900" id="modalParcela"></p>
                                <p class="text-sm text-emerald-700 font-bold" id="modalDimensiones"></p>
                                <p class="text-[10px] text-emerald-600 uppercase tracking-widest mt-2">Suelo: <span id="modalSuelo"></span></p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Programado</p>
                            <div class="bg-blue-50/50 p-6 rounded-[2rem] border border-blue-100">
                                <p class="font-black text-blue-900" id="modalFecha"></p>
                                <p class="text-sm font-bold text-blue-700" id="modalCultivo"></p>
                                <p class="text-[10px] text-blue-600 uppercase tracking-widest mt-2">Fin Estimado: <span id="modalEstimada"></span></p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-violet-50/50 p-6 rounded-[2rem] border border-violet-100">
                        <p class="text-[10px] font-black text-violet-400 uppercase tracking-widest mb-3 text-center">Detalles Finales de Cosecha</p>
                        <div class="flex justify-around items-center text-center">
                            <div>
                                <p class="text-[9px] text-violet-500 uppercase font-black tracking-widest leading-none mb-1">Siembra</p>
                                <p class="font-bold text-violet-900" id="modalSiembra"></p>
                            </div>
                            <div class="w-px h-8 bg-violet-200"></div>
                            <div>
                                <p class="text-[9px] text-violet-500 uppercase font-black tracking-widest leading-none mb-1">Cantidad</p>
                                <p class="font-bold text-violet-900" id="modalCantidad"></p>
                            </div>
                            <div class="w-px h-8 bg-violet-200"></div>
                            <div>
                                <p class="text-[9px] text-violet-500 uppercase font-black tracking-widest leading-none mb-1">Producción</p>
                                <p class="font-bold text-violet-900" id="modalProduccion"></p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-8 border-t border-gray-100">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-6 text-center">Gestionar Progreso</p>
                        <form id="modalFormEstado" method="POST" class="max-w-md mx-auto" enctype="multipart/form-data">
                            @csrf
                            {{-- 15 = Realizado --}}
                            <input type="hidden" name="id_estado" value="15">
                            
                            {{-- Observación del trabajador - solo visible si ya la tiene (tarea completada) --}}
                            <div id="obsGuardadaWrap" class="hidden mb-6 bg-emerald-50 border border-emerald-100 p-5 rounded-2xl">
                                <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-2">Tu Observación Registrada</p>
                                <p class="text-sm text-emerald-800 font-semibold leading-relaxed italic" id="obsGuardadaTexto"></p>
                            </div>

                            {{-- Textarea de observación - solo visible cuando se puede finalizar --}}
                            <div id="obsInputWrap" class="mb-5 text-left">
                                <label for="observacion_trabajador" class="block text-[10px] font-black text-gray-500 uppercase tracking-widest ml-1 mb-2">¿Qué realizaste? <span class="text-gray-400 normal-case font-normal">(opcional)</span></label>
                                <textarea name="observacion_trabajador" id="observacion_trabajador" rows="3"
                                    class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-4 text-sm text-gray-700 focus:outline-none focus:border-emerald-400 transition-all resize-none shadow-inner"
                                    placeholder="Ej: Realicé el riego completo de la parcela, revise los goteros y todo funcionó correctamente..."></textarea>
                            </div>

                            <div class="mb-6 text-left">
                                <label for="evidencia_foto" class="block text-[10px] font-black text-emerald-600 uppercase tracking-widest ml-1 mb-2">Evidencia Fotográfica Requerida</label>
                                <input type="file" name="evidencia_foto" id="evidencia_foto" accept="image/*" required class="w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition-all border border-gray-200 rounded-xl p-2 bg-white">
                                <p class="text-[9px] text-gray-400 mt-2 ml-1">Debe adjuntar una foto del trabajo realizado (&lt; 2MB).</p>
                            </div>

                            <button type="submit" id="btnFinalizarTarea" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black py-5 px-10 rounded-[2rem] focus:outline-none transition-all cursor-pointer text-center text-lg shadow-2xl shadow-emerald-200/50">
                                Finalizar Trabajo
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Auto-ocultar notificaciones después de 5 segundos
    document.addEventListener('DOMContentLoaded', function() {
        const alert = document.getElementById('notification-alert');
        if (alert) {
            setTimeout(() => {
                closeNotification();
            }, 5000);
        }
    });

    function closeNotification() {
        const alert = document.getElementById('notification-alert');
        if (alert) {
            alert.classList.add('translate-x-[150%]');
            setTimeout(() => alert.remove(), 600);
        }
    }

    function showTaskDetails(btn) {
        const ds = btn.dataset;
        document.getElementById('modalFaseId').innerText = (ds.tipoLabel || 'Fase') + ' #' + (ds.faseId || '---');
        document.getElementById('modalTipoTarea').innerText = ds.tipoLabel || 'Detalle de Trabajo';
        document.getElementById('modalDescripcion').innerText = ds.descripcion || 'Sin descripción';
        document.getElementById('modalFecha').innerText = ds.fecha || 'No definida';
        document.getElementById('modalCultivo').innerText = ds.cultivo || 'Cosecha';
        document.getElementById('modalEstimada').innerText = ds.estimada || 'Pendiente';
        document.getElementById('modalParcela').innerText = ds.parcela || 'N/A';
<<<<<<< HEAD
        document.getElementById('modalDimensiones').innerText = ds.dimensiones || 'N/A';
        document.getElementById('modalSuelo').innerText = ds.suelo || 'N/A';
        
        document.getElementById('modalSiembra').innerText = ds.siembra || '-';
        document.getElementById('modalCantidad').innerText = ds.cantidad || '-';
        document.getElementById('modalProduccion').innerText = ds.produccion || '-';
=======
        document.getElementById('modalUbicacion').innerText = ds.ubicacion || 'N/A';

        // Mostrar/ocultar observación del trabajador ya guardada
        const obsGuardadaWrap = document.getElementById('obsGuardadaWrap');
        const obsGuardadaTexto = document.getElementById('obsGuardadaTexto');
        const obsInputWrap = document.getElementById('obsInputWrap');
        const obsTextarea = document.getElementById('observacion_trabajador');
        if (ds.obsTrabajador && ds.obsTrabajador.trim() !== '') {
            obsGuardadaTexto.innerText = '"' + ds.obsTrabajador + '"';
            obsGuardadaWrap.classList.remove('hidden');
        } else {
            obsGuardadaWrap.classList.add('hidden');
        }
        if (obsTextarea) obsTextarea.value = '';
>>>>>>> 0baaef173059b3ffd58351d6407d8c9030e12740
        
        const modalForm = document.getElementById('modalFormEstado');
        const btnFinalizar = document.getElementById('btnFinalizarTarea');
        if (modalForm && ds.updateUrl) {
            modalForm.action = ds.updateUrl;
            const currentStatus = parseInt(ds.idEstado || '1');

            if (currentStatus === 15) {
                btnFinalizar.disabled = true;
                btnFinalizar.innerText = 'Trabajo Finalizado ✓';
                btnFinalizar.classList.remove('bg-emerald-600', 'hover:bg-emerald-700', 'shadow-emerald-200/50');
                btnFinalizar.classList.add('bg-gray-300', 'text-gray-500', 'cursor-not-allowed', 'shadow-none');
                // Ocultar inputs al estar finalizado
                obsInputWrap.classList.add('hidden');
                document.getElementById('evidencia_foto').closest('div').classList.add('hidden');
            } else {
                btnFinalizar.disabled = false;
                btnFinalizar.innerText = 'Finalizar Trabajo';
                btnFinalizar.classList.remove('bg-gray-300', 'text-gray-500', 'cursor-not-allowed', 'shadow-none');
                btnFinalizar.classList.add('bg-emerald-600', 'hover:bg-emerald-700', 'text-white', 'shadow-emerald-200/50');
                // Mostrar inputs
                obsInputWrap.classList.remove('hidden');
                document.getElementById('evidencia_foto').closest('div').classList.remove('hidden');
            }

            if (currentStatus === 1) {
                // Bloquear el botón PRIMERO para evitar que el form se envíe durante la transición
                btnFinalizar.disabled = true;
                btnFinalizar.innerText = 'Procesando...';
                obsInputWrap.classList.add('hidden');
                document.getElementById('evidencia_foto').closest('div').classList.add('hidden');

                // Pasar automáticamente a "En Proceso" (id=17) al abrir los detalles
                const csrfToken = document.querySelector('input[name="_token"]').value;
                const formData = new FormData();
                formData.append('_token', csrfToken);
                formData.append('id_estado', 17);

                fetch(ds.updateUrl, {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                }).then(response => {
                    if (response.ok) {
                        btn.dataset.idEstado = '17';
                        btn.dataset.estado = 'En Proceso';

                        const cardTag = btn.closest('.group\\/card').querySelector('span.rounded-full');
                        if (cardTag) {
                            cardTag.innerText = 'En Proceso';
                            cardTag.className = 'px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest shadow-sm bg-sky-100 text-sky-700 border border-sky-200';
                        }
                    }
                    // Reactivar el botón y mostrar inputs después de completar la transición
                    btnFinalizar.disabled = false;
                    btnFinalizar.innerText = 'Finalizar Trabajo';
                    btnFinalizar.classList.remove('bg-gray-300', 'text-gray-500', 'cursor-not-allowed', 'shadow-none');
                    btnFinalizar.classList.add('bg-emerald-600', 'hover:bg-emerald-700', 'text-white', 'shadow-emerald-200/50');
                    obsInputWrap.classList.remove('hidden');
                    document.getElementById('evidencia_foto').closest('div').classList.remove('hidden');
                }).catch(e => {
                    console.error(e);
                    // En caso de error, reactivar el botón de todos modos
                    btnFinalizar.disabled = false;
                    btnFinalizar.innerText = 'Finalizar Trabajo';
                    obsInputWrap.classList.remove('hidden');
                    document.getElementById('evidencia_foto').closest('div').classList.remove('hidden');
                });
            }
        }

        const modal = document.getElementById('modalTarea');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeTaskModal() {
        document.getElementById('modalTarea').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>
@endsection
