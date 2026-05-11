@extends('layouts.app')

@section('title', 'Marents')

@section('banner')
    @include('components.banner', [
        'imagen' => asset('banners/Banner_home.jpg'),
        'titulo' => ''
    ])
@endsection

@section('content')

<style>
body {
    background:rgb(23, 23, 23);
}
.fade-in {
    opacity: 0;
    transform: translateY(40px);
    transition: all 0.8s ease;
}
.fade-in.show {
    opacity: 1;
    transform: translateY(0);
}

</style>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const elements = document.querySelectorAll(".fade-in");

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("show");
            }
        });
    });

    elements.forEach(el => observer.observe(el));
});
</script>

<div class="max-w-7xl mx-auto py-10 px-4 space-y-20 text-black">

    <!-- HERO -->
    <section class="text-center fade-in">

        <h1 class="text-4xl md:text-5xl font-extrabold mb-4">
            Estilo que marca diferencia 👟
        </h1>

        <p class="text-gray-600 mb-6 max-w-xl mx-auto">
            Descubre diseños únicos, personalizados y exclusivos en Marents
        </p>

        <a href="/categoria/caballero"
           class="bg-black text-white px-6 py-3 rounded-full font-semibold hover:bg-gray-800 transition">
            Ver productos
        </a>

    </section>

    <!-- CATEGORÍAS -->
    <section class="fade-in">

        <h2 class="text-2xl font-bold mb-6">Categorías</h2>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">

            @foreach ([
                ['nombre'=>'Caballero','url'=>'/categoria/caballero'],
                ['nombre'=>'Dama','url'=>'/categoria/dama'],
                ['nombre'=>'Niños','url'=>'/categoria/ninos'],
                ['nombre'=>'Personalizados','url'=>'/personalizados/vans']
            ] as $cat)

                <a href="{{ $cat['url'] }}"
                   class="bg-white border border-gray-200 rounded-2xl p-6 text-center 
                          hover:shadow-lg hover:-translate-y-1 transition duration-300">

                    <h3 class="text-lg font-semibold">
                        {{ $cat['nombre'] }}
                    </h3>

                </a>

            @endforeach

        </div>

    </section>

    <!-- PRODUCTOS -->
    <section class="fade-in">

        <h2 class="text-2xl font-bold mb-6">Destacados</h2>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">

            @foreach ([
                ['nombre'=>'Bolichero','img'=>'img/productos/caballero/bolichero_negro.png'],
                ['nombre'=>'Cool','img'=>'img/productos/caballero/cool.png'],
                ['nombre'=>'Tractor','img'=>'img/productos/caballero/tractor_blanco_a.png'],
                ['nombre'=>'Bigotes','img'=>'img/productos/caballero/bigotes_negro.png'],
            ] as $p)

                <div class="bg-white border border-gray-200 rounded-2xl p-4 
                            hover:shadow-xl hover:-translate-y-1 transition duration-300">

                    <!-- IMAGEN -->
                    <div class="bg-gray-100 rounded-xl p-4 mb-4 flex items-center justify-center">
                        <img src="{{ asset($p['img']) }}"
                             class="h-40 object-contain drop-shadow-xl">
                    </div>

                    <!-- INFO -->
                    <h3 class="font-semibold text-black">
                        {{ $p['nombre'] }}
                    </h3>

                    <p class="text-sm text-gray-500">
                        $79.999
                    </p>

                </div>

            @endforeach

        </div>

    </section>

    <!-- BENEFICIOS -->
    <section class="grid md:grid-cols-3 gap-6 text-center fade-in">

        <div class="bg-white border border-gray-200 rounded-2xl p-6 hover:shadow-lg transition">
            🚚
            <p class="mt-2 font-semibold">Envíos a todo el país</p>
            <p class="text-gray-500 text-sm">Rápido y seguro</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-6 hover:shadow-lg transition">
            🎨
            <p class="mt-2 font-semibold">Diseños personalizados</p>
            <p class="text-gray-500 text-sm">Únicos como tú</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-6 hover:shadow-lg transition">
            🔒
            <p class="mt-2 font-semibold">Pago seguro</p>
            <p class="text-gray-500 text-sm">Protección garantizada</p>
        </div>

    </section>

    <!-- CTA -->
    <section class="text-center fade-in">

        <h2 class="text-3xl font-bold mb-4">
            Crea tu propio estilo
        </h2>

        <p class="text-gray-600 mb-6">
            Diseña tus zapatos únicos y destaca donde vayas
        </p>

        <a href="/personalizados/vans"
           class="bg-black text-white px-8 py-3 rounded-full font-semibold hover:bg-gray-800 transition">
            Personalizar ahora
        </a>

    </section>

</div>

@endsection