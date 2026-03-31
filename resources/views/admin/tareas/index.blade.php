@extends('layouts.admin')

@section('title', 'Gestión de Tareas por Categorías')

@section('content')
<div class="space-y-6">
    <div class="space-y-10 pb-20">
        {{-- Header Section --}}
        <div class="bg-white dark:bg-slate-800 p-8 rounded-3xl border border-gray-100 dark:border-emerald-900/20 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-6 overflow-hidden relative transition-all duration-300">
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-emerald-50 dark:bg-emerald-900/20 rounded-full blur-3xl opacity-50"></div>
            <div class="relative z-10">
                <h1 class="text-3xl font-black text-gray-900 dark:text-emerald-50 tracking-tight">Gestión Operativa</h1>
                <p class="text-gray-500 dark:text-emerald-400 font-medium">Asigna y supervisa las labores de cultivo de tu empresa.</p>
            </div>
            <div class="flex items-center gap-3 relative z-10">
                <span class="flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                </span>
                <span class="bg-emerald-100 dark:bg-emerald-900/30 text-emerald-800 dark:text-emerald-400 text-xs font-black px-3 py-1 rounded-full uppercase tracking-widest">En Vivo</span>
            </div>
        </div>

        {{-- Creation Cards Section --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Card: Riego --}}
            <div class="group bg-white dark:bg-slate-800 p-1 rounded-[3rem] border border-gray-100 dark:border-emerald-900/20 shadow-xl shadow-gray-200/50 dark:shadow-none hover:shadow-blue-200/40 transition-all duration-500 hover:-translate-y-2 relative overflow-hidden flex flex-col">
                <div class="p-10 pb-6 flex-grow relative">
                    <div class="absolute -right-6 -top-6 w-40 h-40 bg-blue-50 dark:bg-blue-900/10 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>

                    {{-- Small Top Icon --}}
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center mb-8 shadow-sm group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z" />
                        </svg>
                    </div>

                    {{-- Large Background Icon --}}
                    <div class="absolute top-10 right-10 opacity-[0.03] dark:opacity-[0.05] group-hover:opacity-10 transition-opacity duration-500 pointer-events-none">
                        <svg class="w-32 h-32 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z" />
                        </svg>
                    </div>

                    <div class="relative z-10">
                        <h3 class="text-2xl font-black text-gray-900 dark:text-emerald-50 mb-2">Control de Riego</h3>
                        <p class="text-gray-500 dark:text-emerald-400/70 text-sm leading-relaxed max-w-[90%]">
                            Programa el suministro de agua para tus lotes activos.
                        </p>
                    </div>

                    <div class="mt-10 flex items-center justify-between relative z-10">
                        <div class="flex flex-col">
                            <span class="text-3xl font-black text-blue-600">{{ $riego->count() }}</span>
                            <span class="text-[10px] text-gray-400 dark:text-gray-500 font-black uppercase tracking-widest">Activos</span>
                        </div>
                        <button onclick="openModal('modalRiego')" class="bg-blue-600 text-white p-5 rounded-2xl hover:bg-blue-700 transition-all shadow-xl shadow-blue-200 dark:shadow-none hover:scale-110 active:scale-95 group/btn">
                            <svg class="w-7 h-7 transition-transform duration-500 group-hover/btn:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

