@extends('layouts.admin')

@section('title', 'Gestionar Tipos de Insumo')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Form Column -->
        <div class="xl:col-span-1">
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-emerald-50 dark:border-emerald-900/20 p-6 sticky top-6 transition-all duration-300">
                <div class="flex items-center gap-3 mb-6">
                    <div class="bg-emerald-600 p-2.5 rounded-2xl text-white shadow-lg shadow-emerald-100 dark:shadow-none transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-emerald-950 dark:text-emerald-50" id="formTitle">Nuevo Tipo</h3>
                        <p class="text-[10px] font-bold text-emerald-500 dark:text-emerald-400 uppercase tracking-widest mt-0.5">Categorización de Insumos</p>
                    </div>
                </div>

                <form id="tipoInsumoForm" action="{{ route('tipo_insumos.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div id="methodField">@if(isset($edit)) @method('PUT') @endif</div>

                    <div>
                        <label class="block text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-wider mb-2">Nombre del Tipo</label>
                        <input type="text" name="nombre" id="nombre" required placeholder="Ej. Fertilizante, Abono, Fungicida..."
                            class="w-full px-4 py-3 rounded-2xl border-2 border-emerald-50 dark:border-emerald-900/20 focus:border-emerald-500 focus:ring-0 bg-emerald-50/20 dark:bg-slate-900 text-sm font-medium transition-all focus:bg-white dark:focus:bg-slate-900 text-emerald-950 dark:text-emerald-50">
                        @error('nombre')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="button" id="cancelBtn" onclick="resetForm()" class="hidden px-5 py-3 bg-gray-100 dark:bg-slate-900 hover:bg-gray-200 dark:hover:bg-slate-850 text-gray-600 dark:text-emerald-700 font-bold rounded-2xl transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        <button type="submit" id="submitBtn" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-black py-3 rounded-2xl shadow-xl shadow-emerald-100 dark:shadow-none transition-all transform hover:-translate-y-1">
                            Guardar Tipo
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- List Column -->
        <div class="xl:col-span-2">
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-emerald-50 dark:border-emerald-900/20 overflow-hidden flex flex-col transition-all duration-300">
                <div class="p-6 border-b border-emerald-50 dark:border-emerald-900/10 bg-gray-50/50 dark:bg-slate-900/50 transition-colors">
                    <h3 class="text-lg font-black text-emerald-950 dark:text-emerald-50">Tipos Registrados</h3>
                    <p class="text-xs text-emerald-600 dark:text-emerald-400 mt-1">Lista de categorías disponibles para sus insumos</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-white dark:bg-slate-900/50 text-[10px] font-black text-emerald-400 dark:text-emerald-600 uppercase tracking-[0.2em] border-b border-emerald-50 dark:border-emerald-900/10 transition-colors">
                                <th class="px-6 py-4">Nombre del Tipo</th>
                                <th class="px-6 py-4 text-center">Origen</th>
                                <th class="px-6 py-4 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-emerald-50/50 dark:divide-emerald-900/10">
                            @forelse($tipoInsumos as $tipo)
                            <tr class="hover:bg-emerald-50/30 dark:hover:bg-slate-700/20 transition-all group cursor-default">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 {{ $tipo->id_empresa ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400' : 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400' }} rounded-xl flex items-center justify-center font-black transition-colors">
                                            {{ substr($tipo->nombre, 0, 1) }}
                                        </div>
                                        <span class="font-bold text-emerald-950 dark:text-emerald-50 tracking-tight">{{ $tipo->nombre }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($tipo->id_empresa)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 dark:bg-emerald-900/30 text-emerald-800 dark:text-emerald-400 transition-colors">
                                            Personalizado
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400 transition-colors">
                                            Sistema
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @if($tipo->id_empresa)
                                    <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all">
                                        <button onclick="editTipo({{ $tipo->id_tipo_insumo }}, '{{ $tipo->nombre }}')" class="p-2 bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 rounded-xl hover:bg-amber-100 dark:hover:bg-amber-900/50 shadow-sm border border-transparent dark:border-amber-800/40 transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <form action="{{ route('tipo_insumos.destroy', $tipo->id_tipo_insumo) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" onclick="return confirm('¿Está seguro de eliminar este tipo de insumo?')" class="p-2 bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-xl hover:bg-red-100 dark:hover:bg-red-900/50 shadow-sm border border-transparent dark:border-red-800/40 transition-all">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                    @else
                                        <span class="text-[10px] font-bold text-gray-400 dark:text-gray-600 uppercase italic">Solo lectura</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-8 py-12 text-center text-emerald-300 dark:text-emerald-800 font-bold italic">No hay tipos de insumo registrados.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($tipoInsumos->hasPages())
                <div class="p-6 bg-gray-50/50 dark:bg-slate-900/50 border-t border-emerald-50 dark:border-emerald-900/10 transition-colors">
                    {{ $tipoInsumos->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function editTipo(id, nombre) {
        const form = document.getElementById('tipoInsumoForm');
        const methodField = document.getElementById('methodField');
        const nombreInput = document.getElementById('nombre');
        const formTitle = document.getElementById('formTitle');
        const submitBtn = document.getElementById('submitBtn');
        const cancelBtn = document.getElementById('cancelBtn');

        form.action = `/tipo_insumos/${id}`;
        methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
        nombreInput.value = nombre;
        formTitle.innerText = 'Editar Tipo';
        submitBtn.innerText = 'Actualizar Tipo';
        submitBtn.classList.replace('bg-emerald-600', 'bg-amber-600');
        submitBtn.classList.replace('hover:bg-emerald-700', 'hover:bg-amber-700');
        cancelBtn.classList.remove('hidden');
        
        nombreInput.focus();
    }

    function resetForm() {
        const form = document.getElementById('tipoInsumoForm');
        const methodField = document.getElementById('methodField');
        const nombreInput = document.getElementById('nombre');
        const formTitle = document.getElementById('formTitle');
        const submitBtn = document.getElementById('submitBtn');
        const cancelBtn = document.getElementById('cancelBtn');

        form.action = "{{ route('tipo_insumos.store') }}";
        methodField.innerHTML = '';
        form.reset();
        formTitle.innerText = 'Nuevo Tipo';
        submitBtn.innerText = 'Guardar Tipo';
        submitBtn.classList.replace('bg-amber-600', 'bg-emerald-600');
        submitBtn.classList.replace('hover:bg-amber-700', 'hover:bg-emerald-700');
        cancelBtn.classList.add('hidden');
    }
</script>
@endpush
@endsection