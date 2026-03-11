@extends('layouts.admin')

@section('title', 'Catálogo Pro de Semillas')

@section('content')
<div class="space-y-6">
    @if(session('success'))
    <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-xl flex items-center shadow-sm">
        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-xl flex items-center shadow-sm">
        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="font-medium">{{ session('error') }}</span>
    </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        <!-- Advanced Search & Config Column -->
        <div class="xl:col-span-1">
            <div class="bg-white rounded-3xl shadow-xl border border-emerald-50 p-6 sticky top-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="bg-emerald-600 p-3 rounded-2xl text-white shadow-lg shadow-emerald-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-emerald-900">Configurar Semilla</h3>
                        <p class="text-[10px] font-medium text-emerald-500 uppercase tracking-widest mt-1">Catálogo Global v3.0</p>
                    </div>
                </div>

                <!-- Professional AJAX Search Input -->
                <div class="relative group mb-6">
                    <label class="block text-xs font-bold text-emerald-700 uppercase tracking-wider mb-2">Buscar variedad técnica</label>
                    <div class="relative">
                        <input type="text" id="catalogSearch" autocomplete="off"
                            placeholder="Ej. Tomate, Café, Maíz..."
                            class="w-full pl-12 pr-4 py-4 rounded-2xl border-2 border-emerald-50 focus:border-emerald-500 focus:ring-0 bg-emerald-50/30 text-sm transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-emerald-400 group-focus-within:text-emerald-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <!-- Dropdown Results -->
                        <div id="searchResults" class="hidden absolute top-full left-0 right-0 mt-2 bg-white rounded-2xl shadow-2xl border border-emerald-50 z-50 max-h-64 overflow-y-auto overflow-x-hidden">
                            <!-- Results inject here -->
                        </div>
                    </div>
                </div>

                <form id="seedForm" action="{{ route('tipo_semillas.store') }}" method="POST" class="space-y-4 hidden animate-in zoom-in-95 duration-200">
                    @csrf
                    <input type="hidden" name="id_catalogo" id="input_id_catalogo">

                    <div>
                        <label class="block text-xs font-bold text-emerald-700 uppercase tracking-wider mb-2">Nombre en su Finca</label>
                        <input type="text" name="nombre_semilla" id="nombre_semilla" required
                            class="w-full px-4 py-3 rounded-2xl border-emerald-100 focus:border-emerald-500 focus:ring-emerald-500 bg-white text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-emerald-700 uppercase tracking-wider mb-2">Stock Inicial</label>
                        <input type="number" name="stock_actual" id="stock_actual" step="0.01" min="0" required
                            class="w-full px-4 py-3 rounded-2xl border-emerald-100 focus:border-emerald-500 focus:ring-emerald-500 bg-white text-sm"
                            placeholder="Ej: 500.00">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100 relative overflow-hidden group">
                            <div class="absolute -right-2 -bottom-2 text-gray-100 group-hover:text-emerald-50 transition-colors duration-500">
                                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z" />
                                </svg>
                            </div>
                            <span class="text-[10px] font-bold text-gray-400 uppercase block mb-1">Días Base</span>
                            <span id="display_dias" class="text-xl font-black text-gray-800 tracking-tight">--</span>
                            <span class="bg-emerald-600 text-[8px] text-white px-1.5 py-0.5 rounded absolute top-2 right-2 font-black uppercase">Fijo</span>
                        </div>
                        <div class="bg-emerald-50/50 p-4 rounded-2xl border border-emerald-100 relative overflow-hidden group">
                            <div class="absolute -right-2 -bottom-2 text-emerald-100 group-hover:text-emerald-200 transition-colors duration-500">
                                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14h-2v-4h2v4zm0-6h-2V7h2v4z" />
                                </svg>
                            </div>
                            <span class="text-[10px] font-bold text-emerald-400 uppercase block mb-1">Rendimiento Técnico</span>
                            <div class="flex items-baseline gap-1">
                                <span id="display_rendimiento" class="text-xl font-black text-emerald-700 tracking-tight">--</span>
                                <span class="text-[8px] font-bold text-emerald-500 uppercase">kg/m²</span>
                            </div>
                            <span class="bg-blue-600 text-[8px] text-white px-1.5 py-0.5 rounded absolute top-2 right-2 font-black uppercase">Doc</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-emerald-700 uppercase tracking-wider mb-2">Descripción Personalizada</label>
                        <textarea name="descripcion" id="descripcion" rows="3"
                            class="w-full px-4 py-3 rounded-2xl border-emerald-100 focus:border-emerald-500 focus:ring-emerald-500 bg-white text-sm"></textarea>
                    </div>

                    <div class="flex gap-3">
                        <button type="button" onclick="resetForm()" class="px-6 py-4 bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold rounded-2xl transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        <button type="submit" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-emerald-200 transition-all transform hover:-translate-y-1">
                            Guardar en Inventario
                        </button>
                    </div>
                </form>

                <!-- Initial State Illustration -->
                <div id="formPlaceholder" class="py-12 flex flex-col items-center justify-center text-center space-y-4 opacity-40">
                    <div class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-emerald-900">Busque una semilla arriba para empezar a configurar su variedad.</p>
                </div>
            </div>
        </div>

        <!-- Inventory List Column -->
        <div class="xl:col-span-2">
            <div class="bg-white rounded-3xl shadow-xl border border-emerald-50 overflow-hidden min-h-[500px] flex flex-col">
                <div class="p-6 border-b border-emerald-50 bg-gray-50/50 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-black text-emerald-950">Inventario de Semillas</h3>
                        <p class="text-[10px] font-medium text-emerald-600 mt-1">Variedades adaptadas a su finca</p>
                    </div>
                    <div class="bg-white border-2 border-emerald-100 px-6 py-2 rounded-2xl flex items-center gap-3">
                        <span class="text-2xl font-black text-emerald-600">{{ $tipoSemillas->total() }}</span>
                        <span class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest leading-none">Especies<br>Activas</span>
                    </div>
                </div>

                <div class="flex-1 overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-white text-[10px] font-black text-emerald-400 uppercase tracking-[0.2em] border-b border-emerald-50">
                                <th class="px-6 py-4">Especie y Variedad</th>
                                 <th class="px-6 py-4">Parámetros Técnicos</th>
                                 <th class="px-6 py-4">Cantidad en Stock</th>
                                 <th class="px-6 py-4">Productividad</th>
                                 <th class="px-6 py-4 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-emerald-50/50">
                            @forelse($tipoSemillas as $semilla)
                            <tr class="hover:bg-emerald-50/30 transition-all group">
                                 <td class="px-6 py-4">
                                     <div class="flex items-center gap-3">
                                         <div class="w-10 h-10 bg-emerald-600 rounded-2xl flex items-center justify-center text-white font-black text-base shadow-lg shadow-emerald-100 transform group-hover:rotate-12 transition-transform">
                                            {{ substr($semilla->nombre_semilla, 0, 1) }}
                                        </div>
                                        <div>
                                            <span class="font-black text-emerald-950 block text-base">{{ $semilla->nombre_semilla }}</span>
                                            <span class="text-[10px] font-bold text-emerald-400 uppercase tracking-wider italic">Catálogo: {{ $semilla->catalogo->nombre ?? 'Custom' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                            <span class="text-sm font-bold text-emerald-900">{{ $semilla->tiempo_base_dias }} <span class="text-[10px] font-normal text-emerald-500">días ciclo base</span></span>
                                        </div>
                                        <p class="text-xs text-emerald-400 italic max-w-[180px] truncate">{{ $semilla->descripcion }}</p>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="bg-emerald-50 rounded-xl px-4 py-2 border border-emerald-100 inline-block">
                                        <span class="text-sm font-black text-emerald-700">{{ $semilla->rendimiento_promedio }} <span class="text-[10px] font-bold">kg/m²</span></span>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-all translate-x-4 group-hover:translate-x-0">
                                        <button onclick='editSemilla(@json($semilla))' class="p-3 bg-amber-50 text-amber-600 rounded-2xl hover:bg-amber-100 transition-colors shadow-sm">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <form action="{{ route('tipo_semillas.destroy', $semilla->id_semilla) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" onclick="return confirm('¿Eliminar esta variedad?')" class="p-2.5 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 transition-colors shadow-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7M10 11v6M14 11v6M4 7h16M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-20 text-center">
                                    <p class="text-emerald-400 text-sm font-bold italic">Su inventario está vacío. Comience agregando variedades desde el buscador lateral.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-6 bg-gray-50/50 border-t border-emerald-50">
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
    const formPlaceholder = document.getElementById('formPlaceholder');

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
                            const div = document.createElement('div');
                            div.className = 'px-6 py-4 hover:bg-emerald-50 cursor-pointer border-b border-emerald-50 last:border-0 transition-colors';
                            div.innerHTML = `
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="font-black text-emerald-950 text-sm">${item.nombre}</p>
                                        <p class="text-[10px] text-emerald-500 font-bold uppercase tracking-widest">${item.tiempo_base_dias} días base</p>
                                    </div>
                                    <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                </div>
                            `;
                            div.onclick = () => selectFromCatalog(item);
                            searchResults.appendChild(div);
                        });
                        searchResults.classList.remove('hidden');
                    } else {
                        searchResults.innerHTML = '<p class="px-6 py-4 text-xs text-gray-400 italic">No se encontraron resultados...</p>';
                        searchResults.classList.remove('hidden');
                    }
                });
        }, 300);
    });

    function selectFromCatalog(item) {
        searchResults.classList.add('hidden');
        searchInput.value = item.nombre;

        // Populate Form
        document.getElementById('input_id_catalogo').value = item.id;
        document.getElementById('nombre_semilla').value = item.nombre;
        document.getElementById('display_dias').innerText = item.tiempo_base_dias;
        document.getElementById('display_rendimiento').innerText = item.rendimiento_promedio || '0.00';
        document.getElementById('descripcion').value = item.descripcion || '';

        // Toggle visibility
        formPlaceholder.classList.add('hidden');
        seedForm.classList.remove('hidden');
    }

    function resetForm() {
        seedForm.classList.add('hidden');
        formPlaceholder.classList.remove('hidden');
        searchInput.value = '';
        searchInput.disabled = false;
        seedForm.reset();
        document.getElementById('stock_actual').value = '';
    }

    function editSemilla(semilla) {
        // Show form immediately
        formPlaceholder.classList.add('hidden');
        seedForm.classList.remove('hidden');

        // Populate Form directly from record data
        document.getElementById('input_id_catalogo').value = semilla.id_catalogo;
        document.getElementById('nombre_semilla').value = semilla.nombre_semilla;
        document.getElementById('display_dias').innerText = semilla.tiempo_base_dias;
        document.getElementById('display_rendimiento').innerText = semilla.rendimiento_promedio || '0.00';
        document.getElementById('descripcion').value = semilla.descripcion || '';
        
        searchInput.value = semilla.nombre_semilla;
        searchInput.disabled = true;

        // Adjust form for update mode
        seedForm.action = `/tipo_semillas/${semilla.id_semilla}`;
        if (!seedForm.querySelector('input[name="_method"]')) {
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PUT';
            seedForm.appendChild(methodInput);
        }
        seedForm.querySelector('button[type="submit"]').innerText = 'Actualizar Variedad';
    }

    // Close results when clicking outside
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.classList.add('hidden');
        }
    });
</script>
@endpush
@endsection