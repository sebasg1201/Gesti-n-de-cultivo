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

                    <div id="actionArea" class="mt-8 pt-8 border-t border-gray-100 hidden">
                        <button onclick="openRegistroModal()" class="w-full bg-emerald-600 text-white font-black py-5 rounded-[1.5rem] hover:bg-emerald-700 transition-all shadow-xl shadow-emerald-100 flex items-center justify-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Registrar Mi Asistencia Hoy
                        </button>
                    </div>
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
            selectable: true,
            unselectAuto: false,
            dateClick: function(info) {
                updateDayDetails(info.dateStr, info.date);
            }
        });
        calendar.render();

        // Manejar parámetro 'date' de la URL para redirección
        const urlParams = new URLSearchParams(window.location.search);
        const focusDate = urlParams.get('date');
        if (focusDate) {
            setTimeout(() => {
                calendar.gotoDate(focusDate);
                const dateObj = new Date(focusDate + 'T12:00:00');
                updateDayDetails(focusDate, dateObj);
                
                // Aplicar efecto de resaltado al panel de detalles
                const detailsCard = document.getElementById('dayDetailsCard');
                detailsCard.classList.add('ring-4', 'ring-emerald-500/20', 'scale-[1.01]');
                setTimeout(() => detailsCard.classList.remove('ring-4', 'ring-emerald-500/20', 'scale-[1.01]'), 1000);
            }, 300);
        }
    });

    function updateDayDetails(dateStr, dateObj) {
        selectedDate = dateStr;
        const titleEl = document.getElementById('selectedDateTitle');
        const listEl = document.getElementById('eventsList');
        const actionArea = document.getElementById('actionArea');
        
        titleEl.innerText = dateObj.toLocaleDateString('es-ES', { 
            weekday: 'long', day: 'numeric', month: 'long' 
        });

        const allEvents = calendar.getEvents();
        const dailyEvents = allEvents.filter(ev => {
            const evDate = ev.startStr.split('T')[0];
            return evDate === dateStr;
        });

        listEl.innerHTML = '';
        let yaRegistroGeneral = false;

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
                if (props.tipo === 'registro') {
                    yaRegistroGeneral = true;
                    listEl.insertAdjacentHTML('afterbegin', `
                        <div class="bg-emerald-50 border border-emerald-100 p-6 rounded-[2rem] space-y-4 shadow-sm shadow-emerald-50/50">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-emerald-600 rounded-2xl flex items-center justify-center text-white shadow-lg">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest leading-none mb-1">Tu Registro</p>
                                    <p class="font-black text-emerald-900 text-lg">Asistencia Confirmada</p>
                                </div>
                            </div>
                            
                            <div class="bg-white/60 p-4 rounded-2xl border border-emerald-100/50">
                                <p class="text-xs font-bold text-emerald-800 leading-relaxed italic">
                                    "${props.observacion || 'Sin observaciones'}"
                                </p>
                            </div>

                            ${props.foto_url ? `
                                <div class="relative group cursor-pointer overflow-hidden rounded-2xl border-2 border-emerald-200 shadow-md" onclick="viewPhoto('${props.foto_url}')">
                                    <img src="${props.foto_url}" class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-700" onerror="this.src='https://placehold.co/600x400/f0fdf4/059669?text=Error+al+cargar+imagen'">
                                    <div class="absolute inset-0 bg-emerald-900/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <span class="bg-white text-emerald-700 px-6 py-2 rounded-full text-xs font-black shadow-xl">Ver evidencia completa</span>
                                    </div>
                                </div>
                            ` : `
                                <div class="p-4 bg-gray-50/50 rounded-2xl border border-gray-100 text-center">
                                    <p class="text-[10px] font-bold text-gray-400">Sin foto de evidencia</p>
                                </div>
                            `}
                        </div>
                    `);
                } else if (props.tipo === 'fase') {
                    listEl.insertAdjacentHTML('beforeend', `
                        <div class="bg-blue-50 border border-blue-100 p-6 rounded-[2rem] space-y-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-lg">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest leading-none mb-1">Fase de Cultivo</p>
                                    <p class="font-black text-blue-900 text-lg">${props.cultivo || 'Cosecha'}</p>
                                </div>
                            </div>
                            <div class="bg-white/60 p-4 rounded-2xl border border-blue-100/50">
                                <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest mb-1">Actividad Programada</p>
                                <p class="text-sm font-bold text-blue-800 leading-tight mb-2">
                                    ${props.descripcion}
                                </p>
                                <div class="pt-2 border-t border-blue-100/30">
                                    <p class="text-[9px] font-black text-blue-300 uppercase tracking-widest mb-1">Resumen de labores</p>
                                    <p class="text-[11px] text-blue-700 leading-relaxed">
                                        ${props.resumen || 'Sigue las instrucciones estándar para esta fase.'}
                                    </p>
                                </div>
                                ${props.foto_url ? `
                                    <div class="pt-3 mt-3 border-t border-blue-100/30">
                                        <p class="text-[9px] font-black text-blue-400 uppercase tracking-widest mb-2">Evidencia Fotográfica</p>
                                        <div class="relative group cursor-pointer overflow-hidden rounded-xl border border-blue-200 shadow-sm" onclick="viewPhoto('${props.foto_url}')">
                                            <img src="${props.foto_url}" class="w-full h-24 object-cover group-hover:scale-105 transition-transform duration-500">
                                            <div class="absolute inset-0 bg-blue-900/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                <span class="bg-white text-blue-700 px-3 py-1 rounded-full text-[10px] font-black shadow-lg">Ver Foto</span>
                                            </div>
                                        </div>
                                    </div>
                                ` : ''}
                            </div>
                            <div class="flex items-center gap-2 px-2">
                                <div class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></div>
                                <span class="text-[10px] font-black text-blue-500 uppercase tracking-tighter">Acción requerida para hoy</span>
                            </div>
                        </div>
                    `);
                } else {
                    const isRiego = props.tipo === 'riego';
                    const colorClass = isRiego ? 'sky' : 'purple';
                    const canRegister = props.tipo === 'insumo'; 
                    
                    listEl.insertAdjacentHTML('beforeend', `
                        <div class="bg-${colorClass}-50/50 border border-${colorClass}-100 p-5 rounded-3xl flex items-center justify-between gap-4 group hover:bg-white hover:shadow-xl hover:shadow-${colorClass}-200/50 transition-all">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-gray-400 border border-gray-100 group-hover:text-${colorClass}-600 transition-colors" style="color: ${ev.backgroundColor}">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-${colorClass}-400 uppercase tracking-widest">${props.tipo}</p>
                                    <p class="font-bold text-${colorClass}-900">${ev.title}</p>
                                </div>
                            </div>
                            ${canRegister ? `
                                <button onclick="openRegistroModal(null, '${props.id_original}', '${ev.title}')" 
                                        class="bg-white text-${colorClass}-600 p-3 rounded-xl border border-${colorClass}-100 hover:bg-${colorClass}-600 hover:text-white transition-all shadow-sm flex-shrink-0" title="Registrar Trabajo">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                </button>
                            ` : ''}
                            ${props.foto_url ? `
                                <button onclick="viewPhoto('${props.foto_url}')" class="bg-white text-${colorClass}-600 p-3 rounded-xl border border-${colorClass}-100 hover:bg-${colorClass}-600 hover:text-white transition-all shadow-sm flex-shrink-0" title="Ver Evidencia">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </button>
                            ` : ''}
                        </div>
                    `);
                }
            });
        }

        if (!yaRegistroGeneral) {
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            // dateObj viene de FullCalendar y ya es objeto Date
            const selectedDateObj = new Date(dateStr + 'T12:00:00'); // Usar T12:00:00 para evitar problemas de zona horaria
            selectedDateObj.setHours(0, 0, 0, 0);

            if (selectedDateObj < today) {
                actionArea.classList.add('hidden');
            } else {
                actionArea.classList.remove('hidden');
            }
        } else {
            actionArea.classList.add('hidden');
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
