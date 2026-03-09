@extends('layouts.admin')

@section('title', 'Control de Cosechas')

@section('content')
<div class="space-y-8 animate-in fade-in duration-700">
    <!-- Header con Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-emerald-600 to-green-600 rounded-3xl p-8 text-white shadow-2xl shadow-emerald-200 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
            <p class="text-emerald-100 text-sm font-black uppercase tracking-widest mb-2">Cultivos Activos</p>
            <div class="flex items-end gap-3">
                <h3 class="text-5xl font-black">{{ $cosechas->total() }}</h3>
                <span class="text-emerald-200 mb-1 font-bold">Lotes en curso</span>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-8 border-2 border-emerald-50 shadow-xl shadow-emerald-50/50 flex flex-col justify-center">
            <p class="text-emerald-400 text-xs font-black uppercase tracking-widest mb-1">Terrenos Disponibles</p>
            <h3 class="text-3xl font-black text-emerald-950">{{ $terrenos->count() }}</h3>
        </div>

        <div class="flex items-center">
            <button onclick="document.getElementById('modal-nueva-cosecha').classList.remove('hidden')"
                class="w-full bg-emerald-950 text-white rounded-3xl py-6 font-black uppercase tracking-tighter hover:bg-emerald-900 hover:scale-[1.02] active:scale-95 transition-all shadow-xl shadow-emerald-200 flex items-center justify-center gap-4 group">
                <div class="w-8 h-8 rounded-full bg-emerald-500 flex items-center justify-center group-hover:rotate-90 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                Iniciar Nueva Siembra
            </button>
        </div>
    </div>

    <!-- Tabla de Cosechas -->
    <div class="bg-white rounded-[2.5rem] border border-emerald-50 shadow-2xl shadow-emerald-100/50 overflow-hidden">
        <div class="p-8 border-b border-emerald-50 flex justify-between items-center">
            <div>
                <h3 class="text-2xl font-black text-emerald-950">Seguimiento Real</h3>
                <p class="text-xs font-medium text-emerald-600 mt-1">Monitoreo de producción estimada</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-emerald-50/30 text-[10px] font-black text-emerald-400 uppercase tracking-[0.2em]">
                        <th class="px-8 py-6">ID Siembra</th>
                        <th class="px-8 py-6">Terreno / Semilla</th>
                        <th class="px-8 py-6">Fecha Siembra</th>
                        <th class="px-8 py-6 uppercase tracking-widest">Producción Estimada</th>
                        <th class="px-8 py-6 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-emerald-50/50">
                    @forelse($cosechas as $cosecha)
                    <tr class="hover:bg-emerald-50/30 transition-all group">
                        <td class="px-8 py-6">
                            <span class="font-black text-emerald-950 text-sm">#{{ $cosecha->id_cosecha }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="font-bold text-emerald-900">{{ $cosecha->terreno->nombre ?? 'N/A' }}</span>
                                <span class="text-[10px] text-emerald-400 font-bold uppercase tracking-tighter italic">
                                    {{ $cosecha->semilla->nombre_semilla ?? 'Variedad Desconocida' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-2 text-emerald-700 font-medium">
                                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10m-13 9h16a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z" />
                                </svg>
                                {{ \Carbon\Carbon::parse($cosecha->fecha_siembra)->format('d/m/Y') }}
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-lg font-black text-emerald-600">{{ number_format($cosecha->produccion_estimada, 1) }} kg</span>
                                <span class="text-[9px] font-bold text-emerald-300 uppercase leading-none">Cálculo basado en rendimiento</span>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <button class="p-3 bg-white border-2 border-emerald-50 rounded-2xl text-emerald-600 hover:bg-emerald-600 hover:text-white hover:border-emerald-600 transition-all shadow-sm active:scale-95">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center gap-4 opacity-30">
                                <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center">
                                    <svg class="w-10 h-10 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                <p class="font-black text-emerald-950 uppercase tracking-widest text-xs">No hay cosechas activas registradas</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($cosechas->hasPages())
        <div class="p-8 border-t border-emerald-50 bg-emerald-50/10">
            {{ $cosechas->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal Nueva Cosecha -->
<div id="modal-nueva-cosecha" class="fixed inset-0 z-[100] hidden overflow-y-auto px-4 py-6 sm:px-0">
    <div class="fixed inset-0 bg-emerald-950/80 backdrop-blur-md transition-opacity" onclick="this.parentElement.classList.add('hidden')"></div>

    <div class="relative mx-auto mt-10 max-w-2xl bg-white rounded-[3rem] shadow-2xl overflow-hidden animate-in zoom-in-95 duration-300">
        <!-- Header Modal -->
        <div class="p-10 bg-gradient-to-br from-emerald-900 to-emerald-950 text-white relative">
            <h2 class="text-3xl font-black leading-none">Nueva Siembra</h2>
            <p class="text-emerald-400 text-sm mt-2 font-bold uppercase tracking-widest">Registro de Ciclo Productivo</p>
            <button onclick="this.closest('#modal-nueva-cosecha').classList.add('hidden')" class="absolute top-10 right-10 text-emerald-500 hover:text-white transition-colors">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form action="{{ route('admin.cosechas.store') }}" method="POST" class="p-10 space-y-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Terreno -->
                <div class="space-y-3">
                    <label class="block text-xs font-black text-emerald-950 uppercase tracking-widest ml-4">Terreno Disponible</label>
                    <select name="id_terreno" required class="w-full bg-emerald-50 border-2 border-emerald-50 rounded-2xl p-4 text-emerald-900 font-bold focus:border-emerald-500 transition-all">
                        <option value="" disabled selected>Seleccione Terreno</option>
                        @foreach($terrenos as $terreno)
                        <option value="{{ $terreno->id_terreno }}">{{ $terreno->nombre }} ({{ $terreno->Ancho * $terreno->Alto }} m²)</option>
                        @endforeach
                    </select>
                </div>

                <!-- Semilla -->
                <div class="space-y-3">
                    <label class="block text-xs font-black text-emerald-950 uppercase tracking-widest ml-4">Especie a Sembrar</label>
                    <select name="id_semilla" id="select-semilla" required class="w-full bg-emerald-50 border-2 border-emerald-50 rounded-2xl p-4 text-emerald-900 font-bold focus:border-emerald-500 transition-all">
                        <option value="" disabled selected>Seleccione Variedad</option>
                        @foreach($semillas as $semilla)
                        <option value="{{ $semilla->id_semilla }}" data-yield="{{ $semilla->rendimiento_promedio }}">{{ $semilla->nombre_semilla }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Cantidad -->
                <div class="space-y-3">
                    <label class="block text-xs font-black text-emerald-950 uppercase tracking-widest ml-4">Cantidad (Semillas/Plantas)</label>
                    <input type="number" name="cantidad_sembrada" id="input-cantidad" step="0.01" required min="1" placeholder="Ej: 1000"
                        class="w-full bg-emerald-50 border-2 border-emerald-50 rounded-2xl p-4 text-emerald-900 font-bold placeholder:text-emerald-200 focus:border-emerald-500 transition-all">
                </div>

                <!-- Fecha -->
                <div class="space-y-3">
                    <label class="block text-xs font-black text-emerald-950 uppercase tracking-widest ml-4">Fecha de Inicio</label>
                    <input type="date" name="fecha_siembra" required value="{{ date('Y-m-d') }}"
                        class="w-full bg-emerald-50 border-2 border-emerald-50 rounded-2xl p-4 text-emerald-900 font-bold focus:border-emerald-500 transition-all">
                </div>
            </div>

            <!-- Previsualización de Producción -->
            <div id="preview-produccion" class="hidden bg-emerald-50 rounded-3xl p-6 border-2 border-emerald-100 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-emerald-600 rounded-2xl flex items-center justify-center text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-emerald-400 uppercase tracking-widest">Producción Estimada</p>
                        <h4 id="valor-estimado" class="text-2xl font-black text-emerald-950 leading-none">0 kg</h4>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-[9px] font-bold text-emerald-400 uppercase leading-none">Potencial Máximo</p>
                    <p class="text-[9px] font-medium text-emerald-300 italic italic">Cálculo basado en catálogo técnico</p>
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full bg-emerald-500 text-white rounded-3xl py-6 font-black uppercase tracking-widest hover:bg-emerald-600 transition-all shadow-xl shadow-emerald-100 flex items-center justify-center gap-4">
                    Confirmar Inicio de Siembra
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectSemilla = document.getElementById('select-semilla');
        const inputCantidad = document.getElementById('input-cantidad');
        const previewDiv = document.getElementById('preview-produccion');
        const valorEstimado = document.getElementById('valor-estimado');

        function updatePreview() {
            const option = selectSemilla.options[selectSemilla.selectedIndex];
            const yieldValue = option ? option.getAttribute('data-yield') : null;
            const cantidad = inputCantidad.value;

            if (yieldValue && cantidad > 0) {
                const estimado = (yieldValue * cantidad).toLocaleString(undefined, {
                    minimumFractionDigits: 1,
                    maximumFractionDigits: 1
                });
                valorEstimado.textContent = `${estimado} kg`;
                previewDiv.classList.remove('hidden');
            } else {
                previewDiv.classList.add('hidden');
            }
        }

        if (selectSemilla) selectSemilla.addEventListener('change', updatePreview);
        if (inputCantidad) inputCantidad.addEventListener('input', updatePreview);
    });
</script>
@endpush

@endsection