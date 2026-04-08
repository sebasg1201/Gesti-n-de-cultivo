@extends('layouts.admin')

@section('title', 'Configuración de Suelos v3')

@section('content')
<div class="space-y-4">
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Search & Config Column -->
        <div class="xl:col-span-1">
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-amber-50 dark:border-amber-900/10 p-5 sticky top-6 transition-all duration-300">
                <div class="flex items-center gap-3 mb-4">
                    <div class="bg-amber-600 p-2.5 rounded-2xl text-white shadow-lg shadow-amber-100 dark:shadow-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-amber-950 dark:text-amber-50">Configurar Suelo</h3>
                        <p class="text-[10px] font-bold text-amber-500 uppercase tracking-widest mt-0.5">Control de Sustrato v3.1</p>
                    </div>
                </div>

                <!-- AJAX Search -->
                <div class="relative group mb-4">
                    <label class="block text-xs font-bold text-amber-700 dark:text-amber-400 uppercase tracking-wider mb-2">Buscar tipo de suelo técnico</label>
                    <div class="relative">
                        <input type="text" id="sueloSearch" autocomplete="off"
                            placeholder="Ej. Arcilloso, Arenoso, Limoso..."
                            class="w-full pl-11 pr-4 py-3 rounded-2xl border-2 border-amber-50 dark:border-amber-900/20 focus:border-amber-500 focus:ring-0 bg-amber-50/20 dark:bg-slate-900/40 text-sm transition-all focus:bg-white dark:focus:bg-slate-900 dark:text-amber-100">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-amber-400 group-focus-within:text-amber-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <div id="sueloResults" class="hidden absolute top-full left-0 right-0 mt-2 bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-amber-50 dark:border-amber-900/20 z-50 max-h-64 overflow-y-auto">
                            <!-- Injected via JS -->
                        </div>
                    </div>
                </div>

                <!-- Draft Chips Container -->
                <div id="chipsContainer" class="flex flex-wrap gap-2 mb-4"></div>

                <!-- Batch Save Form -->
                <form id="batchSaveForm" action="{{ route('tipo_suelos.store') }}" method="POST" class="hidden mb-4">
                    @csrf
                    <div id="batchItemsData"></div>
                    <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white font-black py-4 rounded-3xl shadow-xl shadow-amber-100 dark:shadow-none transition-all flex items-center justify-center gap-2">
                        Habilitar Seleccionados
                    </button>
                    <button type="button" onclick="clearDrafts()" class="w-full mt-3 text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest hover:text-red-500 transition-colors">
                        Descartar Todo
                    </button>
                </form>

                <!-- Manual Card-Based Form -->
                <form id="sueloForm" action="{{ route('tipo_suelos.store') }}" method="POST" class="space-y-3 hidden">
                    @csrf
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-[10px] font-black text-amber-600 uppercase tracking-widest leading-none">Registro Manual</span>
                        <button type="button" onclick="resetSueloForm()" class="text-gray-400 hover:text-red-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <input type="hidden" name="id_catalogo" id="sw_id_catalogo">
                    
                    <div class="space-y-3">
                        <!-- Name Card -->
                        <div class="bg-gray-50 dark:bg-slate-900/40 p-4 rounded-2xl border border-gray-100 dark:border-amber-900/10 flex flex-col items-start gap-1">
                            <label class="text-[10px] font-black text-gray-400 dark:text-amber-600 uppercase tracking-widest leading-none">Nombre del Suelo</label>
                            <input type="text" name="nombre" id="sw_nombre" required
                                class="w-full text-xl font-black bg-transparent border-none focus:ring-0 p-0 text-gray-900 dark:text-slate-100 placeholder:text-gray-200 dark:placeholder:text-slate-700"
                                placeholder="Ej. Tierra Negra Lote A">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <!-- Impact Card (Amber) -->
                            <div class="bg-amber-50/50 dark:bg-amber-900/10 p-4 rounded-2xl border border-amber-100 dark:border-amber-900/20 flex flex-col items-start gap-1">
                                <label class="text-[10px] font-black text-amber-600 uppercase tracking-widest leading-none">Impacto (Días)</label>
                                <input type="number" name="impacto_dias" id="sw_impacto" required
                                    class="w-full text-2xl font-black bg-transparent border-none focus:ring-0 p-0 text-amber-900 dark:text-amber-500 placeholder:text-amber-200 dark:placeholder:text-amber-900"
                                    placeholder="0">
                            </div>

                            <!-- Water Requirement Card (Blue) -->
                            <div class="bg-blue-50/50 dark:bg-blue-900/10 p-4 rounded-2xl border border-blue-100 dark:border-blue-900/20 flex flex-col items-start gap-1">
                                <label class="text-[10px] font-black text-blue-600 uppercase tracking-widest leading-none">Agua Necesaria (L/m²)</label>
                                <input type="number" step="0.01" name="capacidad_retencion_litros_m2" id="sw_agua" required
                                    class="w-full text-2xl font-black bg-transparent border-none focus:ring-0 p-0 text-blue-950 dark:text-blue-500 placeholder:text-blue-200 dark:placeholder:text-blue-900"
                                    placeholder="0.00">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-amber-700 dark:text-amber-600 uppercase tracking-widest mb-1.5 ml-1">Notas (Opcional)</label>
                            <textarea name="descripcion" id="sw_descripcion" rows="2"
                                class="w-full px-4 py-3 rounded-2xl border-amber-100 dark:border-amber-900/20 focus:border-amber-500 focus:ring-amber-500 bg-gray-50/30 dark:bg-slate-900/40 text-xs text-amber-900 dark:text-amber-400 placeholder:text-amber-200 dark:placeholder:text-slate-800"
                                placeholder="Especifique ubicación o calidad..."></textarea>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white font-black py-4 rounded-3xl shadow-xl shadow-amber-100 dark:shadow-none transition-all mt-2">
                        Habilitar Suelo
                    </button>
                </form>

                <div id="sueloPlaceholder" class="py-12 flex flex-col items-center justify-center text-center space-y-4 opacity-40">
                    <div class="w-20 h-20 bg-amber-50 dark:bg-slate-950/40 rounded-full flex items-center justify-center text-amber-300 dark:text-amber-900">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <p class="text-xs font-bold text-amber-900/60 dark:text-amber-700 uppercase tracking-[0.1em]">Busque suelos para configurarlos</p>
                </div>
            </div>
        </div>

        <!-- Suelos List Column -->
        <div class="xl:col-span-2">
            <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] shadow-xl border border-amber-50/50 dark:border-amber-900/20 overflow-hidden flex flex-col transition-colors duration-300">
                <div class="px-6 py-5 border-b border-amber-50 dark:border-amber-950/20 bg-gray-50/30 dark:bg-slate-900/30 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-black text-slate-800 dark:text-emerald-50">Suelos de la Empresa</h3>
                        <p class="text-[10px] font-bold text-slate-400 dark:text-emerald-500/50 mt-1 uppercase tracking-widest italic">Configuración técnica de terrenos</p>
                    </div>
                </div>

                <div class="flex-1 overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-white dark:bg-slate-800 text-[9px] font-black text-slate-400 dark:text-emerald-600 uppercase tracking-[0.2em] border-b border-amber-50 dark:border-amber-950/30">
                                <th class="px-6 py-4">Tipo de Suelo</th>
                                <th class="px-6 py-4 text-center">Impacto / Agua</th>
                                <th class="px-6 py-4 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-amber-50/50 dark:divide-amber-950/20">
                            @forelse($tipoSuelos as $suelo)
                            <tr class="hover:bg-amber-50/10 dark:hover:bg-amber-500/5 transition-all group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 bg-amber-600 text-white rounded-2xl flex items-center justify-center font-black shadow-lg shadow-amber-100 dark:shadow-amber-900/50 group-hover:scale-110 transition-transform">
                                            {{ substr($suelo->nombre, 0, 1) }}
                                        </div>
                                        <div>
                                            <span class="font-black text-slate-700 dark:text-slate-200 block text-sm leading-tight">{{ $suelo->nombre }}</span>
                                            <span class="text-[9px] font-black text-amber-500 uppercase italic opacity-60 dark:opacity-100 transition-all tracking-wider">Base: {{ $suelo->catalogo->nombre ?? 'Manual' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-2xl {{ $suelo->impacto_dias >= 0 ? 'bg-red-50 dark:bg-red-950/20 text-red-600 dark:text-red-400 border-red-100 dark:border-red-900/20' : 'bg-green-50 dark:bg-green-950/20 text-green-600 dark:text-green-400 border-green-100 dark:border-green-900/20' }} border font-black text-[10px]">
                                            {{ $suelo->impacto_dias > 0 ? '+' : '' }}{{ $suelo->impacto_dias }} días
                                        </div>
                                        <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-2xl bg-blue-50 dark:bg-blue-950/20 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-900/20 font-black text-[10px]">
                                            {{ number_format($suelo->capacidad_retencion_litros_m2, 2) }} L/m²
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all">
                                        <button onclick='editSuelo(@json($suelo))' class="p-2.5 bg-amber-50 dark:bg-amber-950/20 text-amber-600 dark:text-amber-400 rounded-xl hover:bg-amber-100 dark:hover:bg-amber-900/30 shadow-sm transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <form action="{{ route('tipo_suelos.destroy', $suelo->id_tipo_suelo) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" onclick="return confirm('¿Eliminar este suelo?')" class="p-2.5 bg-red-50 dark:bg-red-950/20 text-red-600 dark:text-red-400 rounded-xl hover:bg-red-100 dark:hover:bg-red-900/30 shadow-sm transition-all">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-8 py-20 text-center text-slate-300 italic font-bold">No hay suelos registrados.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 bg-gray-50/30 dark:bg-slate-900/30 border-t border-amber-50 dark:border-amber-950/20">
                    {{ $tipoSuelos->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const searchInput = document.getElementById('sueloSearch');
    const searchResults = document.getElementById('sueloResults');
    const form = document.getElementById('sueloForm');
    const batchForm = document.getElementById('batchSaveForm');
    const placeholder = document.getElementById('sueloPlaceholder');
    const chipsContainer = document.getElementById('chipsContainer');
    const batchItemsData = document.getElementById('batchItemsData');

    const registeredIds = @json($registeredIds);

    let selectedItems = [];
    let timer;

    searchInput.addEventListener('input', function() {
        clearTimeout(timer);
        const q = this.value.trim();
        if (q.length < 1) {
            searchResults.classList.add('hidden');
            return;
        }

        timer = setTimeout(() => {
            fetch(`${window.APP_URL}/tipo_suelos/catalog?q=${q}`)
                .then(res => res.json())
                .then(data => {
                    searchResults.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(item => {
                            const isAlreadyRegistered = registeredIds.includes(parseInt(item.id));
                            const div = document.createElement('div');
                            div.className = `px-4 py-3 border-b border-amber-50 last:border-0 transition-colors ${isAlreadyRegistered ? 'opacity-50 cursor-not-allowed bg-gray-50/50' : 'hover:bg-amber-50 cursor-pointer'}`;
                            div.innerHTML = `
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="font-black text-amber-950 text-sm">${item.nombre}</p>
                                        <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest">${isAlreadyRegistered ? 'Ya configurado' : 'Sugerido por catálogo'}</p>
                                    </div>
                                    <div class="text-right">
                                        ${item.impacto_dias != 0 ? `
                                            <span class="block text-[10px] font-black ${item.impacto_dias > 0 ? 'text-amber-500' : 'text-emerald-500'}">${item.impacto_dias > 0 ? '+' : ''}${item.impacto_dias} días</span>
                                        ` : ''}
                                        <span class="block text-[10px] font-black text-blue-500">${item.capacidad_retencion_litros_m2 || '0.00'} L/m²</span>
                                    </div>
                                </div>
                            `;
                            if (!isAlreadyRegistered) div.onclick = () => addChip(item);
                            searchResults.appendChild(div);
                        });
                        
                        // Add Manual Option
                        const customDiv = document.createElement('div');
                        customDiv.className = 'px-5 py-4 bg-amber-50/30 hover:bg-amber-50 cursor-pointer transition-colors border-t border-amber-50';
                        customDiv.innerHTML = `
                            <p class="text-[9px] font-black text-amber-500 uppercase tracking-[0.2em] mb-3 leading-none tracking-widest">Suelo no en catálogo...</p>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-amber-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-amber-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                </div>
                                <span class="text-xs font-black text-amber-600 uppercase tracking-widest leading-none text-amber-700">Registrar "${q}" manualmente</span>
                            </div>
                        `;
                        customDiv.onclick = () => showManualForm(q);
                        searchResults.appendChild(customDiv);
                        
                        searchResults.classList.remove('hidden');
                    } else {
                        searchResults.innerHTML = `
                            <div class="px-5 py-4 hover:bg-amber-50 cursor-pointer transition-colors bg-amber-50/20" onclick="showManualForm('${q}')">
                                <p class="text-[9px] font-black text-amber-500 uppercase tracking-[0.2em] mb-3 leading-none tracking-widest">Técnica no encontrada...</p>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-amber-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-amber-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                    </div>
                                    <span class="text-xs font-black text-amber-600 uppercase tracking-widest text-amber-700">Crear "${q}" manualmente</span>
                                </div>
                            </div>
                        `;
                        searchResults.classList.remove('hidden');
                    }
                });
        }, 300);
    });

    function addChip(item) {
        searchResults.classList.add('hidden');
        searchInput.value = '';

        if (selectedItems.find(i => i.id_catalogo === item.id)) return;

        selectedItems.push({
            id_catalogo: item.id,
            nombre: item.nombre,
            descripcion: item.descripcion || '',
            impacto_dias: item.impacto_dias,
            capacidad_retencion_litros_m2: item.capacidad_retencion_litros_m2 || 0
        });

        renderChips();
        updateBatchForm();
    }

    function renderChips() {
        chipsContainer.innerHTML = '';
        placeholder.classList.add('hidden');
        form.classList.add('hidden');
        
        if (selectedItems.length === 0) {
            placeholder.classList.remove('hidden');
            batchForm.classList.add('hidden');
            return;
        }

        batchForm.classList.remove('hidden');

        selectedItems.forEach((item, index) => {
            const chip = document.createElement('div');
            chip.className = 'flex items-center gap-4 bg-amber-600 text-white pl-4 pr-3 py-3 rounded-[1.2rem] shadow-xl shadow-amber-100 animate-in zoom-in-90 duration-200';
            chip.innerHTML = `
                <div class="bg-amber-500/50 p-2 rounded-xl">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9" /></svg>
                </div>
                <div>
                    <p class="text-xs font-black uppercase tracking-wider leading-none mb-1 text-white">${item.nombre}</p>
                    <p class="text-[9px] font-bold text-amber-100 uppercase tracking-widest leading-none">Catalog • ${item.impacto_dias}d • ${item.capacidad_retencion_litros_m2}L</p>
                </div>
                <button onclick="removeChip(${index})" class="ml-2 w-6 h-6 flex items-center justify-center hover:bg-white/20 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            `;
            chipsContainer.appendChild(chip);
        });
    }

    function removeChip(index) {
        selectedItems.splice(index, 1);
        renderChips();
        updateBatchForm();
    }

    function clearDrafts() {
        selectedItems = [];
        renderChips();
        updateBatchForm();
    }

    function updateBatchForm() {
        batchItemsData.innerHTML = '';
        selectedItems.forEach((item, index) => {
            batchItemsData.innerHTML += `
                <input type="hidden" name="items[${index}][id_catalogo]" value="${item.id_catalogo || ''}">
                <input type="hidden" name="items[${index}][nombre]" value="${item.nombre}">
                <input type="hidden" name="items[${index}][descripcion]" value="${item.descripcion}">
                <input type="hidden" name="items[${index}][impacto_dias]" value="${item.impacto_dias}">
                <input type="hidden" name="items[${index}][capacidad_retencion_litros_m2]" value="${item.capacidad_retencion_litros_m2}">
            `;
        });
    }

    function showManualForm(nombre) {
        searchResults.classList.add('hidden');
        searchInput.value = '';
        clearDrafts();

        document.getElementById('sw_id_catalogo').value = '';
        document.getElementById('sw_nombre').value = nombre;
        document.getElementById('sw_impacto').value = '0';
        document.getElementById('sw_agua').value = '0.00';
        document.getElementById('sw_descripcion').value = '';

        placeholder.classList.add('hidden');
        form.classList.remove('hidden');
    }

    function resetSueloForm() {
        form.classList.add('hidden');
        placeholder.classList.remove('hidden');
        searchInput.value = '';
        form.reset();
        
        form.action = "{{ route('tipo_suelos.store') }}";
        const methodInput = form.querySelector('input[name="_method"]');
        if (methodInput) methodInput.remove();
        form.querySelector('button[type="submit"]').innerText = 'Habilitar Suelo';
    }

    function editSuelo(suelo) {
        clearDrafts();
        placeholder.classList.add('hidden');
        form.classList.remove('hidden');

        document.getElementById('sw_id_catalogo').value = suelo.id_catalogo;
        document.getElementById('sw_nombre').value = suelo.nombre;
        document.getElementById('sw_impacto').value = suelo.impacto_dias;
        document.getElementById('sw_agua').value = suelo.capacidad_retencion_litros_m2;
        document.getElementById('sw_descripcion').value = suelo.descripcion || '';

        form.action = `/tipo_suelos/${suelo.id_tipo_suelo}`;
        if (!form.querySelector('input[name="_method"]')) {
            const mi = document.createElement('input');
            mi.type = 'hidden'; mi.name = '_method'; mi.value = 'PUT';
            form.appendChild(mi);
        }
        form.querySelector('button[type="submit"]').innerText = 'Actualizar Suelo';
    }

    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.classList.add('hidden');
        }
    });
</script>
@endpush
@endsection