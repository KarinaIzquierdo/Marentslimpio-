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

    {{-- PRODUCTOS --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

        @foreach ($productos as $producto)
            @include('components.product-card', [
                'imagen' => $producto['imagen'],
                'nombre' => $producto['nombre'],
                'tallas' => $producto['tallas'],
                'precio' => $producto['precio']
            ])
        @endforeach

    </div>

    {{-- PAGINACION --}}
    <div class="mt-10 flex justify-center">
        @include('components.pagination')
    </div>

    {{-- 🔥 SECCION PERSONALIZACION --}}
    @include('components.personalizacion')

</div>

@endsection