@extends('layouts.admin')

@section('title', 'Gestión de Estados')

@section('content')

<div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800">
            Gestión de Estados
        </h2>
    </div>

    <!-- ALERTAS -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-2 rounded-lg mb-4 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-2 rounded-lg mb-4 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <!-- FORMULARIO DE CREACIÓN -->
    <div class="bg-gray-50 p-4 rounded-lg mb-6 border border-gray-200">
        <h3 class="text-lg font-medium text-gray-700 mb-3">Crear Nuevo Estado</h3>
        
        @if ($errors->has('nombre_estado') && !session('editing'))
            <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-2 rounded-lg mb-4 text-sm">
                {{ $errors->first('nombre_estado') }}
            </div>
        @endif

        <form action="{{ route('estados.store') }}" method="POST" class="flex items-end gap-4">
            @csrf
            <div class="flex-1">
                <label for="nombre_estado" class="block text-sm font-medium text-gray-600 mb-1">Nombre del Estado</label>
                <input type="text" name="nombre_estado" id="nombre_estado" required
                    placeholder="Ej. Activo, Inactivo, Pendiente..."
                    value="{{ old('nombre_estado') }}"
                    class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none @error('nombre_estado') border-red-500 @enderror">
                @error('nombre_estado') @if(!session('editing')) <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @endif @enderror
            </div>
            <button type="submit"
                class="px-4 py-2 bg-green-600 text-white text-sm rounded-lg shadow hover:bg-green-700 transition">
                + Crear Estado
            </button>
        </form>
    </div>

    <!-- TABLA -->
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left border border-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">Nombre del Estado</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse($estados as $estado)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 font-medium text-gray-700">
                        {{ $estado->id_estado }}
                    </td>

                    <td class="px-4 py-3 text-gray-600">
                        {{ $estado->nombre_estado }}
                    </td>

                    <td class="px-4 py-3 text-center space-x-2">
                        
                        <button 
                            data-estado='@json($estado)'
                            onclick="openModal(this)"
                            class="px-3 py-1 bg-yellow-500 text-white rounded-lg text-xs shadow hover:bg-yellow-600 transition">
                            Editar
                        </button>

                        <form action="{{ route('estados.destroy', $estado->id_estado) }}"
                              method="POST"
                              class="inline">
                            @csrf
                            @method('DELETE')

                            <button
                                onclick="return confirm('¿Eliminar este estado?')"
                                class="px-3 py-1 bg-red-500 text-white text-xs rounded-lg shadow hover:bg-red-600 transition">
                                Eliminar
                            </button>
                        </form>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-4 py-3 text-center text-gray-500">
                        No hay estados registrados.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINACIÓN -->
    <div class="mt-6 text-sm">
        {{ $estados->links() }}
    </div>

</div>

<!-- MODAL EDICIÓN -->
<div id="editModal" class="fixed inset-0 hidden items-center justify-center bg-black/5 z-50">
    <div class="bg-white w-96 p-6 rounded-2xl shadow-xl relative">

        <h2 class="text-lg font-semibold text-gray-700 mb-4">
            Editar Estado
        </h2>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')

            @if ($errors->has('nombre_estado') && session('editing'))
                <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-2 rounded-lg mb-4 text-sm">
                    {{ $errors->first('nombre_estado') }}
                </div>
            @endif

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1 text-gray-700">Nombre del Estado</label>
                <input type="text" name="nombre_estado" id="editNombreEstado" required
                    value="{{ session('editing') ? old('nombre_estado') : '' }}"
                    class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none @error('nombre_estado') border-red-500 @enderror">
                @error('nombre_estado') @if(session('editing')) <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @endif @enderror
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button"
                    onclick="closeModal()"
                    class="px-3 py-1 bg-gray-400 text-white text-xs rounded-lg hover:bg-gray-500 transition">
                    Cancelar
                </button>

                <button type="submit"
                    class="px-3 py-1 bg-green-600 text-white text-xs rounded-lg hover:bg-green-700 transition">
                    Guardar
                </button>
            </div>

        </form>

    </div>
</div>

@if(session('editing'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editModal').classList.add('flex');
        document.getElementById('editForm').action = "{{ session('edit_action') }}";
    });
</script>
@endif

<script>
function openModal(button) {
    let estado = JSON.parse(button.getAttribute('data-estado'));

    // Mostrar modal
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editModal').classList.add('flex');

    // Llenar datos
    document.getElementById('editNombreEstado').value = estado.nombre_estado;

    // Actualizar action del formulario
    document.getElementById('editForm').action = '/estados/' + estado.id_estado;
}

function closeModal() {
    document.getElementById('editModal').classList.remove('flex');
    document.getElementById('editModal').classList.add('hidden');
}
</script>

@endsection
