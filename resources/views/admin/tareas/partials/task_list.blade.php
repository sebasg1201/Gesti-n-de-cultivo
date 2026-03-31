@php
$borderColor = 'emerald-500';
$bgLight = 'emerald-50';
$textColor = 'emerald-700';
$shadowColor = 'shadow-emerald-100';

if($type === 'riego') {
$borderColor = 'blue-500';
$bgLight = 'blue-50';
$textColor = 'blue-700';
$shadowColor = 'shadow-blue-100';
} elseif($type === 'insumo') {
$borderColor = 'purple-500';
$bgLight = 'purple-50';
$textColor = 'purple-700';
$shadowColor = 'shadow-purple-100';
}
@endphp

<div class="space-y-6">
    <div class="flex items-center justify-between px-2">
        <h4 class="text-xl font-black text-gray-800 dark:text-emerald-50 tracking-tight">{{ $title }}</h4>
        <div class="flex items-center gap-2">
            @if($type !== 'all')
            <button onclick="showCategory('todas')" class="px-3 py-1 bg-gray-50 dark:bg-slate-900 hover:bg-gray-100 dark:hover:bg-slate-800 text-gray-500 dark:text-emerald-500 text-[10px] font-black uppercase tracking-widest rounded-lg border border-gray-100 dark:border-emerald-900/20 transition-all flex items-center gap-1.5 shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                Ver Todas
            </button>
            @endif
            <span class="px-3 py-1 bg-white dark:bg-slate-800 border border-gray-100 dark:border-emerald-950/30 rounded-full text-[10px] font-black uppercase tracking-widest text-gray-400 dark:text-emerald-500/50 shadow-sm">
                {{ $tasks->count() }} Registros
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 task-list-container" data-type="{{ $type }}">
        @forelse($tasks as $task)
        @php
        // Determine task type and colors
        $itemType = $task->tipo_referencia ?? $type;
        $borderColor = 'emerald-500';
        $bgLight = 'emerald-50';
        $textColor = 'emerald-700';
        $shadowColor = 'shadow-emerald-200/40';
        $accentColor = 'emerald-600';
        $barColor = 'bg-emerald-500';
        $iconSvg = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
        </svg>';
        $bgIconSvg = '
        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />';

        if($itemType === 'riego') {
        $borderColor = 'blue-500'; $bgLight = 'blue-50'; $textColor = 'blue-700'; $shadowColor = 'shadow-blue-200/40'; $accentColor = 'blue-600'; $barColor = 'bg-blue-600';
        $iconSvg = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21.5c-3.5 0-6.5-3-6.5-6.5 0-2.5 1.5-5 6.5-11 5 6 6.5 8.5 6.5 11 0 3.5-3 6.5-6.5 6.5z" />
        </svg>';
        $bgIconSvg = '
        <path d="M12 21.5c-3.5 0-6.5-3-6.5-6.5 0-2.5 1.5-5 6.5-11 5 6 6.5 8.5 6.5 11 0 3.5-3 6.5-6.5 6.5z" />';
        } elseif($itemType === 'insumo') {
        $borderColor = 'purple-500'; $bgLight = 'purple-50'; $textColor = 'purple-700'; $shadowColor = 'shadow-purple-200/40'; $accentColor = 'purple-600'; $barColor = 'bg-purple-600';
        $iconSvg = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
        </svg>';
        $bgIconSvg = '
        <path d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />';
        } elseif($itemType === 'recoleccion') {
        $borderColor = 'orange-500'; $bgLight = 'orange-50'; $textColor = 'orange-700'; $shadowColor = 'shadow-orange-200/40'; $accentColor = 'orange-600'; $barColor = 'bg-orange-600';
        $iconSvg = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
        </svg>';
        $bgIconSvg = '
        <path d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />';
        }

        // Determine Status and Meta
        $date = \Carbon\Carbon::parse($task->fecha_programada);
        $dateDisplay = $date->format('d/m H:i');
        $statusText = 'Pendiente';
        $statusClass = 'bg-yellow-50 dark:bg-yellow-950/20 text-yellow-700 dark:text-yellow-400 border-yellow-100 dark:border-yellow-900/20'; // Default Pendiente

        if($task->id_estado == 15) { // Realizado
        $statusText = 'Completado';
        $statusClass = 'bg-emerald-50 dark:bg-emerald-950/20 text-emerald-700 dark:text-emerald-400 border-emerald-100 dark:border-emerald-900/20';
        } elseif($task->id_estado == 19) { // Realizado con retraso
        $statusText = 'Completado con Retraso';
        $statusClass = 'bg-indigo-50 dark:bg-indigo-950/20 text-indigo-700 dark:text-indigo-400 border-indigo-100 dark:border-indigo-900/20';
        } elseif($task->id_estado == 17) { // En Proceso
        $statusText = 'En Proceso';
        $statusClass = 'bg-blue-50 dark:bg-blue-950/20 text-blue-700 dark:text-blue-400 border-blue-100 dark:border-blue-900/20';
        } elseif(in_array($task->id_estado, [16, 18])) { // Perdida u Oculta
        $statusText = 'Perdida';
        $statusClass = 'bg-red-50 dark:bg-red-950/20 text-red-700 dark:text-red-400 border-red-100 dark:border-red-900/20';
        } elseif($date->isPast()) { // Atrasada
        $statusText = 'Atrasada';
        $statusClass = 'bg-red-50 dark:bg-red-950/20 text-red-700 dark:text-red-400 border-red-100 dark:border-red-900/20';
        }
        @endphp

        <div class="task-card group bg-white dark:bg-slate-800 rounded-[2rem] p-5 border border-gray-100 dark:border-emerald-900/20 shadow-sm hover:shadow-xl hover:{{ $shadowColor }} transition-all duration-500 relative overflow-hidden flex flex-col md:flex-row md:items-center gap-5">


            {{-- Left Accent Border --}}
            <div class="absolute left-0 top-0 bottom-0 w-3 {{ $barColor }} opacity-80 group-hover:opacity-100 transition-opacity"></div>

            {{-- Status Checkmark Simulation --}}
            <div class="flex-shrink-0 flex items-center">
                @if($task->id_estado == 15)
                <div class="w-10 h-10 bg-emerald-500 rounded-2xl text-white flex items-center justify-center shadow-lg shadow-emerald-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                @elseif($task->id_estado == 19)
                <div class="w-10 h-10 bg-indigo-500 rounded-2xl text-white flex items-center justify-center shadow-lg shadow-indigo-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                @elseif($task->id_estado == 17)
                <div class="w-10 h-10 bg-amber-500 rounded-2xl text-white flex items-center justify-center shadow-lg shadow-amber-200 animate-pulse-slow">
                    <span class="w-3 h-3 bg-white rounded-full"></span>
                </div>
                @elseif(in_array($task->id_estado, [16, 18]))
                <div class="w-10 h-10 bg-red-500 rounded-2xl text-white flex items-center justify-center shadow-lg shadow-red-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                @else
                <div class="w-10 h-10 rounded-2xl border-2 border-gray-100 dark:border-emerald-900/20 bg-white dark:bg-slate-900 group-hover:border-{{ $borderColor }} transition-all duration-300 flex items-center justify-center text-gray-300 group-hover:text-{{ $borderColor }}">
                    {!! $iconSvg !!}
                </div>
                @endif
            </div>

            {{-- Core Task Info --}}
            <div class="flex-grow space-y-3">
                <div class="flex flex-col gap-0.5">
                    <h5 class="text-lg font-black {{ in_array($task->id_estado, [15, 19]) ? 'text-gray-400 line-through decoration-2' : (in_array($task->id_estado, [16, 18]) ? 'text-red-400 line-through decoration-2' : 'text-gray-900 dark:text-emerald-50 group-hover:text-' . $borderColor) }} transition-colors">
                        {{ $task->descripcion }}
                    </h5>
                    @if(!empty($task->sub_descripcion))
                    <p class="text-xs text-gray-400 font-medium leading-snug">
                        {{ $task->sub_descripcion }}
                    </p>
                    @endif
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    {{-- Terrain / Location Badge --}}
                    <div class="flex items-center gap-1.5 px-3 py-1.5 bg-gray-50 dark:bg-slate-900 rounded-xl text-gray-600 dark:text-emerald-500/70 text-[11px] font-bold border border-gray-100 dark:border-emerald-900/20 group-hover:bg-white dark:group-hover:bg-slate-700 transition-colors">
                        @if($itemType === 'general')
                        Terreno: {{ $task->terreno?->nombre ?? 'N/A' }}
                        @else
                        Parcela: {{ $task->cosecha?->terreno?->nombre ?? 'Sin Terreno' }}
                        @endif
                    </div>

                    {{-- Variety / Item Badge --}}
                    <div class="flex items-center gap-1.5 px-3 py-1.5 bg-{{ $bgLight }} dark:bg-{{ $borderColor }}/10 rounded-xl text-{{ $textColor }} dark:text-{{ $borderColor }} text-[11px] font-black border border-{{ $borderColor }}/20 uppercase tracking-tight group-hover:bg-white dark:group-hover:bg-slate-700 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L4.5 20.29l.71.71L12 18l6.79 3 .71-.71z" />
                        </svg>
                        @if($itemType === 'general')
                        {{ $task->terreno?->ubicacion ?? 'Ubicación General' }}
                        @else
                        {{ $task->cosecha?->semilla?->nombre_semilla ?? 'Variedad' }}
                        @endif
                    </div>

                    {{-- Worker Badge --}}
                    <div class="flex items-center gap-1.5 px-3 py-1.5 bg-blue-50/50 dark:bg-blue-900/10 rounded-xl text-blue-700 dark:text-blue-400 text-[11px] font-bold border border-blue-100 dark:border-blue-900/20 group-hover:bg-blue-50 dark:group-hover:bg-slate-700 transition-colors">
                        <div class="w-4 h-4 bg-blue-600 rounded-full flex items-center justify-center text-white text-[8px]">
                            {{ strtoupper(substr($task->usuario->nombre ?? 'U', 0, 1)) }}
                        </div>
                        {{ $task->usuario->nombre ?? 'Sin Asignar' }}
                    </div>
                </div>
            </div>

            {{-- Status & Meta (Right Side) --}}
            <div class="flex flex-col items-start md:items-end justify-between gap-3 min-w-[140px]">
                <div class="flex flex-col items-start md:items-end gap-1 w-full">
                    <span class="text-[9px] font-black text-gray-400 dark:text-emerald-500/40 uppercase tracking-widest ml-1 md:mr-1">
                        {{ $dateDisplay }}
                    </span>
                    <div class="px-4 py-2 rounded-2xl text-[11px] font-black uppercase tracking-widest border {{ $statusClass }} shadow-sm flex items-center gap-2 w-full md:w-auto justify-center">
                        @if(!in_array($task->id_estado, [15, 16, 19]) && $date->isToday())
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-red-600"></span>
                        </span>
                        @endif
                        {{ $statusText }}
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    @if(!in_array($task->id_estado, [15, 19])) {{-- Only allow edit if not completed --}}
                    <button onclick='editTask({!! json_encode($task) !!}, "{{ $itemType }}")' class="flex items-center gap-2 px-3 py-1.5 rounded-xl bg-white dark:bg-slate-900 text-gray-400 dark:text-emerald-500/50 hover:text-{{ $borderColor }} dark:hover:text-{{ $borderColor }} hover:border-{{ $borderColor }} transition-all border border-gray-100 dark:border-emerald-900/20 shadow-sm group/edit">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.242 3.242a1.5 1.5 0 112.121 2.121L12.121 12l-4.242 1.061L8.939 8.939l7.303-7.303z" />
                        </svg>
                        <span class="text-[10px] font-black uppercase tracking-widest">Editar</span>
                    </button>
                    @endif
                </div>

                <div class="text-[10px] font-bold text-gray-400 italic">
                    Asignado por: <span class="text-gray-600 dark:text-gray-400 not-italic uppercase tracking-tighter">Administrador</span>
                </div>
            </div>

            {{-- Hover Decoration --}}
            <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-gray-50 dark:bg-slate-700/20 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-700 blur-2xl"></div>
        </div>

        @empty
        <div class="bg-gray-50/50 border-2 border-dashed border-gray-200 rounded-[3rem] p-20 text-center space-y-4">
            <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto text-gray-200 shadow-inner">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <div>
                <h5 class="text-xl font-black text-gray-800 tracking-tight">Categoría Vacía</h5>
                <p class="text-gray-400 font-medium">No se encontraron registros activos para {{ strtolower($title) }}.</p>
            </div>
        </div>
        @endforelse
    </div>

    {{-- Pagination Footer --}}
    @if($tasks->count() > 7)
    <div class="mt-8 flex items-center justify-between bg-gray-50/50 dark:bg-slate-900/30 p-4 rounded-3xl border border-gray-100 dark:border-emerald-950/20" id="pagination-{{ $type }}">
        <span class="text-[11px] font-bold text-gray-400 dark:text-emerald-600 uppercase tracking-widest pl-4">Página <span class="current-page text-gray-700 dark:text-emerald-400">1</span> de <span class="total-pages text-gray-700 dark:text-emerald-400">1</span></span>
        <div class="flex gap-2">
            <button onclick="changePage('{{ $type }}', -1)" class="p-2 rounded-xl bg-white dark:bg-slate-800 border border-gray-100 dark:border-emerald-900/20 text-gray-400 hover:text-gray-700 dark:hover:text-emerald-400 hover:shadow-sm transition-all disabled:opacity-30 btn-prev">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <div class="flex gap-1 page-numbers">
                {{-- JS injected buttons --}}
            </div>
            <button onclick="changePage('{{ $type }}', 1)" class="p-2 rounded-xl bg-white dark:bg-slate-800 border border-gray-100 dark:border-emerald-900/20 text-gray-400 hover:text-gray-700 dark:hover:text-emerald-400 hover:shadow-sm transition-all disabled:opacity-30 btn-next">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </div>
</div>
@endif
</div>

<style>
    @keyframes pulse-slow {

        0%,
        100% {
            opacity: 1;
            transform: scale(1);
        }

        50% {
            opacity: 0.9;
            transform: scale(0.98);
        }
    }

    .animate-pulse-slow {
        animation: pulse-slow 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
</style>