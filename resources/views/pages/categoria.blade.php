@extends('layouts.app')

@section('title', $categoria)

@section('banner')
    @include('components.banner', [
        'imagen' => $banner,
        'titulo' => $categoria
    ])
@endsection

@section('content')

<div class="max-w-7xl mx-auto py-10 px-4">

    <h2 class="text-3xl font-bold mb-8 text-center">
        {{ $categoria }}
    </h2>

    <div class="mb-6 flex justify-center">
        <input type="text" placeholder="Buscar producto..."
            class="w-full md:w-1/2 px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-400">
    </div>

    {{-- SI NO HAY PRODUCTOS --}}
    @if($productos->isEmpty())
        <div class="text-center py-20 text-gray-400">
            <h3 class="text-xl font-semibold">No hay productos disponibles</h3>
        </div>
    @endif

    {{-- GRID --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">

        @foreach ($productos as $producto)

            @include('components.product-card', [
                'id' => $producto->id,
                'imagen' => $producto->imagen?->url,
                'nombre' => $producto->modelo->nombre,
                'tallas' => $producto->variaciones
                                ->where('stock', '>', 0)
                                ->pluck('talla.numero')
                                ->unique()
                                ->implode(','),
                'precio' => $producto->variaciones
                                ->where('stock', '>', 0)
                                ->avg('precio'),
                'categoria' => strtolower($producto->modelo->categoria->nombre)
            ])

        @endforeach

    </div>

</div>

@endsection