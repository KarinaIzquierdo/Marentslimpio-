@extends('layouts.admin')

@section('content')

{{-- 🔥 HEADER --}}
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">
        Dashboard
    </h1>
    <p class="text-gray-500 text-sm">
        Resumen general del negocio
    </p>
</div>


{{-- 🔥 CARDS PRO --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">

    {{-- PEDIDOS --}}
    <div class="bg-white p-5 rounded-xl shadow flex items-center gap-4">
        <div class="bg-blue-100 text-blue-600 p-3 rounded-lg text-xl">
            📦
        </div>
        <div>
            <p class="text-gray-500 text-sm">Pendientes</p>
            <h2 class="text-2xl font-bold">12</h2>
        </div>
    </div>

    {{-- REALIZADOS --}}
    <div class="bg-white p-5 rounded-xl shadow flex items-center gap-4">
        <div class="bg-green-100 text-green-600 p-3 rounded-lg text-xl">
            ✅
        </div>
        <div>
            <p class="text-gray-500 text-sm">Completados</p>
            <h2 class="text-2xl font-bold">58</h2>
        </div>
    </div>

    {{-- STOCK --}}
    <div class="bg-white p-5 rounded-xl shadow flex items-center gap-4">
        <div class="bg-red-100 text-red-600 p-3 rounded-lg text-xl">
            ⚠️
        </div>
        <div>
            <p class="text-gray-500 text-sm">Stock bajo</p>
            <h2 class="text-2xl font-bold text-red-500">5</h2>
        </div>
    </div>

    {{-- VENTAS --}}
    <div class="bg-white p-5 rounded-xl shadow flex items-center gap-4">
        <div class="bg-purple-100 text-purple-600 p-3 rounded-lg text-xl">
            💰
        </div>
        <div>
            <p class="text-gray-500 text-sm">Ventas</p>
            <h2 class="text-2xl font-bold">$2.5M</h2>
        </div>
    </div>

</div>


{{-- 🔥 GRID PRINCIPAL --}}
<div class="grid md:grid-cols-3 gap-6 mb-8">

    {{-- 📊 GRAFICA --}}
    <div class="bg-white rounded-xl shadow p-6 col-span-2">
        <h2 class="text-lg font-semibold mb-4 text-gray-700">
            Ventas del mes
        </h2>

        <canvas id="ventasChart" height="120"></canvas>
    </div>

    {{-- 🔥 TOP PRODUCTOS --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold mb-4 text-gray-700">
            Más vendidos
        </h2>

        <ul class="space-y-3 text-sm">

            <li class="flex justify-between">
                <span>Cool</span>
                <span class="font-semibold">25</span>
            </li>

            <li class="flex justify-between">
                <span>Bolichero</span>
                <span class="font-semibold">18</span>
            </li>

            <li class="flex justify-between">
                <span>Bigotes</span>
                <span class="font-semibold">12</span>
            </li>

        </ul>
    </div>

</div>


{{-- 🔥 TABLA MEJORADA --}}
<div class="bg-white rounded-xl shadow p-6">

    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold text-gray-700">
            Pedidos recientes
        </h2>

        <button class="text-sm text-blue-600 hover:underline">
            Ver todos
        </button>
    </div>

    <table class="w-full text-sm">

        <thead class="text-gray-500 border-b">
            <tr>
                <th class="py-2 text-center ">ID</th>
                <th>Cliente</th>
                <th>Total</th>
                <th>Estado</th>
            </tr>
        </thead>

        <tbody>

            <tr class="border-t hover:bg-gray-50 text-center ">
                <td class="py-2">#001</td>
                <td>Juan</td>
                <td>$120.000</td>
                <td>
                    <span class="bg-yellow-100 text-yellow-600 px-2 py-1 rounded text-xs">
                        Pendiente
                    </span>
                </td>
            </tr>

            <tr class="border-t hover:bg-gray-50 text-center ">
                <td class="py-2">#002</td>
                <td>Ana</td>
                <td>$85.000</td>
                <td>
                    <span class="bg-green-100 text-green-600 px-2 py-1 rounded text-xs">
                        Completado
                    </span>
                </td>
            </tr>

        </tbody>

    </table>

</div>

@endsection


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('ventasChart');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sab', 'Dom'],
        datasets: [{
            label: 'Ventas',
            data: [120, 190, 300, 250, 400, 350, 500],
            borderWidth: 2,
            tension: 0.4
        }]
    },
    options: {
        plugins: {
            legend: { display: false }
        }
    }
});
</script>
@endpush