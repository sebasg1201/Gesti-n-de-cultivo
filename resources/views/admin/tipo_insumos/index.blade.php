@extends('layouts.admin')

@section('title', 'Catálogo Pro de Insumos')

@section('content')
    <div class="space-y-8">


        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <!-- Advanced Search & Config Column -->
            <div class="xl:col-span-1">
                <div class="bg-white rounded-3xl shadow-xl border border-blue-50 p-8 sticky top-8">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="bg-blue-600 p-3 rounded-2xl text-white shadow-lg shadow-blue-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-blue-900">Configurar Insumo</h3>
                            <p class="text-[10px] font-medium text-blue-500 uppercase tracking-widest mt-1">Catálogo Global
                                v3.0</p>
                        </div>
                    </div>

                    <!-- Professional AJAX Search Input -->
                    <div class="relative group mb-8">
                        <label class="block text-xs font-bold text-blue-700 uppercase tracking-wider mb-3">Buscar tipo de
                            insumo</label>
                        <div class="relative">
                            <input type="text" id="catalogSearch" autocomplete="off"
                                placeholder="Ej. Semillas, Fertilizante, Veneno..."
                                class="w-full pl-12 pr-4 py-4 rounded-2xl border-2 border-blue-50 focus:border-blue-500 focus:ring-0 bg-blue-50/30 text-sm transition-all">
                            <div
                                class="absolute left-4 top-1/2 -translate-y-1/2 text-blue-400 group-focus-within:text-blue-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <!-- Dropdown Results -->
                            <div id="searchResults"
                                class="hidden absolute top-full left-0 right-0 mt-2 bg-white rounded-2xl shadow-2xl border border-blue-50 z-50 max-h-64 overflow-y-auto overflow-x-hidden">
                                <!-- Results inject here -->
                            </div>
                        </div>
                    </div>

                    <form id="insumoForm" action="{{ route('admin.tipo_insumos.store') }}" method="POST"
                        class="space-y-6 hidden animate-in zoom-in-95 duration-200">
                        @csrf
                        <input type="hidden" name="id_catalogo" id="input_id_catalogo">

                        <div>
                            <label class="block text-xs font-bold text-blue-700 uppercase tracking-wider mb-2">Nombre
                                Personalizado</label>
                            <input type="text" name="nombre_insumo" id="nombre_insumo" required
                                class="w-full px-4 py-3 rounded-2xl border-blue-100 focus:border-blue-500 focus:ring-blue-500 bg-white text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-blue-700 uppercase tracking-wider mb-2">Descripción
                                Personalizada</label>
                            <textarea name="descripcion" id="descripcion" rows="3"
                                class="w-full px-4 py-3 rounded-2xl border-blue-100 focus:border-blue-500 focus:ring-blue-500 bg-white text-sm"></textarea>
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
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-blue-200 transition-all transform hover:-translate-y-1">
                                Habilitar Insumo
                            </button>
                        </div>
                    </form>

                    <!-- Initial State Illustration -->
                    <div id="formPlaceholder"
                        class="py-12 flex flex-col items-center justify-center text-center space-y-4 opacity-40">
                        <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center text-blue-300">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-blue-900">Busque un tipo de insumo arriba para habilitarlo en su
                            finca.</p>
                    </div>
                </div>
            </div>

            <!-- Inventory List Column -->
            <div class="xl:col-span-2">
                <div
                    class="bg-white rounded-3xl shadow-xl border border-blue-50 overflow-hidden min-h-[600px] flex flex-col">
                    <div class="p-8 border-b border-blue-50 bg-gray-50/50 flex justify-between items-center">
                        <div>
                            <h3 class="text-2xl font-black text-blue-950">Tipos de Insumo Habilitados</h3>
                            <p class="text-xs font-medium text-blue-600 mt-1">Categorías activas para el inventario</p>
                        </div>
                        <div class="bg-white border-2 border-blue-100 px-6 py-2 rounded-2xl flex items-center gap-3">
                            <span class="text-2xl font-black text-blue-600">{{ $tipoInsumos->total() }}</span>
                            <span
                                class="text-[10px] font-bold text-blue-400 uppercase tracking-widest leading-none">Categorías<br>Activas</span>
                        </div>
                    </div>

                    <div class="flex-1 overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr
                                    class="bg-white text-[10px] font-black text-blue-400 uppercase tracking-[0.2em] border-b border-blue-50">
                                    <th class="px-8 py-6">Tipo / Categoría</th>
                                    <th class="px-8 py-6">Descripción</th>
                                    <th class="px-8 py-6 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-blue-50/50">
                                @forelse($tipoInsumos as $tipo)
                                    <tr class="hover:bg-blue-50/30 transition-all group">
                                        <td class="px-8 py-6">
                                            <div class="flex items-center gap-4">
                                                <div
                                                    class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center text-white font-black text-lg shadow-lg shadow-blue-100 transform group-hover:rotate-12 transition-transform">
                                                    {{ substr($tipo->nombre_insumo, 0, 1) }}
                                                </div>
                                                <div>
                                                    <span
                                                        class="font-black text-blue-950 block text-base">{{ $tipo->nombre_insumo }}</span>
                                                    <span
                                                        class="text-[10px] font-bold text-blue-400 uppercase tracking-wider italic">Catálogo:
                                                        {{ $tipo->catalogo->nombre ?? 'Custom' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-6">
                                            <p class="text-xs text-blue-400 italic max-w-sm truncate">
                                                {{ $tipo->descripcion ?? 'Sin descripción' }}
                                            </p>
                                        </td>
                                        <td class="px-8 py-6 text-right">
                                            <div
                                                class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-all translate-x-4 group-hover:translate-x-0">
                                                <button onclick="editInsumo(@json($tipo))"
                                                    class="p-3 bg-amber-50 text-amber-600 rounded-2xl hover:bg-amber-100 transition-colors shadow-sm">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </button>
                                                <form action="{{ route('admin.tipo_insumos.destroy', $tipo->id_tipo_insumo) }}"
                                                    method="POST" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('¿Eliminar esta categoría de insumo?')"
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
                                        <td colspan="3" class="px-8 py-32 text-center">
                                            <p class="text-blue-400 font-bold italic">No hay categorías activas. Busque en el
                                                catálogo para agregarlas.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="p-8 bg-gray-50/50 border-t border-blue-50">
                        {{ $tipoInsumos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const searchInput = document.getElementById('catalogSearch');
            const searchResults = document.getElementById('searchResults');
            const insumoForm = document.getElementById('insumoForm');
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
                    fetch(`/tipo_insumos/catalog?q=${query}`)
                        .then(res => res.json())
                        .then(data => {
                            searchResults.innerHTML = '';
                            let content = '';
                            if (data.length > 0) {
                                data.forEach(item => {
                                    content += `
                                        <div class="px-6 py-4 hover:bg-blue-50 cursor-pointer border-b border-blue-50 transition-colors" onclick='selectFromCatalog(${JSON.stringify(item).replace(/'/g, "&apos;")})'>
                                            <div class="flex justify-between items-center">
                                                <div>
                                                    <p class="font-black text-blue-950 text-sm">${item.nombre}</p>
                                                    <p class="text-[10px] text-blue-500 font-bold uppercase tracking-widest">${item.descripcion || 'Sin descripción'}</p>
                                                </div>
                                                <svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                            </div>
                                        </div>
                                    `;
                                });
                            } else {
                                content += '<p class="px-6 py-4 text-xs text-gray-400 italic text-center">No se encontraron resultados en el catálogo estándar...</p>';
                            }
                            // Call to action button to create a custom supply type
                            const safeQuery = query.replace(/'/g, "\\'");
                            content += `
                                <div class="px-6 py-4 bg-gray-50 text-center border-t border-blue-100">
                                    <p class="text-[10px] text-gray-500 mb-2 italic">¿No encuentra lo que busca?</p>
                                    <button type="button" onclick="crearInsumoPersonalizado('${safeQuery}')" class="px-4 py-2 bg-blue-600 text-white rounded-xl text-xs font-bold hover:bg-blue-700 shadow-md shadow-blue-200 transition-all w-full">
                                        Crear "${query}" como Personalizado
                                    </button>
                                </div>
                            `;
                            searchResults.innerHTML = content;
                            searchResults.classList.remove('hidden');
                        });
                }, 300);
            });

            function selectFromCatalog(item) {
                searchResults.classList.add('hidden');
                searchInput.value = item.nombre;

                // Populate Form
                document.getElementById('input_id_catalogo').value = item.id;
                document.getElementById('nombre_insumo').value = item.nombre;
                document.getElementById('descripcion').value = item.descripcion || '';

                // Toggle visibility
                formPlaceholder.classList.add('hidden');
                insumoForm.classList.remove('hidden');

                insumoForm.action = `/admin/tipo_insumos`;
                if (insumoForm.querySelector('input[name="_method"]')) {
                    insumoForm.querySelector('input[name="_method"]').remove();
                }
                insumoForm.querySelector('button[type="submit"]').innerText = 'Habilitar Insumo';
            }

            function crearInsumoPersonalizado(nombre) {
                searchResults.classList.add('hidden');
                searchInput.value = nombre;

                // Populate Form
                document.getElementById('input_id_catalogo').value = '';
                document.getElementById('nombre_insumo').value = nombre;
                document.getElementById('descripcion').value = '';
                
                // Toggle visibility
                formPlaceholder.classList.add('hidden');
                insumoForm.classList.remove('hidden');

                insumoForm.action = `/admin/tipo_insumos`;
                if (insumoForm.querySelector('input[name="_method"]')) {
                    insumoForm.querySelector('input[name="_method"]').remove();
                }
                insumoForm.querySelector('button[type="submit"]').innerText = 'Habilitar Insumo Personalizado';
            }

            function resetForm() {
                insumoForm.classList.add('hidden');
                formPlaceholder.classList.remove('hidden');
                searchInput.value = '';
                insumoForm.reset();

                insumoForm.action = `/admin/tipo_insumos`;
                if (insumoForm.querySelector('input[name="_method"]')) {
                    insumoForm.querySelector('input[name="_method"]').remove();
                }
            }

            function editInsumo(tipo) {
                searchInput.value = tipo.nombre_insumo;

                formPlaceholder.classList.add('hidden');
                insumoForm.classList.remove('hidden');

                document.getElementById('input_id_catalogo').value = tipo.id_catalogo;
                document.getElementById('nombre_insumo').value = tipo.nombre_insumo;
                document.getElementById('descripcion').value = tipo.descripcion || '';

                // Adjust form for update mode
                insumoForm.action = `/admin/tipo_insumos/${tipo.id_tipo_insumo}`;
                if (!insumoForm.querySelector('input[name="_method"]')) {
                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'PUT';
                    insumoForm.appendChild(methodInput);
                }
                insumoForm.querySelector('button[type="submit"]').innerText = 'Actualizar Insumo';
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