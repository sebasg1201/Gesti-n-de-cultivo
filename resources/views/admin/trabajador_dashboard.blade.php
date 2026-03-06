@extends('layouts.admin')

@section('title', 'Mis Tareas Asignadas')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">

    @if (session('success'))
        <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-r-lg shadow-sm">
            <p class="font-medium flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </p>
        </div>
    @endif

    <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-6 mb-6">
        <h2 class="text-xl font-bold text-emerald-900 mb-2">¡Bienvenido, {{ explode(' ', auth()->guard('usuario')->user()->nombre)[0] }}!</h2>
        <p class="text-emerald-700">Aquí puedes ver tus tareas asignadas y el estado de tu progreso.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($tareas as $fase)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:border-emerald-300 transition-all flex flex-col overflow-hidden relative group">
                
                {{-- Border left to indicate state --}}
                <div class="absolute left-0 top-0 bottom-0 w-1.5 
                    {{ $fase->estado == 'En Progreso' ? 'bg-orange-400' : 'bg-green-500' }}">
                </div>

                <div class="p-6 flex-1 flex flex-col">
                    <div class="flex justify-between items-start mb-4">
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider
                            {{ $fase->estado == 'En Progreso' ? 'bg-orange-100 text-orange-800' : 'bg-green-100 text-green-800' }}">
                            {{ $fase->estado }}
                        </span>
                        
                        <div class="text-right">
                            <p class="text-[10px] text-gray-400 font-bold uppercase">Programado para</p>
                            <p class="text-sm font-bold text-gray-700">{{ \Carbon\Carbon::parse($fase->fecha_programada)->format('d M, Y') }}</p>
                        </div>
                    </div>

                    <p class="text-sm text-gray-500 mb-3 font-medium bg-gray-50 self-start px-2 py-1 rounded">
                        Lote Cosecha: #{{ $fase->id_cosecha }} {{ optional(optional(optional($fase->cosecha)->tipoCosecha)->semilla)->Tipo_semilla ? '- ' . $fase->cosecha->tipoCosecha->semilla->Tipo_semilla : '' }}
                    </p>

                    <h3 class="text-lg font-bold text-gray-800 mb-2 flex-grow">
                        {{ $fase->descripcion }}
                    </h3>

                    @if($fase->estado == 'En Progreso')
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <form action="{{ route('trabajador.tareas.finalizar', $fase->id_fase) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="w-full flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-4 rounded-xl transition-colors shadow-sm text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Marcar como Finalizado
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <div class="w-full flex items-center justify-center gap-2 bg-gray-100 text-gray-400 font-bold py-2.5 px-4 rounded-xl text-sm cursor-not-allowed">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Trabajo Completado
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white border-2 border-dashed border-gray-200 rounded-3xl p-12 text-center">
                <div class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Sin tareas asignadas</h3>
                <p class="text-gray-500 max-w-sm mx-auto">No tienes ninguna fase programada en este momento. Cuando se te asigne trabajo, aparecerá aquí.</p>
            </div>
        @endforelse
    </div>

</div>
@endsection
