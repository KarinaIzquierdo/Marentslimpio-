@extends('layouts.admin')

@section('content')

{{-- 🔥 HEADER --}}
<div class="flex justify-between items-center mb-6">

    <h1 class="text-2xl font-bold text-gray-800">
        Pedidos
    </h1>

    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
        + Crear pedido
    </button>

</div>


{{-- 🔍 FILTROS --}}
<div class="bg-white rounded-xl shadow p-4 mb-6 flex gap-4 flex-wrap">

    <input type="text" id="buscarPedido"
        placeholder="Buscar pedido..."
        class="border rounded-lg px-3 py-2 w-64">

    <select id="filtroEstado" class="border rounded-lg px-3 py-2">
        <option value="">Todos</option>
        <option value="Pendiente">Pendiente</option>
        <option value="En proceso">En proceso</option>
        <option value="Completado">Completado</option>
    </select>

</div>


{{-- 🔥 TABLA --}}
<div class="bg-white rounded-xl shadow p-6 overflow-x-auto">

    <table id="tabla-pedidos" class="w-full text-sm">

        <thead class="text-gray-500 border-b">
            <tr>
                <th># Pedido</th>
                <th>Código</th>
                <th>Cliente</th>
                <th>Productos</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>

            <tr class="border-t hover:bg-gray-50">

                <td>#001</td>

                <td class="text-gray-500">
                    ORD-2026-001
                </td>

                <td>Juan Pérez</td>

                <td>
                    Cool x1, Bolichero x2
                </td>

                <td class="font-semibold">
                    $120.000
                </td>

                {{-- 🔥 ESTADO --}}
                <td>
                    <select class="border rounded px-2 py-1 text-sm estado-select">

                        <option value="Pendiente" selected>🟡 Pendiente</option>
                        <option value="En proceso">🔵 En proceso</option>
                        <option value="Completado">🟢 Completado</option>

                    </select>
                </td>

                {{-- 🔥 ACCIONES --}}
                <td>
                    <div class="flex gap-2 justify-center">

                        <button class="bg-gray-200 px-2 py-1 rounded text-xs">
                            Ver
                        </button>

                        <button class="bg-blue-500 text-white px-2 py-1 rounded text-xs">
                            Editar
                        </button>

                        <button class="bg-red-500 text-white px-2 py-1 rounded text-xs">
                            Eliminar
                        </button>

                    </div>
                </td>

            </tr>

        </tbody>

    </table>

</div>

@endsection


@push('scripts')
<script>

$(document).ready(function () {

    let tabla = $('#tabla-pedidos').DataTable({
        pageLength: 5,
        responsive: false,
        scrollX: true,
        autoWidth: false,
        language: {
            search: "Buscar:",
        }
    });

    // 🔍 BUSCAR
    $('#buscarPedido').on('keyup', function () {
        tabla.search(this.value).draw();
    });

    // 🎯 FILTRO ESTADO
    $('#filtroEstado').on('change', function () {
        tabla.column(5).search(this.value).draw();
    });

});


/* 🔥 CAMBIO DE ESTADO (visual) */
$(document).on('change', '.estado-select', function () {

    let val = $(this).val();

    $(this).removeClass('text-yellow-500 text-blue-500 text-green-500');

    if (val === 'Pendiente') {
        $(this).addClass('text-yellow-500');
    }
    if (val === 'En proceso') {
        $(this).addClass('text-blue-500');
    }
    if (val === 'Completado') {
        $(this).addClass('text-green-500');
    }

});

</script>
@endpush