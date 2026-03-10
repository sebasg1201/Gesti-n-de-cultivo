@extends('layouts.admin')

@section('title', 'Inventario de Suministros')

@section('content')
    <div class="space-y-8">
        @if(session('success'))
            <div
                class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-xl flex items-center shadow-sm">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-xl flex items-center shadow-sm">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <!-- Advanced Search & Config Column -->
            <div class="xl:col-span-1">
                <div class="bg-white rounded-3xl shadow-xl border border-emerald-50 p-8 sticky top-8">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="bg-emerald-600 p-3 rounded-2xl text-white shadow-lg shadow-emerald-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-emerald-900">Agregar Insumo</h3>
                            <p class="text-[10px] font-medium text-emerald-500 uppercase tracking-widest mt-1">Búsqueda en
                                Catálogo</p>
                        </div>
                    </div>

                    <!-- Professional AJAX Search Input -->
                    <div class="relative group mb-8">
                        <label class="block text-xs font-bold text-emerald-700 uppercase tracking-wider mb-3">Buscar
                            producto</label>
                        <div class="relative">
                            <input type="text" id="catalogSearch" autocomplete="off"
                                placeholder="Ej. Fertilizante, Pala, Semilla..."
                                class="w-full pl-12 pr-4 py-4 rounded-2xl border-2 border-emerald-50 focus:border-emerald-500 focus:ring-0 bg-emerald-50/30 text-sm transition-all">
                            <div
                                class="absolute left-4 top-1/2 -translate-y-1/2 text-emerald-400 group-focus-within:text-emerald-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <!-- Dropdown Results -->
                            <div id="searchResults"
                                class="hidden absolute top-full left-0 right-0 mt-2 bg-white rounded-2xl shadow-2xl border border-emerald-50 z-50 max-h-64 overflow-y-auto overflow-x-hidden">
                                <!-- Results inject here -->
                            </div>
                        </div>
                    </div>

                    <form id="seedForm" action="{{ route('insumos.store') }}" method="POST"
                        class="space-y-6 hidden animate-in zoom-in-95 duration-200">
                        @csrf
                        <input type="hidden" name="id_catalogo_insumo" id="input_id_catalogo_insumo">

                        <div>
                            <label class="block text-xs font-bold text-emerald-700 uppercase tracking-wider mb-2">Nombre
                                Comercial / Local</label>
                            <input type="text" name="nombre" id="nombre" required
                                class="w-full px-4 py-3 rounded-2xl border-emerald-100 focus:border-emerald-500 focus:ring-emerald-500 bg-white text-sm">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100 relative overflow-hidden group">
                                <div
                                    class="absolute -right-2 -bottom-2 text-gray-100 group-hover:text-emerald-50 transition-colors duration-500">
                                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M4 6h16v12H4z" />
                                    </svg>
                                </div>
                                <span class="text-[10px] font-bold text-gray-400 uppercase block mb-1">Categoría</span>
                                <span id="display_categoria"
                                    class="text-sm font-black text-gray-800 tracking-tight">--</span>
                                <span
                                    class="bg-emerald-600 text-[8px] text-white px-1.5 py-0.5 rounded absolute top-2 right-2 font-black uppercase">Tipo</span>
                            </div>
                            <div
                                class="bg-emerald-50/50 p-4 rounded-2xl border border-emerald-100 relative overflow-hidden group">
                                <div
                                    class="absolute -right-2 -bottom-2 text-emerald-100 group-hover:text-emerald-200 transition-colors duration-500">
                                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M3 3v18h18V3H3zm16 16H5V5h14v14zM11 7h2v2h-2zM7 7h2v2H7zm8 0h2v2h-2zM7 11h2v2H7zm4 0h2v2h-2zm4 0h2v2h-2zM7 15h2v2H7zm4 0h2v2h-2zm4 0h2v2h-2z" />
                                    </svg>
                                </div>
                                <span class="text-[10px] font-bold text-emerald-400 uppercase block mb-1">Stock
                                    Inicial</span>
                                <div class="flex items-baseline gap-1">
                                    <span class="text-xl font-black text-emerald-700 tracking-tight">0</span>
                                    <span class="text-[8px] font-bold text-emerald-500 uppercase">Unidades</span>
                                </div>
                                <span
                                    class="bg-blue-600 text-[8px] text-white px-1.5 py-0.5 rounded absolute top-2 right-2 font-black uppercase">Config</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-emerald-700 uppercase tracking-wider mb-2">Detalles /
                                Notas</label>
                            <textarea name="descripcion" id="descripcion" rows="3"
                                class="w-full px-4 py-3 rounded-2xl border-emerald-100 focus:border-emerald-500 focus:ring-emerald-500 bg-white text-sm"></textarea>
                        </div>

                        <div class="flex gap-3">
                            <button type="button" onclick="resetForm()"
                                class="px-6 py-4 bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold rounded-2xl transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                            <button type="submit"
                                class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-emerald-200 transition-all transform hover:-translate-y-1">
                                Guardar en Suministros
                            </button>
                        </div>
                    </form>

                    <!-- Initial State Illustration -->
                    <div id="formPlaceholder"
                        class="py-12 flex flex-col items-center justify-center text-center space-y-4 opacity-40">
                        <div class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-300">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-emerald-900">Busque un insumo en el catálogo para agregarlo a su
                            inventario.</p>
                    </div>
                </div>
            </div>

            <!-- Inventory List Column -->
            <div class="xl:col-span-2">
                <div
                    class="bg-white rounded-3xl shadow-xl border border-emerald-50 overflow-hidden min-h-[600px] flex flex-col">
                    <div class="p-8 border-b border-emerald-50 bg-gray-50/50 flex justify-between items-center">
                        <div>
                            <h3 class="text-2xl font-black text-emerald-950">Inventario de Suministros</h3>
                            <p class="text-xs font-medium text-emerald-600 mt-1">Gestione el stock de semillas,
                                fertilizantes, herramientas y más</p>
                        </div>
                        <div class="bg-white border-2 border-emerald-100 px-6 py-2 rounded-2xl flex items-center gap-3">
                            <span class="text-2xl font-black text-emerald-600">{{ $insumos->total() }}</span>
                            <span
                                class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest leading-none">Productos<br>Registrados</span>
                        </div>
                    </div>

                    <div class="flex-1 overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr
                                    class="bg-white text-[10px] font-black text-emerald-400 uppercase tracking-[0.2em] border-b border-emerald-50">
                                    <th class="px-8 py-6">Producto</th>
                                    <th class="px-8 py-6">Categoría</th>
                                    <th class="px-8 py-6">Cantidad en Stock</th>
                                    <th class="px-8 py-6 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-emerald-50/50">
                                @forelse($insumos as $insumo)
                                    <tr class="hover:bg-emerald-50/30 transition-all group">
                                        <td class="px-8 py-6">
                                            <div class="flex items-center gap-4">
                                                <div
                                                    class="w-12 h-12 bg-emerald-600 rounded-2xl flex items-center justify-center text-white font-black text-lg shadow-lg shadow-emerald-100 transform group-hover:rotate-12 transition-transform">
                                                    {{ substr($insumo->Nombre, 0, 1) }}
                                                </div>
                                                <div>
                                                    <span
                                                        class="font-black text-emerald-950 block text-base">{{ $insumo->Nombre }}</span>
                                                    <span
                                                        class="text-[10px] font-bold text-emerald-400 uppercase tracking-wider italic">Cat:
                                                        {{ $insumo->catalogo->nombre_comercial ?? 'Custom' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-6">
                                            <span
                                                class="bg-amber-50 text-amber-600 text-xs font-bold px-3 py-1 rounded-full border border-amber-100">
                                                {{ $insumo->catalogo->tipoInsumo->nombre ?? 'Insumo' }}
                                            </span>
                                        </td>
                                        <td class="px-8 py-6">
                                            <div class="flex items-center gap-3">
                                                <span
                                                    class="text-xl font-black text-emerald-900">{{ number_format($insumo->stock_actual, 2) }}</span>
                                                @if($insumo->stock_actual <= 0)
                                                    <span
                                                        class="bg-red-50 text-red-600 text-[10px] font-bold px-2 py-0.5 rounded-md uppercase flex items-center gap-1 border border-red-100">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                        </svg>
                                                        Sin Stock
                                                    </span>
                                                @else
                                                    <span
                                                        class="bg-emerald-50 text-emerald-600 text-[10px] font-bold px-2 py-1 rounded-md uppercase border border-emerald-100">
                                                        En Stock
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-8 py-6 text-right">
                                            <div
                                                class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-all translate-x-4 group-hover:translate-x-0">
                                                <button onclick="editInsumo(@json($insumo))"
                                                    class="p-3 bg-amber-50 text-amber-600 rounded-2xl hover:bg-amber-100 transition-colors shadow-sm">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </button>
                                                <form action="{{ route('insumos.destroy', $insumo->ID_insumo) }}" method="POST"
                                                    class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('¿Eliminar este producto de su inventario?')"
                                                        class="p-3 bg-red-50 text-red-600 rounded-2xl hover:bg-red-100 transition-colors shadow-sm">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
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
                                        <td colspan="4" class="px-8 py-32 text-center">
                                            <p class="text-emerald-400 font-bold italic">Su inventario está vacío. Agregue
                                                insumos desde el buscador lateral.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="p-8 bg-gray-50/50 border-t border-emerald-50">
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
                                    div.className = 'px-6 py-4 hover:bg-emerald-50 cursor-pointer border-b border-emerald-50 last:border-0 transition-colors flex justify-between items-center';

                                    const categoria = item.tipo_insumo ? item.tipo_insumo.nombre : 'Insumo';

                                    div.innerHTML = `
                                        <div>
                                            <p class="font-black text-emerald-950 text-sm">${item.nombre_comercial}</p>
                                            <p class="text-[10px] text-emerald-500 font-bold uppercase tracking-widest">${categoria}</p>
                                        </div>
                                        <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                    `;
                                    div.onclick = () => selectFromCatalog(item);
                                    searchResults.appendChild(div);
                                });
                                searchResults.classList.remove('hidden');
                            } else {
                                searchResults.innerHTML = '<p class="px-6 py-4 text-xs text-gray-400 italic">No se encontraron productos en el catálogo...</p>';
                                searchResults.classList.remove('hidden');
                            }
                        });
                }, 300);
            });

            function selectFromCatalog(item) {
                searchResults.classList.add('hidden');
                searchInput.value = item.nombre_comercial;

                // Populate Form
                document.getElementById('input_id_catalogo_insumo').value = item.id_catalogo_insumo;
                document.getElementById('nombre').value = item.nombre_comercial;
                document.getElementById('display_categoria').innerText = item.tipo_insumo ? item.tipo_insumo.nombre : 'Insumo';
                document.getElementById('descripcion').value = item.descripcion || '';

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
                document.getElementById('display_categoria').innerText = catalogData.tipo_insumo ? catalogData.tipo_insumo.nombre : 'Insumo';

                // Override custom edits
                document.getElementById('nombre').value = insumo.Nombre;
                document.getElementById('descripcion').value = insumo.descripcion || '';

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