@extends('layouts.admin')

@section('content')
    <div class="min-h-[calc(100vh-4rem)] bg-emerald-50/30 p-4 md:p-8">
        <div class="max-w-4xl mx-auto space-y-8">

            <!-- Header -->
            <div class="flex items-center gap-4">
                <a href="{{ $id_cosecha ? route('admin.cultivos.cosechaDetail', $id_cosecha) : route('admin.cultivos.index') }}"
                    class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-emerald-600 shadow-sm border border-emerald-100 hover:bg-emerald-50 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-black text-emerald-950">Nueva Recolección</h1>
                    <p class="text-emerald-600 font-medium">Registra los productos obtenidos de la cosecha.</p>
                </div>
            </div>

            @if($errors->any())
                <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-700 p-4 rounded-lg shadow-sm">
                    <p class="font-bold">Por favor corrige los siguientes errores:</p>
                    <ul class="list-disc list-inside text-sm mt-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <form action="{{ route('admin.cultivos.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Card de Selección de Cosecha -->
                <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-emerald-50">
                    <h3 class="text-lg font-black text-slate-800 mb-6 flex items-center gap-2">
                        <span
                            class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs">1</span>
                        Información de Origen
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-emerald-900 uppercase tracking-widest mb-2">ID
                                Cosecha Target</label>
                            <input type="text" value="{{ $cosecha ? '#' . $cosecha->id_cosecha : 'N/A' }}" readonly
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-slate-500 font-bold focus:outline-none">
                            <input type="hidden" name="id_cosecha" value="{{ $id_cosecha }}">
                        </div>
                        <div>
                            <label
                                class="block text-[10px] font-black text-emerald-900 uppercase tracking-widest mb-2">Producto
                                de Referencia</label>
                            <input type="text" name="nombre_producto"
                                value="{{ old('nombre_producto', $productoReferencia) }}" readonly
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-slate-500 font-bold focus:outline-none"
                                placeholder="Ej: Tomate Chonto Madurado">
                        </div>
                    </div>

                    @if($cosecha)
                        <div class="mt-4 p-4 bg-emerald-50/50 rounded-2xl flex items-center gap-4">
                            <div
                                class="w-12 h-12 bg-white rounded-xl shadow-sm border border-emerald-100 flex items-center justify-center text-emerald-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2 2 2 0 012 2v.658m1.817-4.683a11.037 11.037 0 012.316 2.105m-3.264 1.818l-1.442-1.441a1 1 0 010-1.414l1.442-1.442a1 1 0 011.414 0l1.441 1.442a1 1 0 010 1.414l-1.441 1.441a1 1 0 01-1.414 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-emerald-800 uppercase tracking-widest">Procedencia</p>
                                <p class="text-sm font-bold text-emerald-600">{{ $cosecha->terreno->nombre }} -
                                    {{ $cosecha->semilla->nombre }}
                                </p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Card de Detalles de Recolección -->
                <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-emerald-50">
                    <h3 class="text-lg font-black text-slate-800 mb-6 flex items-center gap-2">
                        <span
                            class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs">2</span>
                        Datos de Producción
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label
                                class="block text-[10px] font-black text-emerald-900 uppercase tracking-widest mb-2">Trabajador
                                Encargado</label>
                            <select name="documento_trabajador"
                                class="w-full px-4 py-3 bg-white border border-emerald-100 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all font-medium text-slate-700 appearance-none bg-[url('data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%2310b981%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpath%20d%3D%22M6%209l6%206%206-6%22%3E%3C/path%3E%3C/svg%3E')] bg-[length:20px_20px] bg-no-repeat bg-[right_1rem_center]">
                                <option value="" disabled selected>Seleccione trabajador</option>
                                @foreach($trabajadores as $t)
                                    <option value="{{ $t->documento }}" {{ old('documento_trabajador') == $t->documento ? 'selected' : '' }}>{{ $t->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label
                                class="block text-[10px] font-black text-emerald-900 uppercase tracking-widest mb-2">Fecha
                                de Recolección</label>
                            <input type="date" name="fecha_recoleccion"
                                value="{{ old('fecha_recoleccion', date('Y-m-d')) }}"
                                class="w-full px-4 py-3 bg-white border border-emerald-100 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all font-medium text-slate-700">
                        </div>
                        <div>
                            <label
                                class="block text-[10px] font-black text-emerald-900 uppercase tracking-widest mb-2">Cantidad
                                Obtenida (Kg/Und)</label>
                            <input type="number" step="0.01" name="cantidad" value="{{ old('cantidad') }}"
                                class="w-full px-4 py-3 bg-white border border-emerald-100 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all font-medium text-slate-700"
                                placeholder="Ej: 540.50">
                        </div>
                        <div>
                            <label
                                class="block text-[10px] font-black text-emerald-900 uppercase tracking-widest mb-2">Calidad
                                del Producto</label>
                            <select name="calidad"
                                class="w-full px-4 py-3 bg-white border border-emerald-100 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all font-medium text-slate-700 appearance-none bg-[url('data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%2310b981%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpath%20d%3D%22M6%209l6%206%206-6%22%3E%3C/path%3E%3C/svg%3E')] bg-[length:20px_20px] bg-no-repeat bg-[right_1rem_center]">
                                <option value="Primera" {{ old('calidad') == 'Primera' ? 'selected' : '' }}>Primera (Premium)
                                </option>
                                <option value="Segunda" {{ old('calidad') == 'Segunda' ? 'selected' : '' }}>Segunda (Estándar)
                                </option>
                                <option value="Tercera" {{ old('calidad') == 'Tercera' ? 'selected' : '' }}>Tercera
                                    (Industrial)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Card de Observaciones y Referencia -->
                <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-emerald-50">
                    <h3 class="text-lg font-black text-slate-800 mb-6 flex items-center gap-2">
                        <span
                            class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs">3</span>
                        Adicionales
                    </h3>

                    <div class="space-y-6">
                        <div>
                            <label
                                class="block text-[10px] font-black text-emerald-900 uppercase tracking-widest mb-2">Código
                                de Referencia (SKU)</label>
                            <input type="text" name="codigo_referencia" value="{{ old('codigo_referencia') }}"
                                class="w-full px-4 py-3 bg-white border border-emerald-100 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all font-medium text-slate-700"
                                placeholder="Dejar vacío para autogenerar">
                        </div>
                        <div>
                            <label
                                class="block text-[10px] font-black text-emerald-900 uppercase tracking-widest mb-2">Observaciones
                                de la Recolección</label>
                            <textarea name="observaciones" rows="3"
                                class="w-full px-4 py-3 bg-white border border-emerald-100 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all font-medium text-slate-700"
                                placeholder="Mencione cualquier anomalía o detalle relevante durante la cosecha...">{{ old('observaciones') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="flex gap-4">
                    <a href="{{ route('admin.cultivos.index') }}"
                        class="flex-1 bg-white border-2 border-slate-100 text-slate-500 font-bold py-4 rounded-2xl hover:bg-slate-50 transition-all text-center">
                        Descartar
                    </a>
                    <button type="submit"
                        class="flex-[2] bg-emerald-600 text-white font-black py-4 rounded-2xl shadow-lg shadow-emerald-200 hover:bg-emerald-700 hover:-translate-y-1 transition-all">
                        Finalizar y Registrar Recolección
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection