@extends('layouts.barra_lateral')

@section('content')
<div class="px-4 pt-6">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Solicitudes de Compra</h2>
        {{-- Add filter or search if needed later --}}
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Empresa
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Representante
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Plan
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Fecha
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($solicitudes as $solicitud)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $solicitud->nombre_empresa }}</div>
                            <div class="text-sm text-gray-500">{{ $solicitud->nit_empresa }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $solicitud->nombre_repre_legal }}</div>
                            <div class="text-sm text-gray-500">{{ $solicitud->correo }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $solicitud->tipoLicencia->nombre_licencia ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $solicitud->fecha_solicitud }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                                            {{ $solicitud->id_estado == 1 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                {{ $solicitud->estado->nombre_estado ?? 'Desconocido' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button onclick="openModal('{{ $solicitud->id_solicitud }}')"
                                class="text-green-600 hover:text-green-900 font-semibold bg-green-50 px-3 py-1 rounded-lg cursor-pointer">
                                Ver Detalle
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                            No hay solicitudes de compra registradas.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- MODAL --}}
<div id="modalDetalle" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">



        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Detalle de Solicitud de Compra
                        </h3>

                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6" id="modalContent">
                            <!-- Dynamic content will be loaded here via JS -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm cursor-pointer"
                    onclick="closeModal()">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Hidden element to pass data to JS without syntax errors -->
<div id="solicitudes-data" data-json="{{ json_encode($solicitudes) }}" class="hidden"></div>

<script>
    // Retrieve data safely from DOM
    const solicitudesData = document.getElementById('solicitudes-data').getAttribute('data-json');
    const solicitudes = solicitudesData ? JSON.parse(solicitudesData) : [];

    function openModal(id) {
        const solicitud = solicitudes.find(s => s.id_solicitud == id);
        if (!solicitud) return;

        const modal = document.getElementById('modalDetalle');
        const content = document.getElementById('modalContent');

        // Build content HTML
        const comprobanteUrl = solicitud.comprobante_pago ? `/cooperativa_agricola/public/${solicitud.comprobante_pago}` : ''; // Adjust base URL if needed
        // NOTE: Using direct public asset path. Might need asset() helper equivalent logic in JS or pass full URL from PHP.
        // Let's assume asset() helper in PHP:

        const fullComprobanteUrl = "{{ asset('') }}" + solicitud.comprobante_pago;


        content.innerHTML = `
                                    <div class="space-y-4">
                                        <div>
                                            <h4 class="font-bold text-gray-700">Información de la Empresa</h4>
                                            <div class="mt-2 text-sm text-gray-600 space-y-1">
                                                <p><span class="font-semibold">Empresa:</span> ${solicitud.nombre_empresa}</p>
                                                <p><span class="font-semibold">NIT:</span> ${solicitud.nit_empresa}</p>
                                                <p><span class="font-semibold">Representante:</span> ${solicitud.nombre_repre_legal}</p>
                                                <p><span class="font-semibold">Teléfono:</span> ${solicitud.telefono}</p>
                                                <p><span class="font-semibold">Correo:</span> ${solicitud.correo}</p>
                                                <p><span class="font-semibold">Dirección:</span> ${solicitud.direccion}</p>
                                            </div>
                                        </div>

                                        <div>
                                            <h4 class="font-bold text-gray-700">Detalles de la Licencia</h4>
                                            <div class="mt-2 text-sm text-gray-600 space-y-1">
                                                 <p><span class="font-semibold">Plan:</span> ${solicitud.tipo_licencia ? solicitud.tipo_licencia.nombre_licencia : 'N/A'}</p>
                                                 <p><span class="font-semibold">Precio:</span> $${solicitud.tipo_licencia ? new Intl.NumberFormat().format(solicitud.tipo_licencia.precio) : '0'}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex flex-col">
                                        <h4 class="font-bold text-gray-700 mb-2">Comprobante de Pago</h4>
                                        <div class="border rounded-lg overflow-hidden bg-gray-50 flex items-center justify-center p-2 h-64">
                                             <img src="${fullComprobanteUrl}" alt="Comprobante" class="max-w-full max-h-full object-contain">
                                        </div>
                                         <a href="${fullComprobanteUrl}" target="_blank" class="mt-2 text-sm text-blue-600 hover:underline text-center">Ver imagen original</a>
                                    </div>

                                    <div class="mt-4 pt-4 border-t border-gray-200">
                                        ${solicitud.id_estado == 1 ? `
                                            <form action="{{ url('/dashboard/solicitudes') }}/${solicitud.id_solicitud}/visto" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition cursor-pointer">
                                                    Marcar como Visto
                                                </button>
                                            </form>
                                        ` : `
                                            <div class="text-center text-gray-500 font-medium">
                                                <span class="inline-flex items-center">
                                                    <svg class="w-5 h-5 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    Solicitud ya revisada
                                                </span>
                                            </div>
                                        `}
                                    </div>
                                `;

        modal.classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modalDetalle').classList.add('hidden');
    }
</script>
@endsection