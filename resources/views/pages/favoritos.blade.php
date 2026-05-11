@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto py-12 px-6 text-white">

    <!-- HEADER -->
    <div class="mb-10">
        <h1 class="text-3xl font-bold">Tus favoritos ❤️</h1>
        <p class="text-gray-400 mt-1">Guarda tus productos favoritos aquí</p>
    </div>

    <!-- VACÍO -->
    <div class="flex flex-col items-center justify-center py-20 text-center">

        <div class="text-6xl mb-4">💔</div>

        <h2 class="text-xl font-semibold mb-2">
            No tienes favoritos aún
        </h2>

        <p class="text-gray-400 mb-6">
            Explora productos y guarda los que más te gusten
        </p>

        <a href="/"
           class="bg-white text-black px-6 py-3 rounded-full font-semibold hover:bg-gray-200 transition">
            Explorar productos
        </a>

    </div>

</div>

@endsection