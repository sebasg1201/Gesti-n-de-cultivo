@extends('layouts.admin')

@section('title', 'Gestión de Estados')

@section('content')
<div class="space-y-8">
    <!-- ALERTAS -->
    @if(session('success'))
    <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-xl flex items-center shadow-sm animate-in fade-in slide-in-from-top-4 duration-300">
        <svg class="w-6 h-6 mr-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <span class="font-bold">{{ session('success') }}</span>
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
        <!-- Configuration Column -->
        <div class="xl:col-span-1">
            <div class="bg-white rounded-3xl shadow-xl border border-emerald-50 p-8 sticky top-8">
                <div class="flex items-center gap-4 mb-8">
                    <div class="bg-emerald-600 p-3 rounded-2xl text-white shadow-lg shadow-emerald-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div>
                        <h3 id="formTitle" class="text-xl font-black text-emerald-950">Crear Estado</h3>
                        <p class="text-[10px] font-bold text-emerald-500 uppercase tracking-widest mt-0.5">Gestión de Catálogo</p>
                    </div>
                </div>

                <form id="estadoForm" action="{{ route('estados.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div id="method_field"></div>

                    <div>
                        <label class="block text-xs font-bold text-emerald-700 uppercase tracking-wider mb-2">Nombre del Estado</label>
                        <input type="text" name="nombre_estado" id="nombre_estado" required
                            class="w-full px-4 py-3 rounded-2xl border-emerald-100 focus:border-emerald-500 focus:ring-emerald-500 bg-gray-50/50 text-sm font-medium"
                            placeholder="Ej. Activo, Inactivo, Pendiente..."
                            value="{{ old('nombre_estado') }}">
                        @error('nombre_estado')
                            <p class="text-red-500 text-xs mt-2 font-bold italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-3">
                        <button type="button" onclick="resetForm()" id="cancelBtn" class="hidden px-6 py-4 bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold rounded-2xl transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        <button type="submit" id="submitBtn" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-black py-4 rounded-2xl shadow-xl shadow-emerald-100 transition-all transform hover:-translate-y-1">
                            Guardar Estado
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- List Column -->
        <div class="xl:col-span-2">
            <div class="bg-white rounded-3xl shadow-xl border border-emerald-50 overflow-hidden flex flex-col min-h-[600px]">
                <div class="p-8 border-b border-emerald-50 bg-gray-50/50 flex justify-between items-center">
                    <div>
                        <h3 class="text-2xl font-black text-emerald-950">Estados Registrados</h3>
                        <p class="text-xs font-medium text-emerald-600 mt-1">Listado maestro del sistema</p>
                    </div>
                </div>

                <div class="flex-1 overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-white text-[10px] font-black text-emerald-400 uppercase tracking-[0.2em] border-b border-emerald-50">
                                <th class="px-8 py-6">ID</th>
                                <th class="px-8 py-6">Nombre del Estado</th>
                                <th class="px-8 py-6 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-emerald-50/50">
                            @forelse($estados as $estado)
                            <tr class="hover:bg-emerald-50/20 transition-all group">
                                <td class="px-8 py-6">
                                    <span class="font-bold text-gray-400 text-xs">#{{ $estado->id_estado }}</span>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="font-black text-emerald-950">{{ $estado->nombre_estado }}</span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-all translate-x-4 group-hover:translate-x-0">
                                        <button onclick='editEstado(@json($estado))' class="p-3 bg-amber-50 text-amber-600 rounded-2xl hover:bg-amber-100 shadow-sm transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <form action="{{ route('estados.destroy', $estado->id_estado) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" onclick="return confirm('¿Eliminar este estado?')" class="p-3 bg-red-50 text-red-600 rounded-2xl hover:bg-red-100 shadow-sm transition-all">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-8 py-32 text-center text-emerald-300 font-bold italic">No hay estados registrados.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-8 bg-gray-50/50 border-t border-emerald-50">
                    {{ $estados->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const form = document.getElementById('estadoForm');
    const inputNombre = document.getElementById('nombre_estado');
    const formTitle = document.getElementById('formTitle');
    const submitBtn = document.getElementById('submitBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const methodField = document.getElementById('method_field');

    function editEstado(estado) {
        // Change form status
        formTitle.innerText = 'Editar Estado';
        submitBtn.innerText = 'Actualizar Estado';
        submitBtn.classList.replace('bg-emerald-600', 'bg-amber-600');
        cancelBtn.classList.remove('hidden');

        // Populate fields
        inputNombre.value = estado.nombre_estado;

        // Update action and method
        form.action = `/estados/${estado.id_estado}`;
        methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';

        // Focus input
        inputNombre.focus();
    }

    function resetForm() {
        formTitle.innerText = 'Crear Estado';
        submitBtn.innerText = 'Guardar Estado';
        submitBtn.classList.replace('bg-amber-600', 'bg-emerald-600');
        cancelBtn.classList.add('hidden');
        
        form.reset();
        form.action = "{{ route('estados.store') }}";
        methodField.innerHTML = '';
    }

    @if(session('editing'))
        document.addEventListener('DOMContentLoaded', function() {
            const estado = {!! json_encode(session('estado_data') ?? []) !!};
            if(estado.id_estado) editEstado(estado);
        });
    @endif
</script>
@endpush
@endsection

