@extends('layouts.admin')

@section('title', 'Asignar Pago')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">

    <div class="mb-4">
        <a href="{{ route('admin.usuarios.index') }}" class="inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 font-semibold transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Volver a la Gestión de Personal
        </a>
    </div>

    @if (session('success'))
        <div class="auto-dismiss bg-emerald-100 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-r-lg shadow-sm">
            <p class="font-medium flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        {{-- COLUMNA IZQUIERDA: FORMULARIO AGREGAR PAGO --}}
        <div class="lg:col-span-1 bg-white rounded-3xl shadow-lg border border-emerald-100 overflow-hidden sticky top-8">
            <div class="bg-gradient-to-br from-emerald-600 to-green-500 p-6 text-white">
                <h3 class="text-xl font-bold flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Asignar Pago
                </h3>
                <p class="text-sm text-emerald-100 mt-1">Registra un pago o salario para {{ explode(' ', $usuario->nombre)[0] }}</p>
            </div>

            <div class="p-6">
                @if ($errors->any())
                    <div class="bg-red-50 text-red-600 text-sm p-3 rounded-lg mb-4">
                        <ul class="list-disc pl-4 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="paymentForm" action="{{ route('admin.usuarios.store_trabajo', $usuario->documento) }}" method="POST" class="space-y-5">
                    @csrf
                    <input type="hidden" name="id_salario" id="id_salario_input">

                    <div>
                        <label for="descripcion_pago" class="block text-sm font-bold text-gray-700 mb-1">Descripción del Pago</label>
                        <textarea name="descripcion_pago" id="descripcion_pago" rows="2"
                                  placeholder="Ej: Pago de semana, Bono de productividad..."
                                  class="w-full px-3 py-2.5 rounded-lg border @error('descripcion_pago') border-red-500 @else border-gray-300 @enderror focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 bg-gray-50 text-sm resize-none">{{ old('descripcion_pago') }}</textarea>
                        @error('descripcion_pago') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="cantidad_pago" class="block text-sm font-bold text-gray-700 mb-1">Monto <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 font-bold">$</span>
                                <input type="number" step="0.01" name="cantidad_pago" id="cantidad_pago" value="{{ old('cantidad_pago') }}" required
                                       class="w-full pl-7 pr-3 py-2.5 rounded-lg border @error('cantidad_pago') border-red-500 @else border-gray-300 @enderror focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 bg-gray-50 text-sm">
                            </div>
                            @error('cantidad_pago') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="unidad_pago" class="block text-sm font-bold text-gray-700 mb-1">Unidad</label>
                            <input type="text" name="unidad_pago" id="unidad_pago" value="{{ old('unidad_pago') }}" placeholder="Ej: COP, USD"
                                   class="w-full px-3 py-2.5 rounded-lg border @error('unidad_pago') border-red-500 @else border-gray-300 @enderror focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 bg-gray-50 text-sm">
                            @error('unidad_pago') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="id_tipo_salario" class="block text-sm font-bold text-gray-700 mb-1">Frecuencia / Tipo</label>
                        <select name="id_tipo_salario" id="id_tipo_salario"
                                class="w-full px-3 py-2.5 rounded-lg border @error('id_tipo_salario') border-red-500 @else border-gray-300 @enderror focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 bg-gray-50 text-sm">
                            <option value="">-- Selecciona un Tipo --</option>
                            @foreach($tiposSalario as $tipo)
                                <option value="{{ $tipo->id_tipo_salario }}" {{ old('id_tipo_salario') == $tipo->id_tipo_salario ? 'selected' : '' }}>
                                    {{ $tipo->tipo_salario }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_tipo_salario') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 mt-2 rounded-lg shadow-md transition-colors text-sm flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            <span id="btnSubmitText">Guardar Pago</span>
                        </button>
                        <button type="button" id="btnResetForm" onclick="resetPaymentForm()" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold py-2 mt-2 rounded-lg transition-colors text-xs hidden">
                            Limpiar / Nuevo Pago
                        </button>
                    </form>
            </div>
        </div>

        {{-- COLUMNA DERECHA: LISTADO DE PAGOS --}}
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-emerald-100 flex items-center gap-6">
                 @if($usuario->imagen)
                    <img src="{{ asset('uploads/' . $usuario->imagen) }}" alt="Avatar" class="w-16 h-16 rounded-full object-cover border-2 border-emerald-200">
                @else
                    <div class="w-16 h-16 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 text-2xl font-bold border-2 border-emerald-200">
                        {{ strtoupper(substr($usuario->nombre, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $usuario->nombre }}</h2>
                    <p class="text-gray-500 text-sm font-medium">Doc: {{ $usuario->documento }} • {{ $usuario->id_tipo_usuario == 2 ? 'Supervisor' : 'Trabajador' }}</p>
                </div>
            </div>

            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Historial de Pagos / Salarios
                </h3>
                <a href="{{ route('admin.usuarios.exportar_pagos', $usuario->documento) }}" 
                class="bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200 px-4 py-2 rounded-xl text-sm font-bold transition flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Descargar Reporte Excel
                </a>
            </div>

            @forelse($salarios as $salario)
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:border-emerald-300 transition-colors relative overflow-hidden group cursor-pointer salary-card"
                     data-id="{{ $salario->id_salario }}"
                     data-descripcion="{{ $salario->descripcion_pago }}"
                     data-cantidad="{{ $salario->cantidad_pago }}"
                     data-unidad="{{ $salario->unidad_pago }}"
                     data-tipo="{{ $salario->id_tipo_salario }}">
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 {{ $salario->estado == 'activo' ? 'bg-emerald-500' : 'bg-gray-300' }}"></div>
                    
                    <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-1">
                                <h4 class="text-lg font-bold text-emerald-900">
                                    {{ $salario->tipoSalario ? $salario->tipoSalario->tipo_salario : 'Pago General' }}
                                </h4>
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider
                                    {{ $salario->estado == 'activo' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($salario->estado) }}
                                </span>
                            </div>
                            <p class="text-gray-700 mt-2">{{ $salario->descripcion_pago ?: 'Sin descripción adicional' }}</p>
                        </div>
                        
                        <div class="text-right whitespace-nowrap bg-emerald-50 p-3 rounded-xl border border-emerald-100 min-w-[140px]">
                            <p class="text-[10px] text-emerald-600 font-bold uppercase mb-1">
                                {{ $salario->fecha_pago ? \Carbon\Carbon::parse($salario->fecha_pago)->format('d/m/Y') : 'Sin fecha' }}
                            </p>
                            <p class="font-black text-emerald-800 text-xl">
                                ${{ number_format($salario->cantidad_pago, 0, ',', '.') }} 
                                <span class="text-xs font-normal text-emerald-600 italic underline">{{ $salario->unidad_pago }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white border-2 border-dashed border-gray-200 rounded-2xl p-10 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-gray-800 font-bold text-lg">Sin pagos registrados</p>
                    <p class="text-gray-500 text-sm mt-1">Aún no se han asignado montos salariales a este empleado.</p>
                </div>
            @endforelse

            <hr class="border-gray-100 my-8">

            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Actividades y Evidencias
                </h3>
            </div>

            <div class="space-y-4">
                @forelse($actividades as $act)
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all">
                        <div class="flex flex-col md:flex-row gap-6">
                            {{-- Info de la Tarea --}}
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="px-2 py-0.5 rounded-lg text-[10px] font-black uppercase tracking-widest 
                                        {{ $act->tipo_actividad == 'Fase' ? 'bg-blue-100 text-blue-700' : ($act->tipo_actividad == 'Riego' ? 'bg-sky-100 text-sky-700' : 'bg-purple-100 text-purple-700') }}">
                                        {{ $act->tipo_actividad }}
                                    </span>
                                    <h5 class="font-bold text-gray-800">{{ $act->titulo }}</h5>
                                </div>
                                <p class="text-sm text-gray-600 line-clamp-2 mb-3">{{ $act->descripcion ?? 'Actividad programada del día.' }}</p>
                                
                                <div class="grid grid-cols-2 gap-4 text-xs">
                                    <div class="flex flex-col">
                                        <span class="text-gray-400 font-bold uppercase truncate">Programada</span>
                                        <span class="text-gray-700 font-medium">{{ \Carbon\Carbon::parse($act->fecha_prog)->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-gray-400 font-bold uppercase truncate">Estado</span>
                                        <span class="font-bold {{ $act->id_estado == 9 ? 'text-emerald-600' : 'text-orange-500' }}">
                                            {{ $act->estado->nombre_estado ?? 'Pendiente' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- Cumplimiento y Evidencia --}}
                            <div class="md:w-64 flex flex-col gap-3">
                                @if($act->evidencia)
                                    <div class="flex items-center justify-between bg-gray-50 p-2 rounded-xl border border-gray-100">
                                        <div class="flex flex-col">
                                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-tighter">Cumplimiento</span>
                                            @if($act->a_tiempo)
                                                <span class="text-emerald-600 font-bold text-xs flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                                    A tiempo
                                                </span>
                                            @else
                                                <span class="text-amber-600 font-bold text-xs flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                                    Fuera de tiempo
                                                </span>
                                            @endif
                                        </div>
                                        
                                        @if($act->evidencia->foto_evidencia)
                                            <div class="relative group cursor-pointer" onclick="viewEvidencia('{{ asset('uploads/' . $act->evidencia->foto_evidencia) }}', '{{ addslashes($act->evidencia->observacion) }}')">
                                                <img src="{{ asset('uploads/' . $act->evidencia->foto_evidencia) }}" class="w-12 h-12 rounded-lg object-cover border-2 border-emerald-100 group-hover:border-emerald-500 transition-all">
                                                <div class="absolute inset-0 bg-black/40 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                </div>
                                            </div>
                                        @else
                                            <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center text-gray-300" title="Sin foto">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="bg-red-50 p-2 rounded-xl border border-red-100 text-center">
                                        <p class="text-[10px] font-black text-red-400 uppercase tracking-tighter">Sin registro</p>
                                        <p class="text-xs font-bold text-red-600">No reportado</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-400 text-sm py-10 italic">No hay actividades asignadas recientemente.</p>
                @endforelse
            </div>

        </div>

    </div>

</div>

{{-- MODAL PARA VER EVIDENCIA --}}
<div id="modalEvidencia" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-4 bg-gray-900/90 backdrop-blur-sm">
    <div class="relative max-w-2xl w-full bg-white rounded-3xl overflow-hidden shadow-2xl">
        <button onclick="closeEvidencia()" class="absolute top-4 right-4 z-10 bg-white/50 hover:bg-white text-gray-600 p-2 rounded-full transition-all">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <img id="evidenciaImg" src="" class="w-full h-80 object-cover">
        <div class="p-6">
            <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Comentarios del trabajador</h4>
            <p id="evidenciaObs" class="text-gray-700 italic font-medium"></p>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function viewEvidencia(url, obs) {
        document.getElementById('evidenciaImg').src = url;
        document.getElementById('evidenciaObs').innerText = obs || 'Sin observaciones del trabajador.';
        document.getElementById('modalEvidencia').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeEvidencia() {
        document.getElementById('modalEvidencia').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    document.querySelectorAll('.salary-card').forEach(card => {
        card.addEventListener('click', function() {
            const data = {
                id: this.dataset.id,
                descripcion: this.dataset.descripcion,
                cantidad: this.dataset.cantidad,
                unidad: this.dataset.unidad,
                tipo: this.dataset.tipo
            };
            fillPaymentForm(data);
        });
    });

    function fillPaymentForm(data) {
        document.getElementById('id_salario_input').value = data.id || '';
        document.getElementById('descripcion_pago').value = data.descripcion || '';
        document.getElementById('cantidad_pago').value = data.cantidad || '';
        document.getElementById('unidad_pago').value = data.unidad || '';
        document.getElementById('id_tipo_salario').value = data.tipo || '';
        
        // Cambiar el texto del botón y mostrar reset
        const submitBtn = document.querySelector('#paymentForm button[type="submit"]');
        const btnText = document.getElementById('btnSubmitText');
        const resetBtn = document.getElementById('btnResetForm');

        if (data.id) {
            btnText.innerText = 'Actualizar Pago';
            submitBtn.classList.add('bg-blue-600', 'hover:bg-blue-700');
            submitBtn.classList.remove('bg-emerald-600', 'hover:bg-emerald-700');
            resetBtn.classList.remove('hidden');
        } else {
            resetPaymentForm();
        }

        // Hacer scroll al formulario
        document.getElementById('descripcion_pago').scrollIntoView({ behavior: 'smooth', block: 'center' });
        
        // Animacion de resaltado
        const formPanel = document.getElementById('descripcion_pago').closest('.bg-white');
        formPanel.classList.add('ring-4', 'ring-emerald-500/30');
        setTimeout(() => {
            formPanel.classList.remove('ring-4', 'ring-emerald-500/30');
        }, 800);
    }

    function resetPaymentForm() {
        document.getElementById('paymentForm').reset();
        document.getElementById('id_salario_input').value = '';
        
        const submitBtn = document.querySelector('#paymentForm button[type="submit"]');
        const btnText = document.getElementById('btnSubmitText');
        const resetBtn = document.getElementById('btnResetForm');

        btnText.innerText = 'Guardar Pago';
        submitBtn.classList.add('bg-emerald-600', 'hover:bg-emerald-700');
        submitBtn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
        resetBtn.classList.add('hidden');
    }
</script>
@endpush
@endsection
