@extends('layouts.admin')

@section('title', 'Tipos de Riego')

@section('content')

<div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800">
            Tipos de Riego
        </h2>
    </div>

    <!-- ALERTA -->
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
        <h3 class="text-lg font-medium text-gray-700 mb-3">Crear Nuevo Tipo de Riego</h3>

        @if ($errors->has('tipo_riego') && !session('editing'))
            <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-2 rounded-lg mb-4 text-sm">
                {{ $errors->first('tipo_riego') }}
            </div>
        @endif

        <form action="{{ route('tipo_riegos.store') }}" method="POST" class="flex items-end gap-4">
            @csrf
            <div class="flex-1">
                <label for="tipo_riego" class="block text-sm font-medium text-gray-600 mb-1">Nombre del Riego</label>
                <input type="text" name="tipo_riego" id="tipo_riego" required
                    placeholder="Ej. Goteo, Aspersión..."
                    value="{{ old('tipo_riego') }}"
                    class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none @error('tipo_riego') border-red-500 @enderror">
                @error('tipo_riego') @if(!session('editing')) <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @endif @enderror
            </div>
            <div class="flex-1">
                <label for="cant_agua_apl" class="block text-sm font-medium text-gray-600 mb-1">Cantidad de Agua</label>
                <input type="text" name="cant_agua_apl" id="cant_agua_apl"
                    placeholder="Ej. 10L, 500ml..."
                    value="{{ old('cant_agua_apl') }}"
                    class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none @error('cant_agua_apl') border-red-500 @enderror">
            </div>
            <button type="submit"
                class="px-4 py-2 bg-green-600 text-white text-sm rounded-lg shadow hover:bg-green-700 transition">
                + Crear Riego
            </button>
        </form>
    </div>

    <!-- TABLA -->
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left border border-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">Tipo de Riego</th>
                    <th class="px-4 py-3">Cantidad de Agua</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 bg-white">
                @foreach($tipoRiegos as $riego)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 font-medium text-gray-700">
                        {{ $riego->id_tipo_riego }}
                    </td>

                    <td class="px-4 py-3 text-gray-600">
                        {{ $riego->tipo_riego }}
                    </td>

                    <td class="px-4 py-3 text-gray-600">
                        {{ $riego->riegos->first()->cant_agua_apl ?? 'N/A' }}
                    </td>


                    <td class="px-4 py-3 text-center space-x-2">
                        
                        <button 
                            data-riego='@json($riego)'
                            onclick="openModal(this)"
                            class="px-2 py-1 bg-yellow-500 text-white rounded text-xs">
                            Editar
                        </button>

                        <form action="{{ route('tipo_riegos.destroy', $riego->id_tipo_riego) }}"
                              method="POST"
                              class="inline">
                            @csrf
                            @method('DELETE')

                            <button
                                onclick="return confirm('¿Eliminar este tipo de riego?')"
                                class="px-3 py-1 bg-red-500 text-white text-xs rounded-lg shadow hover:bg-red-600 transition">
                                Eliminar
                            </button>
                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- PAGINACIÓN -->
    <div class="mt-6 text-sm">
        {{ $tipoRiegos->links() }}
    </div>

</div>

<!-- MODAL EDICIÓN -->
<div id="editModal" class="fixed inset-0 hidden items-center justify-center bg-black/5 z-50">
    <div class="bg-white w-96 p-6 rounded-2xl shadow-xl relative">

        <h2 class="text-lg font-semibold text-gray-700 mb-4">
            Editar Tipo de Riego
        </h2>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')

            @if ($errors->has('tipo_riego') && session('editing'))
                <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-2 rounded-lg mb-4 text-sm">
                    {{ $errors->first('tipo_riego') }}
                </div>
            @endif

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1 text-gray-700">Nombre del Riego</label>
                <input type="text" name="tipo_riego" id="editTipoRiego" required
                    value="{{ session('editing') ? old('tipo_riego') : '' }}"
                    class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none @error('tipo_riego') border-red-500 @enderror">
                @error('tipo_riego') @if(session('editing')) <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @endif @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1 text-gray-700">Cantidad de Agua</label>
                <input type="text" name="cant_agua_apl" id="editCantAgua"
                    value="{{ session('editing') ? old('cant_agua_apl') : '' }}"
                    class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none @error('cant_agua_apl') border-red-500 @enderror">
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

@endsection

<script>
function openModal(button) {
    let riego = JSON.parse(button.getAttribute('data-riego'));

    // Mostrar modal
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editModal').classList.add('flex');

    // Llenar datos
    document.getElementById('editTipoRiego').value = riego.tipo_riego;
    document.getElementById('editCantAgua').value = riego.riegos && riego.riegos.length > 0 ? riego.riegos[0].cant_agua_apl : '';


    // Actualizar action del formulario
    document.getElementById('editForm').action = '/tipo_riegos/' + riego.id_tipo_riego;
}

function closeModal() {
    document.getElementById('editModal').classList.remove('flex');
    document.getElementById('editModal').classList.add('hidden');
}
</script>