{{-- Card: Insumo --}}
            <div class="group bg-white dark:bg-slate-800 p-1 rounded-[3rem] border border-gray-100 dark:border-emerald-900/20 shadow-xl shadow-gray-200/50 dark:shadow-none hover:shadow-purple-200/40 transition-all duration-500 hover:-translate-y-2 relative overflow-hidden flex flex-col">
                <div class="p-10 pb-6 flex-grow relative">
                    <div class="absolute -right-6 -top-6 w-40 h-40 bg-purple-50 dark:bg-purple-900/10 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>

                    {{-- Small Top Icon --}}
                    <div class="w-14 h-14 rounded-2xl bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 flex items-center justify-center mb-8 shadow-sm group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>

                    {{-- Large Background Icon --}}
                    <div class="absolute top-10 right-10 opacity-[0.03] dark:opacity-[0.05] group-hover:opacity-10 transition-opacity duration-500 pointer-events-none">
                        <svg class="w-32 h-32 text-purple-600 dark:text-purple-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 13H5v-2h14v2z" />
                        </svg>
                    </div>

                    <div class="relative z-10">
                        <h3 class="text-2xl font-black text-gray-900 dark:text-emerald-50 mb-2">Insumos y Nutrición</h3>
                        <p class="text-gray-500 dark:text-emerald-400/70 text-sm leading-relaxed max-w-[90%]">
                            Asigna fertilizantes y agroquímicos a tus cosechas.
                        </p>
                    </div>

                    <div class="mt-10 flex items-center justify-between relative z-10">
                        <div class="flex flex-col">
                            <span class="text-3xl font-black text-purple-600">{{ $insumoCosecha->count() }}</span>
                            <span class="text-[10px] text-gray-400 dark:text-gray-500 font-black uppercase tracking-widest">Asignados</span>
                        </div>
                        <button onclick="openModal('modalInsumo')" class="bg-purple-600 text-white p-5 rounded-2xl hover:bg-purple-700 transition-all shadow-xl shadow-purple-200 dark:shadow-none hover:scale-110 active:scale-95 group/btn">
                            <svg class="w-7 h-7 transition-transform duration-500 group-hover/btn:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                            </svg>
                        </button>
                    </div>
                </div>
                <button onclick="showCategory('insumo')" class="w-full py-5 text-[10px] font-black uppercase tracking-[0.2em] text-purple-600 dark:text-purple-400 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-colors border-t border-gray-50 dark:border-emerald-950/20">
                    Ver Inventario y Uso
                </button>
            </div>

            {{-- Card: General --}}
            <div class="group bg-white dark:bg-slate-800 p-1 rounded-[3rem] border border-gray-100 dark:border-emerald-900/20 shadow-xl shadow-gray-200/50 dark:shadow-none hover:shadow-emerald-200/40 transition-all duration-500 hover:-translate-y-2 relative overflow-hidden flex flex-col">
                <div class="p-10 pb-6 flex-grow relative">
                    <div class="absolute -right-6 -top-6 w-40 h-40 bg-emerald-50 dark:bg-emerald-900/10 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>

                    {{-- Small Top Icon --}}
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center mb-8 shadow-sm group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>

                    {{-- Large Background Icon --}}
                    <div class="absolute top-10 right-10 opacity-[0.03] dark:opacity-[0.05] group-hover:opacity-10 transition-opacity duration-500 pointer-events-none">
                        <svg class="w-32 h-32 text-emerald-600 dark:text-emerald-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M4 6h16v12H4z" />
                        </svg>
                    </div>

                    <div class="relative z-10">
                        <h3 class="text-2xl font-black text-gray-900 dark:text-emerald-50 mb-2">Fases Labores</h3>
                        <p class="text-gray-500 dark:text-emerald-400/70 text-sm leading-relaxed max-w-[90%]">
                            Tareas generales de mantenimiento, poda o monitoreo.
                        </p>
                    </div>

                    <div class="mt-10 flex items-center justify-between relative z-10">
                        <div class="flex flex-col">
                            <span class="text-3xl font-black text-emerald-600">{{ $general->count() }}</span>
                            <span class="text-[10px] text-gray-400 dark:text-gray-500 font-black uppercase tracking-widest">Listadas</span>
                        </div>
                        <button onclick="openModal('modalGeneral')" class="bg-emerald-600 text-white p-5 rounded-2xl hover:bg-emerald-700 transition-all shadow-xl shadow-emerald-200 dark:shadow-none hover:scale-110 active:scale-95 group/btn">
                            <svg class="w-7 h-7 transition-transform duration-500 group-hover/btn:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                            </svg>
                        </button>
                    </div>
                </div>
                <button onclick="showCategory('general')" class="w-full py-5 text-[10px] font-black uppercase tracking-[0.2em] text-emerald-600 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors border-t border-gray-50 dark:border-emerald-950/20">
                    Ver Cronograma General
                </button>
            </div>
        </div>

        {{-- FILTERS & REPORT BAR --}}
        <div class="bg-white dark:bg-slate-800 p-8 rounded-[2.5rem] border border-emerald-100 dark:border-emerald-900/20 shadow-xl shadow-emerald-100/20 dark:shadow-none mb-10 transition-all duration-300">
            <form action="{{ route('admin.tareas.index') }}" method="GET" class="flex flex-col lg:flex-row gap-6 items-end">
                <div class="flex-1 w-full">
                    <label class="block text-[10px] font-black text-emerald-600 dark:text-emerald-400 uppercase tracking-[0.2em] mb-3 ml-1">Filtrar por Mes</label>
                    <div class="relative group">
                        <select name="month" class="w-full bg-emerald-50/50 dark:bg-emerald-900/20 border-2 border-transparent focus:border-emerald-500/30 rounded-2xl px-5 py-4 text-sm font-bold text-gray-700 dark:text-emerald-50 appearance-none transition-all outline-none cursor-pointer">
                            <option value="">Todos los meses</option>
                            @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                {{ ucfirst(\Carbon\Carbon::create()->month($m)->translatedFormat('F')) }}
                            </option>
                            @endforeach
                        </select>
                        <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-emerald-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="w-full lg:w-56">
                    <label class="block text-[10px] font-black text-emerald-600 dark:text-emerald-400 uppercase tracking-[0.2em] mb-3 ml-1">Estado</label>
                    <div class="relative group">
                        <select name="id_estado" class="w-full bg-emerald-50/50 dark:bg-emerald-900/20 border-2 border-transparent focus:border-emerald-500/30 rounded-2xl px-5 py-4 text-sm font-bold text-gray-700 dark:text-emerald-50 appearance-none transition-all outline-none cursor-pointer">
                            <option value="">Todos los estados</option>
                        <option value="1" {{ request('id_estado') == '1' ? 'selected' : '' }}>Pendiente</option>
                        <option value="17" {{ request('id_estado') == '17' ? 'selected' : '' }}>En Proceso</option>
                        <option value="15" {{ request('id_estado') == '15' ? 'selected' : '' }}>Realizado</option>
                        <option value="18" {{ request('id_estado') == '18' ? 'selected' : '' }}>Perdida</option>
                        <option value="19" {{ request('id_estado') == '19' ? 'selected' : '' }}>Realizada con Retraso</option>
                        </select>
                        <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-emerald-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-40">
                    <label class="block text-[10px] font-black text-emerald-600 dark:text-emerald-400 uppercase tracking-[0.2em] mb-3 ml-1">Año</label>
                    <input type="number" name="year" value="{{ request('year', date('Y')) }}"
                        class="w-full bg-emerald-50/50 dark:bg-emerald-900/20 border-2 border-transparent focus:border-emerald-500/30 rounded-2xl px-5 py-4 text-sm font-bold text-gray-700 dark:text-emerald-50 transition-all outline-none" placeholder="YYYY">
                </div>

                <div class="flex-[2] w-full">
                    <label class="block text-[10px] font-black text-emerald-600 dark:text-emerald-400 uppercase tracking-[0.2em] mb-3 ml-1">Búsqueda rápida</label>
                    <div class="relative group">
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="w-full bg-emerald-50/50 dark:bg-emerald-900/20 border-2 border-transparent focus:border-emerald-500/30 rounded-2xl px-5 py-4 pl-12 text-sm font-bold text-gray-700 dark:text-emerald-50 transition-all outline-none" placeholder="Buscar trabajador o labor...">
                        <div class="absolute left-5 top-1/2 -translate-y-1/2 text-emerald-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 w-full lg:w-auto">
                    <button type="submit" class="flex-1 lg:flex-none justify-center bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest transition-all shadow-lg shadow-emerald-200/50 dark:shadow-none flex items-center gap-3 active:scale-95">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filtrar
                    </button>
                    <a href="{{ route('admin.tareas.export', request()->all()) }}" class="flex-1 lg:flex-none justify-center bg-white dark:bg-slate-700 border-2 border-emerald-500 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest transition-all flex items-center gap-3 active:scale-95 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Excel
                    </a>
                </div>
            </form>
        </div>

        {{-- CATEGORIES CONTENT --}}
        <div id="content-todas" class="category-content space-y-4">
            @include('admin.tareas.partials.task_list', [
            'tasks' => $riego->concat($insumoCosecha)->concat($general)->concat($recoleccion)->sortByDesc('fecha_programada'),
            'title' => 'Todas las Labores',
            'type' => 'all'
            ])
        </div>

        <div id="content-riego" class="category-content hidden space-y-4">
            @include('admin.tareas.partials.task_list', ['tasks' => $riego, 'title' => 'Historial de Riego', 'type' => 'riego'])
        </div>

        <div id="content-insumo" class="category-content hidden space-y-4">
            @include('admin.tareas.partials.task_list', ['tasks' => $insumoCosecha, 'title' => 'Consumo de Insumos', 'type' => 'insumo'])
        </div>

        <div id="content-general" class="category-content hidden space-y-4">
            @include('admin.tareas.partials.task_list', ['tasks' => $general, 'title' => 'Labores Generales Programadas', 'type' => 'general'])
        </div>
    </div>

    {{-- MODALS SECTION --}}
    @include('admin.tareas.partials.modals')

    @push('scripts')
    <script>
        let currentCategoryId = 'todas';
        const itemsPerPage = 6;
        let paginationState = {};

        function showCategory(id) {
            if (currentCategoryId === id && id !== 'todas') {
                id = 'todas';
            }
            document.querySelectorAll('.category-content').forEach(el => el.classList.add('hidden'));
            document.getElementById('content-' + id).classList.remove('hidden');
            currentCategoryId = id;
            if (id !== 'todas') {
                window.scrollTo({
                    top: document.getElementById('content-' + id).offsetTop - 100,
                    behavior: 'smooth'
                });
            }
            // Initialize or refresh pagination for the shown category
            initPagination(id);
        }

        function initPagination(type) {
            const container = document.querySelector(`.task-list-container[data-type="${type}"]`);
            if (!container) return;

            const cards = Array.from(container.querySelectorAll('.task-card'));
            const totalItems = cards.length;
            const totalPages = Math.ceil(totalItems / itemsPerPage);

            paginationState[type] = {
                currentPage: 1,
                totalPages: totalPages,
                cards: cards
            };

            updatePaginationUI(type);
        }

        function updatePaginationUI(type) {
            const state = paginationState[type];
            if (!state) return;

            const start = (state.currentPage - 1) * itemsPerPage;
            const end = start + itemsPerPage;

            state.cards.forEach((card, index) => {
                if (index >= start && index < end) {
                    card.classList.remove('hidden');
                    card.style.display = 'flex';
                } else {
                    card.classList.add('hidden');
                    card.style.display = 'none';
                }
            });

            const nav = document.getElementById(`pagination-${type}`);
            if (nav) {
                nav.querySelector('.current-page').innerText = state.currentPage;
                nav.querySelector('.total-pages').innerText = state.totalPages;
                nav.querySelector('.btn-prev').disabled = state.currentPage === 1;
                nav.querySelector('.btn-next').disabled = state.currentPage === state.totalPages;

                // Generate page numbers
                const pageNumbersContainer = nav.querySelector('.page-numbers');
                if (pageNumbersContainer) {
                    pageNumbersContainer.innerHTML = '';
                    for (let i = 1; i <= state.totalPages; i++) {
                        const btn = document.createElement('button');
                        btn.innerText = i;
                        btn.className = `px-3 py-1 rounded-lg text-xs font-black transition-all ${state.currentPage === i ? 'bg-gray-900 text-white' : 'bg-white text-gray-400 border border-gray-100 hover:bg-gray-50'}`;
                        btn.onclick = () => {
                            state.currentPage = i;
                            updatePaginationUI(type);
                        };
                        pageNumbersContainer.appendChild(btn);
                    }
                }
            }
        }

        function changePage(type, delta) {
            if (!paginationState[type]) return;

            let newState = paginationState[type];
            newState.currentPage += delta;

            if (newState.currentPage < 1) newState.currentPage = 1;
            if (newState.currentPage > newState.totalPages) newState.currentPage = newState.totalPages;

            updatePaginationUI(type);

            // Small scroll to top of list
            const contentHeader = document.querySelector(`#content-${type} h4`);
            if (contentHeader) {
                window.scrollTo({
                    top: contentHeader.offsetTop - 120,
                    behavior: 'smooth'
                });
            }
        }

        // Initial load for all
        window.addEventListener('DOMContentLoaded', () => {
            ['todas', 'riego', 'insumo', 'general'].forEach(type => initPagination(type));
        });

        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function editTask(task, type) {
            console.log("Editing task:", task, "Type:", type);

            if (type === 'riego') {
                const form = document.getElementById('formEditRiego');
                form.action = `{{ url('/admin/tareas/update-riego') }}/${task.id_riego}`;
                document.getElementById('edit_riego_cosecha').value = task.id_cosecha;
                document.getElementById('edit_riego_trabajador').value = task.documento_trabajador;
                document.getElementById('edit_riego_tipo').value = task.id_tipo_riego;
                document.getElementById('edit_riego_cantidad').value = task.cant_agua_apl;
                document.getElementById('edit_riego_fecha').value = task.fecha_programada.split(' ')[0];
                document.getElementById('edit_riego_obs').value = task.observaciones || '';
                openModal('modalEditRiego');
            } else if (type === 'insumo') {
                const form = document.getElementById('formEditInsumo');
                form.action = `{{ url('/admin/tareas/update-insumo') }}/${task.id_insumo_cosecha}`;
                document.getElementById('edit_insumo_cosecha').value = task.id_cosecha;
                document.getElementById('edit_insumo_trabajador').value = task.documento_trabajador;
                document.getElementById('edit_insumo_producto').value = task.id_insumo;
                document.getElementById('edit_insumo_cantidad').value = task.cantidad_usada;
                document.getElementById('edit_insumo_fecha').value = task.fecha_programada.split(' ')[0];
                document.getElementById('edit_insumo_obs').value = task.observaciones || '';
                openModal('modalEditInsumo');
            } else if (type === 'general') {
                const form = document.getElementById('formEditGeneral');
                form.action = `{{ url('/admin/tareas/update-general') }}/${task.id_fase}`;
                document.getElementById('edit_general_desc').value = task.descripcion;

                const selectTerreno = document.getElementById('edit_general_terreno');
                // Si el terreno no está en la lista (porque no es "libre"), lo agregamos temporalmente
                if (!Array.from(selectTerreno.options).some(opt => opt.value == task.id_terreno)) {
                    const opt = document.createElement('option');
                    opt.value = task.id_terreno;
                    opt.text = task.terreno ? task.terreno.nombre : 'Terreno Actual';
                    selectTerreno.add(opt);
                }
                selectTerreno.value = task.id_terreno;

                document.getElementById('edit_general_trabajador').value = task.documento_trabajador;
                document.getElementById('edit_general_fecha').value = task.fecha_programada.split(' ')[0];
                openModal('modalEditGeneral');
            } else if (type === 'recoleccion') {
                const form = document.getElementById('formEditRecoleccion');
                form.action = `{{ url('/admin/tareas/update-recoleccion') }}/${task.id_cultivo}`;
                document.getElementById('edit_recoleccion_trabajador').value = task.documento_trabajador;
                document.getElementById('edit_recoleccion_fecha').value = (task.fecha_recoleccion || task.fecha_programada).split(' ')[0];
                document.getElementById('edit_recoleccion_desc').value = task.descripcion_recoleccion || task.sub_descripcion || '';
                openModal('modalEditRecoleccion');
            }
        }


        // --- Search Logic for Modals ---
        let lotesTimeout = null;
        let workersTimeout = null;

        function debounceLotesSearch(query, type) {
            clearTimeout(lotesTimeout);
            if (query.length < 2) {
                document.getElementById(`loteResults${type}`).classList.add('hidden');
                return;
            }
            lotesTimeout = setTimeout(() => performLotesSearch(query, type), 300);
        }

        function performLotesSearch(query, type) {
            const resultsDiv = document.getElementById(`loteResults${type}`);
            resultsDiv.innerHTML = '<div class="p-4 text-xs font-bold text-gray-400 animate-pulse uppercase tracking-widest">Buscando lotes...</div>';
            resultsDiv.classList.remove('hidden');

            fetch(`{{ route('admin.tareas.buscar_lotes') }}?q=${query}`)
                .then(response => response.json())
                .then(data => {
                    resultsDiv.innerHTML = '';
                    if (data.length === 0) {
                        resultsDiv.innerHTML = `
    <div class="p-6 text-center">
        <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">No se encontraron lotes activos</p>
        <a href="{{ route('admin.cosechas.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-100 transition-all">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
            </svg>
            Ir a Control de Cosechas
        </a>
    </div>`;
                        return;
                    }

                    data.forEach(lote => {
                        const div = document.createElement('div');
                        div.className = "p-4 hover:bg-blue-50 cursor-pointer border-b border-gray-50 last:border-0 transition-colors group";
                        div.onclick = () => selectLote(lote.id, lote.nombre, lote.info, type);
                        div.innerHTML = `
    <div class="flex items-center gap-3">
        <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
        </div>
        <div>
            <p class="text-[11px] font-black text-gray-900 uppercase">${lote.nombre}</p>
            <p class="text-[9px] text-gray-400 font-bold uppercase">${lote.info}</p>
        </div>
    </div>`;
                        resultsDiv.appendChild(div);
                    });
                });
        }

        function selectLote(id, nombre, info, type) {
            document.getElementById(`hiddenIdCosecha${type}`).value = id;
            document.getElementById(`loteSearchContainer${type}`).classList.add('hidden');

            document.getElementById(`feedbackLoteName${type}`).innerText = nombre;
            document.getElementById(`feedbackLoteInfo${type}`).innerText = info;
            document.getElementById(`selectedLoteFeedback${type}`).classList.remove('hidden');

            document.getElementById(`loteResults${type}`).classList.add('hidden');
        }

        function clearLoteSelection(type) {
            document.getElementById(`hiddenIdCosecha${type}`).value = '';
            document.getElementById(`selectedLoteFeedback${type}`).classList.add('hidden');
            document.getElementById(`loteSearchContainer${type}`).classList.remove('hidden');
            document.getElementById(`loteSearchInput${type}`).value = '';
            document.getElementById(`loteSearchInput${type}`).focus();
        }

        function debounceTrabajadoresSearch(query, type) {
            clearTimeout(workersTimeout);
            if (query.length < 2) {
                document.getElementById(`workerResults${type}`).classList.add('hidden');
                return;
            }
            workersTimeout = setTimeout(() => performTrabajadoresSearch(query, type), 300);
        }

        function performTrabajadoresSearch(query, type) {
            const resultsDiv = document.getElementById(`workerResults${type}`);
            let accentColor = 'purple';
            if (type === 'Riego') accentColor = 'blue';
            if (type === 'General') accentColor = 'emerald';

            resultsDiv.innerHTML = `<div class="p-4 text-xs font-bold text-gray-400 animate-pulse uppercase tracking-widest">Buscando personal...</div>`;
            resultsDiv.classList.remove('hidden');

            fetch(`{{ route('admin.tareas.buscar_trabajadores') }}?q=${query}`)
                .then(response => response.json())
                .then(data => {
                    resultsDiv.innerHTML = '';
                    if (data.length === 0) {
                        resultsDiv.innerHTML = `
        <div class="p-6 text-center">
            <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Trabajador no encontrado</p>
            <a href="{{ route('admin.usuarios.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-${accentColor}-50 text-${accentColor}-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-${accentColor}-100 transition-all">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                Ir a Gestión de Personal
            </a>
        </div>`;
                        return;
                    }

                    data.forEach(worker => {
                        const div = document.createElement('div');
                        div.className = `p-4 hover:bg-${accentColor}-50 cursor-pointer border-b border-gray-50 last:border-0 transition-colors group`;
                        div.onclick = () => selectWorker(worker.id, worker.nombre, worker.info, type);
                        div.innerHTML = `
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-${accentColor}-50 text-${accentColor}-600 flex items-center justify-center group-hover:bg-${accentColor}-600 group-hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div>
                <p class="text-[11px] font-black text-gray-900 uppercase">${worker.nombre}</p>
                <p class="text-[9px] text-gray-400 font-bold uppercase">${worker.info}</p>
            </div>
        </div>`;
                        resultsDiv.appendChild(div);
                    });
                });
        }

        // --- Terrenos Search Logic ---
        let terrenosTimeout = null;

        function debounceTerrenosSearch(query) {
            clearTimeout(terrenosTimeout);
            if (query.trim().length === 0) {
                document.getElementById('terrenoResults').classList.add('hidden');
                return;
            }
            terrenosTimeout = setTimeout(() => performTerrenosSearch(query), 300);
        }

        function performTerrenosSearch(query) {
            const resultsDiv = document.getElementById('terrenoResults');
            resultsDiv.innerHTML = '<div class="p-4 text-xs font-bold text-gray-400 animate-pulse uppercase tracking-widest">Buscando terrenos...</div>';
            resultsDiv.classList.remove('hidden');

            fetch(`{{ route('admin.tareas.buscar_terrenos') }}?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(items => {
                    resultsDiv.innerHTML = '';
                    if (items.length === 0) {
                        resultsDiv.innerHTML = `
        <div class="p-6 text-center">
            <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Terreno no encontrado o (Ocupado)</p>
            <a href="{{ route('admin.terrenos.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-600 rounded-xl text-[10px] font-black uppercase hover:bg-emerald-100 transition-all">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                </svg>
                Ir a Gestión de Terrenos
            </a>
        </div>`;
                        return;
                    }

                    items.forEach(item => {
                        const div = document.createElement('div');
                        div.className = "p-4 hover:bg-emerald-50 cursor-pointer border-b border-gray-50 last:border-0 transition-colors group";
                        div.onclick = () => selectTerreno(item.id, item.nombre, item.info);
                        div.innerHTML = `
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <div>
                <p class="text-[11px] font-black text-gray-900 uppercase italic">${item.nombre}</p>
                <p class="text-[9px] text-gray-400 font-bold uppercase">${item.info}</p>
            </div>
        </div>`;
                        resultsDiv.appendChild(div);
                    });
                });
        }

        function selectTerreno(id, nombre, info) {
            document.getElementById('hiddenIdTerreno').value = id;
            document.getElementById('feedbackTerrenoName').innerText = nombre;
            document.getElementById('feedbackTerrenoInfo').innerText = info;

            document.getElementById('terrenoSearchContainer').classList.add('hidden');
            document.getElementById('selectedTerrenoFeedback').classList.remove('hidden');
            document.getElementById('terrenoResults').classList.add('hidden');
        }

        function clearTerrenoSelection() {
            document.getElementById('hiddenIdTerreno').value = '';
            document.getElementById('terrenoSearchContainer').classList.remove('hidden');
            document.getElementById('selectedTerrenoFeedback').classList.add('hidden');
            document.getElementById('terrenoSearchInput').value = '';
            document.getElementById('terrenoSearchInput').focus();
        }

        function selectWorker(id, nombre, info, type) {
            document.getElementById(`hiddenDocTrabajador${type}`).value = id;
            document.getElementById(`workerSearchContainer${type}`).classList.add('hidden');

            document.getElementById(`feedbackWorkerName${type}`).innerText = nombre;
            document.getElementById(`feedbackWorkerInfo${type}`).innerText = info;
            document.getElementById(`selectedWorkerFeedback${type}`).classList.remove('hidden');

            document.getElementById(`workerResults${type}`).classList.add('hidden');
        }

        function clearWorkerSelection(type) {
            document.getElementById(`hiddenDocTrabajador${type}`).value = '';
            document.getElementById(`selectedWorkerFeedback${type}`).classList.add('hidden');
            document.getElementById(`workerSearchContainer${type}`).classList.remove('hidden');
            document.getElementById(`workerSearchInput${type}`).value = '';
            document.getElementById(`workerSearchInput${type}`).focus();
        }

        // --- Insumos Search Logic ---
        let insumosTimeout = null;

        function debounceInsumosSearch(query) {
            clearTimeout(insumosTimeout);
            if (query.trim().length === 0) {
                document.getElementById('insumoResults').classList.add('hidden');
                return;
            }
            insumosTimeout = setTimeout(() => performInsumosSearch(query), 300);
        }

        function performInsumosSearch(query) {
            const resultsDiv = document.getElementById('insumoResults');
            resultsDiv.innerHTML = '<div class="p-4 text-xs font-bold text-gray-400 animate-pulse uppercase tracking-widest">Buscando productos...</div>';
            resultsDiv.classList.remove('hidden');

            fetch(`{{ route('admin.tareas.buscar_insumos') }}?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(items => {
                    resultsDiv.innerHTML = '';
                    if (items.length === 0) {
                        resultsDiv.innerHTML = `
        <div class="p-6 text-center">
            <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Insumo no encontrado</p>
            <a href="{{ route('admin.insumos.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-purple-50 text-purple-600 rounded-xl text-[10px] font-black uppercase hover:bg-purple-100 transition-all">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                </svg>
                Ir a Inventario
            </a>
        </div>`;
                        return;
                    }

                    items.forEach(item => {
                        const hasStock = parseFloat(item.stock) > 0;
                        const itemDiv = document.createElement('div');
                        itemDiv.className = "w-full border-b border-gray-50 last:border-0 flex items-center justify-between group";

                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.disabled = !hasStock;
                        btn.className = `flex-1 text-left p-4 transition-colors flex items-center gap-3 ${hasStock ? 'hover:bg-purple-50' : 'opacity-60 cursor-not-allowed bg-gray-50'}`;
                        btn.innerHTML = `
        <div class="w-8 h-8 rounded-lg bg-gray-50 text-purple-600 flex items-center justify-center group-hover:bg-white transition-colors border border-transparent group-hover:border-purple-100">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
            </svg>
        </div>
        <div class="overflow-hidden">
            <p class="text-[11px] font-black text-gray-900 uppercase truncate">${item.nombre}</p>
            <p class="text-[9px] font-bold uppercase ${hasStock ? 'text-gray-400' : 'text-red-500'}">
                ${hasStock ? `Stock: ${item.stock} • ID: #${item.id}` : 'SIN STOCK DISPONIBLE'}
            </p>
        </div>
        `;
                        if (hasStock) btn.onclick = () => selectInsumo(item);
                        itemDiv.appendChild(btn);

                        if (!hasStock) {
                            const vendorLink = document.createElement('a');
                            vendorLink.href = "{{ route('admin.proveedores.index') }}";
                            vendorLink.className = "mr-4 p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors group/buy";
                            vendorLink.title = "Comprar a Proveedor";
                            vendorLink.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>`;
                            itemDiv.appendChild(vendorLink);
                        }

                        resultsDiv.appendChild(itemDiv);
                    });
                });
        }

        function selectInsumo(item) {
            document.getElementById('hiddenIdInsumo').value = item.id;
            document.getElementById('feedbackInsumoName').innerText = item.nombre;
            document.getElementById('feedbackInsumoInfo').innerText = `Stock: ${item.stock} • ID: #${item.id}`;

            document.getElementById('insumoSearchContainer').classList.add('hidden');
            document.getElementById('selectedInsumoFeedback').classList.remove('hidden');
            document.getElementById('insumoResults').classList.add('hidden');
        }

        function clearInsumoSelection() {
            document.getElementById('hiddenIdInsumo').value = '';
            document.getElementById('insumoSearchContainer').classList.remove('hidden');
            document.getElementById('selectedInsumoFeedback').classList.add('hidden');
            document.getElementById('insumoSearchInput').value = '';
            document.getElementById('insumoSearchInput').focus();
        }
    </script>
    @endpush

    @endsection