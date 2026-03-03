@extends('layouts.admin')

@section('title', 'Tipos de Cosecha')

@section('content')

    <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100">

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">
                Tipos de Cosecha
            </h2>

            <a href="{{ route('tipo_cosechas.create') }}"
                class="px-4 py-2 bg-green-600 text-white text-sm rounded-lg shadow hover:bg-green-700 transition">
                + Nueva Cosecha
            </a>
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

        <!-- TABLA -->
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-4 py-3">Tiempo</th>
                        <th class="px-4 py-3">Terreno</th>
                        <th class="px-4 py-3">Semilla</th>
                        <th class="px-4 py-3">Riego</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach($cosechas as $cosecha)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 font-medium text-gray-700">
                                {{ $cosecha->tiempo }}
                            </td>

                            <td class="px-4 py-3 text-gray-600">
                                {{ $cosecha->terreno }}
                            </td>

                            <td class="px-4 py-3 text-gray-600">
                                {{ $cosecha->semilla->Tipo_semilla ?? 'N/A' }}
                            </td>

                            <td class="px-4 py-3 text-gray-600">
                                {{ $cosecha->riego->tipo_riego ?? 'N/A' }}
                            </td>

                            <td class="px-4 py-3 text-center space-x-2">

                                <button data-cosecha='@json($cosecha)' onclick="openModal(this)"
                                    class="px-2 py-1 bg-yellow-500 text-white rounded text-xs">
                                    Editar
                                </button>

                                <form action="{{ route('tipo_cosechas.destroy', $cosecha->id_tipo_cosecha) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('¿Eliminar esta cosecha?')"
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
            {{ $cosechas->links() }}
        </div>

    </div>




    <div id="editModal" class="fixed inset-0 hidden items-center justify-center">


        <div class="bg-white w-96 p-6 rounded-2xl shadow-xl relative">

            <h2 class="text-lg font-semibold text-gray-700 mb-4">
                Editar Tipo de Cosecha
            </h2>

            <form id="editForm" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Tiempo</label>
                    <input type="datetime" name="tiempo" id="editTiempo"
                        class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none">
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Terreno</label>
                    <input type="text" name="terreno" id="editTerreno"
                        class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none">
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Tipo de Semilla</label>
                    <select name="id_semilla" id="editSemilla"
                        class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none"
                        required>
                        <option value="">-- Seleccione Semilla --</option>
                        @foreach($tipoSemillas as $semilla)
                            <option value="{{ $semilla->id_semilla }}">
                                {{ $semilla->Tipo_semilla }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Tipo de Riego</label>
                    <select name="id_tipo_riego" id="editRiego"
                        class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-2 focus:ring-green-500 focus:outline-none"
                        required>
                        <option value="">-- Seleccione Riego --</option>
                        @foreach($tipoRiegos as $riego)
                            <option value="{{ $riego->id_tipo_riego }}">{{ $riego->tipo_riego }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal()"
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




    </div>

@endsection

<script>
    function openModal(button) {

        let cosecha = JSON.parse(button.getAttribute('data-cosecha'));

        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editModal').classList.add('flex');

        document.getElementById('editTiempo').value = cosecha.tiempo;
        document.getElementById('editTerreno').value = cosecha.terreno;
        document.getElementById('editSemilla').value = cosecha.id_semilla;
        document.getElementById('editRiego').value = cosecha.id_tipo_riego;


        document.getElementById('editForm').action = '/tipo_cosechas/' + cosecha.id_tipo_cosecha;
    }

    function closeModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
</script>