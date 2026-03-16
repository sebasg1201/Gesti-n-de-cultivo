@extends('layouts.admin')

@section('title', 'Gestión de Proveedores')

@section('content')
    <div class="space-y-8">


        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- List Column -->
            <div class="lg:col-span-8 space-y-6">
                <div
                    class="bg-white rounded-3xl shadow-xl border border-emerald-50 overflow-hidden min-h-[600px] flex flex-col">
                    <div
                        class="p-8 border-b border-emerald-50 bg-gray-50/50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h3 class="text-2xl font-black text-emerald-950">Director de Proveedores</h3>
                            <p class="text-xs font-medium text-emerald-600 mt-1">Administre sus contactos de suministro y
                                abastecimiento</p>
                        </div>
                        <button onclick="resetProvForm(); openModal('modalProveedor')"
                            class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-emerald-200 transition-all flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Nuevo Proveedor
                        </button>
                    </div>

                    <!-- Search Bar -->
                    <div class="px-8 py-4 bg-white border-b border-emerald-50">
                        <form action="{{ route('admin.proveedores.index') }}" method="GET" class="relative group">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Buscar por nombre, producto o contacto..."
                                class="w-full pl-12 pr-4 py-3 rounded-2xl border-2 border-emerald-50 focus:border-emerald-500 focus:ring-0 bg-emerald-50/30 text-sm transition-all text-emerald-950">
                            <div
                                class="absolute left-4 top-1/2 -translate-y-1/2 text-emerald-400 group-focus-within:text-emerald-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </form>
                    </div>

                    <div class="flex-1 overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr
                                    class="bg-white text-[10px] font-black text-emerald-400 uppercase tracking-[0.2em] border-b border-emerald-50">
                                    <th class="px-8 py-6">Proveedor</th>
                                    <th class="px-8 py-6">Especialidad</th>
                                    <th class="px-8 py-6">Contacto</th>
                                    <th class="px-8 py-6 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-emerald-50/50">
                                @forelse($proveedores as $prov)
                                    <tr class="hover:bg-emerald-50/30 transition-all group cursor-pointer"
                                        onclick='showProveedorDetails({!! json_encode($prov) !!})'>
                                        <td class="px-8 py-6">
                                            <div class="flex items-center gap-4">
                                                <div
                                                    class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-700 font-black">
                                                    {{ strtoupper(substr($prov->nombre, 0, 1)) }}
                                                </div>
                                                <span class="font-bold text-emerald-950">{{ $prov->nombre }}</span>
                                            </div>
                                        </td>
                                        <td class="px-8 py-6 text-sm text-emerald-700 font-medium">
                                            {{ $prov->producto ?? 'General' }}
                                        </td>
                                        <td class="px-8 py-6 text-sm text-emerald-600 italic">
                                            {{ $prov->contacto ?? 'Sin contacto' }}
                                        </td>
                                        <td class="px-8 py-6 text-right">
                                            <div class="flex items-center justify-end gap-2 ml-auto">
                                                <button onclick='event.stopPropagation(); openEntradaModal({!! json_encode($prov) !!})'
                                                    title="Registrar Entrada"
                                                    class="p-2.5 bg-emerald-50 text-emerald-600 rounded-xl hover:bg-emerald-100 transition-colors border border-emerald-100">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 4v16m8-8H4" />
                                                    </svg>
                                                </button>
                                                <button onclick='event.stopPropagation(); editProveedor({!! json_encode($prov) !!})'
                                                    title="Editar"
                                                    class="p-2.5 bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-100 transition-colors border border-amber-100">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </button>
                                                <form action="{{ route('admin.proveedores.destroy', $prov->id_proveedor) }}"
                                                    method="POST" onsubmit="return confirm('¿Eliminar proveedor?')"
                                                    class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="event.stopPropagation();" title="Eliminar"
                                                        class="p-2.5 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 transition-colors border border-red-100">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7M10 11v6M14 11v6M4 7h16M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-8 py-20 text-center text-emerald-400 italic font-medium">No se
                                            encontraron proveedores...</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="p-8 bg-gray-50/50 border-t border-emerald-50">
                        {{ $proveedores->links() }}
                    </div>
                </div>
            </div>

            <!-- Detail Column (Image Style) -->
            <div class="lg:col-span-4">
                <div id="noSelectionPanel"
                    class="bg-white rounded-3xl shadow-xl border border-emerald-50 p-12 text-center flex flex-col items-center justify-center min-h-[600px] opacity-40">
                    <div
                        class="w-24 h-24 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-200 mb-6">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h4 class="text-lg font-bold text-emerald-950">Seleccione un Proveedor</h4>
                    <p class="text-sm text-emerald-600 mt-2">Haga clic en un registro para ver su historial y detalles de
                        contacto.</p>
                </div>

                <div id="detailPanel"
                    class="hidden bg-white rounded-3xl shadow-2xl border border-emerald-100 overflow-hidden sticky top-8 flex flex-col min-h-[600px]">
                    <!-- Header with Icon and Name -->
                    <div class="bg-gradient-to-br from-emerald-600 to-green-500 p-8 text-white relative">
                        <div class="absolute top-4 right-4 flex gap-2">
                            <button id="btnEditDetail"
                                class="p-2 bg-white/20 hover:bg-white/30 rounded-xl backdrop-blur-md transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                            <button onclick="closeDetails()"
                                class="p-2 bg-white/20 hover:bg-white/30 rounded-xl backdrop-blur-md transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-emerald-600 text-2xl font-black shadow-xl mb-4"
                            id="detailInitial">
                            --
                        </div>
                        <h3 class="text-xl font-black tracking-tight" id="detailName">Cargando...</h3>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="bg-white/20 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider"
                                id="detailCategory">Categoría</span>
                            <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                        </div>
                    </div>

                    <!-- Tabs Navigation -->
                    <div class="flex border-b border-emerald-50">
                        <button onclick="switchTab('detalles')" id="tab-detalles"
                            class="flex-1 py-4 text-xs font-bold uppercase tracking-widest text-emerald-600 border-b-2 border-emerald-600 bg-emerald-50/30">Detalles</button>
                        <button onclick="switchTab('historial')" id="tab-historial"
                            class="flex-1 py-4 text-xs font-bold uppercase tracking-widest text-gray-400 border-b-2 border-transparent hover:bg-gray-50">Historial</button>
                    </div>

                    <!-- Tab: Details -->
                    <div id="content-detalles" class="p-8 space-y-6 flex-1">
                        <div class="space-y-4">
                            <label
                                class="text-[10px] font-black text-emerald-400 uppercase tracking-widest block">Información
                                de Contacto</label>
                            <div
                                class="flex items-center gap-4 p-4 bg-emerald-50/50 rounded-2xl border border-emerald-100/50">
                                <div class="p-3 bg-white rounded-xl text-emerald-600 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[10px] text-emerald-400 font-bold uppercase">Contacto Directo</p>
                                    <p class="text-sm font-bold text-emerald-950" id="detailContact">--</p>
                                </div>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-emerald-50 flex gap-4">
                            <button onclick="openEntradaModalFromCurrent()"
                                class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-emerald-200 transition-all transform hover:-translate-y-1 text-sm">
                                Registrar Despacho
                            </button>
                        </div>
                    </div>

                    <!-- Tab: History -->
                    <div id="content-historial" class="hidden flex-1 flex flex-col">
                        <div class="p-8 pb-0">
                            <label
                                class="text-[10px] font-black text-emerald-400 uppercase tracking-widest block mb-4">Últimas
                                Entradas</label>
                        </div>
                        <div class="flex-1 overflow-y-auto px-8 pb-8 space-y-4 pt-2" id="historyList">
                            <!-- History items AJAX -->
                            <div class="text-center py-10 opacity-30 italic text-sm">Cargando historial...</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL: CREAR/EDITAR PROVEEDOR -->
    <div id="modalProveedor"
        class="hidden fixed inset-0 bg-emerald-950/80 backdrop-blur-sm z-[100] flex items-center justify-center p-4">
        <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-md overflow-hidden animate-in zoom-in-95 duration-300">
            <div class="bg-emerald-600 p-8 text-white">
                <h3 class="text-2xl font-black tracking-tight" id="modalProvTitle">Nuevo Proveedor</h3>
                <p class="text-emerald-100 text-xs mt-1">Ingrese los datos básicos del remitente.</p>
            </div>
            <form id="formProveedor" method="POST" action="{{ route('admin.proveedores.store') }}" class="p-8 space-y-6">
                @csrf
                <div id="provMethod"></div>
                <div>
                    <label class="block text-xs font-bold text-emerald-700 uppercase tracking-wider mb-2">Nombre de la
                        Empresa / Persona</label>
                    <input type="text" name="nombre" id="inProvNombre" required
                        class="w-full px-4 py-3 rounded-2xl border-emerald-100 focus:border-emerald-500 focus:ring-emerald-500 bg-emerald-50/30 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-emerald-700 uppercase tracking-wider mb-2">Categoría (Ej:
                        Semillas, Químicos)</label>
                    <input type="text" name="producto" id="inProvProducto"
                        class="w-full px-4 py-3 rounded-2xl border-emerald-100 focus:border-emerald-500 focus:ring-emerald-500 bg-emerald-50/30 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-emerald-700 uppercase tracking-wider mb-2">Contacto
                        (Teléfono/Correo)</label>
                    <input type="text" name="contacto" id="inProvContacto"
                        class="w-full px-4 py-3 rounded-2xl border-emerald-100 focus:border-emerald-500 focus:ring-emerald-500 bg-emerald-50/30 text-sm">
                </div>
                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closeModal('modalProveedor')"
                        class="px-6 py-4 bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold rounded-2xl transition-all">Cancelar</button>
                    <button type="submit"
                        class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-emerald-200 transition-all">Guardar
                        Proveedor</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: REGISTRAR ENTRADA -->
    <div id="modalEntrada"
        class="hidden fixed inset-0 bg-emerald-950/80 backdrop-blur-sm z-[100] flex items-center justify-center p-4">
        <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-lg overflow-hidden animate-in zoom-in-95 duration-300">
            <div class="bg-gradient-to-r from-emerald-600 to-green-600 p-8 text-white flex justify-between items-center">
                <div>
                    <h3 class="text-2xl font-black tracking-tight">Registrar Despacho</h3>
                    <p class="text-emerald-100 text-xs mt-1" id="entradaProvName">Proveedor seleccionado</p>
                </div>
                <div class="bg-white/20 p-3 rounded-2xl">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>
            <form id="formEntrada" method="POST" action="" class="p-8 space-y-6">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-emerald-700 uppercase tracking-wider mb-2">Tipo de
                            Item</label>
                        <select name="tipo_item" id="tipoSelectItem" onchange="toggleItemSelect()" required
                            class="w-full px-4 py-3 rounded-2xl border-emerald-100 focus:border-emerald-500 focus:ring-emerald-500 bg-emerald-50/30 text-sm">
                            <option value="insumo">Insumo General</option>
                            <option value="semilla">Semilla / Variedad</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-emerald-700 uppercase tracking-wider mb-2">Producto de
                            Inventario</label>
                        <div id="containerInsumo" class="flex gap-2">
                            <select name="id_item_insumo" id="selectInsumo"
                                class="w-full px-4 py-3 rounded-2xl border-emerald-100 focus:border-emerald-500 focus:ring-emerald-500 bg-emerald-50/30 text-sm">
                                <option value="">-- Seleccionar --</option>
                                @foreach($insumosParaEntrada as $ins)
                                    <option value="{{ $ins->ID_insumo }}">{{ $ins->Nombre }}</option>
                                @endforeach
                            </select>
                            <a href="{{ route('insumos.index') }}" title="Ir a crear nuevo Insumo" class="bg-emerald-100 hover:bg-emerald-200 text-emerald-700 flex items-center justify-center p-3 rounded-2xl transition-colors shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </a>
                        </div>
                        <div id="containerSemilla" class="hidden flex gap-2">
                            <select name="id_item_semilla" id="selectSemilla"
                                class="w-full px-4 py-3 rounded-2xl border-emerald-100 focus:border-emerald-500 focus:ring-emerald-500 bg-emerald-50/30 text-sm">
                                <option value="">-- Seleccionar --</option>
                                @foreach($semillasParaEntrada as $sem)
                                    <option value="{{ $sem->id_semilla }}">{{ $sem->nombre_semilla }}</option>
                                @endforeach
                            </select>
                            <a href="{{ route('tipo_semillas.index') }}" title="Ir a crear nueva Semilla" class="bg-emerald-100 hover:bg-emerald-200 text-emerald-700 flex items-center justify-center p-3 rounded-2xl transition-colors shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </a>
                        </div>
                        <!-- Hidden input to unify both selects in controller -->
                        <input type="hidden" name="id_item" id="hiddenIdItem">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-emerald-700 uppercase tracking-wider mb-2">Cantidad
                            Recibida</label>
                        <div class="relative">
                            <input type="number" name="cantidad_recibida" step="0.01" required placeholder="0.00"
                                class="w-full pl-4 pr-12 py-3 rounded-2xl border-emerald-100 focus:border-emerald-500 focus:ring-emerald-500 bg-emerald-50/30 text-sm">
                            <span
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-bold text-emerald-400">UNID</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-emerald-700 uppercase tracking-wider mb-2">Precio
                            Unitario</label>
                        <div class="relative">
                            <input type="number" name="precio_unitario" step="0.01" placeholder="0.00"
                                class="w-full pl-8 pr-4 py-3 rounded-2xl border-emerald-100 focus:border-emerald-500 focus:ring-emerald-500 bg-emerald-50/30 text-sm">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-emerald-400 font-bold">$</span>
                        </div>
                    </div>
                </div>

                <div id="vencimientoGroup">
                    <label class="block text-xs font-bold text-emerald-700 uppercase tracking-wider mb-2">Fecha de
                        Vencimiento <span class="text-[10px] font-normal lowercase">(Opcional)</span></label>
                    <input type="date" name="fecha_vencimiento"
                        class="w-full px-4 py-3 rounded-2xl border-emerald-100 focus:border-emerald-500 focus:ring-emerald-500 bg-emerald-50/30 text-sm">
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closeModal('modalEntrada')"
                        class="px-6 py-4 bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold rounded-2xl transition-all">Cancelar</button>
                    <button type="submit"
                        class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-emerald-200 transition-all transform hover:-translate-y-1">Confirmar
                        Entrada</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            let currentProveedor = null;

            function openModal(id) {
                document.getElementById(id).classList.remove('hidden');
            }

            function closeModal(id) {
                document.getElementById(id).classList.add('hidden');
            }

            function toggleItemSelect() {
                const type = document.getElementById('tipoSelectItem').value;
                const groupVencimiento = document.getElementById('vencimientoGroup');

                if (type === 'insumo') {
                    document.getElementById('containerInsumo').classList.remove('hidden');
                    document.getElementById('containerSemilla').classList.add('hidden');
                    groupVencimiento.classList.remove('hidden');
                } else {
                    document.getElementById('containerInsumo').classList.add('hidden');
                    document.getElementById('containerSemilla').classList.remove('hidden');
                    groupVencimiento.classList.add('hidden');
                }
            }

            // Capture the correct ID before submitting entry form
            document.getElementById('formEntrada').addEventListener('submit', function (e) {
                const type = document.getElementById('tipoSelectItem').value;
                if (type === 'insumo') {
                    document.getElementById('hiddenIdItem').value = document.getElementById('selectInsumo').value;
                } else {
                    document.getElementById('hiddenIdItem').value = document.getElementById('selectSemilla').value;
                }
            });

            function showProveedorDetails(prov) {
                console.log("Mostrando detalles para:", prov);
                currentProveedor = prov;
                document.getElementById('noSelectionPanel').classList.add('hidden');
                const detailPanel = document.getElementById('detailPanel');
                detailPanel.classList.remove('hidden');

                // Populate header
                document.getElementById('detailInitial').innerText = prov.nombre ? prov.nombre.charAt(0).toUpperCase() : '?';
                document.getElementById('detailName').innerText = prov.nombre || 'Sin nombre';
                document.getElementById('detailCategory').innerText = prov.producto || 'Proveedor General';
                document.getElementById('detailContact').innerText = prov.contacto || 'Sin contacto registrado';

                // Config Edit Button
                document.getElementById('btnEditDetail').onclick = () => editProveedor(prov);

                // Load History (if tab is active or just for next time)
                loadHistory(prov.id_proveedor);

                // Scroll to panel on small screens
                if (window.innerWidth < 1024) {
                    detailPanel.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }

            function closeDetails() {
                document.getElementById('detailPanel').classList.add('hidden');
                document.getElementById('noSelectionPanel').classList.remove('hidden');
                currentProveedor = null;
            }

            function switchTab(tab) {
                const tabs = ['detalles', 'historial'];
                tabs.forEach(t => {
                    const btn = document.getElementById('tab-' + t);
                    const content = document.getElementById('content-' + t);
                    if (t === tab) {
                        btn.classList.add('border-emerald-600', 'text-emerald-600', 'bg-emerald-50/30');
                        btn.classList.remove('text-gray-400', 'border-transparent');
                        content.classList.remove('hidden');
                    } else {
                        btn.classList.remove('border-emerald-600', 'text-emerald-600', 'bg-emerald-50/30');
                        btn.classList.add('text-gray-400', 'border-transparent');
                        content.classList.add('hidden');
                    }
                });
            }

            function loadHistory(id) {
                const listContainer = document.getElementById('historyList');
                listContainer.innerHTML = '<div class="text-center py-10 opacity-30 italic text-sm">Cargando historial...</div>';

                fetch(`/admin/proveedores/${id}/historial`)
                    .then(res => res.json())
                    .then(data => {
                        listContainer.innerHTML = '';
                        if (data.length === 0) {
                            listContainer.innerHTML = '<div class="text-center py-10 opacity-30 italic text-sm">Sin historial de entradas.</div>';
                            return;
                        }
                        data.forEach(item => {
                            const date = new Date(item.fecha_entrada).toLocaleDateString('es-ES', { day: 'numeric', month: 'short', year: 'numeric' });
                            const isSemilla = !!item.semilla;
                            const nombre = isSemilla ? item.semilla.nombre_semilla : (item.insumo ? item.insumo.Nombre : 'Desconocido');

                            const div = document.createElement('div');
                            div.className = "p-4 bg-emerald-50 rounded-2xl border border-emerald-100 flex justify-between items-center group/item hover:bg-emerald-100 transition-colors";
                            div.innerHTML = `
                                                <div>
                                                    <p class="text-xs font-bold text-emerald-950">${nombre}</p>
                                                    <p class="text-[10px] text-emerald-500 font-medium">${date} • ${isSemilla ? 'Semilla' : 'Insumo'}</p>
                                                </div>
                                                <div class="text-right">
                                                    <p class="text-sm font-black text-emerald-600">+${parseFloat(item.cantidad_recibida).toFixed(1)}</p>
                                                    ${item.precio_unitario ? `<p class="text-[9px] font-bold text-gray-400">$${parseFloat(item.precio_unitario).toFixed(2)}/u</p>` : ''}
                                                </div>
                                            `;
                            listContainer.appendChild(div);
                        });
                    });
            }

            function openEntradaModal(prov) {
                currentProveedor = prov;
                document.getElementById('entradaProvName').innerText = prov.nombre;
                document.getElementById('formEntrada').action = `/admin/proveedores/${prov.id_proveedor}/entradas`;
                openModal('modalEntrada');
            }

            function openEntradaModalFromCurrent() {
                if (currentProveedor) openEntradaModal(currentProveedor);
            }

            function editProveedor(prov) {
                resetProvForm();
                document.getElementById('modalProvTitle').innerText = 'Editar Proveedor';
                document.getElementById('inProvNombre').value = prov.nombre;
                document.getElementById('inProvProducto').value = prov.producto || '';
                document.getElementById('inProvContacto').value = prov.contacto || '';

                const form = document.getElementById('formProveedor');
                form.action = `/admin/proveedores/${prov.id_proveedor}`;

                // Add _method PUT for Laravel spoofing
                if (!form.querySelector('input[name="_method"]')) {
                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'PUT';
                    form.appendChild(methodInput);
                }

                openModal('modalProveedor');
            }

            function resetProvForm() {
                document.getElementById('modalProvTitle').innerText = 'Nuevo Proveedor';
                const form = document.getElementById('formProveedor');
                form.action = "{{ route('admin.proveedores.store') }}";
                form.reset();
                const mInput = form.querySelector('input[name="_method"]');
                if (mInput) mInput.remove();
            }
        </script>
    @endpush
@endsection