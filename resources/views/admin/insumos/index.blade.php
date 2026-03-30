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
                            <h3 class="text-lg font-bold text-emerald-900 dark:text-emerald-50">Agregar Insumo</h3>
                            <p class="text-[10px] font-medium text-emerald-500 dark:text-emerald-400 update tracking-widest mt-1">Búsqueda en
                                Catálogo</p>
                        </div>
                    </div>

                    <!-- Professional AJAX Search Input -->
                    <div class="relative group mb-4">
                        <label class="block text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-wider mb-2">Buscar
                            producto</label>
                        <div class="relative">
                            <input type="text" id="catalogSearch" autocomplete="off"
                                placeholder="Ej. Fertilizante, Pala, Semilla..."
                                class="w-full pl-11 pr-4 py-3 rounded-2xl border-2 border-emerald-50 dark:border-emerald-900/20 focus:border-emerald-500 focus:ring-0 bg-emerald-50/30 dark:bg-slate-900/50 text-sm dark:text-emerald-50 transition-all">
                            <div
                                class="absolute left-4 top-1/2 -translate-y-1/2 text-emerald-400 group-focus-within:text-emerald-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <!-- Dropdown Results -->
                            <div id="searchResults"
                                class="hidden absolute top-full left-0 right-0 mt-2 bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-emerald-50 dark:border-emerald-900/30 z-50 max-h-64 overflow-y-auto overflow-x-hidden">
                                <!-- Results inject here -->
                            </div>
                        </div>
                    </div>

                    <form id="seedForm" action="{{ route('insumos.store') }}" method="POST"
                        class="space-y-3 hidden animate-in zoom-in-95 duration-200">
                        @csrf
                        <input type="hidden" name="id_catalogo_insumo" id="input_id_catalogo_insumo">

                        <div>
                            <label class="block text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-wider mb-1.5">Nombre
                                Comercial / Local</label>
                            <input type="text" name="nombre" id="nombre" required
                                class="w-full px-4 py-2.5 rounded-2xl border-emerald-100 dark:border-emerald-900/20 focus:border-emerald-500 focus:ring-emerald-500 bg-white dark:bg-slate-900 text-sm dark:text-emerald-50">
                        </div>

                        <div class="grid grid-cols-3 gap-3">
                            <div class="bg-gray-50 dark:bg-slate-900 p-3 rounded-2xl border border-gray-100 dark:border-emerald-900/20 relative overflow-hidden group">
                                <div
                                    class="absolute -right-2 -bottom-2 text-gray-100 dark:text-emerald-900/20 group-hover:text-emerald-50 transition-colors duration-500 pointer-events-none">
                                    <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M4 6h16v12H4z" />
                                    </svg>
                                </div>
                                <label class="block text-[9px] font-bold text-gray-400 dark:text-emerald-600 uppercase mb-0.5">Categoría</label>
                                <select name="categoria_manual" id="categoria_manual" class="w-full text-xs font-black text-gray-800 dark:text-emerald-100 tracking-tight bg-transparent border-b-2 border-gray-200 dark:border-emerald-900 focus:ring-0 focus:border-emerald-500 relative z-10 cursor-pointer appearance-none">
                                    <option value="" disabled selected>Tipo...</option>
                                    @foreach($tiposInsumo as $tipo)
                                        <option value="{{ $tipo->id_tipo_insumo }}">{{ $tipo->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="bg-blue-50/50 p-3 rounded-2xl border border-blue-100 relative overflow-hidden group">
                                <div class="absolute -right-2 -bottom-2 text-blue-100 group-hover:text-blue-200 transition-colors duration-500 pointer-events-none">
                                    <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/><path d="M12.5 7H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                                    </svg>
                                </div>
                                <label class="block text-[9px] font-bold text-blue-400 uppercase mb-0.5">Impacto (Días)</label>
                                <div class="flex items-center justify-center gap-1 relative z-10 mt-1.5 bg-white/50 px-2 py-0.5 rounded-lg transition-colors">
                                    <input type="number" name="impacto_dias" id="impacto_dias" value="0"
                                        class="w-full text-lg font-black text-blue-700 tracking-tight bg-transparent border-0 focus:ring-0 px-0 py-0 transition-colors outline-none selection:bg-blue-200 text-center">
                                </div>
                            </div>

                            <div
                                class="bg-emerald-50/50 p-3 rounded-2xl border border-emerald-100 relative overflow-hidden group">
                                <div
                                    class="absolute -right-2 -bottom-2 text-emerald-100 group-hover:text-emerald-200 transition-colors duration-500 pointer-events-none">
                                    <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M3 3v18h18V3H3zm16 16H5V5h14v14zM11 7h2v2h-2zM7 7h2v2H7zm8 0h2v2h-2zM7 11h2v2H7zm4 0h2v2h-2zm4 0h2v2h-2zM7 15h2v2H7zm4 0h2v2h-2zm4 0h2v2h-2z" />
                                    </svg>
                                </div>
                                <label class="block text-[9px] font-bold text-emerald-400 uppercase mb-0.5">Stock Actual</label>
                                <div class="flex items-center gap-1 relative z-10">
                                    <span class="text-lg font-black text-emerald-700 tracking-tight">0</span>
                                    <span class="text-[7px] font-bold text-emerald-500 uppercase">Unid</span>
                                    <input type="hidden" name="cantidad_ingreso" id="stock_manual" value="0">
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-emerald-700 dark:text-emerald-500 uppercase tracking-wider mb-1.5 transition-colors">Detalles /
                                Notas</label>
                            <textarea name="descripcion" id="descripcion" rows="2"
                                class="w-full px-4 py-2.5 rounded-2xl border border-emerald-100 dark:border-emerald-900/20 focus:border-emerald-500 focus:ring-emerald-500 bg-white dark:bg-slate-900 text-emerald-950 dark:text-emerald-50 text-sm transition-all"></textarea>
                        </div>

                        <div class="flex gap-2.5">
                            <button type="button" onclick="resetForm()"
                                class="px-5 py-3 bg-gray-100 dark:bg-slate-900 hover:bg-gray-200 dark:hover:bg-slate-850 text-gray-600 dark:text-emerald-700 font-bold rounded-2xl transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                            <button type="submit"
                                class="flex-1 bg-emerald-600 dark:bg-emerald-500 hover:bg-emerald-700 dark:hover:bg-emerald-400 text-white font-bold py-3 rounded-2xl shadow-lg shadow-emerald-200 dark:shadow-none transition-all transform hover:-translate-y-1">
                                Guardar en Suministros
                            </button>
                        </div>
                    </form>

                    <!-- Initial State Illustration -->
                    <div id="formPlaceholder"
                        class="py-12 flex flex-col items-center justify-center text-center space-y-4 opacity-40">
                        <div class="w-20 h-20 bg-emerald-50 dark:bg-slate-900 rounded-full flex items-center justify-center text-emerald-300 dark:text-emerald-900 transition-colors">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-emerald-900 dark:text-emerald-50 transition-colors">Busque un insumo en el catálogo para agregarlo a su
                            inventario.</p>
                    </div>
                </div>
            </div>

            <!-- Inventory List Column -->
            <div class="xl:col-span-2">
                <div
                    class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-emerald-50 dark:border-emerald-900/20 overflow-hidden flex flex-col transition-all duration-300">
                    <div class="p-4 border-b border-emerald-50 dark:border-emerald-900/10 bg-gray-50/50 dark:bg-slate-900/50 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div>
                            <h3 class="text-lg font-black text-emerald-950 dark:text-emerald-50">Inventario de Suministros</h3>
                            <p class="text-[10px] font-medium text-emerald-600 dark:text-emerald-400 mt-1">Gestione el stock de semillas, fertilizantes, herramientas y más</p>
                        </div>
                        <div class="flex flex-wrap items-center gap-3">
                            <form action="{{ route('admin.insumos.index') }}" method="GET" class="flex items-center gap-2 bg-white dark:bg-slate-900 p-1 rounded-2xl border border-emerald-100 dark:border-emerald-900/30 shadow-sm transition-all">
                                <select name="month" class="bg-transparent border-0 text-[10px] font-bold text-emerald-700 dark:text-emerald-400 focus:ring-0 cursor-pointer">
                                    <option value="">Mes...</option>
                                    @php
                                        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                                    @endphp
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
                            
                            <a href="{{ route('admin.insumos.export', request()->all()) }}" class="flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl text-[10px] font-bold shadow-lg shadow-emerald-100 dark:shadow-none transition-all transform hover:-translate-y-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                Exportar
                            </a>

                            <div class="bg-white dark:bg-slate-900 border-2 border-emerald-100 dark:border-emerald-900/20 px-4 py-1.5 rounded-2xl flex items-center gap-2.5 shadow-sm transition-all">
                                <span class="text-xl font-black text-emerald-600 dark:text-emerald-400">{{ $insumos->total() }}</span>
                                <span class="text-[9px] font-bold text-emerald-400 dark:text-emerald-600 uppercase tracking-widest leading-none">Total<br>Productos</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex-1 overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr
                                    class="bg-white dark:bg-slate-900/50 text-[9px] font-black text-emerald-400 dark:text-emerald-600 uppercase tracking-[0.2em] border-b border-emerald-50 dark:border-emerald-900/10 transition-colors">
                                    <th class="px-4 py-2">Producto</th>
                                    <th class="px-4 py-2 text-center">Categoría</th>
                                    <th class="px-4 py-2 text-center">Stock</th>
                                    <th class="px-4 py-2 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-emerald-50/50 dark:divide-emerald-900/10">
                                @forelse($insumos as $insumo)
                                    <tr class="hover:bg-emerald-50/30 transition-all group">
                                        <td class="px-4 py-2">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-8 h-8 bg-emerald-600 rounded-xl flex items-center justify-center text-white font-black text-sm shadow-lg shadow-emerald-100 dark:shadow-none transform group-hover:rotate-12 transition-transform">
                                                    {{ substr($insumo->Nombre, 0, 1) }}
                                                </div>
                                                <div>
                                                    <span
                                                        class="font-black text-emerald-950 dark:text-emerald-50 block text-xs">{{ $insumo->Nombre }}</span>
                                                    <span
                                                        class="text-[9px] font-bold text-emerald-400 dark:text-emerald-500 uppercase tracking-wider italic">Cat:
                                                        {{ $insumo->catalogo->nombre_comercial ?? 'Custom' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-2 text-center">
                                            <span
                                                class="bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 text-[9px] font-black uppercase tracking-tighter px-2 py-0.5 rounded-full border border-amber-100 dark:border-amber-800/40 transition-colors">
                                                {{ $insumo->catalogo->tipoInsumo->nombre ?? 'Insumo' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2 text-center">
                                            <div class="flex flex-col gap-0.5 items-center">
                                                <div class="flex items-center gap-1.5">
                                                    <span class="text-lg font-black text-emerald-950 dark:text-emerald-50">{{ number_format($insumo->stock_actual ?? 0, 0) }}</span>
                                                    @if(($insumo->stock_actual ?? 0) <= 0)
                                                        <div class="flex items-center gap-1 px-1.5 py-0.5 bg-red-50 dark:bg-red-900/30 border border-red-100 dark:border-red-800/40 rounded-md animate-pulse">
                                                            <svg class="w-2.5 h-2.5 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                            </svg>
                                                            <span class="text-[8px] font-black text-red-600 dark:text-red-300 uppercase tracking-tighter">Falta</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-4 py-2 text-right">
                                            <div
                                                class="flex items-center justify-end gap-2.5 opacity-0 group-hover:opacity-100 transition-all">
                                                <button data-insumo="{{ json_encode($insumo) }}" onclick="editInsumo(JSON.parse(this.dataset.insumo))"
                                                    class="p-2 bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 rounded-xl hover:bg-amber-100 dark:hover:bg-amber-900/50 transition-colors shadow-sm dark:shadow-none border border-transparent dark:border-amber-800/40">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </button>
                                                <form action="{{ route('insumos.destroy', $insumo->ID_insumo) }}" method="POST"
                                                    class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('¿Eliminar este producto de su inventario?')"
                                                        class="p-2 bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-xl hover:bg-red-100 dark:hover:bg-red-900 transition-colors shadow-sm border border-transparent dark:border-red-800/40">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7M10 11v6M14 11v6M4 7h16M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-emerald-400 font-bold italic">
                                            Su inventario está vacío. Agregue insumos desde el buscador lateral.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="p-4 bg-gray-50/50 dark:bg-slate-900/50 border-t border-emerald-50 dark:border-emerald-900/10">
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
            const seedForm = document.getElementById('seedForm');
            const formPlaceholder = document.getElementById('formPlaceholder');

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
                                    const div = document.createElement('div');
                                    div.className = 'px-4 py-3 hover:bg-emerald-50 dark:hover:bg-slate-700/50 cursor-pointer border-b border-emerald-50 dark:border-emerald-900/10 last:border-0 transition-colors flex justify-between items-center';

                                    const categoria = item.tipo_insumo ? item.tipo_insumo.nombre : 'Insumo';

                                    div.innerHTML = `
                                                <div>
                                                    <p class="font-black text-emerald-950 dark:text-emerald-50 text-sm">${item.nombre_comercial}</p>
                                                    <p class="text-[10px] text-emerald-500 dark:text-emerald-400 font-bold uppercase tracking-widest">${categoria}</p>
                                                </div>
                                                <svg class="w-4 h-4 text-emerald-300 dark:text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                            `;
                                    div.onclick = () => selectFromCatalog(item);
                                    searchResults.appendChild(div);
                                });
                                // Add "Custom" option at the end
                                const customDiv = document.createElement('div');
                                customDiv.className = 'px-4 py-3 hover:bg-emerald-50 dark:hover:bg-slate-700/50 cursor-pointer border-t border-emerald-100 dark:border-emerald-900/30 bg-emerald-50/50 dark:bg-slate-900/50 transition-colors';
                                customDiv.innerHTML = `
                                    <div class="flex space-x-3 items-center text-emerald-700 dark:text-emerald-400">
                                        <div class="bg-emerald-200 dark:bg-emerald-900/50 text-emerald-800 dark:text-emerald-200 p-1.5 rounded-lg">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                        </div>
                                        <span class="font-bold text-sm">Crear "${query}" como nuevo insumo libre</span>
                                    </div>
                                `;
                                customDiv.onclick = () => selectCustomInsumo(query);
                                searchResults.appendChild(customDiv);

                                searchResults.classList.remove('hidden');
                            } else {
                                searchResults.innerHTML = `
                                    <div class="px-4 py-3 hover:bg-emerald-50 dark:hover:bg-slate-700/50 cursor-pointer transition-colors" onclick="selectCustomInsumo('${query}')">
                                        <p class="text-[10px] text-gray-400 dark:text-gray-500 mb-1 italic">No se encontró en el catálogo global...</p>
                                        <div class="flex space-x-3 items-center text-emerald-700 dark:text-emerald-400">
                                            <div class="bg-emerald-200 dark:bg-emerald-900/50 text-emerald-800 dark:text-emerald-200 p-1.5 rounded-lg">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                            </div>
                                            <span class="font-bold text-sm">Registrar "${query}" manualmente</span>
                                        </div>
                                    </div>
                                `;
                                searchResults.classList.remove('hidden');
                            }
                        });
                }, 300);
            });

            function selectCustomInsumo(nombre) {
                searchResults.classList.add('hidden');
                searchInput.value = nombre;

                document.getElementById('input_id_catalogo_insumo').value = '';
                document.getElementById('nombre').value = nombre;
                document.getElementById('categoria_manual').value = '';
                document.getElementById('descripcion').value = '';
                document.getElementById('impacto_dias').value = 0;
                document.getElementById('stock_manual').value = 0;

                formPlaceholder.classList.add('hidden');
                seedForm.classList.remove('hidden');
            }

            function selectFromCatalog(item) {
                searchResults.classList.add('hidden');
                searchInput.value = item.nombre_comercial;
                // Populate Form
                document.getElementById('input_id_catalogo_insumo').value = item.id_catalogo_insumo;
                document.getElementById('nombre').value = item.nombre_comercial;
                document.getElementById('categoria_manual').value = item.id_tipo_insumo || '';
                document.getElementById('descripcion').value = item.descripcion || '';
                document.getElementById('impacto_dias').value = item.impacto_dias || 0;
                document.getElementById('stock_manual').value = 0;

                // Toggle visibility
                formPlaceholder.classList.add('hidden');
                seedForm.classList.remove('hidden');
            }

            function resetForm() {
                seedForm.classList.add('hidden');
                formPlaceholder.classList.remove('hidden');
                searchInput.value = '';
                seedForm.action = "{{ route('insumos.store') }}";

                let methodInput = seedForm.querySelector('input[name="_method"]');
                if (methodInput) methodInput.remove();

                seedForm.querySelector('button[type="submit"]').innerText = 'Guardar en Suministros';
                seedForm.reset();
            }

            function editInsumo(insumo) {
                // Prevent clearing searchInput on normal use, but here we enforce the form
                searchInput.value = insumo.Nombre;

                const catalogData = insumo.catalogo || {
                    id_catalogo_insumo: insumo.id_catalogo_insumo,
                    nombre_comercial: insumo.Nombre,
                    descripcion: insumo.descripcion,
                    tipo_insumo: null
                };

                // Populate standard info
                document.getElementById('input_id_catalogo_insumo').value = catalogData.id_catalogo_insumo || '';
                document.getElementById('categoria_manual').value = catalogData.id_tipo_insumo || '';

                // Override custom edits
                document.getElementById('nombre').value = insumo.Nombre;
                document.getElementById('descripcion').value = insumo.descripcion || '';
                document.getElementById('impacto_dias').value = insumo.impacto_dias || 0;
                document.getElementById('stock_manual').value = 0; // Se reinicia para agregar o quitar en edición

                // Adjust form for update mode
                seedForm.action = `/insumos/${insumo.ID_insumo}`;
                if (!seedForm.querySelector('input[name="_method"]')) {
                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'PUT';
                    seedForm.appendChild(methodInput);
                }
                seedForm.querySelector('button[type="submit"]').innerText = 'Actualizar Producto';

                // Toggle visibility
                formPlaceholder.classList.add('hidden');
                seedForm.classList.remove('hidden');
            }

            // Close results when clicking outside
            document.addEventListener('click', function (e) {
                if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                    searchResults.classList.add('hidden');
                }
            });
        </script>
    @endpush
@endsection