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
                    {{-- Lote de Cosecha --}}
                    <div class="space-y-2 relative">
                        <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Lote de Cosecha</label>
                        <div class="relative group" id="loteSearchContainerRiego">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </div>
                            <input type="text" id="loteSearchInputRiego" oninput="debounceLotesSearch(this.value, 'Riego')"
                                autocomplete="off" placeholder="Buscar lote o semilla..."
                                class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 pl-10 pr-4 focus:outline-none focus:border-blue-500 transition-all font-bold text-gray-700">
                            
                            <div id="loteResultsRiego" class="absolute z-[110] w-full mt-2 bg-white rounded-2xl shadow-2xl border border-gray-100 hidden max-h-60 overflow-y-auto"></div>
                        </div>

                        {{-- Feedback for selected lote --}}
                        <div id="selectedLoteFeedbackRiego" class="hidden p-4 bg-blue-600 rounded-2xl flex items-center justify-between group shadow-lg shadow-blue-100">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center text-white">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                </div>
                                <div class="overflow-hidden">
                                    <p id="feedbackLoteNameRiego" class="text-xs font-black text-white uppercase truncate"></p>
                                    <p id="feedbackLoteInfoRiego" class="text-[9px] text-blue-100 font-bold uppercase"></p>
                                </div>
                            </div>
                            <button type="button" onclick="clearLoteSelection('Riego')" class="p-1 hover:bg-white/10 rounded-lg text-blue-100 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                        <input type="hidden" name="id_cosecha" id="hiddenIdCosechaRiego" required>
                    </div>

                    {{-- Trabajador Asignado --}}
                    <div class="space-y-2 relative">
                        <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Trabajador Asignado</label>
                        <div class="relative group" id="workerSearchContainerRiego">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                            <input type="text" id="workerSearchInputRiego" oninput="debounceTrabajadoresSearch(this.value, 'Riego')"
                                autocomplete="off" placeholder="Nombre o documento..."
                                class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 pl-10 pr-4 focus:outline-none focus:border-blue-500 transition-all font-bold text-gray-700">
                            
                            <div id="workerResultsRiego" class="absolute z-[110] w-full mt-2 bg-white rounded-2xl shadow-2xl border border-gray-100 hidden max-h-60 overflow-y-auto"></div>
                        </div>

                        {{-- Feedback for selected worker --}}
                        <div id="selectedWorkerFeedbackRiego" class="hidden p-4 bg-blue-600 rounded-2xl flex items-center justify-between group shadow-lg shadow-blue-100">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center text-white">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                </div>
                                <div class="overflow-hidden">
                                    <p id="feedbackWorkerNameRiego" class="text-xs font-black text-white uppercase truncate"></p>
                                    <p id="feedbackWorkerInfoRiego" class="text-[9px] text-blue-100 font-bold uppercase"></p>
                                </div>
                            </div>
                            <button type="button" onclick="clearWorkerSelection('Riego')" class="p-1 hover:bg-white/10 rounded-lg text-blue-100 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                        <input type="hidden" name="documento_trabajador" id="hiddenDocTrabajadorRiego" required>
                    </div>

                    <div class="space-y-2">
                        <div class="flex justify-between items-center mr-1">
                            <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Tipo de Riego</label>
                            <a href="{{ route('tipo_riegos.index') }}" class="text-blue-500 hover:text-blue-600 transition-colors" title="Ver Tipos de Riego">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                            </a>
                        </div>
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
                    {{-- Lote de Cosecha --}}
                    <div class="space-y-2 relative">
                        <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Lote de Cosecha</label>
                        <div class="relative group" id="loteSearchContainerInsumo">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </div>
                            <input type="text" id="loteSearchInputInsumo" oninput="debounceLotesSearch(this.value, 'Insumo')"
                                autocomplete="off" placeholder="Buscar lote o semilla..."
                                class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 pl-10 pr-4 focus:outline-none focus:border-purple-500 transition-all font-bold text-gray-700">
                            
                            <div id="loteResultsInsumo" class="absolute z-[110] w-full mt-2 bg-white rounded-2xl shadow-2xl border border-gray-100 hidden max-h-60 overflow-y-auto"></div>
                        </div>

                        {{-- Feedback for selected lote --}}
                        <div id="selectedLoteFeedbackInsumo" class="hidden p-4 bg-purple-600 rounded-2xl flex items-center justify-between group shadow-lg shadow-purple-100">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center text-white">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                </div>
                                <div class="overflow-hidden">
                                    <p id="feedbackLoteNameInsumo" class="text-xs font-black text-white uppercase truncate"></p>
                                    <p id="feedbackLoteInfoInsumo" class="text-[9px] text-purple-100 font-bold uppercase"></p>
                                </div>
                            </div>
                            <button type="button" onclick="clearLoteSelection('Insumo')" class="p-1 hover:bg-white/10 rounded-lg text-purple-100 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                        <input type="hidden" name="id_cosecha" id="hiddenIdCosechaInsumo" required>
                    </div>

                    {{-- Trabajador --}}
                    <div class="space-y-2 relative">
                        <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Trabajador</label>
                        <div class="relative group" id="workerSearchContainerInsumo">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                            <input type="text" id="workerSearchInputInsumo" oninput="debounceTrabajadoresSearch(this.value, 'Insumo')"
                                autocomplete="off" placeholder="Nombre o documento..."
                                class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 pl-10 pr-4 focus:outline-none focus:border-purple-500 transition-all font-bold text-gray-700">
                            
                            <div id="workerResultsInsumo" class="absolute z-[110] w-full mt-2 bg-white rounded-2xl shadow-2xl border border-gray-100 hidden max-h-60 overflow-y-auto"></div>
                        </div>

                        {{-- Feedback for selected worker --}}
                        <div id="selectedWorkerFeedbackInsumo" class="hidden p-4 bg-purple-600 rounded-2xl flex items-center justify-between group shadow-lg shadow-purple-100">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center text-white">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                </div>
                                <div class="overflow-hidden">
                                    <p id="feedbackWorkerNameInsumo" class="text-xs font-black text-white uppercase truncate"></p>
                                    <p id="feedbackWorkerInfoInsumo" class="text-[9px] text-purple-100 font-bold uppercase"></p>
                                </div>
                            </div>
                            <button type="button" onclick="clearWorkerSelection('Insumo')" class="p-1 hover:bg-white/10 rounded-lg text-purple-100 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                        <input type="hidden" name="documento_trabajador" id="hiddenDocTrabajadorInsumo" required>
                    </div>
                    <div class="space-y-2 relative">
                        <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Producto / Insumo</label>
                        <div class="relative group" id="insumoSearchContainer">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                            </div>
                            <input type="text" id="insumoSearchInput" oninput="debounceInsumosSearch(this.value)"
                                autocomplete="off" placeholder="Buscar producto o insumo..."
                                class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 pl-10 pr-4 focus:outline-none focus:border-purple-500 transition-all font-bold text-gray-700">
                            
                            <div id="insumoResults" class="absolute z-[110] w-full mt-2 bg-white rounded-2xl shadow-2xl border border-gray-100 hidden max-h-60 overflow-y-auto"></div>
                        </div>

                        {{-- Feedback for selected insumo --}}
                        <div id="selectedInsumoFeedback" class="hidden p-4 bg-purple-600 rounded-2xl flex items-center justify-between group shadow-lg shadow-purple-100">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center text-white">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                                </div>
                                <div class="overflow-hidden">
                                    <p id="feedbackInsumoName" class="text-xs font-black text-white uppercase truncate"></p>
                                    <p id="feedbackInsumoInfo" class="text-[9px] text-purple-100 font-bold uppercase"></p>
                                </div>
                            </div>
                            <button type="button" onclick="clearInsumoSelection()" class="p-1 hover:bg-white/10 rounded-lg text-purple-100 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                        <input type="hidden" name="id_insumo" id="hiddenIdInsumo" required>
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
                    {{-- Terreno --}}
                    <div class="space-y-2 relative">
                        <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Terreno</label>
                        <div class="relative group" id="terrenoSearchContainer">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <input type="text" id="terrenoSearchInput" oninput="debounceTerrenosSearch(this.value)"
                                autocomplete="off" placeholder="Buscar terreno..."
                                class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 pl-10 pr-4 focus:outline-none focus:border-emerald-500 transition-all font-bold text-gray-700">
                            
                            <div id="terrenoResults" class="absolute z-[110] w-full mt-2 bg-white rounded-2xl shadow-2xl border border-gray-100 hidden max-h-60 overflow-y-auto"></div>
                        </div>

                        {{-- Feedback for selected terreno --}}
                        <div id="selectedTerrenoFeedback" class="hidden p-4 bg-emerald-600 rounded-2xl flex items-center justify-between group shadow-lg shadow-emerald-100">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center text-white">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <div class="overflow-hidden">
                                    <p id="feedbackTerrenoName" class="text-xs font-black text-white uppercase truncate"></p>
                                    <p id="feedbackTerrenoInfo" class="text-[9px] text-emerald-100 font-bold uppercase"></p>
                                </div>
                            </div>
                            <button type="button" onclick="clearTerrenoSelection()" class="p-1 hover:bg-white/10 rounded-lg text-emerald-100 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                        <input type="hidden" name="id_terreno" id="hiddenIdTerreno" required>
                    </div>

                    {{-- Trabajador --}}
                    <div class="space-y-2 relative">
                        <label class="text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Trabajador</label>
                        <div class="relative group" id="workerSearchContainerGeneral">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                            <input type="text" id="workerSearchInputGeneral" oninput="debounceTrabajadoresSearch(this.value, 'General')"
                                autocomplete="off" placeholder="Nombre o documento..."
                                class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 pl-10 pr-4 focus:outline-none focus:border-emerald-500 transition-all font-bold text-gray-700">
                            
                            <div id="workerResultsGeneral" class="absolute z-[110] w-full mt-2 bg-white rounded-2xl shadow-2xl border border-gray-100 hidden max-h-60 overflow-y-auto"></div>
                        </div>

                        {{-- Feedback for selected worker --}}
                        <div id="selectedWorkerFeedbackGeneral" class="hidden p-4 bg-emerald-600 rounded-2xl flex items-center justify-between group shadow-lg shadow-emerald-100">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center text-white">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                </div>
                                <div class="overflow-hidden">
                                    <p id="feedbackWorkerNameGeneral" class="text-xs font-black text-white uppercase truncate"></p>
                                    <p id="feedbackWorkerInfoGeneral" class="text-[9px] text-emerald-100 font-bold uppercase"></p>
                                </div>
                            </div>
                            <button type="button" onclick="clearWorkerSelection('General')" class="p-1 hover:bg-white/10 rounded-lg text-emerald-100 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                        <input type="hidden" name="documento_trabajador" id="hiddenDocTrabajadorGeneral" required>
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
