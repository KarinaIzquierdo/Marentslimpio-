@extends('layouts.admin')

@section('content')

<div class="max-w-7xl mx-auto space-y-6 productos-admin">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <h1 class="text-2xl font-bold text-gray-800">
            Gestión de productos
        </h1>

        <div class="flex flex-wrap gap-2">
            <button id="btnStockGlobal"
                class="bg-slate-800 text-white px-4 py-2 rounded-xl shadow hover:bg-slate-900 transition">
                Gestión existencias
            </button>

            <button id="btnNuevoProducto"
                class="bg-black text-white px-4 py-2 rounded-xl shadow hover:bg-gray-900 transition">
                + Nuevo producto
            </button>
        </div>
    </div>

    <!-- FILTROS -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4">
        <div class="flex flex-wrap items-center gap-3">

            <input id="buscar"
                type="text"
                placeholder="Buscar producto..."
                class="border border-gray-300 rounded-xl px-3 py-2 text-sm w-full sm:w-64 focus:outline-none focus:ring-2 focus:ring-slate-300">

            <select id="filtroCategoria"
                class="border border-gray-300 rounded-xl px-3 py-2 text-sm min-w-[180px] focus:outline-none focus:ring-2 focus:ring-slate-300">
                <option value="">Todas las categorías</option>
                @foreach($categorias as $cat)
                    <option value="{{ $cat->nombre }}">
                        {{ $cat->nombre }}
                    </option>
                @endforeach
            </select>

            <select id="ordenStock"
                class="border border-gray-300 rounded-xl px-3 py-2 text-sm min-w-[180px] focus:outline-none focus:ring-2 focus:ring-slate-300">
                <option value="">Ordenar stock</option>
                <option value="mayor">Mayor a menor</option>
                <option value="menor">Menor a mayor</option>
            </select>

        </div>
    </div>

    <!-- TABLA -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4">
        <div class="overflow-x-auto">

            <table id="tabla-productos" class="min-w-full text-sm align-middle">

                <thead>
                    <tr>
                        <th class="text-left">Categoría</th>
                        <th class="text-left">Nombre</th>
                        <th class="text-left">Variaciones</th>
                        <th class="text-center">Stock</th>
                        <th class="text-center">Costo</th>
                        <th class="text-center">Precio</th>
                        <th class="text-center">Ganancia</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($productos as $producto)

                        @php
                            $variaciones = $producto->variaciones;
                            $stockTotal = $variaciones->sum('stock');
                            $costoPromedio = $variaciones->avg('costo') ?? 0;
                            $precioPromedio = $variaciones->avg('precio') ?? 0;
                            $gananciaPromedio = $precioPromedio - $costoPromedio;

                            $agrupado = $variaciones->groupBy(fn($v) => $v->colorPrimario->nombre ?? 'Sin color');
                        @endphp

                        <tr>

                            <!-- CATEGORIA -->
                            <td>
                                <span class="inline-flex items-center rounded-full bg-slate-100 text-slate-700 px-2.5 py-1 text-xs font-medium">
                                    {{ $producto->modelo?->categoria?->nombre ?? 'Sin categoría' }}
                                </span>
                            </td>

                            <!-- NOMBRE -->
                            <td>
                                <div class="flex items-center gap-3">

                                    <button
                                        class="ver-imagen shrink-0 bg-gray-200 hover:bg-gray-300 px-2 py-1 rounded text-xs transition"
                                        data-img="{{ $producto->imagen ? $producto->imagen->url : '/img/default.png' }}">
                                        Ver
                                    </button>

                                    <div class="min-w-0">
                                        <p class="font-semibold text-gray-800 truncate">
                                            {{ $producto->modelo?->nombre ?? 'Sin nombre' }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            ID: {{ $producto->id }}
                                        </p>
                                    </div>

                                </div>
                            </td>

                            <!-- VARIACIONES AGRUPADAS -->
                            <td>
                                <div class="space-y-2">

                                    @foreach($agrupado as $color => $items)

                                        <div class="border rounded-lg p-2 bg-gray-50">

                                            <div class="flex items-center gap-2 mb-1">

                                                <div class="w-3 h-3 rounded-full border"
                                                    style="background: {{ $items->first()->colorPrimario->hex ?? '#000' }}">
                                                </div>

                                                <span class="text-xs font-semibold text-gray-700">
                                                    {{ $color }}
                                                </span>

                                            </div>

                                            <div class="flex flex-wrap gap-1">

                                                @foreach($items as $v)
                                                    <span class="bg-white border px-2 py-1 rounded text-xs">
                                                        T{{ $v->talla->numero ?? '-' }} ({{ $v->stock }})
                                                    </span>
                                                @endforeach

                                            </div>

                                        </div>

                                    @endforeach

                                </div>
                            </td>

                            <!-- STOCK -->
                            <td class="text-center">
                                <span class="
                                    inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold
                                    {{ $stockTotal > 10 ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $stockTotal <= 10 && $stockTotal > 0 ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    {{ $stockTotal == 0 ? 'bg-red-100 text-red-700' : '' }}
                                ">
                                    {{ $stockTotal }}
                                </span>
                            </td>

                            <!-- COSTO -->
                            <td class="text-center font-medium">
                                ${{ number_format($costoPromedio, 0, ',', '.') }}
                            </td>

                            <!-- PRECIO -->
                            <td class="text-center font-semibold text-gray-800">
                                ${{ number_format($precioPromedio, 0, ',', '.') }}
                            </td>

                            <!-- GANANCIA -->
                            <td class="text-center font-semibold text-green-600">
                                ${{ number_format($gananciaPromedio, 0, ',', '.') }}
                            </td>

                            <!-- ACCIONES -->
                            <td class="text-center">
                                @if($producto->modelo)
                                <button
    class="btn-stock bg-black hover:bg-gray-900 text-white px-3 py-1.5 rounded-lg text-xs transition"
    data-modelo="{{ $producto->modelo->id }}">
    Stock
</button>
                                @else
                                <span class="text-xs text-gray-400">Sin modelo</span>
                                @endif
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>
    </div>

</div>

<!-- MODAL IMAGEN -->
<div id="modalImagen"
class="modal hidden fixed inset-0 bg-black/70 z-[9999] flex items-center justify-center p-4">

    <div class="bg-white p-4 rounded-xl shadow-xl relative max-w-[460px] w-full">
        <button id="cerrarModalImagen"
            class="absolute top-2 right-2 text-gray-500 hover:text-black text-lg">
            ✕
        </button>

        <img id="imagenGrande" src="" class="w-full rounded-lg object-contain">
    </div>
</div>

@include('admin.productos.modal-create')
@include('admin.productos.modal-stock-global')
@include('admin.productos.modal-stock-producto')

@endsection