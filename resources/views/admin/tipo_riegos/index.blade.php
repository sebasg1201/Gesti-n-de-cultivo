@extends('layouts.admin')

@section('title', 'Catálogo de Riegos Pro v5')

@section('content')
<div class="space-y-4">


    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Search & Config Column -->
        <div class="xl:col-span-1">
            <div class="bg-white rounded-3xl shadow-xl border border-blue-50 p-5 sticky top-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="bg-blue-600 p-2.5 rounded-2xl text-white shadow-lg shadow-blue-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-emerald-950">Configurar Riego</h3>
                        <p class="text-[10px] font-bold text-blue-500 uppercase tracking-widest mt-0.5">Control de Impacto v5.0</p>
                    </div>
                </div>

                <!-- AJAX Search -->
                <div class="relative group mb-4">
                    <label class="block text-xs font-bold text-emerald-700 uppercase tracking-wider mb-2">Buscar sistema técnico</label>
                    <div class="relative">
                        <input type="text" id="riegoSearch" autocomplete="off"
                            placeholder="Ej. Goteo, Aspersión..."
                            class="w-full pl-11 pr-4 py-3 rounded-2xl border-2 border-blue-50 focus:border-blue-500 focus:ring-0 bg-blue-50/20 text-sm transition-all focus:bg-white">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-blue-400 group-focus-within:text-blue-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <div id="riegoResults" class="hidden absolute top-full left-0 right-0 mt-2 bg-white rounded-2xl shadow-2xl border border-blue-50 z-50 max-h-64 overflow-y-auto">
                            <!-- Injected Results -->
                        </div>
                    </div>
                </div>

                <!-- Draft Chips Container -->
                <div id="chipsContainer" class="flex flex-wrap gap-2 mb-4 animate-in fade-in duration-300">
                    <!-- Chips will be injected here -->
                </div>

                <!-- Batch Save Form -->
                <form id="batchSaveForm" action="{{ route('tipo_riegos.store') }}" method="POST" class="hidden mb-4">
                    @csrf
                    <div id="batchItemsData"></div>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-3xl shadow-xl shadow-blue-100 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Habilitar Seleccionados
                    </button>
                    <button type="button" onclick="clearDrafts()" class="w-full mt-3 text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-red-500 transition-colors">
                        Descartar Todo
                    </button>
                </form>

                <!-- Manual Form with New Card Layout -->
                <form id="riegoForm" action="{{ route('tipo_riegos.store') }}" method="POST" class="space-y-4 hidden animate-in zoom-in-95 duration-200">
                    @csrf
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] font-black text-blue-500 uppercase tracking-widest">Registrando Manualmente</span>
                        <button type="button" onclick="resetRiegoForm()" class="text-gray-400 hover:text-red-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <input type="hidden" name="id_catalogo" id="input_id_catalogo">

                    <!-- Custom Card Inputs (Following user screenshot design) -->
                    <div class="space-y-3">
                        <!-- Input for Name -->
                        <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100 flex flex-col items-start gap-1">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none">Nombre del Sistema</label>
                            <input type="text" name="tipo_riego" id="tipo_riego_name" required
                                class="w-full text-xl font-black bg-transparent border-none focus:ring-0 p-0 text-gray-900 placeholder:text-gray-200"
                                placeholder="Ej. Goteo Personalizado">
                        </div>

                        <!-- Input for Impact (Orange themed) -->
                        <div class="bg-amber-50/50 p-4 rounded-2xl border border-amber-100 flex flex-col items-start gap-1">
                            <label class="text-[10px] font-black text-amber-600 uppercase tracking-widest leading-none">Impacto (Días)</label>
                            <input type="number" name="impacto_dias" id="riego_impacto" required
                                class="w-full text-2xl font-black bg-transparent border-none focus:ring-0 p-0 text-amber-900 placeholder:text-amber-200"
                                placeholder="0">
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-3xl shadow-xl shadow-blue-100 transition-all mt-2">
                        Registrar Ahora
                    </button>
                </form>

                <div id="riegoPlaceholder" class="py-12 flex flex-col items-center justify-center text-center space-y-4 opacity-40">
                    <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center text-blue-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547" />
                        </svg>
                    </div>
                    <p class="text-xs font-bold text-blue-900/60 uppercase tracking-[0.1em]">Busque sistemas para registrarlos</p>
                </div>
            </div>
        </div>

        <!-- List Column -->
        <div class="xl:col-span-2">
            <div class="bg-white rounded-[2.5rem] shadow-xl border border-blue-50/50 overflow-hidden flex flex-col">
                <div class="px-6 py-5 border-b border-blue-50 bg-gray-50/30 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-black text-slate-800">Sistemas de Riego</h3>
                        <p class="text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-widest italic">Configuración Técnica de Empresa</p>
                    </div>
                </div>

                <div class="flex-1 overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-white text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-blue-50">
                                <th class="px-6 py-4">Tipo de Riego</th>
                                <th class="px-6 py-4 text-center">Impacto</th>
                                <th class="px-6 py-4 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-blue-50/50">
                            @forelse($tipoRiegos as $riego)
                            <tr class="hover:bg-blue-50/10 transition-all group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 bg-blue-600 text-white rounded-2xl flex items-center justify-center font-black shadow-lg shadow-blue-100 group-hover:scale-110 transition-transform">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517" />
                                            </svg>
                                        </div>
                                        <div>
                                            <span class="font-black text-slate-700 block text-sm">{{ $riego->tipo_riego }}</span>
                                            <span class="text-[9px] font-black text-blue-500 uppercase italic opacity-60 tracking-wider">Base: {{ $riego->catalogo->nombre ?? 'Manual' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-2xl {{ $riego->impacto_dias >= 0 ? 'bg-red-50 text-red-600 border-red-100' : 'bg-green-50 text-green-600 border-green-100' }} border font-black text-[10px]">
                                        {{ $riego->impacto_dias > 0 ? '+' : '' }}{{ $riego->impacto_dias }} días
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all">
                                        <button onclick='editRiego(@json($riego))' class="p-2.5 bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-100 shadow-sm transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <form action="{{ route('tipo_riegos.destroy', $riego->id_tipo_riego) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" onclick="return confirm('¿Eliminar este sistema?')" class="p-2.5 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 shadow-sm transition-all">
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
                                <td colspan="3" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center opacity-30">
                                        <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        <p class="text-sm font-black text-slate-400 mt-4 uppercase tracking-[0.2em]">Sin sistemas registrados</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 bg-gray-50/30 border-t border-blue-50">
                    {{ $tipoRiegos->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const searchInput = document.getElementById('riegoSearch');
    const searchResults = document.getElementById('riegoResults');
    const form = document.getElementById('riegoForm');
    const batchForm = document.getElementById('batchSaveForm');
    const placeholder = document.getElementById('riegoPlaceholder');
    const chipsContainer = document.getElementById('chipsContainer');
    const batchItemsData = document.getElementById('batchItemsData');

    // Load registered catalog IDs from the server to prevent duplicates
    const registeredCatalogIds = @json($registeredIds);

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
            fetch(`/tipo_riegos/catalog?q=${q}`)
                .then(res => res.json())
                .then(data => {
                    searchResults.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(item => {
                            const isAlreadyRegistered = registeredCatalogIds.includes(parseInt(item.id));
                            const div = document.createElement('div');
                            div.className = `px-4 py-3 border-b border-blue-50 last:border-0 transition-colors ${isAlreadyRegistered ? 'opacity-50 cursor-not-allowed bg-gray-50/50' : 'hover:bg-blue-50 cursor-pointer'}`;
                            div.innerHTML = `
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="font-black text-blue-950 text-sm">${item.nombre}</p>
                                        <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest">${isAlreadyRegistered ? 'Ya configurado en la empresa' : 'Sugerido por catálogo'}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="block text-[10px] font-black ${item.impacto_dias >= 0 ? 'text-red-500' : 'text-green-500'}">${item.impacto_dias > 0 ? '+' : ''}${item.impacto_dias} días</span>
                                    </div>
                                </div>
                            `;
                            if (!isAlreadyRegistered) {
                                div.onclick = () => addChip(item);
                            }
                            searchResults.appendChild(div);
                        });
                        
                        // Add "Custom" option
                        const customDiv = document.createElement('div');
                        customDiv.className = 'px-4 py-3 hover:bg-blue-50 cursor-pointer border-t border-blue-100 bg-blue-50/50 transition-colors';
                        customDiv.innerHTML = `
                            <div class="flex space-x-3 items-center text-blue-600">
                                <div class="bg-blue-100 p-1.5 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                </div>
                                <span class="font-black text-xs uppercase tracking-widest">Registrar "${q}" manualmente</span>
                            </div>
                        `;
                        customDiv.onclick = () => showManualForm(q);
                        searchResults.appendChild(customDiv);
                        
                        searchResults.classList.remove('hidden');
                    } else {
                        searchResults.innerHTML = `
                            <div class="px-4 py-3 hover:bg-blue-50 cursor-pointer transition-colors" onclick="showManualForm('${q}')">
                                <p class="text-[9px] text-gray-400 mb-2 italic uppercase font-bold tracking-widest">Técnica no encontrada...</p>
                                <div class="flex space-x-3 items-center text-blue-600">
                                    <div class="bg-blue-100 p-1.5 rounded-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                    </div>
                                    <span class="font-black text-xs uppercase tracking-widest">Registrar "${q}" manualmente</span>
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

        // Prevent duplicates in current draft
        if (selectedItems.find(i => i.id_catalogo === item.id)) return;

        selectedItems.push({
            id_catalogo: item.id,
            tipo_riego: item.nombre,
            impacto_dias: item.impacto_dias
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
            // Change color to Blue as requested by user
            chip.className = 'flex items-center gap-4 bg-blue-600 text-white pl-4 pr-3 py-3 rounded-[1.2rem] shadow-xl shadow-blue-100 animate-in zoom-in-90 duration-200';
            chip.innerHTML = `
                <div class="bg-blue-500/50 p-2 rounded-xl">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517" /></svg>
                </div>
                <div>
                    <p class="text-xs font-black uppercase tracking-wider leading-none mb-1">${item.tipo_riego}</p>
                    <p class="text-[9px] font-bold text-blue-100 uppercase tracking-widest leading-none">Base: ${item.id_catalogo ? 'Catálogo' : 'Manual'} • ${item.impacto_dias}d</p>
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
                <input type="hidden" name="items[${index}][tipo_riego]" value="${item.tipo_riego}">
                <input type="hidden" name="items[${index}][impacto_dias]" value="${item.impacto_dias}">
            `;
        });
    }

    function showManualForm(nombre) {
        searchResults.classList.add('hidden');
        searchInput.value = '';
        
        batchForm.classList.add('hidden');
        chipsContainer.innerHTML = '';
        selectedItems = [];

        document.getElementById('input_id_catalogo').value = '';
        document.getElementById('tipo_riego_name').value = nombre;
        document.getElementById('riego_impacto').value = '0';

        placeholder.classList.add('hidden');
        form.classList.remove('hidden');
    }

    function resetRiegoForm() {
        form.classList.add('hidden');
        renderChips();
        searchInput.value = '';
        form.reset();
        
        form.action = "{{ route('tipo_riegos.store') }}";
        const methodInput = form.querySelector('input[name="_method"]');
        if (methodInput) methodInput.remove();
        form.querySelector('button[type="submit"]').innerText = 'Registrar Ahora';
    }

    function editRiego(riego) {
        clearDrafts();
        placeholder.classList.add('hidden');
        form.classList.remove('hidden');

        document.getElementById('input_id_catalogo').value = riego.id_catalogo;
        document.getElementById('tipo_riego_name').value = riego.tipo_riego;
        document.getElementById('riego_impacto').value = riego.impacto_dias;
        
        form.action = `/tipo_riegos/${riego.id_tipo_riego}`;
        if (!form.querySelector('input[name="_method"]')) {
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PUT';
            form.appendChild(methodInput);
        }
        form.querySelector('button[type="submit"]').innerText = 'Actualizar Sistema';
    }

    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.classList.add('hidden');
        }
    });
</script>
@endpush
@endsection