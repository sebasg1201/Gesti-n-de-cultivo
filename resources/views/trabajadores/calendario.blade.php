@extends('layouts.admin')

@section('title', 'Mi Calendario de Trabajo')

@section('content')
<div class="max-w-[1400px] mx-auto">
    <div class="flex flex-col lg:flex-row gap-8 items-start">

        {{-- Columna Izquierda: Calendario (Más pequeño) --}}
        <div class="w-full lg:w-[450px] flex-none">
            <div class="bg-white dark:bg-slate-800 rounded-3xl lg:rounded-[2.5rem] p-4 lg:p-6 border border-emerald-50 dark:border-emerald-900/20 shadow-2xl shadow-emerald-50/50 dark:shadow-none transition-all duration-300">
                <div id="calendar" class="compact-calendar dark:text-emerald-50"></div>
                <div class="mt-6 p-4 bg-emerald-50 dark:bg-slate-900/50 rounded-2xl border border-emerald-100 dark:border-emerald-900/30">
                    <p class="text-[10px] font-black text-emerald-700 dark:text-emerald-400 uppercase tracking-widest text-center">
                        Selecciona un día para ver detalles
                    </p>
                </div>
            </div>
        </div>

        {{-- Columna Derecha: Panel de Detalles --}}
        <div class="flex-1 w-full">
            <div id="dayDetailsCard" class="bg-white dark:bg-slate-800 rounded-3xl lg:rounded-[2.5rem] border border-gray-100 dark:border-emerald-900/20 shadow-2xl shadow-gray-100/50 dark:shadow-none min-h-[450px] lg:min-h-[550px] flex flex-col overflow-hidden transition-all duration-300">
                <div class="relative overflow-hidden bg-gradient-to-r from-emerald-600 to-teal-700 dark:from-emerald-700 dark:to-slate-900 p-6 lg:p-10 text-white group">
                    {{-- Decoración Premium --}}
                    <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-white/10 rounded-full blur-2xl group-hover:bg-white/20 transition-all duration-700"></div>
                    <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-24 h-24 bg-emerald-400/20 rounded-full blur-xl group-hover:bg-emerald-400/30 transition-all duration-700"></div>
                    
                    <div class="relative">
                        <p class="text-xs font-black uppercase tracking-[0.2em] opacity-80 mb-2" id="detailType">Agenda del Día</p>
                        <h2 class="text-3xl font-black tracking-tight" id="selectedDateTitle">Selecciona una fecha</h2>
                    </div>
                </div>

                <div class="p-6 lg:p-10 flex-1 flex flex-col">
                    <div id="eventsList" class="space-y-4 flex-1">
                        <div class="flex flex-col items-center justify-center h-full text-center py-20 opacity-30">
                            <svg class="w-20 h-20 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002-2z" />
                            </svg>
                            <p class="text-xl font-bold italic">No hay fecha seleccionada</p>
                        </div>
                    </div>

                    {{-- Registro removido de aquí: se gestiona en la vista de Dashboard principal --}}
                </div>
            </div>
        </div>

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.10/locales/es.global.min.js'></script>
<script>
    // Safelist para Tailwind CSS (colores dinámicos generados en JS)
    const tlSafelist = "bg-sky-50 border-sky-100 text-sky-600 border-sky-200 text-sky-900 border-sky-100/20 text-sky-400 text-sky-800 border-sky-100/50 bg-sky-900/40 text-sky-700 shadow-sky-100/50 shadow-sky-50/50 bg-purple-50 border-purple-100 text-purple-600 border-purple-200 text-purple-900 border-purple-100/20 text-purple-400 text-purple-800 border-purple-100/50 bg-purple-900/40 text-purple-700 shadow-purple-100/50 shadow-purple-50/50 bg-emerald-50 border-emerald-100 text-emerald-600 border-emerald-200 text-emerald-900 border-emerald-100/20 text-emerald-400 text-emerald-800 border-emerald-100/50 bg-emerald-900/40 text-emerald-700 shadow-emerald-100/50 shadow-emerald-50/50 bg-amber-50 border-amber-100 text-amber-600 border-amber-200 text-amber-900 border-amber-100/20 text-amber-400 text-amber-800 border-amber-100/50 bg-amber-900/40 text-amber-700 border-red-50 border-red-100 border-red-100/20 text-red-400 text-red-800 text-red-900 text-red-600 bg-red-50 bg-red-900/40 text-red-700 border-red-200 border-red-100/50 shadow-red-100/50";

    let calendar;
    let selectedDate = null;
    const ROUTES = {
        eventos: '{{ route("trabajador.calendario.eventos") }}',
        store: '{{ route("trabajador.calendario.store") }}'
    };

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
            events: ROUTES.eventos,
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
                calendar.select(info.dateStr);
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
            weekday: 'long',
            day: 'numeric',
            month: 'long'
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
                const isRealizado = (props.estado == 15 || props.estado == 19);
                const isPerdida = (props.estado == 16 || props.estado == 18);

                // 1. REGISTRO GENERAL DE ASISTENCIA
                if (props.tipo === 'registro') {
                    if (yaRegistroGeneral) return;
                    yaRegistroGeneral = true;
                    listEl.insertAdjacentHTML('afterbegin', `
                        <div class="bg-emerald-50 dark:bg-slate-900/50 border border-emerald-100 dark:border-emerald-900/50 p-6 rounded-[2rem] space-y-4 shadow-sm shadow-emerald-50/50 dark:shadow-none mb-4 animate-in slide-in-from-bottom-2 duration-300">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-emerald-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-200 dark:shadow-none">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-emerald-600 dark:text-emerald-400 uppercase tracking-widest leading-none mb-1">Tu Registro</p>
                                    <p class="font-black text-emerald-900 dark:text-emerald-50 text-lg">Asistencia Confirmada</p>
                                </div>
                            </div>
                            <div class="bg-white/60 dark:bg-slate-800/60 p-4 rounded-2xl border border-emerald-100/50 dark:border-emerald-900/30">
                                <p class="text-xs font-bold text-emerald-800 dark:text-emerald-400 leading-relaxed italic">"${props.observacion || 'Sin observaciones'}"</p>
                            </div>
                            ${props.foto_url ? `
                                <div class="relative group/img cursor-pointer overflow-hidden rounded-[1.5rem] border-2 border-emerald-200 dark:border-emerald-900 shadow-md" onclick="viewPhoto('${props.foto_url}')">
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
                        listEl.insertAdjacentHTML('beforeend', '<div class="w-full h-px bg-emerald-200 dark:bg-emerald-900/30 my-6 border-t border-dashed border-emerald-400 dark:border-emerald-800 opacity-60"></div>');
                    }
                    const canRegister = (!isPerdida && !isRealizado && props.estado === 11);
                    const isFuturo = (props.estado === 14);
                    const colorFase = isPerdida ? 'red' : (isRealizado ? 'emerald' : (isFuturo ? 'amber' : 'emerald'));
                    const iconColor = isFuturo ? '#d97706' : '#059669';

                    const descLimpia = (props.descripcion || 'Labor programada').replace(/\[.*?\]/g, '').trim();

                    listEl.insertAdjacentHTML('beforeend', `
                        <div class="bg-${colorFase}-50 border border-${colorFase}-100 p-6 rounded-[2rem] space-y-4 mb-4 relative overflow-hidden ${isRealizado ? 'shadow-sm shadow-emerald-100/50' : ''} animate-in fade-in duration-300">
                            {{-- Metadata Top-Right --}}
                            <div class="absolute top-4 right-6 text-right z-10 pointer-events-none">
                                <span class="text-[9px] font-black uppercase text-${colorFase}-600 bg-${colorFase}-50/50 px-2.5 py-1 rounded-lg border border-${colorFase}-200/50 shadow-sm backdrop-blur-sm">
                                    <i class="fas fa-map-marker-alt mr-1"></i>${props.cultivo || 'General'}
                                </span>
                            </div>

                            <div class="flex items-center justify-between gap-4 w-full">
                                <div class="flex items-center gap-4 flex-1">
                                    <div class="w-12 h-12 bg-white text-${colorFase}-600 rounded-2xl flex items-center justify-center border border-${colorFase}-200 shadow-sm flex-shrink-0" ${!isRealizado ? `style="color: ${iconColor};"` : ''}>
                                        ${isRealizado 
                                            ? '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>'
                                            : (isPerdida 
                                                ? '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>'
                                                : '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>')
                                        }
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black text-${colorFase}-600 uppercase tracking-widest leading-none mb-1">
                                            ${isRealizado ? 'Tu Registro' : 'Fase de Cultivo'} ${isPerdida ? '(Perdida)' : ''}
                                        </p>
                                        <p class="font-black text-${colorFase}-900 text-base leading-tight ${isPerdida ? 'line-through opacity-70' : ''}">
                                            ${isRealizado ? (props.estado == 19 ? 'Labor Completada (Retrasó)' : 'Labor Completada') : (props.cultivo || 'Cosecha')}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            ${isRealizado ? `
                                <div class="px-4 py-3 bg-white/30 rounded-2xl border border-${colorFase}-100/20">
                                    <p class="text-[9px] font-black text-${colorFase}-400 uppercase tracking-widest mb-1">Fase de Cultivo</p>
                                    <p class="text-[11px] font-bold text-${colorFase}-800 leading-tight">${descLimpia}</p>
                                </div>
                            ` : `
                                <div class="bg-white/60 p-4 rounded-2xl border border-${colorFase}-100/50">
                                    <p class="text-[10px] font-black text-${colorFase}-400 uppercase tracking-widest mb-1">Actividad Programada</p>
                                    <p class="text-sm font-bold text-${colorFase}-800 leading-tight mb-2 ${isPerdida ? 'line-through opacity-70' : ''}">${descLimpia}</p>
                                    <div class="pt-2 border-t border-${colorFase}-100/30 flex justify-between items-center">
                                        <p class="text-[11px] text-${colorFase}-700 leading-relaxed">${props.resumen || 'Sigue las instrucciones estándar para esta fase.'}</p>
                                    </div>
                                </div>
                            `}
                            
                            ${isRealizado && props.observacion ? `
                                <div class="bg-white/60 p-4 rounded-2xl border border-${colorFase}-100/50">
                                    <p class="text-xs font-bold text-${colorFase}-800 leading-relaxed italic">"${props.observacion}"</p>
                                </div>
                            ` : ''}
                            
                            ${isRealizado && props.foto_url ? `
                                <div class="relative group/img cursor-pointer overflow-hidden rounded-[1.5rem] border-2 border-${colorFase}-200 shadow-md" onclick="viewPhoto('${props.foto_url}')">
                                    <img src="${props.foto_url}" class="w-full h-40 object-cover group-hover/img:scale-105 transition-transform duration-700" onerror="this.src='https://placehold.co/600x400/f0fdf4/059669?text=Error+al+cargar+imagen'">
                                    <div class="absolute inset-0 bg-${colorFase}-900/40 flex items-center justify-center opacity-0 group-hover/img:opacity-100 transition-opacity">
                                        <span class="bg-white text-${colorFase}-700 px-6 py-2 rounded-full text-xs font-black shadow-xl">Ver evidencia</span>
                                    </div>
                                </div>
                            ` : ''}
                        </div>
                    `);
                }
                // 3. RIEGOS, INSUMOS Y OTROS
                else {
                    const colorClass = isPerdida ? 'red' : (props.tipo === 'riego' ? 'sky' : (props.tipo === 'recoleccion' ? 'amber' : 'purple'));
                    const canRegister = !isPerdida && !isRealizado;

                    const descLimpia = (props.descripcion || 'Labor programada').replace(/\[.*?\]/g, '').trim();
                    const titleLimpio = (ev.title || '').replace(/\[.*?\]/g, '').trim();

                    if (listEl.children.length > 0) {
                        listEl.insertAdjacentHTML('beforeend', '<div class="w-full h-px bg-emerald-200 dark:bg-emerald-900/30 my-6 border-t border-dashed border-emerald-400 dark:border-emerald-800 opacity-60"></div>');
                    }

                    listEl.insertAdjacentHTML('beforeend', `
                        <div class="bg-${colorClass}-50 border border-${colorClass}-100 p-6 rounded-[2rem] space-y-4 mb-4 relative overflow-hidden ${isRealizado ? 'shadow-sm shadow-' + colorClass + '-100/50' : ''}">
                            {{-- Metadata Top-Right --}}
                            <div class="absolute top-4 right-6 text-right z-10 pointer-events-none flex flex-col gap-1.5 items-end">
                                <span class="text-[9px] font-black uppercase text-${colorClass}-600 bg-${colorClass}-50/50 px-2.5 py-1 rounded-lg border border-gray-100 shadow-sm backdrop-blur-sm">
                                    <i class="fas fa-seedling mr-1"></i> ${props.variedad || 'Cultivo'}
                                </span>
                                
                                ${props.tipo === 'recoleccion' && isRealizado && props.cantidad ? `
                                    <div class="flex gap-1.5">
                                        <span class="text-[8px] font-bold text-gray-500 bg-white px-2 py-0.5 rounded-lg border border-gray-100 shadow-sm flex items-center">
                                            <span class="w-1 h-1 bg-gray-400 rounded-full mr-1"></span>
                                            Cant: ${props.cantidad}
                                        </span>
                                        <span class="text-[8px] font-bold text-${colorClass}-600 bg-white px-2 py-0.5 rounded-lg border border-gray-100 shadow-sm flex items-center">
                                            <span class="w-1 h-1 bg-${colorClass}-600 rounded-full mr-1"></span>
                                            Cal: ${props.calidad || 'Estándar'}
                                        </span>
                                    </div>
                                ` : ''}
                            </div>

                            <div class="flex items-center justify-between gap-4 w-full">
                                <div class="flex items-center gap-4 flex-1">
                                    <div class="w-12 h-12 bg-white text-${colorClass}-600 rounded-2xl flex items-center justify-center border border-gray-100 shadow-sm flex-shrink-0">
                                        ${isRealizado 
                                            ? '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>'
                                            : (props.tipo === 'riego'
                                                ? '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21.5c-3.5 0-6.5-3-6.5-6.5 0-2.5 1.5-5 6.5-11 5 6 6.5 8.5 6.5 11 0 3.5-3 6.5-6.5 6.5z"/></svg>'
                                                : (props.tipo === 'insumo'
                                                    ? '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>'
                                                    : (props.tipo === 'recoleccion' ? '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>' 
                                                    : '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01"/></svg>')))
                                        }
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black text-${colorClass}-600 uppercase tracking-widest leading-none mb-1">
                                            ${isRealizado ? 'Tu Registro' : (props.tipo === 'recoleccion' ? 'Recolección' : (props.tipo === 'riego' ? 'Riego' : 'Insumo'))} ${isPerdida ? '(Perdida)' : ''}
                                        </p>
                                        <p class="font-black text-${colorClass}-900 dark:text-emerald-50 text-base leading-tight ${isPerdida ? 'line-through opacity-70' : ''}">
                                            ${isRealizado ? (props.estado == 19 ? 'Labor Completada (Retrasó)' : 'Labor Completada') : titleLimpio}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            ${!isRealizado && !isPerdida ? `
                                <div class="bg-white/30 p-4 rounded-2xl border border-${colorClass}-100/20 flex justify-between items-center">
                                    <div class="flex-1">
                                        <p class="text-[9px] font-black text-${colorClass}-400 uppercase tracking-widest mb-1">Detalles de Tarea</p>
                                        <p class="text-[11px] font-bold text-${colorClass}-800 leading-tight">${descLimpia}</p>
                                    </div>
                                </div>
                            ` : (isRealizado ? `
                                <div class="px-4 py-3 bg-white/30 rounded-2xl border border-${colorClass}-100/20">
                                    <p class="text-[9px] font-black text-${colorClass}-400 uppercase tracking-widest mb-1">
                                        ${props.tipo === 'riego' ? 'Riego' : (props.tipo === 'recoleccion' ? 'Recolección' : 'Insumo')}
                                    </p>
                                    <p class="text-[11px] font-bold text-${colorClass}-800 leading-tight">${descLimpia}</p>
                                </div>
                            ` : '')}
                            
                            ${isRealizado && props.observacion ? `
                                <div class="bg-white/60 p-4 rounded-2xl border border-${colorClass}-100/50">
                                    <p class="text-xs font-bold text-${colorClass}-800 leading-relaxed italic">"${props.observacion}"</p>
                                </div>
                            ` : ''}
                            
                            ${isRealizado && props.foto_url ? `
                                <div class="relative group/img cursor-pointer overflow-hidden rounded-[1.5rem] border-2 border-${colorClass}-200 shadow-md" onclick="viewPhoto('${props.foto_url}')">
                                    <img src="${props.foto_url}" class="w-full h-40 object-cover group-hover/img:scale-105 transition-transform duration-700" onerror="this.src='https://placehold.co/600x400/f0fdf4/059669?text=Error+al+cargar+imagen'">
                                    <div class="absolute inset-0 bg-${colorClass}-900/40 flex items-center justify-center opacity-0 group-hover/img:opacity-100 transition-opacity">
                                        <span class="bg-white text-${colorClass}-700 px-6 py-2 rounded-full text-xs font-black shadow-xl">Ver evidencia</span>
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

    function openRegistroModal(date = null, insumoId = null, taskName = '', riegoId = null, faseId = null, cultivoId = null) {
        const dateToUse = date || selectedDate;
        if (!dateToUse) return;

        document.getElementById('fechaValor').value = dateToUse;
        document.getElementById('insumoIdValor').value = insumoId || '';
        document.getElementById('riegoIdValor').value = riegoId || '';
        document.getElementById('faseIdValor').value = faseId || '';
        document.getElementById('cultivoIdValor').value = cultivoId || '';

        const taskInfo = document.getElementById('taskLinkInfo');
        const taskNameEl = document.getElementById('linkedTaskName');

        if (insumoId || riegoId || faseId || cultivoId) {
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
        
        // Reset hidden values
        document.getElementById('insumoIdValor').value = '';
        document.getElementById('riegoIdValor').value = '';
        document.getElementById('faseIdValor').value = '';
        document.getElementById('cultivoIdValor').value = '';
    }

    function submitRegistro() {
        // Obsoleto: registro movido a dashboard
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
        --fc-list-event-hover-bg-color: #f1f5f9;
        --fc-page-bg-color: #ffffff;
    }

    /* Dark Mode Overrides for FullCalendar */
    :where(.dark, .dark *) .fc {
        --fc-border-color: rgba(6, 78, 59, 0.2);
        --fc-today-bg-color: rgba(6, 78, 59, 0.1);
        --fc-page-bg-color: #0f172a;
        --fc-list-event-hover-bg-color: #1e293b;
    }

    :where(.dark, .dark *) .fc .fc-toolbar-title {
        color: #ecfdf5 !important;
    }

    :where(.dark, .dark *) .fc .fc-col-header-cell {
        background: #1e293b !important;
        color: #10b981 !important;
        border-color: rgba(6, 78, 59, 0.3) !important;
    }

    :where(.dark, .dark *) .fc-daygrid-day-number {
        color: #10b981 !important;
    }

    :where(.dark, .dark *) .fc-scrollgrid {
        border-color: rgba(6, 78, 59, 0.3) !important;
    }

    :where(.dark, .dark *) .fc-daygrid-day {
        border-color: rgba(6, 78, 59, 0.2) !important;
    }

    /* Standard Calendar Styles */
    .fc .fc-toolbar-title {
        font-weight: 900;
        color: #064e3b;
        text-transform: capitalize;
        font-size: 1rem !important;
        transition: color 0.3s;
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
        transition: all 0.3s;
    }

    .fc-daygrid-day-number {
        font-size: 0.75rem;
        font-weight: 700;
        color: #64748b;
        padding: 4px !important;
        transition: color 0.3s;
    }

    .fc-event {
        border-radius: 4px;
        font-size: 0.65rem;
        border: none;
    }

    .fc .fc-daygrid-day.fc-day-today {
        background-color: var(--fc-today-bg-color) !important;
    }

    .fc-daygrid-event-h-dot {
        background: currentColor;
    }

    .compact-calendar {
        font-family: inherit;
    }

    /* ==================== CUSTOM SELECTION & TOUCH OPTIMIZATION ==================== */
    
    /* Highlight para el día seleccionado */
    .fc .fc-daygrid-day.fc-day-selected {
        background-color: rgba(16, 185, 129, 0.08) !important; /* Emerald suave */
        position: relative;
    }

    .fc .fc-daygrid-day.fc-day-selected::after {
        content: '';
        position: absolute;
        inset: 2px;
        border: 2px solid #10b981;
        border-radius: 0.75rem;
        pointer-events: none;
        z-index: 5;
    }

    /* Shadow interno para selección */
    .fc .fc-daygrid-day.fc-day-selected .fc-daygrid-day-number {
        color: #064e3b !important;
        background: #ecfdf5;
        border-radius: 6px;
        padding: 2px 6px !important;
    }

    /* TOUCH OPTIMIZATION: Los puntos y eventos no bloquean el clic */
    .fc-daygrid-day-events, .fc-event, .fc-daygrid-event-h-dot {
        pointer-events: none !important;
    }

    /* Asegurar que la celda sea el target principal */
    .fc-daygrid-day {
        cursor: pointer !important;
    }

    /* Mejorar botones en móvil */
    @media (max-width: 640px) {
        .fc .fc-toolbar {
            flex-direction: column;
            gap: 1rem;
        }
        .fc .fc-toolbar-title {
            font-size: 0.9rem !important;
        }
        .fc .fc-button {
            padding: 0.5rem 0.8rem !important;
            font-size: 0.75rem !important;
        }
    }
</style>
@endpush
@endsection