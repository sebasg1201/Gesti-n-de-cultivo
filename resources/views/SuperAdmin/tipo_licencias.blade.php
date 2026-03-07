@extends('layouts.barra_lateral')

@section('content')

    <div
        class="max-w-6xl mx-auto bg-white shadow-2xl shadow-slate-200/50 rounded-[2.5rem] border border-slate-100 overflow-hidden">

        {{-- HEADER DE LA SECCIÓN --}}
        <div
            class="p-8 sm:p-10 border-b border-slate-50 bg-gradient-to-r from-slate-50/50 to-white flex flex-col sm:flex-row justify-between items-center gap-6">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="p-2 bg-emerald-100 rounded-lg text-[#006b58]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M9 5h12M9 12h12M9 19h12M5 5h.01M5 12h.01M5 19h.01" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-black text-green-800 tracking-tighter">Gestión De <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-green-500">Planes</span>
                    </h2>
                </div>
                <p class="text-slate-400 text-sm font-medium ml-11">Configuración de niveles de suscripción y precios.</p>
            </div>

            <a href="{{ route('licencias.create') }}"
                class="group flex items-center gap-2 bg-gradient-to-r from-[#34d399] via-[#22c55e] to-[#16a34a] hover:from-[#22c55e] hover:via-[#16a34a] hover:to-[#15803d] text-white px-5 py-2.5 rounded-xl transition-all duration-300 transform active:scale-95 font-semibold uppercase tracking-wide text-xs">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 transition-transform group-hover:rotate-90"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                </svg>

                Crear Nuevo Plan
            </a>
        </div>

        {{-- ALERTAS (Toast Style) --}}
        @if(session('success'))
            <div
                class="auto-dismiss fixed bottom-8 right-8 bg-emerald-600 text-white px-6 py-4 rounded-[1.5rem] shadow-2xl shadow-emerald-900/20 animate-fade-in-up z-50 flex items-center gap-3 border border-emerald-400/20">
                <div class="bg-white/20 p-1.5 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                </div>
                <span class="font-bold text-sm tracking-wide">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div
                class="auto-dismiss fixed bottom-8 right-8 bg-rose-600 text-white px-6 py-5 rounded-[1.5rem] shadow-2xl shadow-rose-900/20 animate-fade-in-up z-50 max-w-sm flex items-start gap-3 border border-rose-400/20">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"
                    class="w-6 h-6 flex-shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
                <span class="text-sm font-bold leading-tight">{{ session('error') }}</span>
            </div>
        @endif

        {{-- TABLA DE PLANES --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead
                    class="bg-slate-50/80 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">
                    <tr>
                        <th class="px-10 py-6">Nombre del Plan</th>
                        <th class="px-10 py-6">Duración</th>
                        <th class="px-10 py-6">Inversión</th>
                        <th class="px-10 py-6 text-center">Gestión</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-50">
                    @foreach($licencias as $licencia)
                        @php $enUso = $idsEnUso->contains($licencia->id_tipo_licencia); @endphp
                        <tr class="hover:bg-emerald-50/30 transition-all group">

                            {{-- Nombre --}}
                            <td class="px-10 py-6">
                                <div class="flex items-center gap-3">
                                    <span
                                        class="text-base font-black text-slate-700 group-hover:text-[#006b58] transition-colors">
                                        {{ $licencia->nombre_licencia }}
                                    </span>
                                    @if($enUso)
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-black uppercase bg-emerald-100 text-emerald-700 border border-emerald-200">
                                            <span class="w-1 h-1 bg-emerald-600 rounded-full animate-pulse"></span>
                                            En uso
                                        </span>
                                    @endif
                                </div>
                            </td>

                            {{-- Tiempo --}}
                            <td class="px-10 py-6 text-sm font-bold text-slate-500 italic">
                                {{ $licencia->tiempo }}
                            </td>

                            {{-- Precio --}}
                            <td class="px-10 py-6">
                                <span class="text-lg font-black text-slate-800">
                                    <span class="text-[#006b58] mr-0.5">$</span>{{ number_format($licencia->precio) }}
                                </span>
                            </td>

                            {{-- Acciones --}}
                            <td class="px-10 py-6">
                                <div class="flex justify-center items-center gap-3">

                                    {{-- EDITAR --}}
                                    @if($enUso)
                                        <div class="relative group/tooltip">
                                            <button disabled class="p-3 bg-slate-100 text-slate-300 rounded-xl cursor-not-allowed">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                                </svg>
                                            </button>
                                            {{-- Tooltip Pro --}}
                                            <div
                                                class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 w-56 hidden group-hover/tooltip:block z-20 animate-fade-in">
                                                <div
                                                    class="bg-slate-800 text-white text-[10px] font-bold rounded-xl py-3 px-4 text-center shadow-2xl leading-relaxed">
                                                    BLOQUEADO: Plan con licencias activas
                                                    <div
                                                        class="absolute top-full left-1/2 -translate-x-1/2 border-[6px] border-transparent border-t-slate-800">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <a href="{{ route('licencias.edit', $licencia->id_tipo_licencia) }}"
                                            class="p-3 bg-white border border-slate-200 text-slate-400 hover:text-emerald-600 hover:border-emerald-200 hover:bg-emerald-50 rounded-xl shadow-sm transition-all active:scale-90">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </a>
                                    @endif

                                    {{-- ELIMINAR --}}
                                    @if($enUso)
                                        <div class="relative group/tooltip">
                                            <button disabled class="p-3 bg-slate-100 text-slate-300 rounded-xl cursor-not-allowed">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                                                </svg>
                                            </button>
                                        </div>
                                    @else
                                        <form action="{{ route('licencias.destroy', $licencia->id_tipo_licencia) }}" method="POST"
                                            onsubmit="return confirm('¿Estás seguro de eliminar el plan {{ addslashes($licencia->nombre_licencia) }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-3 bg-white border border-slate-200 text-slate-400 hover:text-rose-600 hover:border-rose-200 hover:bg-rose-50 rounded-xl shadow-sm transition-all active:scale-90">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- PAGINACION --}}
    <div class="flex justify-center mt-6">
        {{ $licencias->withQueryString()->links() }}
    </div>

    </div>

@endsection