@extends('layouts.admin')

@section('title', 'Bienvenido al Panel Administrativo')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

    <div class="bg-blue-50 p-6 rounded-xl border border-blue-100 shadow-sm hover:shadow-md transition">
        <h4 class="font-bold text-lg text-blue-900 mb-2">Gestión de Cultivos</h4>
        <p class="text-sm text-blue-700 mb-4">Administra los tipos de cosecha y sus características.</p>
        <a href="{{ route('tipo_cosechas.index') }}"class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">Gestionar Cosechas</a>
    </div>

    <div class="bg-green-50 p-6 rounded-xl border border-green-100 shadow-sm hover:shadow-md transition">
        <h4 class="font-bold text-lg text-green-900 mb-2">Gestión de Riego</h4>
        <p class="text-sm text-green-700 mb-4">Configura los tipos de riego disponibles.</p>
        <a href="{{ route('tipo_riegos.index') }}" class="inline-block px-4 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700">Gestionar Riegos</a>
    </div>

    <div class="bg-yellow-50 p-6 rounded-xl border border-yellow-100 shadow-sm hover:shadow-md transition">
        <h4 class="font-bold text-lg text-yellow-900 mb-2">Tipos de Semilla</h4>
        <p class="text-sm text-yellow-700 mb-4">Catálogo de semillas permitidas.</p>
        <a href="{{ route('tipo_semillas.index') }}" class="inline-block px-4 py-2 bg-yellow-600 text-white rounded-lg text-sm hover:bg-yellow-700">Gestionar Semillas</a>
    </div>

    <div class="bg-purple-50 p-6 rounded-xl border border-purple-100 shadow-sm hover:shadow-md transition">
        <h4 class="font-bold text-lg text-purple-900 mb-2">Gestion de Personal</h4>
        <p class="text-sm text-purple-700 mb-4">Roles y Gestion de roles y asignacion de trabajos.</p>
        <a href="{{ route('admin.usuarios.index') }}" class="inline-block px-4 py-2 bg-purple-600 text-white rounded-lg text-sm hover:bg-purple-700">Gestionar Roles</a>
    </div>

</div>

@endsection
