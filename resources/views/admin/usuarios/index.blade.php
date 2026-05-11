@extends('layouts.admin')

@section('content')

<h1 class="text-2xl font-bold mb-6 text-gray-800">Usuarios</h1>

<div class="bg-white rounded-xl shadow p-6">

<table class="w-full text-sm table-auto">

    <thead class="text-gray-500 border-b">
        <tr>
            <th class="text-left py-3">Nombre</th>
            <th class="text-left">Email</th>
            <th class="text-left w-32">Rol</th>
            <th class="text-left w-40">Acciones</th>
        </tr>
    </thead>

    <tbody>
        @forelse($usuarios as $usuario)
        <tr class="border-t hover:bg-gray-50">
            <td class="py-3">{{ $usuario->nombres }} {{ $usuario->apellidos }}</td>
            <td>{{ $usuario->email }}</td>
            <td>{{ $usuario->rol ?? 'cliente' }}</td>
            <td class="space-x-3">
                <a href="{{ route('admin.usuarios.edit', $usuario->id) }}" class="text-blue-500 hover:text-blue-700 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Editar
                </a>
                <button class="text-red-500">Eliminar</button>
            </td>
        </tr>
        @empty
        <tr class="border-t">
            <td colspan="4" class="py-3 text-center text-gray-500">No hay usuarios registrados</td>
        </tr>
        @endforelse
    </tbody>

</table>

</div>

@endsection