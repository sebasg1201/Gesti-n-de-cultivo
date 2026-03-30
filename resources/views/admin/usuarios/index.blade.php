@extends('layouts.admin')

@section('title', 'Gestión de Personal')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-emerald-100 dark:border-emerald-900/20 transition-all duration-300">
        <div>
            <h2 class="text-2xl font-bold text-emerald-900 dark:text-emerald-50 group flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                Personal de la Empresa
            </h2>
            <p class="text-sm text-gray-500 dark:text-emerald-400 mt-1">Administra supervisores y trabajadores, y asigna fases programadas.</p>
        </div>
        <a href="{{ route('admin.usuarios.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-md transition-colors flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Nuevo Usuario
        </a>
    </div>



    {{-- TABLA --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-100 dark:border-emerald-900/20 overflow-hidden transition-all duration-300">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-emerald-50 dark:bg-slate-900/50 text-emerald-900 dark:text-emerald-50 border-b border-emerald-100 dark:border-emerald-900/20">
                        <th class="py-4 px-6 font-bold text-sm uppercase tracking-wider">Documento</th>
                        <th class="py-4 px-6 font-bold text-sm uppercase tracking-wider">Usuario</th>
                        <th class="py-4 px-6 font-bold text-sm uppercase tracking-wider">Rol</th>
                        <th class="py-4 px-6 font-bold text-sm uppercase tracking-wider">Contacto</th>
                        <th class="py-4 px-6 font-bold text-sm uppercase tracking-wider text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-emerald-900/10 text-gray-700 dark:text-emerald-100">
                    @forelse($usuarios as $user)
                        <tr class="hover:bg-emerald-50/50 dark:hover:bg-slate-900 transition-colors">
                            <td class="py-4 px-6 font-medium text-gray-900 dark:text-emerald-50">{{ $user->documento }}</td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    @if($user->imagen)
                                        <img src="{{ asset('uploads/' . $user->imagen) }}" alt="Avatar" class="w-10 h-10 rounded-full object-cover border-2 border-emerald-100 dark:border-emerald-900 shadow-sm">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-700 dark:text-emerald-400 font-bold border-2 border-emerald-200 dark:border-emerald-900 shadow-sm font-mono">
                                            {{ strtoupper(substr($user->nombre, 0, 1)) }}
                                        </div>
                                    @endif
                                    <span class="font-semibold text-gray-800 dark:text-emerald-50 transition-colors">{{ $user->nombre }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                @if($user->id_tipo_usuario == 2)
                                    <span class="bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide border border-blue-200 dark:border-blue-800/40">Supervisor</span>
                                @elseif($user->id_tipo_usuario == 3)
                                    <span class="bg-green-100 dark:bg-emerald-900/30 text-green-800 dark:text-emerald-400 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide border border-green-200 dark:border-emerald-800/40">Trabajador</span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <div class="text-sm">
                                    <p class="text-gray-900 dark:text-emerald-50">{{ $user->correo }}</p>
                                    <p class="text-gray-500 dark:text-emerald-400 font-mono mt-0.5">{{ $user->telefono }}</p>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center justify-center gap-2">
                                    
                                    {{-- Asignar Pago --}}
                                    <a href="{{ route('admin.usuarios.asignar_trabajo', $user->documento) }}" title="Asignar Pago"
                                       class="p-2 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 hover:bg-emerald-200 dark:hover:bg-emerald-900/50 rounded-lg transition-colors group">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                        </svg>
                                    </a>

                                    {{-- Editar --}}
                                    <a href="{{ route('admin.usuarios.edit', $user->documento) }}" title="Editar"
                                       class="p-2 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors group">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>

                                    {{-- Eliminar --}}
                                    <form action="{{ route('admin.usuarios.destroy', $user->documento) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de eliminar a este usuario? Esta acción no se puede deshacer.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Eliminar"
                                                class="p-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg transition-colors group cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                                            </svg>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-gray-500 dark:text-emerald-500">
                                <div class="flex flex-col items-center justify-center opacity-40">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300 dark:text-emerald-800 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <p class="text-lg font-medium text-gray-800 dark:text-emerald-50">No hay personal registrado</p>
                                    <p class="text-sm mt-1">Comienza agregando supervisores y trabajadores a tu empresa.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- PAGINACIÓN --}}
    <div class="mt-6 text-sm">
        {{ $usuarios->links() }}
    </div>

</div>
@endsection
