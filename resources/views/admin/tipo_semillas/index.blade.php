@extends('layouts.admin')

@section('title', 'Catálogo Pro de Semillas')

@section('content')
    <div class="space-y-4">


        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <!-- Advanced Search & Config Column -->
            <div class="xl:col-span-1">
                <div class="bg-white rounded-3xl shadow-xl border border-emerald-50 p-5 sticky top-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="bg-emerald-600 p-2.5 rounded-2xl text-white shadow-lg shadow-emerald-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-emerald-900">Configurar Semilla</h3>
                            <p class="text-[10px] font-medium text-emerald-500 uppercase tracking-widest mt-1">Catálogo
                                Global v3.0</p>
                        </div>
                    </div>

                    <!-- Professional AJAX Search Input -->
                    <div class="relative group mb-4">
                        <div class="relative">
                            <input type="text" id="catalogSearch" autocomplete="off" placeholder="Buscar Variedad Técnica (Ej. Tomate, Café...)"
                                class="w-full pl-11 pr-4 py-3 rounded-2xl border-2 border-emerald-50 focus:border-emerald-500 focus:ring-0 bg-emerald-50/30 text-sm transition-all disabled:opacity-50 disabled:cursor-not-allowed">
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

                    <form id="seedForm" action="{{ route('tipo_semillas.store') }}" method="POST"
                        class="space-y-3 hidden animate-in zoom-in-95 duration-200">
                        @csrf
                        <input type="hidden" name="id_catalogo" id="input_id_catalogo">

                        <!-- Basic Information -->
                        <div class="space-y-3 mb-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Nombre de la Variedad *</label>
                                <input type="text" name="nombre_semilla" id="sw_nombre" required
                                    class="w-full px-4 py-2.5 rounded-2xl border-emerald-100 focus:border-emerald-500 focus:ring-emerald-500 bg-white shadow-sm"
                                    placeholder="Ej: Maíz Amarillo">
                            </div>
                            
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Descripción / Notas</label>
                                <textarea name="descripcion" id="sw_descripcion" rows="2"
                                    class="w-full px-4 py-2.5 rounded-2xl border-emerald-100 focus:border-emerald-500 focus:ring-emerald-500 bg-white shadow-sm"
                                    placeholder="Detalles adicionales..."></textarea>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-3">
                            <!-- Rendimiento -->
                            <div class="bg-emerald-50 p-3 rounded-xl border border-emerald-100/50 group transition-all hover:shadow-md relative">
                                <span class="absolute -top-2 -right-2 text-[8px] font-black text-white bg-emerald-600 px-1.5 py-0.5 rounded-lg opacity-0 group-hover:opacity-100 transition-all duration-300 transform scale-75 group-hover:scale-100 shadow-lg z-10">kg/m²</span>
                                <label class="block text-[9px] font-black text-emerald-600 uppercase tracking-widest mb-1">Rendimiento</label>
                                <div class="flex items-end gap-1">
                                    <input type="number" step="0.01" name="rendimiento_promedio" id="sw_rendimiento" class="text-xl font-black text-emerald-950 bg-transparent border-0 p-0 w-full focus:ring-0" value="0.0">
                                </div>
                            </div>

                            <!-- Tiempo Base -->
                            <div class="bg-amber-50 p-3 rounded-xl border border-amber-100/50 group transition-all hover:shadow-md relative">
                                <span class="absolute -top-2 -right-2 text-[8px] font-black text-white bg-amber-600 px-1.5 py-0.5 rounded-lg opacity-0 group-hover:opacity-100 transition-all duration-300 transform scale-75 group-hover:scale-100 shadow-lg z-10">días</span>
                                <label class="block text-[9px] font-black text-amber-600 uppercase tracking-widest mb-1">Ciclo Base</label>
                                <div class="flex items-end gap-1">
                                    <input type="number" name="tiempo_base_dias" id="sw_tiempo_base" class="text-xl font-black text-amber-950 bg-transparent border-0 p-0 w-full focus:ring-0" value="0">
                                </div>
                            </div>

                            <!-- Espacio por planta -->
                            <div class="bg-blue-50 p-3 rounded-xl border border-blue-100/50 group transition-all hover:shadow-md relative">
                                <span class="absolute -top-2 -right-2 text-[8px] font-black text-white bg-blue-600 px-1.5 py-0.5 rounded-lg opacity-0 group-hover:opacity-100 transition-all duration-300 transform scale-75 group-hover:scale-100 shadow-lg z-10">m²/planta</span>
                                <label class="block text-[9px] font-black text-blue-600 uppercase tracking-widest mb-1">Densidad</label>
                                <div class="flex items-end gap-1">
                                    <input type="number" step="0.0001" name="espacio_por_planta_m2" id="sw_espacio" class="text-xl font-black text-blue-950 bg-transparent border-0 p-0 w-full focus:ring-0" value="0.2500">
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-2.5">
                            <button type="button" onclick="resetForm()"
                                class="px-5 py-3 bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold rounded-2xl transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                            <button type="submit"
                                class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-2xl shadow-lg shadow-emerald-200 transition-all transform hover:-translate-y-1">
                                Guardar en Inventario
                            </button>
                        </div>
                    </form>

                    <!-- Initial State Illustration -->
                    <div id="formPlaceholder"
                        class="py-12 flex flex-col items-center justify-center text-center space-y-4 opacity-40">
                        <div class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-300">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-emerald-900">Busque una semilla arriba para empezar a configurar
                            su variedad.</p>
                    </div>
                </div>
            </div>

            <!-- Inventory List Column -->
            <div class="xl:col-span-2">
                <div
                    class="bg-white rounded-3xl shadow-xl border border-emerald-50 overflow-hidden flex flex-col">
                    <div class="p-4 border-b border-emerald-50 bg-gray-50/50 flex justify-between items-center">
                        <div>
                            <h3 class="text-base font-black text-emerald-950">Inventario de Semillas</h3>
                            <p class="text-[9px] font-medium text-emerald-600 mt-1">Variedades adaptadas a su finca</p>
                        </div>
                        <div class="bg-white border-2 border-emerald-100 px-4 py-1.5 rounded-2xl flex items-center gap-3">
                            <span class="text-xl font-black text-emerald-600">{{ $tipoSemillas->total() }}</span>
                            <span
                                class="text-[9px] font-bold text-emerald-400 uppercase tracking-widest leading-none">Especies<br>Activas</span>
                        </div>
                    </div>

                    <div class="flex-1 overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr
                                    class="bg-white text-[9px] font-black text-emerald-400 uppercase tracking-[0.2em] border-b border-emerald-50">
                                    <th class="px-4 py-2">Especie y Variedad</th>
                                    <th class="px-4 py-2">Parámetros</th>
                                    <th class="px-4 py-2">Productividad</th>
                                    <th class="px-4 py-2">Stock</th>
                                    <th class="px-4 py-2 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-emerald-50/50">
                                @forelse($tipoSemillas as $semilla)
                                    <tr class="hover:bg-emerald-50/30 transition-all group">
                                        <td class="px-4 py-2">
                                            <div class="flex items-center gap-2">
                                                <div
                                                    class="w-8 h-8 bg-emerald-600 rounded-xl flex items-center justify-center text-white font-black text-xs shadow-lg shadow-emerald-100 transform group-hover:rotate-12 transition-transform">
                                                    {{ substr($semilla->nombre_semilla, 0, 1) }}
                                                </div>
                                                <div>
                                                    <span
                                                        class="font-black text-emerald-950 block text-xs">{{ $semilla->nombre_semilla }}</span>
                                                    <span
                                                        class="text-[9px] font-bold text-emerald-400 uppercase tracking-wider italic">Catálogo:
                                                        {{ $semilla->catalogo->nombre ?? 'Custom' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-2">
                                            <div class="space-y-0.5">
                                                <div class="flex items-center gap-1.5">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                    <span
                                                        class="text-[11px] font-bold text-emerald-900">{{ $semilla->tiempo_base_dias }}
                                                        <span class="text-[9px] font-normal text-emerald-500">días ciclo</span></span>
                                                </div>
                                                <p class="text-[10px] text-emerald-400 italic max-w-[140px] truncate">
                                                    {{ $semilla->descripcion }}</p>
                                                <p class="text-[9px] font-bold text-blue-500">Densidad: {{ number_format($semilla->espacio_por_planta_m2, 4) }} m²</p>
                                            </div>
                                        </td>
                                        <td class="px-4 py-2">
                                            <div
                                                class="bg-emerald-50 rounded-lg px-2 py-0.5 border border-emerald-100 inline-block">
                                                <span
                                                    class="text-[10px] font-black text-emerald-700">{{ $semilla->rendimiento_promedio }}
                                                    <span class="text-[8px] font-bold">kg/m²</span></span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-2">
                                            <div class="flex flex-col gap-0.5">
                                                <span class="text-[8px] font-black text-emerald-400 uppercase tracking-widest">Stock</span>
                                                <div class="flex items-center gap-1.5">
                                                    <span class="text-base font-black text-emerald-950">{{ number_format($semilla->stock_actual ?? 0, 0) }}</span>
                                                    @if(($semilla->stock_actual ?? 0) <= 0)
                                                        <div class="flex items-center gap-1 px-1.5 py-0.5 bg-red-50 border border-red-100 rounded-md animate-pulse">
                                                            <svg class="w-2.5 h-2.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                            </svg>
                                                            <span class="text-[8px] font-black text-red-600 uppercase tracking-tighter">Sin Stock</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-2 text-right">
                                            <div
                                                class="flex items-center justify-end gap-1.5 opacity-0 group-hover:opacity-100 transition-all">
                                                <button
                                                    data-semilla="{{ json_encode($semilla) }}"
                                                    onclick="editSemilla(JSON.parse(this.dataset.semilla))"
                                                    class="p-1.5 bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-100 transition-colors shadow-sm">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </button>
                                                <form action="{{ route('tipo_semillas.destroy', $semilla->id_semilla) }}"
                                                    method="POST" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" onclick="return confirm('¿Eliminar esta variedad?')"
                                                        class="p-1.5 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 transition-colors shadow-sm">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7M10 11v6M14 11v6M4 7h16M9 7V4a1 1 0 011-1h4a1 2 0 011 1v3" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-10 text-center">
                                            <p class="text-emerald-400 text-sm font-bold italic">Su inventario está vacío.
                                                Comience agregando variedades desde el buscador lateral.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="p-5 bg-gray-50/50 border-t border-emerald-50">
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

            searchInput.addEventListener('input', function () {
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
                                                <p class="text-[10px] text-emerald-500 font-bold uppercase tracking-widest">${item.tiempo_base_dias} días base - ${parseFloat(item.espacio_por_planta_m2 || 0.25).toFixed(4)} m²</p>
                                            </div>
                                            <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                        </div>
                                    `;
                                    div.onclick = () => selectFromCatalog(item);
                                    searchResults.appendChild(div);
                                });
                                
                                // Add "Custom" option at the end
                                const customDiv = document.createElement('div');
                                customDiv.className = 'px-6 py-4 hover:bg-emerald-50 cursor-pointer border-t border-emerald-100 bg-emerald-50/50 transition-colors';
                                customDiv.innerHTML = `
                                    <div class="flex space-x-3 items-center text-emerald-700">
                                        <div class="bg-emerald-200 text-emerald-800 p-1.5 rounded-lg">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                        </div>
                                        <span class="font-bold text-sm">Crear "${query}" como nueva variedad</span>
                                    </div>
                                `;
                                customDiv.onclick = () => selectCustom(query);
                                searchResults.appendChild(customDiv);
                                
                                searchResults.classList.remove('hidden');
                            } else {
                                searchResults.innerHTML = `
                                    <div class="px-6 py-4 hover:bg-emerald-50 cursor-pointer transition-colors" onclick="selectCustom('${query}')">
                                        <p class="text-xs text-gray-500 mb-2 italic">No se encontró en el catálogo global...</p>
                                        <div class="flex space-x-3 items-center text-emerald-700">
                                            <div class="bg-emerald-200 text-emerald-800 p-1.5 rounded-lg">
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

            function selectCustom(nombre) {
                searchResults.classList.add('hidden');
                searchInput.value = nombre;
                
                document.getElementById('input_id_catalogo').value = '';
                document.getElementById('sw_nombre').value = nombre;
                document.getElementById('sw_tiempo_base').value = '0';
                document.getElementById('sw_rendimiento').value = '0.00';
                document.getElementById('sw_espacio').value = '0.2500';
                document.getElementById('sw_descripcion').value = '';
                
                formPlaceholder.classList.add('hidden');
                seedForm.classList.remove('hidden');
            }

            function selectFromCatalog(item) {
                searchResults.classList.add('hidden');
                searchInput.value = item.nombre;

                // Populate Form
                document.getElementById('input_id_catalogo').value = item.id;
                document.getElementById('sw_nombre').value = item.nombre;
                document.getElementById('sw_tiempo_base').value = item.tiempo_base_dias;
                document.getElementById('sw_rendimiento').value = item.rendimiento_promedio || '0.00';
                document.getElementById('sw_espacio').value = parseFloat(item.espacio_por_planta_m2 || 0.2500).toFixed(4);
                document.getElementById('sw_descripcion').value = item.descripcion || '';

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
                document.getElementById('sw_nombre').value = '';
                document.getElementById('sw_descripcion').value = '';
                document.getElementById('sw_tiempo_base').value = '0';
                document.getElementById('sw_espacio').value = '0.2500';
                document.getElementById('sw_rendimiento').value = '0.00';


                // Reset form for create mode
                seedForm.action = "{{ route('tipo_semillas.store') }}";
                const methodInput = seedForm.querySelector('input[name="_method"]');
                if (methodInput) {
                    methodInput.remove();
                }
                seedForm.querySelector('button[type="submit"]').innerText = 'Guardar en Inventario';
            }

            function editSemilla(semilla) {
                // Show form immediately
                formPlaceholder.classList.add('hidden');
                seedForm.classList.remove('hidden');

                // Populate Form directly from record data
                document.getElementById('input_id_catalogo').value = semilla.id_catalogo;
                document.getElementById('sw_nombre').value = semilla.nombre_semilla;
                document.getElementById('sw_tiempo_base').value = semilla.tiempo_base_dias;
                document.getElementById('sw_rendimiento').value = parseFloat(semilla.rendimiento_promedio || 0).toFixed(2);
                document.getElementById('sw_espacio').value = parseFloat(semilla.espacio_por_planta_m2 || 0.2500).toFixed(4);
                document.getElementById('sw_descripcion').value = semilla.descripcion || '';

                searchInput.value = semilla.nombre_semilla;

                // Adjust form for update mode
                seedForm.action = `/tipo_semillas/${semilla.id_semilla}`;

                // Add PUT method if it doesn't exist
                let methodInput = seedForm.querySelector('input[name="_method"]');
                if (!methodInput) {
                    methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'PUT';
                    seedForm.appendChild(methodInput);
                } else {
                    methodInput.value = 'PUT';
                }

                seedForm.querySelector('button[type="submit"]').innerText = 'Actualizar Variedad';
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