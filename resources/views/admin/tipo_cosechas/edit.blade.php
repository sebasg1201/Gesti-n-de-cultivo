@extends('layouts.admin')

@section('title', 'Editar Cosecha')

@section('content')

<div class="bg-white p-6 rounded-xl shadow max-w-xl mx-auto">

    <h2 class="text-2xl font-bold mb-6">Editar Tipo de Cosecha</h2>

    <form action="{{ route('tipo_cosechas.update', $tipoCosecha->id_tipo_cosecha) }}" method="POST">
        @csrf
        @method('PUT')

        @if ($errors->any())
            <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Tiempo (días)</label>
            <input type="number" name="tiempo"
                   value="{{ old('tiempo', $tipoCosecha->tiempo) }}"
                   class="w-full border rounded-lg p-2 @error('tiempo') border-red-500 @enderror"
                   required>
            @error('tiempo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Terreno</label>
            <input type="text" name="terreno"
                   value="{{ old('terreno', $tipoCosecha->terreno) }}"
                   class="w-full border rounded-lg p-2 @error('terreno') border-red-500 @enderror"
                   required>
            @error('terreno') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Semilla</label>
            <select name="id_semilla" class="w-full border rounded-lg p-2 @error('id_semilla') border-red-500 @enderror" required>
                @foreach(\App\Models\TipoSemilla::all() as $semilla)
                    <option value="{{ $semilla->id_semilla }}" {{ old('id_semilla', $tipoCosecha->id_semilla) == $semilla->id_semilla ? 'selected' : '' }}>
                        {{ $semilla->Tipo_semilla }}
                    </option>
                @endforeach
            </select>
            @error('id_semilla') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Riego</label>
            <select name="id_tipo_riego" class="w-full border rounded-lg p-2 @error('id_tipo_riego') border-red-500 @enderror" required>
                @foreach(\App\Models\TipoRiego::all() as $riego)
                    <option value="{{ $riego->id_tipo_riego }}" {{ old('id_tipo_riego', $tipoCosecha->id_tipo_riego) == $riego->id_tipo_riego ? 'selected' : '' }}>
                        {{ $riego->tipo_riego }}
                    </option>
                @endforeach
            </select>
            @error('id_tipo_riego') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>


        <div class="flex justify-between">
            <a href="{{ route('tipo_cosechas.index') }}"
               class="px-4 py-2 bg-gray-500 text-white rounded-lg">
               Cancelar
            </a>

            <button class="px-4 py-2 bg-yellow-500 text-white rounded-lg">
                Actualizar
            </button>
        </div>
    </form>

</div>

@endsection
