@extends('layouts.admin')

@section('title', 'Gestión de Terrenos')

@section('content')
<div class="space-y-8">
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

    @if ($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-xl shadow-sm">
        <div class="flex items-center mb-2">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="font-bold cursor-default flex-1">Hay errores en el formulario:</span>
        </div>
        <ul class="list-disc ml-10 text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        <!-- Add/Edit Form Column -->
        <div class="xl:col-span-1">
            <div class="bg-white rounded-3xl shadow-xl border border-emerald-50 p-8 sticky top-8">
                <div class="flex items-center gap-3 mb-8">
                    <div class="bg-emerald-600 p-3 rounded-2xl text-white shadow-lg shadow-emerald-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 id="formTitle" class="text-xl font-bold text-emerald-900">Registrar Terreno</h3>
                        <p class="text-[10px] font-medium text-emerald-500 uppercase tracking-widest mt-1">Gestor Espacial</p>
                    </div>
                </div>

                <form id="terrenoForm" action="{{ route('admin.terrenos.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div id="methodField"></div>

                    <div>
                        <label class="block text-xs font-bold text-emerald-700 uppercase tracking-wider mb-2">Nombre del Terreno</label>
                        <input type="text" name="nombre" id="nombre" required placeholder="Ej. Lote 1, Parcela Norte"
                            class="w-full px-4 py-3 rounded-2xl border-emerald-100 focus:border-emerald-500 focus:ring-emerald-500 bg-emerald-50/30 text-sm transition-all" value="{{ old('nombre') }}">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-emerald-700 uppercase tracking-wider mb-2">Ubicación</label>
                        <input type="text" name="ubicacion" id="ubicacion" required placeholder="Ej. Coordenadas o Referencia"
                            class="w-full px-4 py-3 rounded-2xl border-emerald-100 focus:border-emerald-500 focus:ring-emerald-500 bg-emerald-50/30 text-sm transition-all" value="{{ old('ubicacion') }}">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-emerald-700 uppercase tracking-wider mb-2">Ancho (m)</label>
                            <input type="number" step="0.01" name="Ancho" id="Ancho" required min="1"
                                class="w-full px-4 py-3 rounded-2xl border-emerald-100 focus:border-emerald-500 focus:ring-emerald-500 bg-emerald-50/30 text-sm transition-all" value="{{ old('Ancho') }}">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-emerald-700 uppercase tracking-wider mb-2">Alto (m)</label>
                            <input type="number" step="0.01" name="Alto" id="Alto" required min="1"
                                class="w-full px-4 py-3 rounded-2xl border-emerald-100 focus:border-emerald-500 focus:ring-emerald-500 bg-emerald-50/30 text-sm transition-all" value="{{ old('Alto') }}">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-emerald-700 uppercase tracking-wider mb-2">Tipo de Suelo</label>
                        <select name="id_tipo_suelo" id="id_tipo_suelo" required
                            class="w-full px-4 py-3 rounded-2xl border-emerald-100 focus:border-emerald-500 focus:ring-emerald-500 bg-emerald-50/30 text-sm transition-all">
                            <option value="">Seleccione un suelo...</option>
                            @foreach($tipoSuelos as $suelo)
                                <option value="{{ $suelo->id_tipo_suelo }}" {{ old('id_tipo_suelo') == $suelo->id_tipo_suelo ? 'selected' : '' }}>
                                    {{ $suelo->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>



                    <div class="flex gap-3 pt-2">
                        <button type="button" onclick="resetForm()" id="btnCancel" class="hidden px-6 py-4 bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold rounded-2xl transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        <button type="submit" id="btnSubmit" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-emerald-200 transition-all transform hover:-translate-y-1">
                            Guardar Terreno
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Inventory List Column -->
        <div class="xl:col-span-2">
            <div class="bg-white rounded-3xl shadow-xl border border-emerald-50 overflow-hidden min-h-[600px] flex flex-col">
                <div class="p-8 border-b border-emerald-50 bg-gray-50/50 flex justify-between items-center">
                    <div>
                        <h3 class="text-2xl font-black text-emerald-950">Parcelas Registradas</h3>
                        <p class="text-xs font-medium text-emerald-600 mt-1">Mapa general de su finca</p>
                    </div>
                    <div class="bg-white border-2 border-emerald-100 px-6 py-2 rounded-2xl flex items-center gap-3">
                        <span class="text-2xl font-black text-emerald-600">{{ collect($terrenos->items())->count() }}</span>
                        <span class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest leading-none">Terrenos<br>Totales</span>
                    </div>
                </div>

                <div class="flex-1 overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-white text-[10px] font-black text-emerald-400 uppercase tracking-[0.2em] border-b border-emerald-50">
                                <th class="px-8 py-6">Terreno</th>
                                <th class="px-8 py-6">Dimensiones</th>
                                <th class="px-8 py-6">Estado</th>
                                <th class="px-8 py-6 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-emerald-50/50">
                            @forelse($terrenos as $terreno)
                            <tr class="hover:bg-emerald-50/30 transition-all group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-emerald-600 rounded-2xl flex items-center justify-center text-white font-black text-lg shadow-lg shadow-emerald-100 transform group-hover:rotate-12 transition-transform">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064" />
                                            </svg>
                                        </div>
                                        <div>
                                            <span class="font-black text-emerald-950 block text-base">{{ $terreno->nombre }}</span>
                                            <span class="text-[10px] font-bold text-emerald-400 uppercase tracking-wider flex items-center gap-1 mt-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                                {{ Str::limit($terreno->ubicacion, 25) }}
                                            </span>
                                            <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider opacity-70 mt-1 block">Suelo: {{ optional($terreno->tipoSuelo)->nombre ?? 'No asignado' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="space-y-1">
                                        <div class="flex flex-col gap-1">
                                            <span class="text-sm font-bold text-emerald-900 border border-emerald-100 bg-white px-3 py-1 rounded-lg shadow-sm inline-flex items-center gap-2">
                                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                                                {{ $terreno->Ancho }}m &times; {{ $terreno->Alto }}m
                                            </span>
                                            <span class="text-xs font-bold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-lg mt-1 inline-block border border-emerald-100">
                                                &approx; {{ number_format($terreno->Ancho * $terreno->Alto, 2) }} m&sup2;
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    @if(optional($terreno->estado)->id_estado == 7)
                                        <div class="bg-emerald-50 rounded-xl px-4 py-2 border border-emerald-200 inline-flex items-center gap-2 shadow-sm">
                                            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                                            <span class="text-sm font-black text-emerald-700">{{ optional($terreno->estado)->nombre_estado ?? 'Disponible' }}</span>
                                        </div>
                                    @else
                                        <div class="bg-amber-50 rounded-xl px-4 py-2 border border-amber-200 inline-flex items-center gap-2 shadow-sm">
                                            <div class="w-2 h-2 rounded-full bg-amber-500"></div>
                                            <span class="text-sm font-black text-amber-700">{{ optional($terreno->estado)->nombre_estado ?? 'Ocupado' }}</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-all translate-x-4 group-hover:translate-x-0">
                                        <button onclick="editTerreno(@json($terreno))" class="p-3 bg-amber-50 text-amber-600 rounded-2xl hover:bg-amber-100 transition-colors shadow-sm">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <form action="{{ route('admin.terrenos.destroy', $terreno->id_terreno) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" onclick="return confirm('¿Eliminar este terreno de manera permanente?')" class="p-3 bg-red-50 text-red-600 rounded-2xl hover:bg-red-100 transition-colors shadow-sm">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7M10 11v6M14 11v6M4 7h16M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-32 text-center">
                                    <div class="flex flex-col items-center justify-center opacity-50">
                                        <svg class="w-16 h-16 text-emerald-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                                        <p class="text-emerald-600 font-bold text-lg">Su mapa está vacío.</p>
                                        <p class="text-sm text-emerald-500 mt-1">Comience registrando un terreno en el formulario lateral.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-8 bg-gray-50/50 border-t border-emerald-50">
                    {{ $terrenos->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const terrenoForm = document.getElementById('terrenoForm');
    const formTitle = document.getElementById('formTitle');
    const methodField = document.getElementById('methodField');
    const btnCancel = document.getElementById('btnCancel');
    const btnSubmit = document.getElementById('btnSubmit');

    function editTerreno(terreno) {
        // Populate form fields
        document.getElementById('nombre').value = terreno.nombre;
        document.getElementById('ubicacion').value = terreno.ubicacion;
        document.getElementById('Ancho').value = terreno.Ancho;
        document.getElementById('Alto').value = terreno.Alto;
        document.getElementById('id_tipo_suelo').value = terreno.id_tipo_suelo || '';

        // Change Form Action & Method to Update
        terrenoForm.action = `/admin/terrenos/${terreno.id_terreno}`;
        methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
        
        // Update UI
        formTitle.innerText = 'Editar Terreno';
        btnSubmit.innerText = 'Actualizar Datos';
        btnCancel.classList.remove('hidden');

        // Scroll to form (for mobile/small screens)
        terrenoForm.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function resetForm() {
        // Reset inputs
        terrenoForm.reset();
        
        // Reset action and method to Store
        terrenoForm.action = '{{ route("admin.terrenos.store") }}';
        methodField.innerHTML = '';
        
        // Update UI
        formTitle.innerText = 'Registrar Terreno';
        btnSubmit.innerText = 'Guardar Terreno';
        btnCancel.classList.add('hidden');
    }
</script>
@endpush
@endsection
