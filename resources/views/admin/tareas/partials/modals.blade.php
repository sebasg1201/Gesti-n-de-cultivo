{{-- Modal Riego --}}
<div id="modalRiego" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeModal('modalRiego')"></div>
        
        <div class="relative bg-white rounded-[2.5rem] shadow-2xl w-full max-w-2xl overflow-hidden transform transition-all">
            <div class="bg-blue-600 p-8 text-white relative">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                <h2 class="text-3xl font-black relative z-10">Programar Riego</h2>
                <p class="text-blue-100 font-medium relative z-10">Asigna una nueva labor de hidratación.</p>
            </div>
            
            <form action="{{ route('admin.tareas.store.riego') }}" method="POST" class="p-8 space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Lote de Cosecha</label>
                        <select name="id_cosecha" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-5 focus:outline-none focus:border-blue-500 transition-all font-bold text-gray-700">
                            @foreach($cosechas as $c)
                                <option value="{{ $c->id_cosecha }}">Lote #{{ $c->id_cosecha }} - {{ $c->semilla?->nombre_semilla ?? 'N/A' }} ({{ $c->terreno?->nombre ?? 'N/A' }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Trabajador Asignado</label>
                        <select name="documento_trabajador" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-5 focus:outline-none focus:border-blue-500 transition-all font-bold text-gray-700">
                            @foreach($trabajadores as $t)
                                <option value="{{ $t->documento }}">{{ $t->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Tipo de Riego</label>
                        <select name="id_tipo_riego" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-5 focus:outline-none focus:border-blue-500 transition-all font-bold text-gray-700">
                            @foreach($tiposRiego as $tr)
                                <option value="{{ $tr->id_tipo_riego }}">{{ $tr->tipo_riego }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Cant. Agua (Lts)</label>
                        <input type="number" step="0.01" name="cant_agua_apl" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-5 focus:outline-none focus:border-blue-500 transition-all font-bold text-gray-700">
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Fecha Programada</label>
                    <input type="date" name="fecha_programada" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-5 focus:outline-none focus:border-blue-500 transition-all font-bold text-gray-700">
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Observaciones</label>
                    <textarea name="observaciones" rows="3" class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-5 focus:outline-none focus:border-blue-500 transition-all font-bold text-gray-700" placeholder="Ej: Riego profundo pre-cosecha..."></textarea>
                </div>
                
                <div class="pt-4 flex gap-3">
                    <button type="button" onclick="closeModal('modalRiego')" class="flex-1 py-4 rounded-2xl font-bold bg-gray-100 text-gray-600 hover:bg-gray-200 transition-all">Cancelar</button>
                    <button type="submit" class="flex-1 py-4 rounded-2xl font-bold bg-blue-600 text-white hover:bg-blue-700 transition-all shadow-lg shadow-blue-200">Asignar Tarea</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Insumo --}}
<div id="modalInsumo" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeModal('modalInsumo')"></div>
        
        <div class="relative bg-white rounded-[2.5rem] shadow-2xl w-full max-w-2xl overflow-hidden transform transition-all">
            <div class="bg-purple-600 p-8 text-white">
                <h2 class="text-3xl font-black">Asignar Insumo</h2>
                <p class="text-purple-100 font-medium">Programa la aplicación de productos.</p>
            </div>
            
            <form action="{{ route('admin.tareas.store.insumo') }}" method="POST" class="p-8 space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Lote de Cosecha</label>
                        <select name="id_cosecha" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-5 focus:outline-none focus:border-purple-500 transition-all font-bold text-gray-700">
                            @foreach($cosechas as $c)
                                <option value="{{ $c->id_cosecha }}">Lote #{{ $c->id_cosecha }} - {{ $c->semilla?->nombre_semilla ?? 'N/A' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Trabajador</label>
                        <select name="documento_trabajador" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-5 focus:outline-none focus:border-purple-500 transition-all font-bold text-gray-700">
                            @foreach($trabajadores as $t)
                                <option value="{{ $t->documento }}">{{ $t->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Producto / Insumo</label>
                        <select name="id_insumo" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-5 focus:outline-none focus:border-purple-500 transition-all font-bold text-gray-700">
                            @foreach($catalogoInsumos as $ci)
                                <option value="{{ $ci->ID_insumo }}">{{ $ci->Nombre }} (Stock: {{ $ci->stock_actual }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Cantidad a Usar</label>
                        <input type="number" step="0.01" name="cantidad_usada" value="1" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-5 focus:outline-none focus:border-purple-500 transition-all font-bold text-gray-700">
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Fecha Programada</label>
                    <input type="date" name="fecha_programada" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-5 focus:outline-none focus:border-purple-500 transition-all font-bold text-gray-700">
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Observaciones / Instrucciones</label>
                    <textarea name="observaciones" rows="3" class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-5 focus:outline-none focus:border-purple-500 transition-all font-bold text-gray-700" placeholder="Ej: Aplicar en la base de la planta, evitar contacto con las hojas..."></textarea>
                </div>
                
                <div class="pt-4 flex gap-3">
                    <button type="button" onclick="closeModal('modalInsumo')" class="flex-1 py-4 rounded-2xl font-bold bg-gray-100 text-gray-600 hover:bg-gray-200 transition-all">Cancelar</button>
                    <button type="submit" class="flex-1 py-4 rounded-2xl font-bold bg-purple-600 text-white hover:bg-purple-700 transition-all shadow-lg shadow-purple-200">Guardar Asignación</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal General --}}
<div id="modalGeneral" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeModal('modalGeneral')"></div>
        
        <div class="relative bg-white rounded-[2.5rem] shadow-2xl w-full max-w-2xl overflow-hidden transform transition-all">
            <div class="bg-emerald-600 p-8 text-white">
                <h2 class="text-3xl font-black">Nueva Labor General</h2>
                <p class="text-emerald-100 font-medium">Registra tareas de mantenimiento o monitoreo.</p>
            </div>
            
            <form action="{{ route('admin.tareas.store.general') }}" method="POST" class="p-8 space-y-6">
                @csrf
                <div class="space-y-2">
                    <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Descripción de la Tarea</label>
                    <input type="text" name="descripcion" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-5 focus:outline-none focus:border-emerald-500 transition-all font-bold text-gray-700" placeholder="Ej: Poda de formación lote 2">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Terreno</label>
                        <select name="id_terreno" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-5 focus:outline-none focus:border-emerald-500 transition-all font-bold text-gray-700">
                            @foreach($terrenosLibres as $t)
                                <option value="{{ $t->id_terreno }}">{{ $t->nombre }} ({{ $t->ubicacion ?? 'Sin ubicación' }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Trabajador</label>
                        <select name="documento_trabajador" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-5 focus:outline-none focus:border-emerald-500 transition-all font-bold text-gray-700">
                            @foreach($trabajadores as $t)
                                <option value="{{ $t->documento }}">{{ $t->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Fecha Programada</label>
                    <input type="date" name="fecha_programada" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-5 focus:outline-none focus:border-emerald-500 transition-all font-bold text-gray-700">
                </div>
                
                <div class="pt-4 flex gap-3">
                    <button type="button" onclick="closeModal('modalGeneral')" class="flex-1 py-4 rounded-2xl font-bold bg-gray-100 text-gray-600 hover:bg-gray-200 transition-all">Cancelar</button>
                    <button type="submit" class="flex-1 py-4 rounded-2xl font-bold bg-emerald-600 text-white hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-200">Programar Fase</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODALES DE EDICIÓN --}}

{{-- Edit Riego --}}
<div id="modalEditRiego" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeModal('modalEditRiego')"></div>
        <div class="relative bg-white rounded-[2.5rem] shadow-2xl w-full max-w-2xl overflow-hidden transform transition-all">
            <div class="bg-blue-600 p-8 text-white">
                <h2 class="text-3xl font-black">Editar Riego</h2>
                <p class="text-blue-100 font-medium tracking-tight">Actualiza los detalles de la labor seleccionada.</p>
            </div>
            <form id="formEditRiego" method="POST" class="p-8 space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Lote de Cosecha</label>
                        <select name="id_cosecha" id="edit_riego_cosecha" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-5 focus:outline-none focus:border-blue-500 transition-all font-bold text-gray-700">
                            @foreach($cosechas as $c)
                                <option value="{{ $c->id_cosecha }}">Lote #{{ $c->id_cosecha }} - {{ $c->semilla?->nombre_semilla ?? 'N/A' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Trabajador Asignado</label>
                        <select name="documento_trabajador" id="edit_riego_trabajador" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-5 focus:outline-none focus:border-blue-500 transition-all font-bold text-gray-700">
                            @foreach($trabajadores as $t)
                                <option value="{{ $t->documento }}">{{ $t->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Tipo de Riego</label>
                        <select name="id_tipo_riego" id="edit_riego_tipo" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-5 focus:outline-none focus:border-blue-500 transition-all font-bold text-gray-700">
                            @foreach($tiposRiego as $tr)
                                <option value="{{ $tr->id_tipo_riego }}">{{ $tr->tipo_riego }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Cant. Agua (Lts)</label>
                        <input type="number" step="0.01" name="cant_agua_apl" id="edit_riego_cantidad" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-5 focus:outline-none focus:border-blue-500 transition-all font-bold text-gray-700">
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Fecha Programada</label>
                    <input type="date" name="fecha_programada" id="edit_riego_fecha" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-5 focus:outline-none focus:border-blue-500 transition-all font-bold text-gray-700">
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Observaciones</label>
                    <textarea name="observaciones" id="edit_riego_obs" rows="3" class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-5 focus:outline-none focus:border-blue-500 transition-all font-bold text-gray-700"></textarea>
                </div>
                <div class="pt-4 flex gap-3">
                    <button type="button" onclick="closeModal('modalEditRiego')" class="flex-1 py-4 rounded-2xl font-bold bg-gray-100 text-gray-600 hover:bg-gray-200 transition-all">Cancelar</button>
                    <button type="submit" class="flex-1 py-4 rounded-2xl font-bold bg-blue-600 text-white hover:bg-blue-700 transition-all shadow-lg shadow-blue-200">Actualizar Tarea</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Insumo --}}
<div id="modalEditInsumo" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeModal('modalEditInsumo')"></div>
        <div class="relative bg-white rounded-[2.5rem] shadow-2xl w-full max-w-2xl overflow-hidden transform transition-all">
            <div class="bg-purple-600 p-8 text-white">
                <h2 class="text-3xl font-black">Editar Insumo</h2>
                <p class="text-purple-100 font-medium">Ajusta la aplicación programada.</p>
            </div>
            <form id="formEditInsumo" method="POST" class="p-8 space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Lote de Cosecha</label>
                        <select name="id_cosecha" id="edit_insumo_cosecha" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-5 focus:outline-none focus:border-purple-500 transition-all font-bold text-gray-700">
                            @foreach($cosechas as $c)
                                <option value="{{ $c->id_cosecha }}">Lote #{{ $c->id_cosecha }} - {{ $c->semilla?->nombre_semilla ?? 'N/A' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Trabajador</label>
                        <select name="documento_trabajador" id="edit_insumo_trabajador" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-5 focus:outline-none focus:border-purple-500 transition-all font-bold text-gray-700">
                            @foreach($trabajadores as $t)
                                <option value="{{ $t->documento }}">{{ $t->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Producto / Insumo</label>
                        <select name="id_insumo" id="edit_insumo_producto" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-5 focus:outline-none focus:border-purple-500 transition-all font-bold text-gray-700">
                            @foreach($catalogoInsumos as $ci)
                                <option value="{{ $ci->ID_insumo }}">{{ $ci->Nombre }} (Stock: {{ $ci->stock_actual }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Cantidad a Usar</label>
                        <input type="number" step="0.01" name="cantidad_usada" id="edit_insumo_cantidad" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-5 focus:outline-none focus:border-purple-500 transition-all font-bold text-gray-700">
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Fecha Programada</label>
                    <input type="date" name="fecha_programada" id="edit_insumo_fecha" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-5 focus:outline-none focus:border-purple-500 transition-all font-bold text-gray-700">
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Observaciones</label>
                    <textarea name="observaciones" id="edit_insumo_obs" rows="3" class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-5 focus:outline-none focus:border-purple-500 transition-all font-bold text-gray-700"></textarea>
                </div>
                <div class="pt-4 flex gap-3">
                    <button type="button" onclick="closeModal('modalEditInsumo')" class="flex-1 py-4 rounded-2xl font-bold bg-gray-100 text-gray-600 hover:bg-gray-200 transition-all">Cancelar</button>
                    <button type="submit" class="flex-1 py-4 rounded-2xl font-bold bg-purple-600 text-white hover:bg-purple-700 transition-all shadow-lg shadow-purple-200">Actualizar Insumo</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit General --}}
<div id="modalEditGeneral" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeModal('modalEditGeneral')"></div>
        <div class="relative bg-white rounded-[2.5rem] shadow-2xl w-full max-w-2xl overflow-hidden transform transition-all">
            <div class="bg-emerald-600 p-8 text-white">
                <h2 class="text-3xl font-black">Editar Labor General</h2>
                <p class="text-emerald-100 font-medium">Actualiza los detalles de la fase programada.</p>
            </div>
            <form id="formEditGeneral" method="POST" class="p-8 space-y-6">
                @csrf
                @method('PUT')
                <div class="space-y-2">
                    <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Descripción de la Tarea</label>
                    <input type="text" name="descripcion" id="edit_general_desc" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-5 focus:outline-none focus:border-emerald-500 transition-all font-bold text-gray-700">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Terreno</label>
                        <select name="id_terreno" id="edit_general_terreno" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-5 focus:outline-none focus:border-emerald-500 transition-all font-bold text-gray-700">
                            @foreach($terrenosLibres as $t)
                                <option value="{{ $t->id_terreno }}">{{ $t->nombre }}</option>
                            @endforeach
                            {{-- Add placeholder in case current terreno is not in libres --}}
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Trabajador</label>
                        <select name="documento_trabajador" id="edit_general_trabajador" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-5 focus:outline-none focus:border-emerald-500 transition-all font-bold text-gray-700">
                            @foreach($trabajadores as $t)
                                <option value="{{ $t->documento }}">{{ $t->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Fecha Programada</label>
                    <input type="date" name="fecha_programada" id="edit_general_fecha" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-5 focus:outline-none focus:border-emerald-500 transition-all font-bold text-gray-700">
                </div>
                <div class="pt-4 flex gap-3">
                    <button type="button" onclick="closeModal('modalEditGeneral')" class="flex-1 py-4 rounded-2xl font-bold bg-gray-100 text-gray-600 hover:bg-gray-200 transition-all">Cancelar</button>
                    <button type="submit" class="flex-1 py-4 rounded-2xl font-bold bg-emerald-600 text-white hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-200">Actualizar Fase</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Recoleccion --}}
<div id="modalEditRecoleccion" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeModal('modalEditRecoleccion')"></div>
        <div class="relative bg-white rounded-[2.5rem] shadow-2xl w-full max-w-2xl overflow-hidden transform transition-all">
            <div class="bg-orange-600 p-8 text-white">
                <h2 class="text-3xl font-black">Editar Recolección</h2>
                <p class="text-orange-100 font-medium tracking-tight">Ajusta la programación de cosecha.</p>
            </div>
            <form id="formEditRecoleccion" method="POST" class="p-8 space-y-6">
                @csrf
                @method('PUT')
                <div class="space-y-2">
                    <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Trabajador Asignado</label>
                    <select name="documento_trabajador" id="edit_recoleccion_trabajador" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-5 focus:outline-none focus:border-orange-500 transition-all font-bold text-gray-700">
                        @foreach($trabajadores as $t)
                            <option value="{{ $t->documento }}">{{ $t->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Fecha Programada</label>
                    <input type="date" name="fecha_recoleccion" id="edit_recoleccion_fecha" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-5 focus:outline-none focus:border-orange-500 transition-all font-bold text-gray-700">
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Instrucciones</label>
                    <textarea name="descripcion_recoleccion" id="edit_recoleccion_desc" rows="3" class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-5 focus:outline-none focus:border-orange-500 transition-all font-bold text-gray-700" placeholder="Ej: Recolectar solo frutos pintones..."></textarea>
                </div>
                <div class="pt-4 flex gap-3">
                    <button type="button" onclick="closeModal('modalEditRecoleccion')" class="flex-1 py-4 rounded-2xl font-bold bg-gray-100 text-gray-600 hover:bg-gray-200 transition-all">Cancelar</button>
                    <button type="submit" class="flex-1 py-4 rounded-2xl font-bold bg-orange-600 text-white hover:bg-orange-700 transition-all shadow-lg shadow-orange-200">Actualizar Programación</button>
                </div>
            </form>
        </div>
    </div>
</div>
