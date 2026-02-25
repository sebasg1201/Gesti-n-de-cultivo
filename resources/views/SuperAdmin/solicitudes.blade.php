@extends('layouts.barra_lateral')

@section('content')
    <div class="px-4 pt-6">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Solicitudes de Compra</h2>
            <button onclick="document.getElementById('exportSolicitudesModal').classList.remove('hidden')"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 shadow-sm transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
                Exportar Reporte
            </button>
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
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $solicitud->empresa->nombre_empresa ?? 'N/A' }}
                                    </div>
                                    <div class="text-sm text-gray-500">NIT: {{ $solicitud->id_empresa }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $solicitud->empresa->nombre_repre_legal ?? 'N/A' }}
                                    </div>
                                    <div class="text-sm text-gray-500">{{ $solicitud->empresa->correo ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $solicitud->tipoLicencia->nombre_licencia ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-medium text-gray-900">
                                        {{ \Carbon\Carbon::parse($solicitud->fecha_solicitud)->timezone('America/Bogota')->format('d M, Y') }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($solicitud->fecha_solicitud)->timezone('America/Bogota')->locale('es')->diffForHumans() }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                                                                                                                               {{ $solicitud->id_estado == 1 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $solicitud->estado->nombre_estado ?? 'Desconocido' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <button onclick="openModal('{{ $solicitud->id_solicitud }}')"
                                            class="text-green-600 hover:text-green-900 font-semibold bg-green-50 px-3 py-1 rounded-lg cursor-pointer">
                                            Ver Detalle
                                        </button>
                                    </div>
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
    <div class="flex justify-center mt-6">
        {{ $solicitudes->withQueryString()->links() }}
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
                            <div class="flex justify-between items-start">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Detalle de Solicitud de Compra
                                </h3>

                                <!-- BOTÓN X ARRIBA -->
                                <button onclick="closeModal()"
                                    class="text-gray-400 hover:text-gray-600 transition cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6" id="modalContent">
                                <!-- Dynamic content will be loaded here via JS -->
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-gray-50 px-4 py-3 sm:px-6 flex flex-wrap items-center justify-between gap-2 border-t border-gray-200">
                    {{-- Botón Reportar (Eliminar) --}}
                    <form id="formReportar" action="" method="POST"
                        onsubmit="return confirm('¿Estás seguro? Esta acción eliminará la solicitud y el registro de la empresa. No se puede deshacer.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" id="btnReportar"
                            class="inline-flex items-center gap-1 bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg text-sm transition cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                            </svg>
                            Reportar
                        </button>
                    </form>

                    <div class="flex gap-2">
                        {{-- Botón Aprobar: visible solo si está pendiente --}}
                        <form id="formAprobar" action="" method="POST">
                            @csrf
                            @method('PUT')
                            <button id="btnAprobar" type="submit"
                                class="hidden inline-flex items-center gap-1 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg text-sm transition cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                                Aprobar
                            </button>
                        </form>

                        {{-- Badge Aprobada: visible solo si ya fue aprobada --}}
                        <span id="badgeAprobada"
                            class="hidden inline-flex items-center gap-1 bg-green-100 text-green-700 font-semibold py-2 px-4 rounded-lg text-sm border border-green-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            Aprobada
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden element to pass data to JS without syntax errors -->
    <div id="solicitudes-data" data-json="{{ json_encode($solicitudes->items()) }}" class="hidden"></div>

    <script>
        // Retrieve data safely from DOM
        const solicitudesData = document.getElementById('solicitudes-data').getAttribute('data-json');
        const solicitudes = solicitudesData ? JSON.parse(solicitudesData) : [];
        const baseUrl = "{{ url('/dashboard/solicitudes') }}";

        function openModal(id) {
            const solicitud = solicitudes.find(s => s.id_solicitud == id);
            if (!solicitud) return;

            const modal = document.getElementById('modalDetalle');
            const content = document.getElementById('modalContent');
            const empresa = solicitud.empresa || {};
            const fullComprobanteUrl = "{{ asset('') }}" + solicitud.comprobante_pago;

            // -- Construir contenido del modal --
            content.innerHTML = `
                                                                <div class="space-y-4">
                                                                    <div>
                                                                        <h4 class="font-bold text-gray-700">Información de la Empresa</h4>
                                                                        <div class="mt-2 text-sm text-gray-600 space-y-1">
                                                                            <p><span class="font-semibold">Empresa:</span> ${empresa.nombre_empresa || 'N/A'}</p>
                                                                            <p><span class="font-semibold">NIT:</span> ${solicitud.id_empresa || 'N/A'}</p>
                                                                            <p><span class="font-semibold">Representante:</span> ${empresa.nombre_repre_legal || 'N/A'}</p>
                                                                            <p><span class="font-semibold">Teléfono:</span> ${empresa.telefono || 'N/A'}</p>
                                                                            <p><span class="font-semibold">Correo:</span> ${empresa.correo || 'N/A'}</p>
                                                                            <p><span class="font-semibold">Dirección:</span> ${empresa.direccion || 'N/A'}</p>
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
                                                                        ${solicitud.comprobante_pago
                    ? `<img src="${fullComprobanteUrl}" alt="Comprobante" class="max-w-full max-h-full object-contain">`
                    : `<span class="text-gray-400 italic text-sm">Sin comprobante de pago (registro manual)</span>`
                }
                                                                    </div>
                                                                    ${solicitud.comprobante_pago
                    ? `<a href="${fullComprobanteUrl}" target="_blank" class="mt-2 text-sm text-green-600 text-center">Ver imagen original</a>`
                    : ''
                }
                                                                </div>
                                                            `;

            // -- Configurar formulario Reportar (DELETE) --
            const formReportar = document.getElementById('formReportar');
            formReportar.action = baseUrl + '/' + solicitud.id_solicitud;

            // -- Configurar formulario Aprobar (PUT) --
            const formAprobar = document.getElementById('formAprobar');
            const btnAprobar = document.getElementById('btnAprobar');
            const badgeAprobada = document.getElementById('badgeAprobada');
            const btnReportar = document.getElementById('btnReportar');

            if (solicitud.id_estado == 1) {
                formAprobar.action = baseUrl + '/' + solicitud.id_solicitud + '/aprobado';
                btnAprobar.style.display = 'inline-flex';
                badgeAprobada.style.display = 'none';

                // Habilitar botón Reportar
                btnReportar.disabled = false;
                btnReportar.classList.remove('opacity-50', 'cursor-not-allowed', 'hover:bg-red-600');
                btnReportar.classList.add('hover:bg-red-700', 'cursor-pointer');
            } else {
                btnAprobar.style.display = 'none';
                badgeAprobada.style.display = 'inline-flex';

                // Deshabilitar botón Reportar
                btnReportar.disabled = true;
                btnReportar.classList.add('opacity-50', 'cursor-not-allowed', 'hover:bg-red-600');
                btnReportar.classList.remove('hover:bg-red-700', 'cursor-pointer');
            }

            modal.classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('modalDetalle').classList.add('hidden');
        }
    </script>
    <!-- EXPORT SOLICITUDES MODAL -->
    <div id="exportSolicitudesModal" class="fixed inset-0 z-[9999] hidden" aria-modal="true">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/50"
            onclick="document.getElementById('exportSolicitudesModal').classList.add('hidden')"></div>
        <div class="relative flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-sm z-10">
                <!-- Header -->
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                        <h3 class="text-base font-semibold text-gray-900">Descargar Reporte de Solicitudes</h3>
                    </div>
                    <button onclick="document.getElementById('exportSolicitudesModal').classList.add('hidden')"
                        class="text-gray-400 hover:text-gray-600 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <!-- Body -->
                <form method="GET" action="{{ route('solicitudes.exportar') }}">
                    <div class="px-6 py-5 space-y-4">
                        <p class="text-sm text-gray-500">Selecciona el mes y año para filtrar el reporte de solicitudes de
                            compra.</p>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mes</label>
                            <select name="month"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500">
                                <option value="">Todo el año</option>
                                @foreach(range(1, 12) as $m)
                                    <option value="{{ $m }}" {{ now()->month == $m ? 'selected' : '' }}>
                                        {{ ucfirst(\Carbon\Carbon::createFromDate(2024, (int) $m, 1)->locale('es')->monthName) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Año</label>
                            <select name="year"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500">
                                @foreach(range(now()->year, 2024) as $y)
                                    <option value="{{ $y }}" {{ now()->year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- Footer -->
                    <div class="px-6 py-4 bg-gray-50 rounded-b-xl flex justify-end gap-3 border-t border-gray-200">
                        <button type="button"
                            onclick="document.getElementById('exportSolicitudesModal').classList.add('hidden')"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">Cancelar</button>
                        <button type="submit"
                            class="flex items-center gap-2 px-4 py-2 text-sm font-bold text-white bg-green-600 hover:bg-green-700 rounded-lg transition cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                            Descargar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection