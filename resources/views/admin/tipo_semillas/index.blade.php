@extends('layouts.admin')

@section('title', 'Catálogo Pro de Semillas')

@section('content')
<div class="space-y-4">
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Advanced Search & Config Column -->
        <div class="xl:col-span-1">
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-emerald-50 dark:border-emerald-900/20 p-5 sticky top-6 transition-colors duration-300">
                <div class="flex items-center gap-3 mb-4">
                    <div class="bg-emerald-600 p-2.5 rounded-2xl text-white shadow-lg shadow-emerald-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-emerald-950">Configurar Semilla</h3>
                        <p class="text-[10px] font-bold text-emerald-500 uppercase tracking-widest mt-1">Catálogo Global v3.1</p>
                    </div>
                </div>

                <!-- AJAX Search Input -->
                <div class="relative group mb-4">
                    <div class="relative">
                        <input type="text" id="catalogSearch" autocomplete="off" placeholder="Buscar Variedad Técnica (Ej. Tomate, Café...)"
                            class="w-full pl-11 pr-4 py-3 rounded-2xl border-2 border-emerald-50 focus:border-emerald-500 focus:ring-0 bg-emerald-50/30 text-sm transition-all focus:bg-white text-emerald-950 font-medium">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-emerald-400 group-focus-within:text-emerald-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <!-- Dropdown Results -->
                        <div id="searchResults"
                            class="hidden absolute top-full left-0 right-0 mt-2 bg-white rounded-2xl shadow-2xl border border-emerald-50 z-50 max-h-64 overflow-y-auto overflow-x-hidden">
                        </div>
                    </div>
                </div>

                <!-- Chips Container -->
                <div id="chipsQueue" class="flex flex-wrap gap-2 mb-4"></div>

                <!-- Batch Action Form -->
                <form id="batchSaveForm" action="{{ route('tipo_semillas.store') }}" method="POST" class="hidden mb-4">
                    @csrf
                    <div id="batchItemsData"></div>
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black py-4 rounded-[1.5rem] shadow-xl shadow-emerald-100 transition-all flex items-center justify-center gap-2 transform active:scale-95">
                        Registrar Selección
                    </button>
                    <button type="button" onclick="clearQueue()" class="w-full mt-3 text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-red-500 transition-all">
                        Limpiar Selección
                    </button>
                </form>

                <!-- Manual Form (Card Design) -->
                <form id="seedForm" action="{{ route('tipo_semillas.store') }}" method="POST"
                    class="space-y-4 hidden animate-in zoom-in-95 duration-200">
                    @csrf
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">Variedad Individual</span>
                        <button type="button" onclick="resetForm()" class="text-gray-400 hover:text-red-500 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <input type="hidden" name="id_catalogo" id="input_id_catalogo">

                    <div class="space-y-3">
                        <!-- Name Card -->
                        <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100 flex flex-col items-start gap-1">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none">Nombre de Variedad</label>
                            <input type="text" name="nombre_semilla" id="sw_nombre" required
                                class="w-full text-lg font-black bg-transparent border-none focus:ring-0 p-0 text-gray-900 placeholder:text-gray-300"
                                placeholder="Ej. Maíz Amarillo">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <!-- Yield Card (Emerald) -->
                            <div class="bg-emerald-50/50 p-4 rounded-2xl border border-emerald-100 flex flex-col items-start gap-1">
                                <label class="text-[10px] font-black text-emerald-600 uppercase tracking-widest leading-none">Rendimiento (kg/m²)</label>
                                <input type="number" step="0.01" name="rendimiento_promedio" id="sw_rendimiento" required
                                    class="w-full text-2xl font-black bg-transparent border-none focus:ring-0 p-0 text-emerald-950 placeholder:text-emerald-200"
                                    placeholder="0.00">
                            </div>

                            <!-- Cycle Card (Amber) -->
                            <div class="bg-amber-50/50 p-4 rounded-2xl border border-amber-100 flex flex-col items-start gap-1">
                                <label class="text-[10px] font-black text-amber-600 uppercase tracking-widest leading-none">Ciclo (Días)</label>
                                <input type="number" name="tiempo_base_dias" id="sw_tiempo_base" required
                                    class="w-full text-2xl font-black bg-transparent border-none focus:ring-0 p-0 text-amber-950 placeholder:text-amber-200"
                                    placeholder="0">
                            </div>
                        </div>

                        <!-- Density Card (Blue) -->
                        <div class="bg-blue-50/50 p-4 rounded-2xl border border-blue-100 flex flex-col items-start gap-1">
                            <label class="text-[10px] font-black text-blue-600 uppercase tracking-widest leading-none">Densidad (m²/planta)</label>
                            <input type="number" step="0.0001" name="espacio_por_planta_m2" id="sw_espacio" required
                                class="w-full text-2xl font-black bg-transparent border-none focus:ring-0 p-0 text-blue-950 placeholder:text-blue-200"
                                placeholder="0.5000">
                        </div>

                        <div>
                            <label class="text-[10px] font-black text-emerald-700 uppercase tracking-widest mb-1.5 ml-1 block">Notas de Variedad</label>
                            <textarea name="descripcion" id="sw_descripcion" rows="2"
                                class="w-full px-4 py-3 rounded-2xl border-emerald-50 focus:border-emerald-500 focus:ring-emerald-500 bg-emerald-50/20 text-xs text-emerald-900"
                                placeholder="Detalle características de la semilla..."></textarea>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black py-4 rounded-[1.5rem] shadow-xl shadow-emerald-100 transition-all flex items-center justify-center gap-2">
                        Añadir al Inventario
                    </button>
                </form>

                <!-- Initial State -->
                <div id="formPlaceholder"
                    class="py-12 flex flex-col items-center justify-center text-center space-y-4 opacity-40">
                    <div class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <p class="text-[10px] font-black text-emerald-900 uppercase tracking-widest">Busque o proponga una variedad</p>
                </div>
            </div>
        </div>

        <!-- Inventory List Column -->
        <div class="xl:col-span-2">
            <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] shadow-xl border border-emerald-50 dark:border-emerald-900/20 overflow-hidden flex flex-col transition-colors duration-300">
                <div class="p-4 border-b border-emerald-50 dark:border-emerald-950/20 bg-gray-50/50 dark:bg-slate-900/30 flex justify-between items-center text-center">
                    <div>
                        <h3 class="text-base font-black text-emerald-950 dark:text-emerald-50">Inventario de Semillas</h3>
                        <p class="text-[11px] font-bold text-emerald-600 dark:text-emerald-500/50 mt-1">Variedades adaptadas a su finca</p>
                    </div>
                    <div class="bg-white dark:bg-slate-900 border-2 border-emerald-100 dark:border-emerald-900/20 px-4 py-1.5 rounded-2xl flex items-center gap-3">
                        <span class="text-xl font-black text-emerald-600 dark:text-emerald-400">{{ $tipoSemillas->total() }}</span>
                        <span
                            class="text-[9px] font-bold text-emerald-400 dark:text-emerald-600 uppercase tracking-widest leading-none">Especies<br>Activas</span>
                    </div>
                </div>
                <div class="flex-1 overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr
                                class="bg-white dark:bg-slate-800 text-[9px] font-black text-emerald-400 dark:text-emerald-600 uppercase tracking-[0.2em] border-b border-emerald-50 dark:border-emerald-950/30">
                                <th class="px-4 py-3">Especie y Variedad</th>
                                <th class="px-4 py-3">Parámetros</th>
                                <th class="px-4 py-3">Productividad</th>
                                <th class="px-4 py-3">Stock</th>
                                <th class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        Acciones
                                        <a href="{{ route('admin.proveedores.index') }}"
                                            class="p-1.5 bg-emerald-50 text-emerald-600 rounded-lg hover:bg-emerald-100 transition-all border border-emerald-100/50 group/prov"
                                            title="Ir a Proveedores">
                                            <svg class="w-4 h-4 group-hover/prov:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                                            </svg>
                                        </a>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-emerald-50/50 dark:divide-emerald-950/20">
                            @forelse($tipoSemillas as $semilla)
                            <tr class="hover:bg-emerald-50/30 dark:hover:bg-emerald-500/5 transition-all group">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-emerald-600 rounded-2xl flex items-center justify-center text-white font-black text-sm shadow-lg shadow-emerald-100 dark:shadow-emerald-950/50 group-hover:rotate-12 transition-transform">
                                            {{ substr($semilla->nombre_semilla, 0, 1) }}
                                        </div>
                                        <div>
                                            <span class="font-black text-emerald-950 dark:text-slate-200 block text-xs">{{ $semilla->nombre_semilla }}</span>
                                            <span class="text-[9px] font-bold text-emerald-400 dark:text-emerald-500 uppercase tracking-wider italic opacity-60 dark:opacity-100 transition-all">Catálogo: {{ $semilla->catalogo->nombre ?? 'Manual' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="space-y-0.5">
                                        @if($semilla->tiempo_base_dias != 0)
                                        <div class="flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            <span class="text-[11px] font-bold text-emerald-900 dark:text-emerald-400">{{ $semilla->tiempo_base_dias }}
                                                <span class="text-[9px] font-normal text-emerald-500 dark:text-emerald-600 uppercase tracking-tighter">días ciclo</span></span>
                                        </div>
                                        @endif
                                        <p class="text-[9px] font-bold text-blue-500 dark:text-emerald-600 flex flex-col gap-0.5">
                                            <span>{{ number_format($semilla->espacio_por_planta_m2, 4) }} m²/pl</span>
                                        </p>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="bg-emerald-50 dark:bg-emerald-950/20 rounded-lg px-2.5 py-1 border border-emerald-100 dark:border-emerald-900/20 inline-block">
                                        <span class="text-[10px] font-black text-emerald-700 dark:text-emerald-400">{{ $semilla->rendimiento_promedio }}
                                            <span class="text-[8px] font-bold">kg/m²</span></span>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-1.5">
                                        <span class="text-sm font-black text-emerald-950 dark:text-slate-100">{{ number_format($semilla->stock_actual ?? 0, 0) }}</span>
                                        @if(($semilla->stock_actual ?? 0) <= 0)
                                            <span class="px-1.5 py-0.5 bg-red-50 dark:bg-red-950/20 text-red-600 dark:text-red-400 text-[8px] font-black rounded-md uppercase tracking-tighter border border-red-100 dark:border-red-900/20">Sin Stock</span>
                                            @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-1.5 opacity-0 group-hover:opacity-100 transition-all">
                                        <button onclick='editSemilla(@json($semilla))' class="p-2 bg-amber-50 dark:bg-amber-950/20 text-amber-600 dark:text-amber-400 rounded-xl hover:bg-amber-100 dark:hover:bg-amber-900/30 transition-all">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <form action="{{ route('tipo_semillas.destroy', $semilla->id_semilla) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" onclick="return confirm('¿Eliminar variedad?')" class="p-2 bg-red-50 dark:bg-red-950/20 text-red-600 dark:text-red-400 rounded-xl hover:bg-red-100 dark:hover:bg-red-900/30 transition-all">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-8 py-16 text-center text-emerald-300 italic font-black text-xs">Inventario vacío. Busque variedades por catálogo.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 bg-gray-50/50 dark:bg-slate-900/30 border-t border-emerald-50 dark:border-emerald-950/20">
                    {{ $tipoSemillas->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const searchInput = document.getElementById('catalogSearch');
    const searchResults = document.getElementById('searchResults');
    const seedForm = document.getElementById('seedForm');
    const batchForm = document.getElementById('batchSaveForm');
    const placeholder = document.getElementById('formPlaceholder');
    const chipsQueue = document.getElementById('chipsQueue');
    const batchItemsData = document.getElementById('batchItemsData');

    const registeredIds = @json($registeredIds);

    let selectedSeeds = [];
    let debounceTimer;

    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        const query = this.value.trim();
        if (query.length < 2) {
            searchResults.classList.add('hidden');
            return;
        }

        debounceTimer = setTimeout(() => {
            fetch(`/tipo_semillas/catalog?q=${query}`)
                .then(res => res.json())
                .then(data => {
                    searchResults.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(item => {
                            const isAlreadyRegistered = registeredIds.includes(parseInt(item.id));
                            const div = document.createElement('div');
                            div.className = `px-5 py-3 border-b border-emerald-50 last:border-0 transition-colors ${isAlreadyRegistered ? 'bg-gray-50 opacity-50 cursor-not-allowed' : 'hover:bg-emerald-50 cursor-pointer'}`;
                            div.innerHTML = `
                                        <div class="flex justify-between items-center transition-colors">
                                            <div>
                                                <p class="font-black text-emerald-950 text-sm leading-tight">${item.nombre}</p>
                                                <p class="text-[9px] font-bold text-emerald-500 uppercase tracking-widest leading-none mt-1">
                                                    ${isAlreadyRegistered ? 'En Inventario' : `
                                                        ${item.tiempo_base_dias != 0 ? `${item.tiempo_base_dias}d ciclo • ` : ''}${parseFloat(item.rendimiento_promedio).toFixed(2)} kg/m²
                                                    `}
                                                </p>
                                            </div>
                                            <svg class="w-4 h-4 text-emerald-300 dark:text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                        </div>
                                    `;
                            if (!isAlreadyRegistered) div.onclick = () => addToQueue(item);
                            searchResults.appendChild(div);
                        });

                        const manualDiv = document.createElement('div');
                        manualDiv.className = 'px-5 py-4 bg-emerald-50/30 hover:bg-emerald-50 cursor-pointer transition-colors border-t border-emerald-50';
                        manualDiv.innerHTML = `
                                    <p class="text-[9px] font-black text-emerald-400 uppercase tracking-[0.2em] mb-3 leading-none tracking-widest">Variedad no en catálogo...</p>
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-emerald-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-emerald-100">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                        </div>
                                        <span class="text-xs font-black text-emerald-600 uppercase tracking-widest leading-none">Registrar "${query}" manualmente</span>
                                    </div>
                                `;
                        manualDiv.onclick = () => showManualForm(query);
                        searchResults.appendChild(manualDiv);

                        searchResults.classList.remove('hidden');
                    } else {
                        searchResults.innerHTML = `
                                    <div class="px-5 py-4 hover:bg-emerald-50 cursor-pointer transition-colors bg-emerald-50/20" onclick="showManualForm('${query}')">
                                        <p class="text-[9px] font-black text-emerald-400 uppercase tracking-[0.2em] mb-3 leading-none tracking-widest">Variedad no encontrada...</p>
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 bg-emerald-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-emerald-100">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                            </div>
                                            <span class="text-xs font-black text-emerald-600 uppercase tracking-widest">Crear "${query}" manualmente</span>
                                        </div>
                                    </div>
                                `;
                        searchResults.classList.remove('hidden');
                    }
                });
        }, 300);
    });

    function addToQueue(item) {
        searchResults.classList.add('hidden');
        searchInput.value = '';
        if (selectedSeeds.find(s => s.id_catalogo === item.id)) return;

        selectedSeeds.push({
            id_catalogo: item.id,
            nombre_semilla: item.nombre,
            descripcion: item.descripcion || '',
            tiempo_base_dias: item.tiempo_base_dias,
            rendimiento_promedio: item.rendimiento_promedio,
            espacio_por_planta_m2: item.espacio_por_planta_m2 || 0.5
        });
        renderQueue();
    }

    function renderQueue() {
        chipsQueue.innerHTML = '';
        placeholder.classList.add('hidden');
        seedForm.classList.add('hidden');

        if (selectedSeeds.length === 0) {
            placeholder.classList.remove('hidden');
            batchForm.classList.add('hidden');
            return;
        }

        batchForm.classList.remove('hidden');
        batchItemsData.innerHTML = '';

        selectedSeeds.forEach((seed, index) => {
            const chip = document.createElement('div');
            chip.className = 'flex items-center gap-2 bg-emerald-600 text-white pl-4 pr-3 py-3 rounded-2xl shadow-lg shadow-emerald-100 animate-in zoom-in-95 duration-200';
            chip.innerHTML = `
                        <div class="mr-1">
                            <p class="text-[10px] font-black uppercase text-white leading-none">${seed.nombre_semilla}</p>
                            <p class="text-[8px] font-bold text-emerald-200 uppercase tracking-tighter mt-1">${seed.tiempo_base_dias}d • ${seed.rendimiento_promedio}kg</p>
                        </div>
                        <button onclick="removeFromQueue(${index})" class="p-1 hover:bg-white/20 rounded-lg"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
                    `;
            chipsQueue.appendChild(chip);

            batchItemsData.innerHTML += `
                        <input type="hidden" name="items[${index}][id_catalogo]" value="${seed.id_catalogo}">
                        <input type="hidden" name="items[${index}][nombre_semilla]" value="${seed.nombre_semilla}">
                        <input type="hidden" name="items[${index}][descripcion]" value="${seed.descripcion}">
                        <input type="hidden" name="items[${index}][tiempo_base_dias]" value="${seed.tiempo_base_dias}">
                        <input type="hidden" name="items[${index}][rendimiento_promedio]" value="${seed.rendimiento_promedio}">
                        <input type="hidden" name="items[${index}][espacio_por_planta_m2]" value="${seed.espacio_por_planta_m2}">
                    `;
        });
    }

    function removeFromQueue(index) {
        selectedSeeds.splice(index, 1);
        renderQueue();
    }

    function clearQueue() {
        selectedSeeds = [];
        renderQueue();
    }

    function showManualForm(name) {
        clearQueue();
        searchResults.classList.add('hidden');
        searchInput.value = '';
        placeholder.classList.add('hidden');
        seedForm.classList.remove('hidden');

        document.getElementById('input_id_catalogo').value = '';
        document.getElementById('sw_nombre').value = name;
        document.getElementById('sw_rendimiento').value = '0.00';
        document.getElementById('sw_tiempo_base').value = '0';
        document.getElementById('sw_espacio').value = '0.5000';
        document.getElementById('sw_descripcion').value = '';
    }

    function resetForm() {
        seedForm.classList.add('hidden');
        placeholder.classList.remove('hidden');
        seedForm.reset();
        seedForm.action = "{{ route('tipo_semillas.store') }}";
        const mi = seedForm.querySelector('input[name="_method"]');
        if (mi) mi.remove();
    }

    function editSemilla(semilla) {
        clearQueue();
        placeholder.classList.add('hidden');
        seedForm.classList.remove('hidden');

        document.getElementById('input_id_catalogo').value = semilla.id_catalogo;
        document.getElementById('sw_nombre').value = semilla.nombre_semilla;
        document.getElementById('sw_rendimiento').value = semilla.rendimiento_promedio;
        document.getElementById('sw_tiempo_base').value = semilla.tiempo_base_dias;
        document.getElementById('sw_espacio').value = semilla.espacio_por_planta_m2;
        document.getElementById('sw_descripcion').value = semilla.descripcion || '';

        seedForm.action = `/tipo_semillas/${semilla.id_semilla}`;
        if (!seedForm.querySelector('input[name="_method"]')) {
            const mi = document.createElement('input');
            mi.type = 'hidden';
            mi.name = '_method';
            mi.value = 'PUT';
            seedForm.appendChild(mi);
        }
    }

    document.addEventListener('click', (e) => {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.classList.add('hidden');
        }
    });
</script>
@endpush
@endsection