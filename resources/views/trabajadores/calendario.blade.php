@extends('layouts.admin')

@section('title', 'Mi Calendario de Trabajo')

@section('content')
<div class="max-w-[1400px] mx-auto">
    <div class="flex flex-col lg:flex-row gap-8 items-start">
        
        {{-- Columna Izquierda: Calendario (Más pequeño) --}}
        <div class="w-full lg:w-[450px] flex-none">
            <div class="bg-white rounded-[2.5rem] p-6 border border-emerald-50 shadow-2xl shadow-emerald-50/50">
                <div id="calendar" class="compact-calendar"></div>
                <div class="mt-6 p-4 bg-emerald-50 rounded-2xl border border-emerald-100">
                    <p class="text-[10px] font-black text-emerald-700 uppercase tracking-widest text-center">
                        Selecciona un día para ver detalles
                    </p>
                </div>
            </div>
        </div>

        {{-- Columna Derecha: Panel de Detalles --}}
        <div class="flex-1 w-full">
            <div id="dayDetailsCard" class="bg-white rounded-[2.5rem] border border-gray-100 shadow-2xl shadow-gray-100/50 min-h-[550px] flex flex-col overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-600 to-teal-700 p-8 lg:p-10 text-white">
                    <p class="text-xs font-black uppercase tracking-[0.2em] opacity-80 mb-2" id="detailType">Agenda del Día</p>
                    <h2 class="text-3xl font-black tracking-tight" id="selectedDateTitle">Selecciona una fecha</h2>
                </div>

                <div class="p-8 lg:p-10 flex-1 flex flex-col">
                    <div id="eventsList" class="space-y-4 flex-1">
                        <div class="flex flex-col items-center justify-center h-full text-center py-20 opacity-30">
                            <svg class="w-20 h-20 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002-2z"/></svg>
                            <p class="text-xl font-bold italic">No hay fecha seleccionada</p>
                        </div>
                    </div>

                    {{-- Botón de registro removido: el registro se gestiona desde la vista de Tareas --}}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal para Registrar Día Trabajado (Mismo de antes pero invocado desde el panel) --}}
