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
                            class="w-full pl-11 pr-4 py-3 rounded-2xl border-2 border-blue-50 focus:border-blue-500 focus:ring-0 bg-blue-50/20 text-sm transition-all focus:bg-white disabled:opacity-50 disabled:cursor-not-allowed">
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

                <form id="riegoForm" action="{{ route('tipo_riegos.store') }}" method="POST" class="space-y-3 hidden animate-in zoom-in-95 duration-200">
                    @csrf
                    <input type="hidden" name="id_catalogo" id="input_id_catalogo">

                    <div>
                        <label class="block text-xs font-bold text-emerald-700 uppercase tracking-wider mb-1.5">Nombre Personalizado</label>
                        <input type="text" name="tipo_riego" id="tipo_riego_name" required
                            class="w-full px-4 py-2.5 rounded-2xl border-emerald-100 focus:border-blue-500 focus:ring-0 bg-gray-50/50 text-sm font-medium">
                    </div>

                    <!-- Impact Card -->
                    <div class="bg-blue-50 p-4 rounded-2xl border border-blue-100 relative overflow-hidden">
                        <div class="absolute -right-4 -bottom-4 text-blue-100/50">
                            <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z" />
                            </svg>
                        </div>
                        <span class="text-[9px] font-black text-blue-400 uppercase tracking-widest block mb-1">Impacto en Cosecha (Días)</span>
                        <div class="flex items-center gap-3 relative z-10">
                            <input type="number" name="impacto_dias" id="riego_impacto" class="text-2xl font-black bg-transparent w-20 border-b-2 border-blue-200 focus:ring-0 focus:border-blue-500 text-blue-600 placeholder:text-gray-300" placeholder="0" value="0">
                            <span class="text-[10px] text-blue-600 font-medium leading-tight">Días sumados<br>técnica</span>
                        </div>
                    </div>



                    <div class="flex gap-2.5">
                        <button type="button" onclick="resetRiegoForm()" class="px-5 py-3 bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold rounded-2xl transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-black py-3 rounded-2xl shadow-xl shadow-blue-100 transition-all transform hover:-translate-y-1">
                            Habilitar Sistema
                        </button>
                    </div>
                </form>

                <div id="riegoPlaceholder" class="py-12 flex flex-col items-center justify-center text-center space-y-4 opacity-40">
                    <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center text-blue-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547" />
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-blue-900">Busque un sistema para ver su impacto en días.</p>
                </div>
            </div>
        </div>

        <!-- List Column -->
        <div class="xl:col-span-2">
            <div class="bg-white rounded-3xl shadow-xl border border-emerald-50 overflow-hidden flex flex-col">
                <div class="p-4 border-b border-emerald-50 bg-gray-50/50 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-black text-emerald-950">Sistemas de Riego</h3>
                        <p class="text-[10px] font-medium text-emerald-600 mt-1">Configuración técnica activa</p>
                    </div>
                </div>

                <div class="flex-1 overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-white text-[9px] font-black text-emerald-400 uppercase tracking-[0.2em] border-b border-emerald-50">
                                <th class="px-4 py-2">Tipo de Riego</th>
                                <th class="px-4 py-2 text-center">Impacto</th>
                                <th class="px-4 py-2 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-emerald-50/50">
                            @forelse($tipoRiegos as $riego)
                            <tr class="hover:bg-blue-50/20 transition-all group">
                                <td class="px-4 py-2">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-blue-600 text-white rounded-xl flex items-center justify-center font-black">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517" />
                                            </svg>
                                        </div>
                                        <div>
                                            <span class="font-black text-emerald-950 block text-sm">{{ $riego->tipo_riego }}</span>
                                            <span class="text-[9px] font-bold text-blue-400 uppercase italic">Base: {{ $riego->catalogo->nombre ?? 'Manual' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl {{ $riego->impacto_dias >= 0 ? 'bg-red-50 text-red-600 border-red-100' : 'bg-green-50 text-green-600 border-green-100' }} border font-black text-xs">
                                        {{ $riego->impacto_dias > 0 ? '+' : '' }}{{ $riego->impacto_dias }}
                                        <span class="text-[9px] font-bold uppercase opacity-60">días</span>
                                    </div>
                                </td>

                                <td class="px-4 py-2 text-right">
                                    <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all">
                                        <button onclick='editRiego(@json($riego))' class="p-2 bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-100 shadow-sm transition-all">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <form action="{{ route('tipo_riegos.destroy', $riego->id_tipo_riego) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" onclick="return confirm('¿Eliminar este sistema?')" class="p-2 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 shadow-sm transition-all">
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
                                <td colspan="4" class="px-8 py-12 text-center text-emerald-300 font-bold italic">No hay sistemas registrados.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 bg-gray-50/50 border-t border-emerald-50">
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
    const placeholder = document.getElementById('riegoPlaceholder');

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
                            const div = document.createElement('div');
                            div.className = 'px-4 py-3 hover:bg-blue-50 cursor-pointer border-b border-blue-50 last:border-0 transition-colors';
                            div.innerHTML = `
                                <div class="flex justify-between items-center">
                                    <p class="font-black text-blue-950 text-sm">${item.nombre}</p>
                                    <span class="text-[10px] font-bold ${item.impacto_dias >= 0 ? 'text-red-500' : 'text-green-500'}">${item.impacto_dias > 0 ? '+' : ''}${item.impacto_dias} días</span>
                                </div>
                            `;
                            div.onclick = () => selectItem(item);
                            searchResults.appendChild(div);
                        });
                        // Add "Custom" option
                        const customDiv = document.createElement('div');
                        customDiv.className = 'px-4 py-3 hover:bg-blue-50 cursor-pointer border-t border-blue-100 bg-blue-50/50 transition-colors';
                        customDiv.innerHTML = `
                            <div class="flex space-x-3 items-center text-blue-700">
                                <div class="bg-blue-200 text-blue-800 p-1.5 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                </div>
                                <span class="font-bold text-sm">Crear "${q}" como nuevo sistema</span>
                            </div>
                        `;
                        customDiv.onclick = () => selectCustomRiego(q);
                        searchResults.appendChild(customDiv);
                        
                        searchResults.classList.remove('hidden');
                    } else {
                        searchResults.innerHTML = `
                            <div class="px-4 py-3 hover:bg-blue-50 cursor-pointer transition-colors" onclick="selectCustomRiego('${q}')">
                                <p class="text-xs text-gray-500 mb-2 italic">No se encontró en el catálogo global...</p>
                                <div class="flex space-x-3 items-center text-blue-700">
                                    <div class="bg-blue-200 text-blue-800 p-1.5 rounded-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                    </div>
                                    <span class="font-bold text-sm">Registrar "${q}" manualmente</span>
                                </div>
                            </div>
                        `;
                        searchResults.classList.remove('hidden');
                    }
                });
        }, 300);
    });

    function selectCustomRiego(nombre) {
        searchResults.classList.add('hidden');
        searchInput.value = nombre;

        document.getElementById('input_id_catalogo').value = '';
        document.getElementById('tipo_riego_name').value = nombre;
        document.getElementById('riego_impacto').value = '0';

        placeholder.classList.add('hidden');
        form.classList.remove('hidden');
    }

    function selectItem(item) {
        searchResults.classList.add('hidden');
        searchInput.value = item.nombre;

        document.getElementById('input_id_catalogo').value = item.id;
        document.getElementById('tipo_riego_name').value = item.nombre;

        const impacto = parseInt(item.impacto_dias);
        document.getElementById('riego_impacto').value = impacto;

        placeholder.classList.add('hidden');
        form.classList.remove('hidden');
    }

    function resetRiegoForm() {
        form.classList.add('hidden');
        placeholder.classList.remove('hidden');
        searchInput.value = '';
        searchInput.disabled = false;
        form.reset();

        // Restore to store mode
        form.action = "{{ route('tipo_riegos.store') }}";
        const methodInput = form.querySelector('input[name="_method"]');
        if (methodInput) methodInput.remove();
        form.querySelector('button[type="submit"]').innerText = 'Habilitar Sistema';
        form.querySelector('button[type="submit"]').classList.replace('bg-amber-600', 'bg-blue-600');
    }

    function editRiego(riego) {
        // Show form
        placeholder.classList.add('hidden');
        form.classList.remove('hidden');

        // Populate Form
        document.getElementById('input_id_catalogo').value = riego.id_catalogo;
        document.getElementById('tipo_riego_name').value = riego.tipo_riego;

        const impacto = parseInt(riego.impacto_dias);
        document.getElementById('riego_impacto').value = impacto;
        
        searchInput.value = riego.tipo_riego;
        searchInput.disabled = true;

        // Adjust form for update mode
        form.action = `/tipo_riegos/${riego.id_tipo_riego}`;
        if (!form.querySelector('input[name="_method"]')) {
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PUT';
            form.appendChild(methodInput);
        }
        form.querySelector('button[type="submit"]').innerText = 'Actualizar Sistema';
        form.querySelector('button[type="submit"]').classList.replace('bg-blue-600', 'bg-amber-600');
    }

    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.classList.add('hidden');
        }
    });
</script>
@endpush
@endsection