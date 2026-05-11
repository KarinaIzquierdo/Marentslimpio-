@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto py-12 px-6 text-white">

    <!-- HEADER -->
    <div class="mb-10">
        <h1 class="text-4xl font-extrabold tracking-wide">
            TU CARRITO
        </h1>

        <p class="text-gray-400 mt-2 text-sm">
            Los artículos en tu carrito no están reservados.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

        <!-- ================= PRODUCTOS ================= -->
        <div class="lg:col-span-2 space-y-6">

            @php $total = 0; @endphp

            @foreach($carrito as $key => $item)

                @php 
                    $subtotal = $item['precio'] * $item['cantidad'];
                    $total += $subtotal;
                @endphp

                <div class="flex flex-col md:flex-row gap-6 p-5 rounded-2xl 
                            bg-white/5 backdrop-blur-xl border border-white/10 
                            hover:bg-white/10 transition">

                    <!-- IMAGEN -->
                    <div class="w-full md:w-36 h-36 bg-white/10 rounded-xl flex items-center justify-center">
                        <img src="{{ asset('img/productos/'.$item['categoria'].'/'.$item['imagen']) }}"
                             class="max-h-full object-contain">
                    </div>

                    <!-- INFO -->
                    <div class="flex-1 flex flex-col justify-between">

                        <div>
                            <h2 class="font-bold text-lg">
                                {{ $item['nombre'] }}
                            </h2>

                            <p class="text-sm text-gray-400">
                                Talla: {{ $item['talla'] }}
                            </p>

                            <p class="text-sm text-gray-500 mt-1">
                                ${{ number_format($item['precio'],0,',','.') }}
                            </p>
                        </div>

                        <!-- ACCIONES -->
                        <div class="flex items-center justify-between mt-4">

                            <!-- CANTIDAD -->
                            <form method="POST" action="{{ route('carrito.actualizar', $key) }}">
                                @csrf
                                <input type="number" name="cantidad"
                                    value="{{ $item['cantidad'] }}"
                                    min="1"
                                    class="w-20 bg-black/40 border border-white/20 px-3 py-1 rounded text-center text-white">
                            </form>

                            <!-- SUBTOTAL -->
                            <p class="font-bold text-lg">
                                ${{ number_format($subtotal,0,',','.') }}
                            </p>

                            <!-- ELIMINAR -->
                            <form method="POST" action="{{ route('carrito.eliminar', $key) }}">
                                @csrf
                                <button class="text-gray-400 hover:text-red-500 text-xl transition">
                                    ✕
                                </button>
                            </form>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

        <!-- ================= RESUMEN ================= -->
        <div class="p-6 rounded-2xl 
                    bg-white/5 backdrop-blur-xl border border-white/10 
                    shadow-xl h-fit">

            <h2 class="text-xl font-bold mb-6">
                RESUMEN DEL PEDIDO
            </h2>

            <div class="space-y-4 text-sm">

                <div class="flex justify-between text-gray-300">
                    <span>{{ count($carrito) }} productos</span>
                    <span>${{ number_format($total,0,',','.') }}</span>
                </div>

                <div class="flex justify-between text-gray-400">
                    <span>Entrega</span>
                    <span class="text-green-400">Gratis</span>
                </div>

                <hr class="border-white/10">

                <div class="flex justify-between text-lg font-bold">
                    <span>Total</span>
                    <span>${{ number_format($total,0,',','.') }}</span>
                </div>

            </div>

            <!-- BOTON -->
            @auth
    <a href="/checkout"
       class="w-full block text-center mt-6 bg-white text-black py-4 rounded-full font-semibold hover:bg-gray-200 transition">
        Ir a pagar →
    </a>
@endauth

@guest
    <button onclick="abrirAuthModal()"
        class="w-full mt-6 bg-white text-black py-4 rounded-full font-semibold hover:bg-gray-200 transition">
        Ir a pagar →
    </button>
@endguest

        </div>

    </div>

</div>

<!-- AUTO UPDATE -->
<script>
document.querySelectorAll('input[name="cantidad"]').forEach(input => {
    input.addEventListener('change', function() {
        this.form.submit();
    });
});
</script>

@endsection