<div id="modalRegistro" class="fixed inset-0 z-[60] hidden">
    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" onclick="closeRegistroModal()"></div>
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative bg-white rounded-[2.5rem] p-8 lg:p-10 w-full max-w-lg shadow-2xl">
                <div class="flex justify-between items-start mb-6">
                    <h2 class="text-2xl font-black text-gray-900">Registrar Día Trabajado</h2>
                    <button onclick="closeRegistroModal()" class="text-gray-400 hover:text-gray-600 p-2 rounded-xl hover:bg-gray-100 transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                
                <form id="formRegistro" class="space-y-6" enctype="multipart/form-data">
                    <input type="hidden" id="fechaValor" name="fecha_trabajada">
                    <input type="hidden" id="insumoIdValor" name="id_insumo_cosecha">
                    
                    <div id="taskLinkInfo" class="hidden bg-amber-50 border border-amber-100 p-4 rounded-2xl">
                        <p class="text-[10px] font-black text-amber-600 uppercase tracking-widest leading-none mb-1">Vinculado a Tarea</p>
                        <p class="text-sm font-bold text-amber-900" id="linkedTaskName"></p>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 ml-4">Evidencia Fotográfica</label>
                        <div class="relative group">
                            <input type="file" name="foto_evidencia" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="w-full bg-emerald-50 border-2 border-dashed border-emerald-200 rounded-2xl p-6 text-center group-hover:bg-emerald-100/50 transition-all">
                                <p class="text-sm font-bold text-emerald-700">Subir foto de evidencia</p>
                                <p class="text-[10px] text-emerald-500 mt-1">Opcional: PNG, JPG hasta 2MB</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 ml-4">Observaciones</label>
                        <textarea name="observacion" rows="3" class="w-full bg-gray-50 border border-gray-100 p-4 rounded-2xl focus:border-emerald-500 transition-all focus:outline-none shadow-inner" placeholder="¿Qué realizaste hoy?"></textarea>
                    </div>

                    <button type="button" onclick="submitRegistro()" class="w-full bg-emerald-600 text-white font-black py-5 rounded-[1.5rem] hover:bg-emerald-700 transition-all shadow-xl shadow-emerald-100">
                        Confirmar Asistencia
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.10/locales/es.global.min.js'></script>
<script>
    let calendar;
    let selectedDate = null;

    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            height: 480,
            headerToolbar: {
                left: 'prev,next',
                center: 'title',
                right: 'today'
            },
            events: '{{ route('trabajador.calendario.eventos') }}',
            eventsSet: function(events) {
                if (window.isCalendarFirstLoad === undefined) {
                    window.isCalendarFirstLoad = true;
                }
                if (window.isCalendarFirstLoad) {
                    window.isCalendarFirstLoad = false;
                    
                    // Pequeño timeout para asegurar que getEvents() está listo internamente en FullCalendar
                    setTimeout(() => {
                        const urlParams = new URLSearchParams(window.location.search);
                        const focusDate = urlParams.get('date');
                        if (focusDate) {
                            calendar.gotoDate(focusDate);
                            calendar.select(focusDate); // Selecciona visualmente el día
                            
                            const dateObj = new Date(focusDate + 'T12:00:00');
                            updateDayDetails(focusDate, dateObj);
                            
                            const detailsCard = document.getElementById('dayDetailsCard');
                            if (detailsCard) {
                                detailsCard.classList.add('ring-4', 'ring-emerald-500/20', 'scale-[1.01]');
                                setTimeout(() => detailsCard.classList.remove('ring-4', 'ring-emerald-500/20', 'scale-[1.01]'), 1000);
                            }
                        } else {
                            const today = new Date();
                            const todayStr = today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0') + '-' + String(today.getDate()).padStart(2, '0');
                            calendar.select(todayStr);
                            updateDayDetails(todayStr, today);
                        }
                    }, 50);
                } else if (typeof selectedDate !== 'undefined' && selectedDate) {
                    setTimeout(() => {
                        const dateObj = new Date(selectedDate + 'T12:00:00');
                        updateDayDetails(selectedDate, dateObj);
                    }, 10);
                }
            },
            selectable: true,
            unselectAuto: false,
            dateClick: function(info) {
                updateDayDetails(info.dateStr, info.date);
            }
        });
        calendar.render();

    });

    function updateDayDetails(dateStr, dateObj) {
        selectedDate = dateStr;
        const titleEl = document.getElementById('selectedDateTitle');
        const listEl = document.getElementById('eventsList');
        
        titleEl.innerText = dateObj.toLocaleDateString('es-ES', { 
            weekday: 'long', day: 'numeric', month: 'long' 
        });

        const allEvents = calendar.getEvents();
        const dailyEvents = allEvents.filter(ev => {
            const evDate = ev.startStr.split('T')[0];
            return evDate === dateStr;
        });

        listEl.innerHTML = '';
        window._sidebarRenderedKeys = new Set();

        if (dailyEvents.length === 0) {
            listEl.innerHTML = `
                <div class="flex flex-col items-center justify-center h-full text-center py-10 opacity-40">
                    <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-sm font-bold">Sin actividades programadas</p>
                </div>
            `;
        } else {
            dailyEvents.forEach(ev => {
                const props = ev.extendedProps;
                const isRealizado = (props.estado == 15);
                const isPerdida = (props.estado == 16 || props.estado == 18);
                const tipoLower = props.tipo.toLowerCase();
                
                // --- VISTA REALIZADO (Diseño Imagen 1228) ---
                if (props.tipo === 'registro') {
                    // Evitar duplicados exactos en el sidebar (Bug de varias tarjetas)
                    const uniqueKey = `registro_${ev.start || ev.startStr}_${props.descripcion}`;
                    if (window._sidebarRenderedKeys?.has(uniqueKey)) return;
                    window._sidebarRenderedKeys?.add(uniqueKey);

                    listEl.insertAdjacentHTML('beforeend', `
                        <div class="bg-white border-2 border-emerald-50 p-8 rounded-[3rem] space-y-6 shadow-2xl shadow-emerald-700/5 relative overflow-hidden animate-in fade-in slide-in-from-bottom-4 duration-500 mb-6 mx-2">
                            <div class="absolute left-0 top-0 bottom-0 w-2.5 bg-emerald-500"></div>
                            
                            <div class="flex items-center gap-5">
                                <div class="w-14 h-14 bg-emerald-500 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-emerald-200">
                                    <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <div class="space-y-0.5">
                                    <p class="text-[10px] font-black text-emerald-400 uppercase tracking-[0.25em] leading-none mb-1">TU REGISTRO</p>
                                    <h4 class="font-black text-emerald-900 text-xl tracking-tight">Asistencia Confirmada</h4>
                                </div>
                            </div>

                            <div class="bg-gray-50/70 p-8 rounded-[2.5rem] border border-gray-100/50 shadow-inner px-8">
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="w-2.5 h-2.5 bg-emerald-400 rounded-full shadow-[0_0_8px_rgba(52,211,153,0.6)]"></div>
                                    <p class="text-[11px] font-black text-emerald-400 uppercase tracking-widest">${tipoLower === 'riego' ? 'HIDRATACIÓN' : (tipoLower === 'insumo' ? 'NUTRICIÓN' : 'LABOR GENERAL')}</p>
                                </div>
                                <p class="text-emerald-950 font-bold italic leading-relaxed text-base">
                                    "${props.descripcion || 'Se completó la tarea satisfactoriamente.'}"
                                </p>
                            </div>
                        </div>
                    `);
                    return;
                } else {
                    const isRealizado = (props.estado == 15);
                    const colorClass = isPerdida ? 'red' : (tipoLower === 'riego' ? 'blue' : (tipoLower === 'insumo' ? 'purple' : 'emerald'));
                    
                    listEl.insertAdjacentHTML('beforeend', `
                        <div class="bg-white border border-gray-100 p-6 rounded-[2.5rem] flex flex-col gap-4 group hover:shadow-xl hover:shadow-${colorClass}-200/50 transition-all ${isPerdida ? 'opacity-90' : ''} relative overflow-hidden mb-6 mx-2">
                            <div class="absolute left-0 top-0 bottom-0 w-2 bg-${colorClass}-600 opacity-60"></div>
                            
                            <div class="flex items-center justify-between gap-4 w-full pl-2">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-gray-50 rounded-2xl flex items-center justify-center text-gray-400 border border-gray-100 group-hover:text-${colorClass}-600 group-hover:bg-${colorClass}-50 transition-all shadow-sm">
                                        ${isPerdida 
                                            ? '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>'
                                            : (tipoLower === 'riego' 
                                                ? '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21.5c-3.5 0-6.5-3-6.5-6.5 0-2.5 1.5-5 6.5-11 5 6 6.5 8.5 6.5 11 0 3.5-3 6.5-6.5 6.5z" /></svg>'
                                                : (tipoLower === 'insumo'
                                                    ? '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>'
                                                    : '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>'))
                                        }
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">${props.tipo} ${isPerdida ? '(Perdida)' : ''} ${isRealizado ? '(Completada)' : ''}</p>
                                        <p class="font-black text-gray-900 text-lg tracking-tight ${isPerdida ? 'line-through opacity-70' : ''}">${ev.title}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);
                }
            });
        }

    }

    // Modal para ver foto
    function viewPhoto(url) {
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/90 backdrop-blur-xl animate-in fade-in duration-300';
        modal.innerHTML = `
            <div class="relative max-w-4xl w-full">
                <button class="absolute -top-12 right-0 text-white p-2 hover:bg-white/10 rounded-full transition-all" onclick="this.closest('.fixed').remove()">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
                <img src="${url}" class="w-full h-auto max-h-[80vh] object-contain rounded-3xl shadow-2xl">
            </div>
        `;
        document.body.appendChild(modal);
        modal.addEventListener('click', (e) => {
            if (e.target === modal) modal.remove();
        });
    }

    function openRegistroModal(date = null, insumoId = null, taskName = '') {
        const dateToUse = date || selectedDate;
        if (!dateToUse) return;
        
        document.getElementById('fechaValor').value = dateToUse;
        document.getElementById('insumoIdValor').value = insumoId || '';
        
        const taskInfo = document.getElementById('taskLinkInfo');
        const taskNameEl = document.getElementById('linkedTaskName');
        
        if (insumoId) {
            taskNameEl.innerText = taskName;
            taskInfo.classList.remove('hidden');
        } else {
            taskInfo.classList.add('hidden');
        }

        document.getElementById('modalRegistro').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeRegistroModal() {
        document.getElementById('modalRegistro').classList.add('hidden');
        document.body.style.overflow = 'auto';
        document.getElementById('formRegistro').reset();
    }

    function submitRegistro() {
        const form = document.getElementById('formRegistro');
        const formData = new FormData(form);
        
        fetch('{{ route('trabajador.calendario.store') }}', {
            method: 'POST',
            body: formData,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                closeRegistroModal();
                calendar.refetchEvents().then(() => {
                    const dateObj = new Date(selectedDate + 'T12:00:00');
                    updateDayDetails(selectedDate, dateObj);
                });
            } else {
                alert(data.error || 'Error al guardar');
            }
        });
    }
</script>

<style>
    .fc {
        --fc-border-color: #f8fafc;
        --fc-button-bg-color: #059669;
        --fc-button-border-color: #059669;
        --fc-button-hover-bg-color: #047857;
        --fc-button-active-bg-color: #065f46;
        --fc-today-bg-color: #f0fdf4;
    }
    .fc .fc-toolbar-title {
        font-weight: 900;
        color: #064e3b;
        text-transform: capitalize;
        font-size: 1rem !important;
    }
    .fc .fc-button {
        border-radius: 0.75rem;
        font-weight: 700;
        font-size: 0.65rem;
        padding: 0.4rem 0.6rem;
    }
    .fc .fc-col-header-cell {
        background: #f8fafc;
        padding: 0.5rem 0;
        font-weight: 900;
        text-transform: uppercase;
        font-size: 0.6rem;
        color: #94a3b8;
    }
    .fc-daygrid-day-number {
        font-size: 0.75rem;
        font-weight: 700;
        color: #64748b;
        padding: 4px !important;
    }
    .fc-event {
        border-radius: 4px;
        font-size: 0.65rem;
        border: none;
    }
    .fc .fc-daygrid-day.fc-day-today {
        background-color: #f0fdf4 !important;
    }
    .fc-daygrid-event-h-dot {
        background: currentColor;
    }
    .compact-calendar {
        font-family: inherit;
    }
</style>
@endpush
@endsection
