@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto py-12 px-6">

    <!-- ================= PRODUCTO ================= -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-start">

        <!-- IMAGEN -->
        <div class="bg-[#f6f6f6] rounded-3xl p-8 flex items-center justify-center shadow-sm">
            @php
                $categoriaNombre = strtolower($producto->modelo->categoria->nombre);
                $categoriaPath = str_replace(['ñ', ' '], ['n', '_'], $categoriaNombre);
            @endphp
            <img 
                src="{{ asset(
                    $producto->imagen 
                    ? 'img/productos/' . $categoriaPath . '/' . $producto->imagen->url
                    : 'img/default.png'
                ) }}"
                class="max-h-[420px] object-contain transition duration-500 hover:scale-105"
                onerror="this.onerror=null; this.src='{{ asset('img/default.png') }}';"
            >
        </div>

        <!-- INFO -->
        <div class="space-y-10">

            <!-- TITULO -->
            <div>
                <h1 class="text-3xl font-bold text-white">
                    {{ $producto->modelo->nombre }}
                </h1>

                <p class="text-gray-400 mt-1">
                    {{ $producto->modelo->categoria->nombre }}
                </p>
            </div>

            <!-- PRECIO -->
            <p class="text-2xl font-bold text-white">
                ${{ number_format($precio, 0, ',', '.') }}
            </p>

            <!-- FORM -->
<form id="formProducto" method="POST" action="{{ route('carrito.agregar') }}">
    @csrf

    <input type="hidden" name="producto_id" value="{{ $producto->id }}">
    <input type="hidden" name="talla" id="tallaSeleccionada" required>

    <!-- COLOR -->
    <div class="mb-10">
        <p class="text-sm font-semibold text-white mb-3">Color</p>

        <div class="flex gap-3">
            @foreach($colores as $color)
                <div class="w-9 h-9 rounded-full border-2 border-white cursor-pointer hover:scale-110 transition shadow"
                     style="background: {{ $color->hex ?? '#000' }}">
                </div>
            @endforeach
        </div>
    </div>

    <!-- TALLAS -->
    <div>
        <p class="text-sm font-semibold text-white mb-3">
            Selecciona la talla
        </p>

        <div class="grid grid-cols-5 gap-2 mb-3">
            @foreach($producto->variaciones as $v)

                <button type="button"
                    data-stock="{{ $v->stock }}"
                    data-talla="{{ $v->talla->numero }}"
                    {{ $v->stock <= 0 ? 'disabled' : '' }}
                    class="talla-btn border border-gray-400 py-3 rounded-lg transition
                    {{ $v->stock <= 0 ? 'opacity-30 cursor-not-allowed' : 'text-white hover:bg-white hover:text-black' }}">

                    {{ $v->talla->numero }}

                    <span class="block text-[10px] text-gray-400">
                        {{ $v->stock }} disponibles
                    </span>

                </button>

            @endforeach
        </div>

        <!-- GUIA -->
        <button type="button" onclick="toggleGuia()"
            class="inline-flex items-center gap-2 px-4 py-2 border border-white/30 text-white rounded-lg 
                   hover:bg-white hover:text-black transition text-sm">
            📏 Guía de tallas
        </button>
    </div>

    <!-- CANTIDAD -->
    <div class="mt-10">
        <p class="text-sm text-white mb-2">Cantidad</p>

        <input type="number" name="cantidad" id="cantidad"
            value="1" min="1"
            class="w-28 px-3 py-2 rounded-lg text-black">
    </div>

    <!-- BOTON -->
    <button type="submit"
        class="w-full bg-black text-white py-4 rounded-full font-semibold hover:bg-gray-900 transition shadow-lg mt-6">
        Agregar a la bolsa de compras
    </button>

</form>

        </div>

    </div>

    <!-- ================= TUTORIAL ================= -->
    <div class="mt-20 grid md:grid-cols-2 gap-12 items-center bg-white/5 p-8 rounded-3xl backdrop-blur">

        <div>
            <h2 class="text-2xl font-bold text-white mb-3">
                ¿Cómo saber tu talla?
            </h2>

            <p class="text-gray-300 text-sm leading-relaxed mb-4">
                Coloca tu pie sobre una hoja, marca el talón y la punta,
                mide en centímetros y compáralo con la guía de tallas.
            </p>

            <button onclick="toggleGuia()"
                class="px-5 py-2 bg-white text-black rounded-full font-semibold hover:bg-gray-200 transition">
                Ver guía de tallas
            </button>
        </div>

        <!-- VIDEO -->
        <div class="max-w-[300px] mx-auto rounded-2xl overflow-hidden shadow-lg bg-black">
            <iframe 
                class="w-full h-[520px]"
                src="https://www.youtube-nocookie.com/embed/mAsl31kGkQM"
                allowfullscreen>
            </iframe>
        </div>

    </div>

</div>

<!-- ================= MODAL ================= -->
<div id="guiaTallas"
     class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">

    <div class="bg-white w-full max-w-5xl rounded-3xl shadow-2xl overflow-hidden text-gray-800">

        <div class="flex justify-between items-center px-6 py-4 border-b">
            <h2 class="text-xl font-bold">Guía de tallas</h2>
            <button onclick="toggleGuia()" class="text-xl">✕</button>
        </div>

        <div class="p-6 overflow-x-auto">
            <table class="w-full text-sm text-center border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3">EU</th>
                        <th class="p-3">US</th>
                        <th class="p-3">CM</th>
                    </tr>
                </thead>

                <tbody>
                    @for ($i = 35; $i <= 45; $i++)
                        <tr class="border-b">
                            <td class="p-3">{{ $i }}</td>
                            <td class="p-3">{{ round(($i - 33) * 0.5 + 4, 1) }}</td>
                            <td class="p-3">{{ number_format(22 + ($i - 35) * 0.7, 1) }}</td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>

    </div>
</div>

<!-- ================= TOAST ================= -->
<div id="toast"
     class="fixed inset-0 flex items-center justify-center z-50 hidden">

    <div id="toastContent"
         class="bg-black text-white px-8 py-4 rounded-2xl shadow-2xl text-center text-sm">
    </div>

</div>

{{-- TOAST DESDE BACKEND --}}
@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    showToast("{{ session('success') }}");
});
</script>
@endif

@if(session('error'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    showToast("{{ session('error') }}", true);
});
</script>
@endif

@endsection