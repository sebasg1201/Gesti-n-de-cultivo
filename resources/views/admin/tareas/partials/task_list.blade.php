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
        <h4 class="text-xl font-black text-gray-800 tracking-tight">{{ $title }}</h4>
        <div class="flex items-center gap-2">
            @if($type !== 'all')
                <button onclick="showCategory('todas')" class="px-3 py-1 bg-gray-50 hover:bg-gray-100 text-gray-500 text-[10px] font-black uppercase tracking-widest rounded-lg border border-gray-100 transition-all flex items-center gap-1.5 shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    Ver Todas
                </button>
            @endif
            <span class="px-3 py-1 bg-white border border-gray-100 rounded-full text-[10px] font-black uppercase tracking-widest text-gray-400 shadow-sm">
                {{ $tasks->count() }} Registros
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 task-list-container" data-type="{{ $type }}">
        @forelse($tasks as $task)
            @php
                // Determinar color basado en el tipo de tarea individual
                $itemType = $task->tipo_referencia ?? $type;
                $borderColor = 'emerald-500';
                $bgLight = 'emerald-50';
                $textColor = 'emerald-700';

                if($itemType === 'riego') {
                    $borderColor = 'blue-500';
                    $bgLight = 'blue-50';
                    $textColor = 'blue-700';
                } elseif($itemType === 'insumo') {
                    $borderColor = 'purple-500';
                    $bgLight = 'purple-50';
                    $textColor = 'purple-700';
                }
            @endphp
            <div class="task-card group bg-white rounded-[2rem] p-5 border border-gray-100 shadow-sm hover:shadow-xl hover:shadow-gray-200/40 transition-all duration-500 relative overflow-hidden flex flex-col md:flex-row md:items-center gap-5">
                
                {{-- Left Accent Border --}}
                <div class="absolute left-0 top-0 bottom-0 w-2 bg-{{ $borderColor }} opacity-80 group-hover:opacity-100 transition-opacity"></div>

                {{-- Status Indicator / Checkbox Simulation --}}
                <div class="flex-shrink-0 flex items-center">
                    @if($task->id_estado == 15) {{-- Realizado --}}
                        <div class="w-10 h-10 bg-emerald-500 rounded-2xl text-white flex items-center justify-center shadow-lg shadow-emerald-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                    @elseif($task->id_estado == 17) {{-- En Proceso --}}
                        <div class="w-10 h-10 bg-amber-500 rounded-2xl text-white flex items-center justify-center shadow-lg shadow-amber-200 animate-pulse-slow">
                            <span class="w-3 h-3 bg-white rounded-full"></span>
                        </div>
                    @else
                        <div class="w-10 h-10 rounded-2xl border-2 border-gray-200 bg-white group-hover:border-{{ $borderColor }} transition-all duration-300 flex items-center justify-center">
                            <div class="w-4 h-4 rounded-md bg-gray-50 group-hover:bg-{{ $bgLight }} transition-colors"></div>
                        </div>
                    @endif
                </div>

                {{-- Core Task Info --}}
                <div class="flex-grow space-y-3">
                    <div class="flex flex-col gap-0.5">
                        <h5 class="text-lg font-black {{ $task->id_estado == 15 ? 'text-gray-400 line-through decoration-2' : 'text-gray-900 group-hover:text-' . $borderColor }} transition-colors">
                            {{ $task->descripcion }}
                        </h5>
                        @if(!empty($task->sub_descripcion))
                            <p class="text-xs text-gray-400 font-medium leading-snug">
                                {{ $task->sub_descripcion }}
                            </p>
                        @endif
                    </div>
                    
                    <div class="flex flex-wrap items-center gap-2">
                        {{-- Lote / Location Badge --}}
                        <div class="flex items-center gap-1.5 px-3 py-1.5 bg-gray-50 rounded-xl text-gray-600 text-[11px] font-bold border border-gray-100 group-hover:bg-white transition-colors">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                            Lote #{{ $task->id_cosecha }}
                        </div>

                        {{-- Crop / Variety Badge --}}
                        <div class="flex items-center gap-1.5 px-3 py-1.5 bg-gray-50 rounded-xl text-emerald-700 text-[11px] font-black border border-emerald-100 uppercase tracking-tight group-hover:bg-emerald-50 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L4.5 20.29l.71.71L12 18l6.79 3 .71-.71z"/>
                            </svg>
                            {{ $task->cosecha?->semilla?->nombre_semilla ?? 'Variedad' }}
                        </div>

                        {{-- Worker Badge (Mini) --}}
                        <div class="flex items-center gap-1.5 px-3 py-1.5 bg-blue-50/50 rounded-xl text-blue-700 text-[11px] font-bold border border-blue-100 group-hover:bg-blue-50 transition-colors">
                            <div class="w-4 h-4 bg-blue-600 rounded-full flex items-center justify-center text-white text-[8px]">
                                {{ strtoupper(substr($task->usuario->nombre ?? 'U', 0, 1)) }}
                            </div>
                            {{ $task->usuario->nombre ?? 'Sin Asignar' }}
                        </div>
                    </div>
                </div>

                {{-- Status & Meta (Right Side) --}}
                <div class="flex flex-col items-start md:items-end justify-between gap-3 min-w-[140px]">
                    @php
                        $date = \Carbon\Carbon::parse($task->fecha_programada);
                        $statusText = $date->isToday() ? 'Hoy, ' . $date->format('H:i') : ($date->isTomorrow() ? 'Mañana' : $date->format('d M'));
                        
                        $statusClass = 'bg-yellow-50 text-yellow-700 border-yellow-100'; // Default Pendiente
                        
                        if($task->id_estado == 15) { // Realizado
                            $statusText = 'Completado';
                            $statusClass = 'bg-emerald-50 text-emerald-700 border-emerald-100';
                        } elseif($task->id_estado == 17) { // En Proceso
                            $statusText = 'En Proceso';
                            $statusClass = 'bg-blue-50 text-blue-700 border-blue-100';
                        } elseif($task->id_estado == 16 || $date->isPast()) { // Perdida o Atrasada
                            $statusText = $task->id_estado == 16 ? 'Perdida' : $statusText;
                            $statusClass = 'bg-red-50 text-red-700 border-red-100';
                        }
                    @endphp

                    <div class="px-4 py-2 rounded-2xl text-[11px] font-black uppercase tracking-widest border {{ $statusClass }} shadow-sm flex items-center gap-2">
                        @if(!in_array($task->id_estado, [15, 16]) && $date->isToday())
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-red-600"></span>
                            </span>
                        @endif
                        {{ $statusText }}
                    </div>

                    <div class="text-[10px] font-bold text-gray-400 italic">
                        Asignado por: <span class="text-gray-600 not-italic uppercase tracking-tighter">Administrador</span>
                    </div>
                </div>

                {{-- Hover Decoration --}}
                <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-gray-50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-700 blur-2xl"></div>
            </div>
        @empty
            <div class="bg-gray-50/50 border-2 border-dashed border-gray-200 rounded-[3rem] p-20 text-center space-y-4">
                <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto text-gray-200 shadow-inner">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
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
    @if($tasks->count() > 5)
        <div class="mt-8 flex items-center justify-between bg-gray-50/50 p-4 rounded-3xl border border-gray-100" id="pagination-{{ $type }}">
            <span class="text-[11px] font-bold text-gray-400 uppercase tracking-widest pl-4">Página <span class="current-page text-gray-700">1</span> de <span class="total-pages text-gray-700">1</span></span>
            <div class="flex gap-2">
                <button onclick="changePage('{{ $type }}', -1)" class="p-2 rounded-xl bg-white border border-gray-100 text-gray-400 hover:text-gray-700 hover:shadow-sm transition-all disabled:opacity-30 btn-prev">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <div class="flex gap-1 page-numbers">
                    {{-- JS injected buttons --}}
                </div>
                <button onclick="changePage('{{ $type }}', 1)" class="p-2 rounded-xl bg-white border border-gray-100 text-gray-400 hover:text-gray-700 hover:shadow-sm transition-all disabled:opacity-30 btn-next">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>
    @endif
</div>

<style>
    @keyframes pulse-slow {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.9; transform: scale(0.98); }
    }
    .animate-pulse-slow {
        animation: pulse-slow 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
</style>
