@extends('layouts.barra_lateral')

@section('content')

<div class="max-w-3xl mx-auto bg-white shadow-[0_20px_50px_rgba(0,0,0,0.05)] rounded-[2.5rem] p-10 border border-slate-50 relative overflow-hidden">

    {{-- Decoración sutil de fondo --}}
    <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-emerald-50 rounded-full opacity-50 blur-3xl"></div>

    {{-- TITULO --}}
    <div class="relative mb-10">
        <div class="flex items-center gap-4 mb-2">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-r from-[#34d399] via-[#22c55e] to-[#16a34a] hover:from-[#22c55e] hover:via-[#16a34a] hover:to-[#15803d] flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
            </div>
            <div>
                <h2 class="text-3xl font-black text-green-800 tracking-tighter">Crear Plan De <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-green-500">Licencias</span></h2>
                <p class="text-slate-400 text-sm font-medium">Define los parámetros para el nuevo modelo de suscripción.</p>
            </div>
        </div>
        <div class="h-1 w-20 bg-emerald-500 rounded-full mt-4"></div>
    </div>

    {{-- ERRORES (Rediseñados) --}}
    @if ($errors->any())
    <div class="bg-rose-50 border border-rose-100 p-6 rounded-[1.5rem] mb-8 animate-shake">
        <div class="flex items-center gap-3 mb-3 text-rose-700 font-black uppercase text-xs tracking-widest">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            Revisa los siguientes campos
        </div>
        <ul class="space-y-1">
            @foreach ($errors->all() as $error)
            <li class="text-rose-600 text-sm font-medium flex items-center gap-2">
                <span class="w-1 h-1 bg-rose-400 rounded-full"></span> {{ $error }}
            </li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('licencias.store') }}" method="POST" class="space-y-8 validate-form relative">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- NOMBRE --}}
            <div class="md:col-span-1">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">
                    Nombre del Plan
                </label>
                <div class="group relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" />
                        </svg>
                    </div>
                    <input type="text" pattern="[A-Za-zÁÉÍÓÚáéíóúñÑ ]+" name="nombre_licencia"
                        value="{{ old('nombre_licencia') }}"
                        class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl pl-12 pr-4 py-4 text-slate-700 font-bold focus:bg-white focus:border-[#006b58] focus:ring-4 focus:ring-emerald-50 outline-none transition-all placeholder:text-slate-300 placeholder:font-medium"
                        placeholder="Ej: Plan Premium" required>
                </div>
            </div>

            {{-- TIEMPO --}}
            <div class="md:col-span-1">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">
                    Tiempo de Duración
                </label>
                <div class="group relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <input type="text" name="tiempo" value="{{ old('tiempo') }}"
                        class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl pl-12 pr-4 py-4 text-slate-700 font-bold focus:bg-white focus:border-[#006b58] focus:ring-4 focus:ring-emerald-50 outline-none transition-all placeholder:text-slate-300 placeholder:font-medium"
                        placeholder="Ej: 1 año, 6 meses" required>
                </div>
            </div>
        </div>

        {{-- DESCRIPCION --}}
        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">
                Descripción Detallada
            </label>
            <div class="group relative">
                <textarea name="description" rows="3"
                    class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl p-5 text-slate-700 font-bold focus:bg-white focus:border-[#006b58] focus:ring-4 focus:ring-emerald-50 outline-none transition-all placeholder:text-slate-300 placeholder:font-medium resize-none"
                    placeholder="Describe los beneficios y alcance de este plan...">{{ old('description') }}</textarea>
            </div>
        </div>

        {{-- PRECIO --}}
        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">
                Inversión / Precio
            </label>
            <div class="group relative">
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-emerald-600 font-black text-xl group-focus-within:scale-125 transition-transform">
                    $
                </div>
                <input type="number" name="precio" value="{{ old('precio') }}"
                    class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl pl-12 pr-4 py-5 text-2xl font-black text-slate-800 focus:bg-white focus:border-[#006b58] focus:ring-4 focus:ring-emerald-50 outline-none transition-all placeholder:text-slate-200"
                    placeholder="0.00" required>
            </div>
        </div>

        {{-- BOTONES --}}
        <div class="flex flex-col sm:flex-row gap-4 pt-6">
            <a href="{{ route('licencias.index') }}"
                class="flex-1 flex justify-center items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-500 font-black py-4 rounded-2xl transition-all active:scale-95 uppercase tracking-widest text-xs">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
                </svg>
                Cancelar
            </a>

            <button type="submit"
                class="flex-[2] group flex justify-center items-center gap-3 bg-gradient-to-r from-[#34d399] via-[#22c55e] to-[#16a34a] hover:from-[#22c55e] hover:via-[#16a34a] hover:to-[#15803d] text-white font-black py-5 rounded-2xl transition-all transform active:scale-95 uppercase tracking-[0.2em] text-xs">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
                Guardar Nuevo Plan
            </button>
        </div>
    </form>
</div>

@endsection