@extends('layouts.admin')

@section('title', 'Gestión de Estados')

@section('content')
<div class="space-y-8">
    <!-- ALERTAS -->
    @if(session('success'))
    <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-xl flex items-center shadow-sm animate-in fade-in slide-in-from-top-4 duration-300">
        <svg class="w-6 h-6 mr-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <span class="font-bold">{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-xl flex items-center shadow-sm">
        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="font-medium">{{ session('error') }}</span>
    </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        <!-- Removed Configuration Column as it's view-only -->

        <!-- List Column -->
        <div class="xl:col-span-3">
            <div class="bg-white rounded-3xl shadow-xl border border-emerald-50 overflow-hidden flex flex-col min-h-[600px]">
                <div class="p-8 border-b border-emerald-50 bg-gray-50/50 flex justify-between items-center">
                    <div>
                        <h3 class="text-2xl font-black text-emerald-950">Estados Registrados</h3>
                        <p class="text-xs font-medium text-emerald-600 mt-1">Listado maestro del sistema</p>
                    </div>
                </div>

                <div class="flex-1 overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-white text-[10px] font-black text-emerald-400 uppercase tracking-[0.2em] border-b border-emerald-50">
                                <th class="px-8 py-6">ID</th>
                                <th class="px-8 py-6">Nombre del Estado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-emerald-50/50">
                            @forelse($estados as $estado)
                            <tr class="hover:bg-emerald-50/20 transition-all group">
                                <td class="px-8 py-6">
                                    <span class="font-bold text-gray-400 text-xs">#{{ $estado->id_estado }}</span>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="font-black text-emerald-950">{{ $estado->nombre_estado }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-8 py-32 text-center text-emerald-300 font-bold italic">No hay estados registrados.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-8 bg-gray-50/50 border-t border-emerald-50">
                    {{ $estados->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- Scripts eliminados porque la vista ahora es de solo lectura -->
@endpush
@endsection

