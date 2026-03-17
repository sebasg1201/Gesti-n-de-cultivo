@extends('layouts.admin')

@section('title', 'Gestión de Estados')

@section('content')
<div class="space-y-8">
    <!-- ALERTAS -->


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

