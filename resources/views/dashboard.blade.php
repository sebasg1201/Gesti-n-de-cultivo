@extends('layouts.barra_lateral')

@section('content')


<h1 class="text-2xl font-bold mb-6">Panel de Control</h1>

<div class="grid grid-cols-4 gap-6">

    <!-- TARJETA 1 -->
    <div class="bg-white p-6 rounded shadow flex items-center justify-between">

        <div>
            <p class="text-gray-500">Ganancia Neta</p>
            <h2 class="text-2xl font-bold">$120,400</h2>
        </div>

        <!-- Icono Finanzas -->
        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
        viewBox="0 0 24 24" stroke-width="1.5"
        stroke="currentColor" class="w-10 h-10 text-green-600">
            <path stroke-linecap="round" stroke-linejoin="round"
            d="M12 8c-3 0-5 1.5-5 3s2 3 5 3 5 1.5 5 3-2 3-5 3m0-12V4m0 16v-2"/>
        </svg>

    </div>


    <!-- TARJETA 2 -->
    <div class="bg-white p-6 rounded shadow flex items-center justify-between">

        <div>
            <p class="text-gray-500">Cosecha Pendiente</p>
            <h2 class="text-2xl font-bold">45 Toneladas</h2>
        </div>

        <!-- Icono Cultivo -->
        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
        viewBox="0 0 24 24" stroke-width="1.5"
        stroke="currentColor" class="w-10 h-10 text-green-500">
            <path stroke-linecap="round" stroke-linejoin="round"
            d="M12 21c4-4 6-8 6-11a6 6 0 10-12 0c0 3 2 7 6 11z"/>
        </svg>

    </div>


    <!-- TARJETA 3 -->
    <div class="bg-white p-6 rounded shadow flex items-center justify-between">

        <div>
            <p class="text-gray-500">Alertas de Riego</p>
            <h2 class="text-2xl font-bold">3 Zonas</h2>
        </div>

        <!-- Icono Riego -->
        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
        viewBox="0 0 24 24" stroke-width="1.5"
        stroke="currentColor" class="w-10 h-10 text-blue-500">
            <path stroke-linecap="round" stroke-linejoin="round"
            d="M12 2C8 7 6 9 6 12a6 6 0 0012 0c0-3-2-5-6-10z"/>
        </svg>

    </div>


    <!-- TARJETA 4 -->
    <div class="bg-white p-6 rounded shadow flex items-center justify-between">

        <div>
            <p class="text-gray-500">Stock Crítico</p>
            <h2 class="text-2xl font-bold">2 Ítems</h2>
        </div>

        <!-- Icono Inventario -->
        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
        viewBox="0 0 24 24" stroke-width="1.5"
        stroke="currentColor" class="w-10 h-10 text-purple-600">
            <path stroke-linecap="round" stroke-linejoin="round"
            d="M20 7L12 3 4 7l8 4 8-4z"/>
            <path stroke-linecap="round" stroke-linejoin="round"
            d="M4 7v10l8 4 8-4V7"/>
        </svg>

    </div>

</div>

<!--GRAFICOS-->
<div class="grid grid-cols-2 gap-6 mt-8">

    <div class="bg-white p-6 rounded shadow">
        <h2 class="font-bold mb-4">Rentabilidad Mensual</h2>

        <div class="h-48 bg-gray-100 flex items-center justify-center text-gray-400">
             Aquí irá el gráfico
        </div>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <h2 class="font-bold mb-4">Crecimiento de Cultivos</h2>

        <div class="h-48 bg-gray-100 flex items-center justify-center text-gray-400">
             Aquí irá el gráfico
        </div>
    </div>

</div>

<!-- TABLA PROVEEDORES  -->
<div class="bg-white p-6 rounded shadow mt-8">

    <h3 class="font-bold mb-4">Últimos Proveedores</h3>

    <table class="w-full text-left">

        <thead>
            <tr class="border-b">
                <th class="p-2">Proveedor</th>
                <th class="p-2">Categoría</th>
                <th class="p-2">Estado</th>
                <th class="p-2">Última Entrega</th>
            </tr>
        </thead>

        <tbody>

            <tr class="border-b">
                <td class="p-2">AgroInsumos del Norte</td>
                <td class="p-2">Fertilizantes</td>
                <td class="p-2 text-green-600 font-semibold">Activo</td>
                <td class="p-2">12 Oct 2023</td>
            </tr>

            <tr>
                <td class="p-2">Semillas Premium</td>
                <td class="p-2">Semillas</td>
                <td class="p-2 text-green-600 font-semibold">Activo</td>
                <td class="p-2">20 Oct 2023</td>
            </tr>

        </tbody>

    </table>

</div>

@endsection
