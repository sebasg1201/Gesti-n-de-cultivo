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
                const isRealizado = (props.estado == 15);
                const isPerdida = (props.estado == 16 || props.estado == 18);

                // 1. REGISTRO GENERAL DE ASISTENCIA
                if (props.tipo === 'registro') {
                    if (yaRegistroGeneral) return; 
                    yaRegistroGeneral = true;
                    listEl.insertAdjacentHTML('afterbegin', `
                        <div class="bg-emerald-50 border border-emerald-100 p-6 rounded-[2rem] space-y-4 shadow-sm shadow-emerald-50/50 mb-4 animate-in slide-in-from-bottom-2 duration-300">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-emerald-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest leading-none mb-1">Tu Registro</p>
                                    <p class="font-black text-emerald-900 text-lg">Asistencia Confirmada</p>
                                </div>
                            </div>
                            <div class="bg-white/60 p-4 rounded-2xl border border-emerald-100/50">
                                <p class="text-xs font-bold text-emerald-800 leading-relaxed italic">"${props.observacion || 'Sin observaciones'}"</p>
                            </div>
                            ${props.foto_url ? `
                                <div class="relative group/img cursor-pointer overflow-hidden rounded-[1.5rem] border-2 border-emerald-200 shadow-md" onclick="viewPhoto('${props.foto_url}')">
                                    <img src="${props.foto_url}" class="w-full h-40 object-cover group-hover/img:scale-105 transition-transform duration-700" onerror="this.src='https://placehold.co/600x400/f0fdf4/059669?text=Error+al+cargar+imagen'">
                                    <div class="absolute inset-0 bg-emerald-900/40 flex items-center justify-center opacity-0 group-hover/img:opacity-100 transition-opacity">
                                        <span class="bg-white text-emerald-700 px-6 py-2 rounded-full text-xs font-black shadow-xl">Ver evidencia completa</span>
                                    </div>
                                </div>
                            ` : ''}
                        </div>
                    `);
                } 
                // 2. FASES DE CULTIVO
                else if (props.tipo === 'fase') {
                    if (listEl.children.length > 0) {
                        listEl.insertAdjacentHTML('beforeend', '<div class="w-full h-px bg-emerald-200 my-6 border-t border-dashed border-emerald-400 opacity-60"></div>');
                    }
                    const canRegister = (!isPerdida && !isRealizado && props.estado === 11);
                    const isFuturo = (props.estado === 14);
                    const colorFase = isPerdida ? 'red' : (isRealizado ? 'emerald' : (isFuturo ? 'amber' : 'emerald'));
                    const iconColor = isFuturo ? '#d97706' : '#059669';

                    listEl.insertAdjacentHTML('beforeend', `
                        <div class="bg-white rounded-[2rem] p-6 border shadow-sm space-y-4 mb-4 ${isRealizado ? 'bg-emerald-50 border-emerald-100 shadow-emerald-50/50' : 'border-' + colorFase + '-100'} animate-in fade-in duration-300">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 ${isRealizado ? 'bg-emerald-600 text-white' : 'bg-white text-' + colorFase + '-600'} rounded-2xl flex items-center justify-center border border-gray-100 shadow-lg" style="${isRealizado ? '' : 'color: ' + iconColor + ';'}">
                                    ${isRealizado 
                                        ? '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>'
                                        : (isPerdida 
                                            ? '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>'
                                            : '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>')
                                    }
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-${colorFase}-600 uppercase tracking-widest leading-none mb-1">
                                        ${isRealizado ? 'Tu Registro' : 'Fase de Cultivo'} ${isPerdida ? '(Perdida)' : ''}
                                    </p>
                                    <p class="font-black text-${colorFase}-900 text-lg ${isPerdida ? 'line-through opacity-70' : ''}">
                                        ${isRealizado ? 'Labor Completada' : (props.cultivo || 'Cosecha')}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="bg-white/60 p-4 rounded-2xl border border-${colorFase}-100/50">
                                <p class="text-[10px] font-black text-${colorFase}-400 uppercase tracking-widest mb-1">Actividad Programada</p>
                                <p class="text-sm font-bold text-${colorFase}-800 leading-tight mb-2 ${isPerdida ? 'line-through opacity-70' : ''}">${props.descripcion}</p>
                                <div class="pt-2 border-t border-${colorFase}-100/30">
                                    <p class="text-[11px] text-${colorFase}-700 leading-relaxed">${props.resumen || 'Sigue las instrucciones estándar para esta fase.'}</p>
                                </div>
                            </div>
                            
                            ${isRealizado && props.observacion ? `
                                <div class="bg-white/60 p-4 rounded-2xl border border-emerald-100/50">
                                    <p class="text-xs font-bold text-emerald-800 leading-relaxed italic">"${props.observacion}"</p>
                                </div>
                            ` : ''}
                            
                            ${isRealizado && props.foto_url ? `
                                <div class="relative group/img cursor-pointer overflow-hidden rounded-[1.5rem] border-2 border-emerald-200 shadow-md" onclick="viewPhoto('${props.foto_url}')">
                                    <img src="${props.foto_url}" class="w-full h-40 object-cover group-hover/img:scale-105 transition-transform duration-700" onerror="this.src='https://placehold.co/600x400/f0fdf4/059669?text=Error+al+cargar+imagen'">
                                    <div class="absolute inset-0 bg-emerald-900/40 flex items-center justify-center opacity-0 group-hover/img:opacity-100 transition-opacity">
                                        <span class="bg-white text-emerald-700 px-6 py-2 rounded-full text-xs font-black shadow-xl">Ver evidencia</span>
                                    </div>
                                </div>
                            ` : ''}
                        </div>
                    `);           
                } 
                // 3. RIEGOS, INSUMOS Y OTROS
                else {
                    const colorClass = isPerdida ? 'red' : (isRealizado ? 'emerald' : (props.tipo === 'riego' ? 'sky' : 'purple'));
                    const canRegister = props.tipo === 'insumo' && !isPerdida && !isRealizado; 
                    
                    if (listEl.children.length > 0) {
                        listEl.insertAdjacentHTML('beforeend', '<div class="w-full h-px bg-emerald-200 my-6 border-t border-dashed border-emerald-400 opacity-60"></div>');
                    }
                    
                    listEl.insertAdjacentHTML('beforeend', `
                        <div class="bg-${colorClass}-50 border border-${colorClass}-100 p-6 rounded-[2rem] space-y-4 mb-4 ${isRealizado ? 'shadow-sm shadow-emerald-50/50' : ''}">
                            <div class="flex items-center justify-between gap-4 w-full">
                                <div class="flex items-center gap-4 flex-1">
                                    <div class="w-12 h-12 bg-white text-${colorClass}-600 rounded-2xl flex items-center justify-center border border-${colorClass}-200 shadow-sm flex-shrink-0">
                                        ${isRealizado 
                                            ? '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>'
                                            : (props.tipo === 'riego'
                                                ? '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>'
                                                : '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01"/></svg>')
                                        }
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black text-${colorClass}-600 uppercase tracking-widest leading-none mb-1">
                                            ${isRealizado ? 'Tu Registro' : props.tipo} ${isPerdida ? '(Perdida)' : ''}
                                        </p>
                                        <p class="font-black text-${colorClass}-900 text-base leading-tight ${isPerdida ? 'line-through opacity-70' : ''}">
                                            ${isRealizado ? 'Labor Completada' : ev.title}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    ${canRegister ? `
                                        <button onclick="openRegistroModal(null, '${props.id_original}', '${ev.title}')" 
                                                class="bg-white text-${colorClass}-600 p-3 rounded-xl border border-${colorClass}-100 hover:bg-${colorClass}-600 hover:text-white transition-all shadow-sm">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        </button>
                                    ` : ''}
                                </div>
                            </div>
                            
                            ${isRealizado ? `
                                <div class="px-4 py-3 bg-white/30 rounded-2xl border border-emerald-100/20">
                                    <p class="text-[9px] font-black text-emerald-400 uppercase tracking-widest mb-1">${props.tipo === 'riego' ? 'Riego' : 'Insumo'}</p>
                                    <p class="text-[11px] font-bold text-emerald-800 leading-tight">${props.descripcion || 'Labor programada'}</p>
                                </div>
                            ` : ''}
                            
                            ${isRealizado && props.observacion ? `
                                <div class="bg-white/60 p-4 rounded-2xl border border-emerald-100/50">
                                    <p class="text-xs font-bold text-emerald-800 leading-relaxed italic">"${props.observacion}"</p>
                                </div>
                            ` : ''}
                            
                            ${isRealizado && props.foto_url ? `
                                <div class="relative group/img cursor-pointer overflow-hidden rounded-[1.5rem] border-2 border-emerald-200 shadow-md" onclick="viewPhoto('${props.foto_url}')">
                                    <img src="${props.foto_url}" class="w-full h-40 object-cover group-hover/img:scale-105 transition-transform duration-700" onerror="this.src='https://placehold.co/600x400/f0fdf4/059669?text=Error+al+cargar+imagen'">
                                    <div class="absolute inset-0 bg-emerald-900/40 flex items-center justify-center opacity-0 group-hover/img:opacity-100 transition-opacity">
                                        <span class="bg-white text-emerald-700 px-6 py-2 rounded-full text-xs font-black shadow-xl">Ver evidencia</span>
                                    </div>
                                </div>
                            ` : ''}
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
