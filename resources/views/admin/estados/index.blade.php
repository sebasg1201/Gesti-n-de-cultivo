@extends('layouts.admin')

@section('title', 'Gestión de Estados')

@section('content')
<div class="space-y-6">
    {{-- ALERTAS (Se manejan en el layout principal) --}}

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- List Column -->
        <div class="xl:col-span-3">
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-emerald-50 dark:border-emerald-900/20 overflow-hidden flex flex-col min-h-[600px] transition-all duration-300">
                <div class="p-6 border-b border-emerald-50 dark:border-emerald-900/10 bg-gray-50/50 dark:bg-slate-900/50 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-black text-emerald-950 dark:text-emerald-50">Estados Registrados</h3>
                        <p class="text-xs font-medium text-emerald-600 dark:text-emerald-400 mt-1">Listado maestro del sistema</p>
                    </div>
                    <div class="bg-emerald-100 dark:bg-emerald-900/30 p-2 rounded-2xl text-emerald-600 dark:text-emerald-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <div class="flex-1 overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-white dark:bg-slate-900/50 text-[10px] font-black text-emerald-400 dark:text-emerald-600 uppercase tracking-[0.2em] border-b border-emerald-50 dark:border-emerald-900/10 transition-colors">
                                <th class="px-6 py-4">ID</th>
                                <th class="px-6 py-4">Nombre del Estado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-emerald-50/50 dark:divide-emerald-900/10">
                            @forelse($estados as $estado)
                            <tr class="hover:bg-emerald-50/20 dark:hover:bg-slate-700/20 transition-all group">
                                <td class="px-6 py-4">
                                    <span class="font-bold text-gray-400 dark:text-gray-500 font-mono text-xs">#{{ $estado->id_estado }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-2 h-2 rounded-full bg-emerald-500 dark:bg-emerald-400 shadow-sm shadow-emerald-200 dark:shadow-none"></div>
                                        <span class="font-black text-emerald-950 dark:text-emerald-50 text-sm tracking-tight">{{ $estado->nombre_estado }}</span>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center opacity-40">
                                        <svg class="w-16 h-16 text-emerald-300 dark:text-emerald-900 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 012 2v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2a2 2 0 012-2m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                        <p class="text-emerald-600 dark:text-emerald-400 font-bold italic">No hay estados registrados.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-6 bg-gray-50/50 dark:bg-slate-900/50 border-t border-emerald-50 dark:border-emerald-900/10">
                    {{ $estados->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Scripts eliminados porque la vista ahora es de solo lectura --}}
@endpush

