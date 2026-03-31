@extends('layouts.barra_lateral')
@section('content')

<div class="max-w-3xl mx-auto bg-white dark:bg-slate-900 shadow-[0_20px_60px_rgba(0,0,0,0.07)] dark:shadow-none rounded-[3rem] p-10 border border-slate-50 dark:border-emerald-950/20 relative overflow-hidden transition-colors duration-300">

    {{-- Decoración abstracta de edición --}}
    <div class="absolute top-0 right-0 w-32 h-32 bg-amber-50 rounded-full -mr-16 -mt-16 opacity-60 blur-2xl"></div>

    {{-- CABECERA DEL EDITOR --}}
    <div class="relative mb-12">
        <div class="flex items-center gap-5">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center text-white shadow-lg shadow-green-200 ring-4 ring-green-50 dark:ring-emerald-950/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2M12 20h9M16.5 3.5l4 4L7 21H3v-4L16.5 3.5z" />
                </svg>
            </div>
            <div>
                <span class="text-[10px] font-black text-green-600 dark:text-emerald-400 uppercase tracking-[0.3em]">Modo Editor</span>
                <h2 class="text-3xl font-black text-green-800 dark:text-emerald-500 tracking-tighter transition-colors">Editar Plan : <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-green-500">{{ $licencia->nombre_licencia }}</span></h2>
            </div>
        </div>
    </div>

    {{-- GESTIÓN DE ERRORES --}}
    @if ($errors->any())
    <div class="bg-rose-50 border-l-4 border-rose-500 p-6 rounded-2xl mb-8 animate-shake">
        <div class="flex items-center gap-3 text-rose-800 font-bold mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
            </svg>
            Atención requerida
        </div>
        <ul class="space-y-1 ml-8">
            @foreach ($errors->all() as $error)
            <li class="text-rose-600 text-sm font-medium list-disc">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('licencias.update', $licencia->id_tipo_licencia) }}" method="POST" class="space-y-8 validate-form">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- Nombre del Plan --}}
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Identificador del Plan</label>
                <div class="relative group">
                    <input type="text" name="nombre_licencia" value="{{ $licencia->nombre_licencia }}"
                        class="w-full bg-slate-50 dark:bg-slate-950 border-2 border-slate-50 dark:border-emerald-900/10 rounded-2xl px-5 py-4 text-slate-700 dark:text-emerald-50 font-bold focus:bg-white dark:focus:bg-slate-900 focus:border-amber-500 focus:ring-4 focus:ring-amber-50 dark:focus:ring-amber-500/10 outline-none transition-all shadow-sm group-hover:border-slate-200 dark:group-hover:border-emerald-900/20"
                        placeholder="Nombre comercial" required>
                </div>
            </div>

            {{-- Tiempo --}}
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Periodo de Vigencia</label>
                <div class="relative group">
                    <input type="text" name="tiempo" value="{{ $licencia->tiempo }}"
                        class="w-full bg-slate-50 dark:bg-slate-950 border-2 border-slate-50 dark:border-emerald-900/10 rounded-2xl px-5 py-4 text-slate-700 dark:text-emerald-50 font-bold focus:bg-white dark:focus:bg-slate-900 focus:border-amber-500 focus:ring-4 focus:ring-amber-50 dark:focus:ring-amber-500/10 outline-none transition-all shadow-sm group-hover:border-slate-200 dark:group-hover:border-emerald-900/20"
                        placeholder="Ej: 365 días" required>
                </div>
            </div>
        </div>

        {{-- Descripción --}}
        <div class="space-y-2">
            <label class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1">Especificaciones Técnicas</label>
            <textarea name="descripcion" rows="4"
                class="w-full bg-slate-50 dark:bg-slate-950 border-2 border-slate-50 dark:border-emerald-900/10 rounded-3xl px-6 py-4 text-slate-700 dark:text-emerald-50 font-medium focus:bg-white dark:focus:bg-slate-900 focus:border-amber-500 focus:ring-4 focus:ring-amber-50 dark:focus:ring-amber-500/10 outline-none transition-all shadow-sm resize-none group-hover:border-slate-200 dark:group-hover:border-emerald-900/20"
                placeholder="¿Qué incluye este plan?">{{ $licencia->descripcion }}</textarea>
        </div>

        {{-- Precio --}}
        <div class="space-y-2">
            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Costo de Suscripción</label>
            <div class="relative group max-w-xs">
                <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                    <span class="text-green-600 font-black text-xl">$</span>
                </div>
                <input type="number" name="precio" value="{{ $licencia->precio }}"
                    class="w-full bg-slate-50 dark:bg-slate-950 border-2 border-slate-50 dark:border-emerald-900/10 rounded-2xl pl-12 pr-6 py-5 text-2xl font-black text-slate-800 dark:text-emerald-50 transition-colors focus:bg-white dark:focus:bg-slate-900 focus:border-amber-500 focus:ring-4 focus:ring-amber-50 dark:focus:ring-amber-500/10 outline-none transition-all shadow-sm"
                    required>
            </div>
        </div>

        {{-- ACCIONES --}}
        <div class="flex flex-col sm:flex-row items-center gap-4 pt-8 border-t border-slate-50">

            {{-- BOTÓN VOLVER --}}
            <a href="{{ route('licencias.index') }}"
                class="w-full sm:w-auto flex items-center justify-center gap-3 px-8 py-4 text-slate-400 dark:text-slate-500 font-bold hover:text-slate-600 dark:hover:text-emerald-400 transition-colors uppercase text-[11px] tracking-widest">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
                </svg>
                Descartar cambios
            </a>

            {{-- BOTÓN ACTUALIZAR --}}
            <button type="submit"
                class="w-full sm:flex-1 group relative flex items-center justify-center gap-3 bg-gradient-to-r from-[#34d399] via-[#22c55e] to-[#16a34a] hover:from-[#22c55e] hover:via-[#16a34a] hover:to-[#15803d] text-white font-black py-5 rounded-2xl shadow-xl shadow-emerald-900/10 transition-all transform active:scale-95 uppercase tracking-[0.2em] text-xs cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
                Confirmar Actualización
            </button>
        </div>
    </form>
</div>

@endsection