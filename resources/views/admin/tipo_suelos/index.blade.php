@extends('layouts.admin')

@section('title', 'Configuración de Suelos v3')

@section('content')
<div class="space-y-8">


    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        <!-- Professional Search & Suelo Config -->
        <div class="xl:col-span-1">
            <div class="bg-white rounded-3xl shadow-xl border border-amber-50 p-8 sticky top-8">
                <div class="flex items-center gap-3 mb-8">
                    <div class="bg-amber-500 p-3 rounded-2xl text-white shadow-lg shadow-amber-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-amber-900">Configurar Suelo</h3>
                        <p class="text-[10px] font-medium text-amber-500 uppercase tracking-widest mt-1">Algoritmo de Impacto v3.0</p>
                    </div>
                </div>

                <!-- AJAX Search for Soils -->
                <div class="relative group mb-8">
                    <label class="block text-xs font-bold text-amber-700 uppercase tracking-wider mb-3">Buscar tipo de suelo técnico</label>
                    <div class="relative">
                        <input type="text" id="sueloSearch" autocomplete="off"
                            placeholder="Ej. Arcilloso, Arenoso, Limoso..."
                            class="w-full pl-12 pr-4 py-4 rounded-2xl border-2 border-amber-50 focus:border-amber-500 focus:ring-0 bg-amber-50/20 text-sm transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-amber-400 group-focus-within:text-amber-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <div id="sueloResults" class="hidden absolute top-full left-0 right-0 mt-2 bg-white rounded-2xl shadow-2xl border border-amber-50 z-50 max-h-64 overflow-y-auto">
                            <!-- Results injected via AJAX -->
                        </div>
                    </div>
                </div>

                <form id="sueloForm" action="{{ route('tipo_suelos.store') }}" method="POST" class="space-y-6 hidden animate-in slide-in-from-bottom-4 duration-300">
                    @csrf
                    <input type="hidden" name="id_catalogo" id="sw_id_catalogo">

                    <div>
                        <label class="block text-xs font-bold text-amber-700 uppercase tracking-wider mb-2">Nombre Personalizado</label>
                        <input type="text" name="nombre" id="sw_nombre" required
                            class="w-full px-4 py-3 rounded-2xl border-amber-100 focus:border-amber-500 focus:ring-amber-500 bg-white text-sm"
                            placeholder="Ej. Tierra Negra Lote 1">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-amber-700 uppercase tracking-wider mb-2">Descripción (Opcional)</label>
                        <textarea name="descripcion" id="sw_descripcion" rows="3"
                            class="w-full px-4 py-3 rounded-2xl border-amber-100 focus:border-amber-500 focus:ring-amber-500 bg-white text-sm"
                            placeholder="Especifique ubicación o calidad..."></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-amber-700 uppercase tracking-wider mb-2">Consumo de Agua Ideal (L/m²)</label>
                        <input type="number" name="consumo_agua_ideal" id="sw_consumo_agua_ideal" step="0.01" min="0" required
                            class="w-full px-4 py-3 rounded-2xl border-amber-100 focus:border-amber-500 focus:ring-amber-500 bg-white text-sm"
                            placeholder="Ej. 5.50">
                        <p class="text-[10px] text-amber-600 mt-1 italic">Este valor se usa para automatizar las tareas de riego de la cosecha.</p>
                    </div>

                    <!-- Impact Card -->
                    <div class="bg-amber-50 p-6 rounded-2xl border border-amber-100 relative overflow-hidden">
                        <span class="text-[10px] font-bold text-amber-400 uppercase block mb-2">Impacto Técnico (Días)</span>
                        <div class="flex items-center gap-3">
                            <input type="number" name="impacto_dias" id="sw_impacto" class="text-3xl font-black bg-transparent w-24 border-b-2 border-amber-200 focus:ring-0 focus:border-amber-500 text-amber-700 placeholder:text-gray-300" placeholder="0" value="0">
                            <span class="text-xs text-amber-600 font-medium leading-tight">Días sumados<br>al ciclo</span>
                        </div>
                        <div class="mt-4 p-2 bg-white/50 rounded-lg text-[10px] text-amber-700 italic border border-amber-100/50">
                            * Este valor se aplica automáticamente al cálculo de fecha estimada según la semilla.
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button type="button" onclick="resetSueloForm()" class="px-6 py-4 bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold rounded-2xl transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        <button type="submit" class="flex-1 bg-amber-600 hover:bg-amber-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-amber-200 transition-all transform hover:-translate-y-1">
                            Habilitar Suelo
                        </button>
                    </div>
                </form>

                <div id="sueloPlaceholder" class="py-12 flex flex-col items-center justify-center text-center space-y-4 opacity-40">
                    <div class="w-20 h-20 bg-amber-50 rounded-full flex items-center justify-center text-amber-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-amber-900">Busque un tipo de suelo técnico arriba para configurarlo.</p>
                </div>
            </div>
        </div>

        <!-- Suelos Habilitados Column -->
        <div class="xl:col-span-2">
            <div class="bg-white rounded-3xl shadow-xl border border-emerald-50 overflow-hidden min-h-[500px]">
                <div class="p-8 border-b border-emerald-50 bg-gray-50/50 flex justify-between items-center">
                    <div>
                        <h3 class="text-2xl font-black text-emerald-950">Suelos de la Empresa</h3>
                        <p class="text-xs font-medium text-emerald-600 mt-1">Configuración técnica de terrenos</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-white text-[10px] font-black text-emerald-400 uppercase tracking-[0.2em] border-b border-emerald-50">
                                <th class="px-8 py-6">Identificador de Suelo</th>
                                <th class="px-8 py-6">Compensación (Días)</th>
                                <th class="px-8 py-6 text-right">Gestión</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-emerald-50/50">
                            @forelse($tipoSuelos as $suelo)
                            <tr class="hover:bg-emerald-50/30 transition-all group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center text-amber-600 font-black">
                                            {{ substr($suelo->nombre, 0, 1) }}
                                        </div>
                                        <div>
                                            <span class="font-bold text-emerald-950 block">{{ $suelo->nombre }}</span>
                                            <span class="text-[10px] font-bold text-amber-500 uppercase italic">Base: {{ $suelo->catalogo->nombre ?? 'Manual' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="space-y-1">
                                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl {{ $suelo->impacto_dias >= 0 ? 'bg-red-50 text-red-600 border-red-100' : 'bg-green-50 text-green-600 border-green-100' }} border font-black text-sm">
                                            {{ $suelo->impacto_dias > 0 ? '+' : '' }}{{ $suelo->impacto_dias }}
                                            <span class="text-[10px] font-bold uppercase opacity-60">días</span>
                                        </div>
                                        @if($suelo->descripcion)
                                        <p class="text-xs text-emerald-400 italic max-w-[180px] truncate">{{ $suelo->descripcion }}</p>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-all translate-x-4 group-hover:translate-x-0">
                                        <button onclick='editSuelo(@json($suelo))' class="p-3 bg-amber-50 text-amber-600 rounded-2xl hover:bg-amber-100 transition-colors shadow-sm">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <form action="{{ route('tipo_suelos.destroy', $suelo->id_tipo_suelo) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" onclick="return confirm('¿Eliminar este suelo?')" class="p-3 bg-red-50 text-red-600 rounded-2xl hover:bg-red-100 transition-colors shadow-sm">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-8 py-24 text-center">
                                    <p class="text-emerald-300 font-bold italic">No hay suelos configurados. Utilice el buscador técnico.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const sueloSearch = document.getElementById('sueloSearch');
    const sueloResults = document.getElementById('sueloResults');
    const sueloForm = document.getElementById('sueloForm');
    const sueloPlaceholder = document.getElementById('sueloPlaceholder');

    let timer;

    sueloSearch.addEventListener('input', function() {
        clearTimeout(timer);
        const q = this.value.trim();

        if (q.length < 1) {
            sueloResults.classList.add('hidden');
            return;
        }

        timer = setTimeout(() => {
            fetch(`/tipo_suelos/catalog?q=${q}`)
                .then(res => res.json())
                .then(data => {
                    sueloResults.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(item => {
                            const div = document.createElement('div');
                            div.className = 'px-6 py-4 hover:bg-amber-50 cursor-pointer border-b border-amber-50 last:border-0 transition-colors';
                            div.innerHTML = `
                                <div class="flex justify-between items-center">
                                    <p class="font-black text-amber-950 text-sm">${item.nombre}</p>
                                    <span class="text-[10px] font-bold ${item.impacto_dias >= 0 ? 'text-red-500' : 'text-green-500'} uppercase">${item.impacto_dias > 0 ? '+' : ''}${item.impacto_dias} días</span>
                                </div>
                            `;
                            div.onclick = () => selectSuelo(item);
                            sueloResults.appendChild(div);
                        });
                        
                        // Add "Custom" option at the end
                        const customDiv = document.createElement('div');
                        customDiv.className = 'px-6 py-4 hover:bg-amber-50 cursor-pointer border-t border-amber-100 bg-amber-50/50 transition-colors';
                        customDiv.innerHTML = `
                            <div class="flex space-x-3 items-center text-amber-700">
                                <div class="bg-amber-200 text-amber-800 p-1.5 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                </div>
                                <span class="font-bold text-sm">Crear "${q}" como nuevo suelo</span>
                            </div>
                        `;
                        customDiv.onclick = () => selectCustomSuelo(q);
                        sueloResults.appendChild(customDiv);
                        
                        sueloResults.classList.remove('hidden');
                    } else {
                        sueloResults.innerHTML = `
                            <div class="px-6 py-4 hover:bg-amber-50 cursor-pointer transition-colors" onclick="selectCustomSuelo('${q}')">
                                <p class="text-xs text-gray-500 mb-2 italic">No se encontró en el catálogo global...</p>
                                <div class="flex space-x-3 items-center text-amber-700">
                                    <div class="bg-amber-200 text-amber-800 p-1.5 rounded-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                    </div>
                                    <span class="font-bold text-sm">Registrar "${q}" manualmente</span>
                                </div>
                            </div>
                        `;
                        sueloResults.classList.remove('hidden');
                    }
                });
        }, 300);
    });

    function selectCustomSuelo(nombre) {
        sueloResults.classList.add('hidden');
        sueloSearch.value = nombre;
        
        document.getElementById('sw_id_catalogo').value = '';
        document.getElementById('sw_nombre').value = nombre;
        document.getElementById('sw_descripcion').value = '';
        document.getElementById('sw_consumo_agua_ideal').value = '';
        
        document.getElementById('sw_impacto').value = '0';
        
        sueloPlaceholder.classList.add('hidden');
        sueloForm.classList.remove('hidden');
    }

    function selectSuelo(item) {
        sueloResults.classList.add('hidden');
        sueloSearch.value = item.nombre;

        document.getElementById('sw_id_catalogo').value = item.id;
        document.getElementById('sw_nombre').value = item.nombre;
        document.getElementById('sw_descripcion').value = item.descripcion || '';
        document.getElementById('sw_consumo_agua_ideal').value = item.consumo_agua_ideal || '';

        const impacto = parseInt(item.impacto_dias);
        document.getElementById('sw_impacto').value = impacto;

        sueloPlaceholder.classList.add('hidden');
        sueloForm.classList.remove('hidden');
    }

    function resetSueloForm() {
        sueloForm.classList.add('hidden');
        sueloPlaceholder.classList.remove('hidden');
        sueloSearch.value = '';
        sueloSearch.disabled = false;
        sueloForm.reset();

        // Restore to store mode
        sueloForm.action = "{{ route('tipo_suelos.store') }}";
        const methodInput = sueloForm.querySelector('input[name="_method"]');
        if (methodInput) methodInput.remove();
        document.getElementById('sw_consumo_agua_ideal').value = '';
        sueloForm.querySelector('button[type="submit"]').innerText = 'Habilitar Suelo';
    }

    function editSuelo(suelo) {
        // Show form
        sueloPlaceholder.classList.add('hidden');
        sueloForm.classList.remove('hidden');

        // Populate Form
        document.getElementById('sw_id_catalogo').value = suelo.id_catalogo;
        document.getElementById('sw_nombre').value = suelo.nombre;
        document.getElementById('sw_descripcion').value = suelo.descripcion || '';
        document.getElementById('sw_consumo_agua_ideal').value = suelo.consumo_agua_ideal || '';

        const impacto = parseInt(suelo.impacto_dias);
        document.getElementById('sw_impacto').value = impacto;
        
        sueloSearch.value = suelo.nombre;
        sueloSearch.disabled = true;

        // Adjust form for update mode
        sueloForm.action = `/tipo_suelos/${suelo.id_tipo_suelo}`;
        if (!sueloForm.querySelector('input[name="_method"]')) {
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PUT';
            sueloForm.appendChild(methodInput);
        }
        sueloForm.querySelector('button[type="submit"]').innerText = 'Actualizar Suelo';
    }

    document.addEventListener('click', function(e) {
        if (!sueloSearch.contains(e.target) && !sueloResults.contains(e.target)) {
            sueloResults.classList.add('hidden');
        }
    });
</script>
@endpush
@endsection