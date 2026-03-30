@extends('layouts.admin')

@section('title', 'Inventario de Suministros')

@section('content')
    <div class="space-y-4">
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <!-- Advanced Search & Config Column -->
            <div class="xl:col-span-1">
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-emerald-50 dark:border-emerald-900/20 p-5 sticky top-6 transition-all duration-300">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="bg-emerald-600 p-2.5 rounded-2xl text-white shadow-lg shadow-emerald-100 dark:shadow-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-emerald-950">Agregar Insumo</h3>
                            <p class="text-[10px] font-bold text-emerald-500 uppercase tracking-widest mt-1">Control de Stock v3.2</p>
                        </div>
                    </div>

                    <!-- AJAX Search Input -->
                    <div class="relative group mb-4">
                        <div class="relative">
                            <input type="text" id="catalogSearch" autocomplete="off" placeholder="Buscar en Catálogo Global..."
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
                    <form id="batchSaveForm" action="{{ route('insumos.store') }}" method="POST" class="hidden mb-4">
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
                    <form id="seedForm" action="{{ route('insumos.store') }}" method="POST"
                        class="space-y-4 hidden animate-in zoom-in-95 duration-200">
                        @csrf
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">Entrada Individual</span>
                            <button type="button" onclick="resetForm()" class="text-gray-400 hover:text-red-500 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                        
                        <input type="hidden" name="id_catalogo_insumo" id="input_id_catalogo_insumo">

                        <div class="space-y-3">
                            <!-- Name Card -->
                            <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100 flex flex-col items-start gap-1">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none">Nombre Producto</label>
                                <input type="text" name="nombre" id="nombre" required
                                    class="w-full text-lg font-black bg-transparent border-none focus:ring-0 p-0 text-gray-900 placeholder:text-gray-300"
                                    placeholder="Ej. Abono Orgánico Premium">
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <!-- Impact Card (Blue) -->
                                <div class="bg-blue-50/50 p-4 rounded-2xl border border-blue-100 flex flex-col items-start gap-1 text-left">
                                    <label class="text-[10px] font-black text-blue-600 uppercase tracking-widest leading-none">Impacto (Días)</label>
                                    <input type="number" name="impacto_dias" id="impacto_dias" required
                                        class="w-full text-2xl font-black bg-transparent border-none focus:ring-0 p-0 text-blue-950 placeholder:text-blue-200"
                                        placeholder="0">
                                </div>

                                <!-- Stock Info Card (Gray) -->
                                <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100 flex flex-col items-start gap-1 opacity-60">
                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none">Stock Inicial</label>
                                    <div class="w-full text-2xl font-black text-gray-400">0 <span class="text-[10px] font-bold">Unid</span></div>
                                </div>
                            </div>

                            <!-- Category Selector (Gray) -->
                            <div class="bg-gray-50/50 p-4 rounded-2xl border border-gray-100 flex flex-col items-start gap-1">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none">Categoría de Insumo</label>
                                <select name="categoria_manual" id="categoria_manual" class="w-full font-bold text-gray-800 bg-transparent border-none focus:ring-0 p-0 text-sm cursor-pointer">
                                    <option value="" disabled selected>Seleccione...</option>
                                    @foreach($tiposInsumo as $tipo)
                                        <option value="{{ $tipo->id_tipo_insumo }}">{{ $tipo->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="text-[10px] font-black text-emerald-700 uppercase tracking-widest mb-1.5 ml-1 block">Descripción del Producto</label>
                                <textarea name="descripcion" id="descripcion" rows="2"
                                    class="w-full px-4 py-3 rounded-2xl border-emerald-50 focus:border-emerald-500 focus:ring-emerald-500 bg-emerald-50/20 text-xs text-emerald-900"
                                    placeholder="Detalle el uso preferente, dosis base o advertencias..."></textarea>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black py-4 rounded-[1.5rem] shadow-xl shadow-emerald-100 transition-all flex items-center justify-center gap-2">
                            Añadir a Inventario
                        </button>
                    </form>

                    <!-- Initial State -->
                    <div id="formPlaceholder"
                        class="py-12 flex flex-col items-center justify-center text-center space-y-4 opacity-40">
                        <div class="w-20 h-20 bg-emerald-50 dark:bg-slate-900 rounded-full flex items-center justify-center text-emerald-300 dark:text-emerald-900 transition-colors">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <p class="text-[10px] font-bold text-emerald-950 uppercase tracking-widest">Catálogo Pro de Suministros</p>
                    </div>
                </div>
            </div>

            <!-- Inventory List Column -->
            <div class="xl:col-span-2">
                <div class="bg-white rounded-[2.5rem] shadow-xl border border-emerald-50 overflow-hidden flex flex-col">
                    <div class="p-6 border-b border-emerald-50 bg-gray-50/30 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div>
                            <h3 class="text-lg font-black text-emerald-950">Inventario de Suministros</h3>
                            <p class="text-[11px] font-bold text-emerald-600 mt-1 uppercase tracking-tighter">Gestión integral de stock y rendimientos</p>
                        </div>
                        <div class="flex flex-wrap items-center gap-3">
                            <form action="{{ route('insumos.index') }}" method="GET" class="flex items-center gap-2 bg-white p-1 rounded-2xl border border-emerald-100 shadow-sm">
                                <select name="month" class="bg-transparent border-0 text-[10px] font-bold text-emerald-700 focus:ring-0 cursor-pointer">
                                    <option value="">Mes...</option>
                                    @php $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']; @endphp
                                    @foreach($meses as $index => $mes)
                                        <option value="{{ $index + 1 }}" {{ request('month') == ($index + 1) ? 'selected' : '' }}>{{ $mes }}</option>
                                    @endforeach
                                </select>
                                <select name="year" class="bg-transparent border-0 text-[10px] font-bold text-emerald-700 dark:text-emerald-400 focus:ring-0 cursor-pointer">
                                    <option value="">Año...</option>
                                    @for($y = date('Y'); $y >= 2024; $y--)
                                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                                <button type="submit" class="p-1.5 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-xl hover:bg-emerald-100 dark:hover:bg-emerald-800 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                </button>
                            </form>
                            
                            <a href="{{ route('admin.insumos.export', request()->all()) }}" class="flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl text-[10px] font-black shadow-lg shadow-emerald-100 transition-all mb-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                EXPORTAR
                            </a>

                            <div class="bg-white border-2 border-emerald-100 px-4 py-1.5 rounded-2xl flex items-center gap-3">
                                <span class="text-xl font-black text-emerald-600">{{ $insumos->total() }}</span>
                                <span class="text-[9px] font-bold text-emerald-400 uppercase tracking-widest leading-none">Global<br>Items</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex-1 overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-white text-[9px] font-black text-emerald-400 uppercase tracking-[0.2em] border-b border-emerald-50">
                                    <th class="px-6 py-4">Suministro / Catálogo</th>
                                    <th class="px-6 py-4 text-center">Categoría</th>
                                    <th class="px-6 py-4 text-center">Stock Disponible</th>
                                    <th class="px-6 py-4 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-emerald-50/50 dark:divide-emerald-900/10">
                                @forelse($insumos as $insumo)
                                    <tr class="hover:bg-emerald-50/30 transition-all group">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-4">
                                                <div class="w-10 h-10 bg-emerald-600 rounded-2xl flex items-center justify-center text-white font-black text-sm shadow-lg shadow-emerald-100 group-hover:rotate-12 transition-transform">
                                                    {{ substr($insumo->Nombre, 0, 1) }}
                                                </div>
                                                <div>
                                                    <span class="font-black text-emerald-950 block text-xs leading-tight">{{ $insumo->Nombre }}</span>
                                                    <span class="text-[9px] font-bold text-emerald-400 uppercase tracking-wider italic opacity-60">CAT: {{ $insumo->catalogo->nombre_comercial ?? 'PROPIO' }}</span>
                                                    @if($insumo->impacto_dias != 0)
                                                        @php $isNeg = $insumo->impacto_dias < 0; @endphp
                                                        <div class="mt-1.5 flex items-center gap-1.5 px-2 py-0.5 {{ $isNeg ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : 'bg-amber-50 text-amber-700 border-amber-100' }} border rounded-lg w-fit transition-colors shadow-sm">
                                                            <span class="w-1.5 h-1.5 rounded-full {{ $isNeg ? 'bg-emerald-500' : 'bg-amber-500' }} animate-pulse"></span>
                                                            <span class="text-[8px] font-black uppercase tracking-widest">{{ $insumo->impacto_dias > 0 ? '+' : '' }}{{ $insumo->impacto_dias }} DÍAS IMPACTO</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="bg-white text-emerald-600 text-[10px] font-black px-3 py-1 rounded-xl border-2 border-emerald-50 shadow-sm uppercase tracking-tighter">
                                                {{ $insumo->catalogo->tipoInsumo->nombre ?? ($tiposInsumo->find($insumo->id_tipo_insumo)->nombre ?? 'GENERAL') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex flex-col gap-0.5 items-center">
                                                <div class="flex items-center gap-2">
                                                    <span class="text-xl font-black text-emerald-950">{{ number_format($insumo->stock_actual ?? 0, 0) }}</span>
                                                    @if(($insumo->stock_actual ?? 0) <= 0)
                                                        <span class="px-2 py-0.5 bg-red-50 text-red-600 text-[8px] font-black rounded-md uppercase border border-red-100 animate-pulse tracking-widest">SIN STOCK</span>
                                                    @else
                                                        <span class="text-[9px] font-black text-emerald-400 uppercase">Unid</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all">
                                                <button onclick='editInsumo(@json($insumo))' class="p-2.5 bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-100 transition-all">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </button>
                                                <form action="{{ route('insumos.destroy', $insumo->ID_insumo) }}" method="POST" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" onclick="return confirm('¿Eliminar del inventario?')" class="p-2.5 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 transition-all">
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
                                        <td colspan="4" class="px-8 py-20 text-center text-emerald-200 font-black italic text-sm">EL INVENTARIO ESTÁ VACÍO. CATALOGUE NUEVOS ELEMENTOS.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="px-6 py-5 bg-gray-50/30 border-t border-emerald-50">
                        {{ $insumos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const searchInput = document.getElementById('catalogSearch');
            const searchResults = document.getElementById('searchResults');
            const mainForm = document.getElementById('seedForm');
            const batchForm = document.getElementById('batchSaveForm');
            const placeholder = document.getElementById('formPlaceholder');
            const chipsQueue = document.getElementById('chipsQueue');
            const batchItemsData = document.getElementById('batchItemsData');

            const registeredIds = @json($registeredCatalogoIds);

            let selectedItems = [];
            let debounceTimer;

            searchInput.addEventListener('input', function () {
                clearTimeout(debounceTimer);
                const query = this.value.trim();
                if (query.length < 2) {
                    searchResults.classList.add('hidden');
                    return;
                }

                debounceTimer = setTimeout(() => {
                    fetch(`/insumos/catalog?q=${query}`)
                        .then(res => res.json())
                        .then(data => {
                            searchResults.innerHTML = '';
                            if (data.length > 0) {
                                data.forEach(item => {
                                    const isAlreadyRegistered = registeredIds.includes(parseInt(item.id_catalogo_insumo));
                                    const div = document.createElement('div');
                                    div.className = `px-5 py-4 border-b border-emerald-50 last:border-0 transition-colors ${isAlreadyRegistered ? 'bg-gray-50 opacity-50 cursor-not-allowed' : 'hover:bg-emerald-50 cursor-pointer'}`;
                                    div.innerHTML = `
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <p class="font-black text-emerald-950 text-sm leading-tight">${item.nombre}</p>
                                                <p class="text-[9px] font-bold text-emerald-500 uppercase tracking-widest leading-none">
                                                    ${isAlreadyRegistered ? 'YA EN INVENTARIO' : (item.tipo_insumo ? item.tipo_insumo.nombre : 'GENERAL')}
                                                </p>
                                                ${item.impacto_dias != 0 ? `
                                                    <span class="text-[8px] font-black ${item.impacto_dias < 0 ? 'text-emerald-500 bg-emerald-50' : 'text-amber-500 bg-amber-50'} px-1.5 py-0.5 rounded-md uppercase tracking-tighter">${item.impacto_dias > 0 ? '+' : ''}${item.impacto_dias}d impacto</span>
                                                ` : ''}
                                            </div>
                                        </div>
                                    `;
                                    if (!isAlreadyRegistered) div.onclick = () => addToQueue(item);
                                    searchResults.appendChild(div);
                                });
                                
                                const manualDiv = document.createElement('div');
                                manualDiv.className = 'px-5 py-4 bg-emerald-50/30 hover:bg-emerald-50 cursor-pointer transition-colors border-t border-emerald-50';
                                manualDiv.innerHTML = `
                                    <p class="text-[9px] font-black text-emerald-400 uppercase tracking-[0.2em] mb-3 leading-none tracking-widest">Insumo no en catálogo...</p>
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-emerald-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-emerald-100">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                        </div>
                                        <span class="text-xs font-black text-emerald-600 uppercase tracking-widest">Registrar "${query}" manualmente</span>
                                    </div>
                                `;
                                manualDiv.onclick = () => showManualForm(query);
                                searchResults.appendChild(manualDiv);
                                
                                searchResults.classList.remove('hidden');
                            } else {
                                searchResults.innerHTML = `
                                    <div class="px-5 py-4 hover:bg-emerald-50 cursor-pointer transition-colors bg-emerald-50/20" onclick="showManualForm('${query}')">
                                        <p class="text-[9px] font-black text-emerald-400 uppercase tracking-[0.2em] mb-3 leading-none tracking-widest">Insumo no encontrado...</p>
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
                if (selectedItems.find(s => s.id_catalogo_insumo === item.id_catalogo_insumo)) return;

                selectedItems.push({
                    id_catalogo_insumo: item.id_catalogo_insumo,
                    nombre: item.nombre_comercial,
                    descripcion: item.descripcion || '',
                    impacto_dias: item.impacto_dias || 0
                });
                renderQueue();
            }

            function renderQueue() {
                chipsQueue.innerHTML = '';
                placeholder.classList.add('hidden');
                mainForm.classList.add('hidden');

                if (selectedItems.length === 0) {
                    placeholder.classList.remove('hidden');
                    batchForm.classList.add('hidden');
                    return;
                }

                batchForm.classList.remove('hidden');
                batchItemsData.innerHTML = '';

                selectedItems.forEach((item, index) => {
                    const chip = document.createElement('div');
                    chip.className = 'flex items-center gap-2 bg-emerald-600 text-white pl-4 pr-2 py-3 rounded-2xl shadow-lg shadow-emerald-100 animate-in zoom-in-95 duration-200';
                    chip.innerHTML = `
                        <div class="mr-1">
                            <p class="text-[10px] font-black uppercase text-white leading-none">${item.nombre}</p>
                            ${item.impacto_dias != 0 ? `<p class="text-[8px] font-bold ${item.impacto_dias < 0 ? 'text-emerald-200' : 'text-amber-200'} uppercase tracking-tight mt-1">${item.impacto_dias > 0 ? '+' : ''}${item.impacto_dias}d impacto</p>` : ''}
                        </div>
                        <button onclick="removeFromQueue(${index})" class="p-1 hover:bg-white/20 rounded-lg"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
                    `;
                    chipsQueue.appendChild(chip);

                    batchItemsData.innerHTML += `
                        <input type="hidden" name="items[${index}][id_catalogo_insumo]" value="${item.id_catalogo_insumo}">
                        <input type="hidden" name="items[${index}][nombre]" value="${item.nombre}">
                        <input type="hidden" name="items[${index}][descripcion]" value="${item.descripcion}">
                        <input type="hidden" name="items[${index}][impacto_dias]" value="${item.impacto_dias}">
                    `;
                });
            }

            function removeFromQueue(index) {
                selectedItems.splice(index, 1);
                renderQueue();
            }

            function clearQueue() {
                selectedItems = [];
                renderQueue();
            }

            function showManualForm(name) {
                clearQueue();
                searchResults.classList.add('hidden');
                searchInput.value = '';
                placeholder.classList.add('hidden');
                mainForm.classList.remove('hidden');

                document.getElementById('input_id_catalogo_insumo').value = '';
                document.getElementById('nombre').value = name;
                document.getElementById('impacto_dias').value = '0';
                document.getElementById('categoria_manual').value = '';
                document.getElementById('descripcion').value = '';
            }

            function resetForm() {
                mainForm.classList.add('hidden');
                placeholder.classList.remove('hidden');
                mainForm.reset();
                mainForm.action = "{{ route('insumos.store') }}";
                const mi = mainForm.querySelector('input[name="_method"]');
                if (mi) mi.remove();
            }

            function editInsumo(insumo) {
                clearQueue();
                placeholder.classList.add('hidden');
                mainForm.classList.remove('hidden');

                document.getElementById('input_id_catalogo_insumo').value = insumo.id_catalogo_insumo || '';
                document.getElementById('nombre').value = insumo.Nombre;
                document.getElementById('impacto_dias').value = insumo.impacto_dias;
                document.getElementById('categoria_manual').value = insumo.catalogo ? insumo.catalogo.id_tipo_insumo : '';
                document.getElementById('descripcion').value = insumo.descripcion || '';

                mainForm.action = `/insumos/${insumo.ID_insumo}`;
                if (!mainForm.querySelector('input[name="_method"]')) {
                    const mi = document.createElement('input');
                    mi.type = 'hidden'; mi.name = '_method'; mi.value = 'PUT';
                    mainForm.appendChild(mi);
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