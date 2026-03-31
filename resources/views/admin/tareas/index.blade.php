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
        <div class="group bg-white dark:bg-slate-800 p-1 rounded-[2.5rem] border border-gray-100 dark:border-emerald-900/20 shadow-xl shadow-gray-200/50 dark:shadow-none hover:shadow-blue-200/40 transition-all duration-500 hover:-translate-y-2 relative overflow-hidden">
            <div class="absolute top-0 right-0 p-6 opacity-5 group-hover:opacity-10 transition-opacity">
                <svg class="w-32 h-32 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>
            </div>
            <div class="p-8 space-y-6 relative z-10">
                <div class="w-16 h-16 bg-blue-50 dark:bg-blue-900/30 rounded-3xl flex items-center justify-center text-blue-600 dark:text-blue-400 shadow-inner group-hover:scale-110 transition-transform duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21.5c-3.5 0-6.5-3-6.5-6.5 0-2.5 1.5-5 6.5-11 5 6 6.5 8.5 6.5 11 0 3.5-3 6.5-6.5 6.5z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-black text-gray-900 dark:text-emerald-50 mb-1">Control de Riego</h3>
                    <p class="text-gray-500 dark:text-emerald-500/70 text-sm leading-relaxed">Programa el suministro de agua para tus lotes activos.</p>
                </div>
                <div class="pt-4 flex items-center justify-between">
                    <span class="text-2xl font-black text-blue-600">{{ $riego->count() }} <span class="text-xs text-gray-400 font-bold uppercase tracking-widest">Activos</span></span>
                    <button onclick="openModal('modalRiego')" class="bg-blue-600 text-white p-4 rounded-2xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-200">
                        <svg class="w-6 h-6 transition-transform duration-500 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                    </button>
                </div>
            </div>
            <button onclick="showCategory('riego')" class="w-full py-4 text-xs font-black uppercase tracking-widest text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors border-t border-gray-50 dark:border-emerald-950/20">
                Ver Listado Completo
            </button>
        </div>

        {{-- Card: Insumo --}}
        <div class="group bg-white dark:bg-slate-800 p-1 rounded-[2.5rem] border border-gray-100 dark:border-emerald-900/20 shadow-xl shadow-gray-200/50 dark:shadow-none hover:shadow-purple-200/40 transition-all duration-500 hover:-translate-y-2 relative overflow-hidden">
            <div class="absolute top-0 right-0 p-6 opacity-5 group-hover:opacity-10 transition-opacity">
                <svg class="w-32 h-32 text-purple-600 dark:text-purple-400" fill="currentColor" viewBox="0 0 24 24"><path d="M19 13H5v-2h14v2z"/></svg>
            </div>
            <div class="p-8 space-y-6 relative z-10">
                <div class="w-16 h-16 bg-purple-50 dark:bg-purple-900/30 rounded-3xl flex items-center justify-center text-purple-600 dark:text-purple-400 shadow-inner group-hover:scale-110 transition-transform duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-black text-gray-900 dark:text-emerald-50 mb-1">Insumos y Nutrición</h3>
                    <p class="text-gray-500 dark:text-emerald-500/70 text-sm leading-relaxed">Asigna fertilizantes y agroquímicos a tus cosechas.</p>
                </div>
                <div class="pt-4 flex items-center justify-between">
                    <span class="text-2xl font-black text-purple-600">{{ $insumoCosecha->count() }} <span class="text-xs text-gray-400 font-bold uppercase tracking-widest">Asignados</span></span>
                    <button onclick="openModal('modalInsumo')" class="bg-purple-600 text-white p-4 rounded-2xl hover:bg-purple-700 transition-all shadow-lg shadow-purple-200 group/btn">
                        <svg class="w-6 h-6 transition-transform duration-500 group-hover/btn:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                    </button>
                </div>
            </div>
            <button onclick="showCategory('insumo')" class="w-full py-4 text-xs font-black uppercase tracking-widest text-purple-600 dark:text-purple-400 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-colors border-t border-gray-50 dark:border-emerald-950/20">
                Ver Inventario y Uso
            </button>
        </div>

        {{-- Card: General --}}
        <div class="group bg-white dark:bg-slate-800 p-1 rounded-[2.5rem] border border-gray-100 dark:border-emerald-900/20 shadow-xl shadow-gray-200/50 dark:shadow-none hover:shadow-emerald-200/40 transition-all duration-500 hover:-translate-y-2 relative overflow-hidden">
            <div class="absolute top-0 right-0 p-6 opacity-5 group-hover:opacity-10 transition-opacity">
                <svg class="w-32 h-32 text-emerald-600 dark:text-emerald-400" fill="currentColor" viewBox="0 0 24 24"><path d="M4 6h16v12H4z"/></svg>
            </div>
            <div class="p-8 space-y-6 relative z-10">
                <div class="w-16 h-16 bg-emerald-50 dark:bg-emerald-900/30 rounded-3xl flex items-center justify-center text-emerald-600 dark:text-emerald-400 shadow-inner group-hover:scale-110 transition-transform duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-black text-gray-900 dark:text-emerald-50 mb-1">Fases Labores</h3>
                    <p class="text-gray-500 dark:text-emerald-500/70 text-sm leading-relaxed">Tareas generales de mantenimiento, poda o monitoreo.</p>
                </div>
                <div class="pt-4 flex items-center justify-between">
                    <span class="text-2xl font-black text-emerald-600">{{ $general->count() }} <span class="text-xs text-gray-400 font-bold uppercase tracking-widest">Listadas</span></span>
                    <button onclick="openModal('modalGeneral')" class="bg-emerald-600 text-white p-4 rounded-2xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-200 group/btn">
                        <svg class="w-6 h-6 transition-transform duration-500 group-hover/btn:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                    </button>
                </div>
            </div>
            <button onclick="showCategory('general')" class="w-full py-4 text-xs font-black uppercase tracking-widest text-emerald-600 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors border-t border-gray-50 dark:border-emerald-950/20">
                Ver Cronograma General
            </button>
        </div>
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
        if(contentHeader) {
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
            document.getElementById('edit_riego_fecha').value = task.fecha_programada.split(' ' )[0];
            document.getElementById('edit_riego_obs').value = task.observaciones || '';
            openModal('modalEditRiego');
        } else if (type === 'insumo') {
            const form = document.getElementById('formEditInsumo');
            form.action = `{{ url('/admin/tareas/update-insumo') }}/${task.id_insumo_cosecha}`;
            document.getElementById('edit_insumo_cosecha').value = task.id_cosecha;
            document.getElementById('edit_insumo_trabajador').value = task.documento_trabajador;
            document.getElementById('edit_insumo_producto').value = task.id_insumo;
            document.getElementById('edit_insumo_cantidad').value = task.cantidad_usada;
            document.getElementById('edit_insumo_fecha').value = task.fecha_programada.split(' ' )[0];
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
            document.getElementById('edit_general_fecha').value = task.fecha_programada.split(' ' )[0];
            openModal('modalEditGeneral');
        } else if (type === 'recoleccion') {
            const form = document.getElementById('formEditRecoleccion');
            form.action = `{{ url('/admin/tareas/update-recoleccion') }}/${task.id_cultivo}`;
            document.getElementById('edit_recoleccion_trabajador').value = task.documento_trabajador;
            document.getElementById('edit_recoleccion_fecha').value = (task.fecha_recoleccion || task.fecha_programada).split(' ' )[0];
            document.getElementById('edit_recoleccion_desc').value = task.descripcion_recoleccion || task.sub_descripcion || '';
            openModal('modalEditRecoleccion');
        }
    }
</script>
@endpush

@endsection
