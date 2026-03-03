@extends('layouts.admin')

@section('title', 'Nueva Cosecha')

@section('content')

    <div class="bg-white p-6 rounded-xl shadow max-w-xl mx-auto">

        <form action="{{ route('tipo_cosechas.store') }}" method="POST">
            @csrf

            @if ($errors->any())
                <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc pl-5 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-3">
                <label>Tiempo (días)</label>
                <input type="number" name="tiempo" value="{{ old('tiempo') }}" class="border p-2 w-full @error('tiempo') border-red-500 @enderror" required>
                @error('tiempo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-3">
                <label>Terreno</label>
                <input type="text" name="terreno" value="{{ old('terreno') }}" class="border p-2 w-full @error('terreno') border-red-500 @enderror" required>
                @error('terreno') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-3">
                <label>Tipo de Semilla</label>
                <select name="id_semilla" class="border p-2 w-full @error('id_semilla') border-red-500 @enderror" required>
                    <option value="">-- Seleccione Semilla --</option>
                    @foreach($tipoSemillas as $semilla)
                        <option value="{{ $semilla->id_semilla }}" {{ old('id_semilla') == $semilla->id_semilla ? 'selected' : '' }}>
                            {{ $semilla->Tipo_semilla }}
                        </option>
                    @endforeach
                </select>
                @error('id_semilla') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-3">
                <label>Tipo de Riego</label>
                <select name="id_tipo_riego" class="border p-2 w-full @error('id_tipo_riego') border-red-500 @enderror" required>

                    <option value="">-- Seleccione Riego --</option>
                    @foreach($tipoRiegos as $riego)
                        <option value="{{ $riego->id_tipo_riego }}" {{ old('id_tipo_riego') == $riego->id_tipo_riego ? 'selected' : '' }}>

                            {{ $riego->tipo_riego }}
                        </option>
                    @endforeach
                </select>
                @error('id_tipo_riego') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

            </div>

            <button class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700 transition">
                Guardar Cosecha
            </button>

        </form>

    </div>

@endsection