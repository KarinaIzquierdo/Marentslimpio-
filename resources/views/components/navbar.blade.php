<nav class="bg-black/90 backdrop-blur-xl border-b border-white/10 sticky top-0 z-50">

    <div class="max-w-7xl mx-auto px-4 md:px-8 py-3 flex items-center justify-between">

        <!-- 🔥 IZQUIERDA (LOGO + MENU MOBILE) -->
        <div class="flex items-center gap-4">

            <!-- MENU MOBILE -->
            <button onclick="toggleMenu()" class="md:hidden text-white">
                ☰
            </button>

            <!-- LOGO -->
            <a href="/" class="flex items-center">
                <img src="{{ asset('img/logo/logo_letras_blanco.png') }}"
                     class="h-8 md:h-10 object-contain hover:scale-105 transition">
            </a>

        </div>

        <!-- 🔥 LINKS DESKTOP -->
        <div class="hidden md:flex items-center gap-8 lg:gap-12 text-sm lg:text-base font-semibold">

            <a href="/" class="nav-link-strong">Home</a>

            <a href="/categoria/caballero" class="nav-link-strong">Caballero</a>
            <a href="/categoria/dama" class="nav-link-strong">Dama</a>
            <a href="/categoria/ninos" class="nav-link-strong">Niños</a>

            <a href="/categoria/pisa-huevos" class="nav-link-strong">Pisa huevos</a>
            <a href="/categoria/vans" class="nav-link-strong">Vans</a>
            <a href="/categoria/botas" class="nav-link-strong">Botas</a>

        </div>

        <!-- 🔥 DERECHA -->
        <div class="flex items-center gap-4 md:gap-6">

            <!-- ❤️ FAVORITOS -->
            <a href="/favoritos"
               class="relative text-white hover:scale-110 transition">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-5 h-5 md:w-6 md:h-6"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 20.364 4.318 12.682a4.5 4.5 0 010-6.364z"/>
                </svg>

                <span class="absolute -top-2 -right-2 bg-red-500 text-xs px-1.5 rounded-full">
                    0
                </span>

            </a>

            <!-- 🛒 CARRITO -->
            @php
                $total = 0;
                if(session('carrito')){
                    foreach(session('carrito') as $item){
                        $total += $item['cantidad'];
                    }
                }
            @endphp

            <a href="{{ route('carrito') }}"
               class="relative text-white hover:scale-110 transition">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-5 h-5 md:w-6 md:h-6"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6h13M10 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z"/>
                </svg>

                @if($total > 0)
                    <span class="absolute -top-2 -right-2 bg-white text-black text-xs px-1.5 rounded-full">
                        {{ $total }}
                    </span>
                @endif

            </a>

            <!-- 👤 USUARIO -->
            @auth
                <div class="hidden md:flex items-center gap-3 bg-white/10 px-4 py-2 rounded-full border border-white/20 hover:bg-white/20 transition">

                    <div class="w-8 h-8 bg-white text-black flex items-center justify-center rounded-full font-bold">
                        {{ strtoupper(substr(auth()->user()->nombres,0,1)) }}
                    </div>

                    <span class="text-white text-sm font-medium">
                        {{ auth()->user()->nombres }}
                    </span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-xs text-red-400 hover:text-red-600 ml-2">
                            Salir
                        </button>
                    </form>

                </div>
            @endauth

            @guest
                <a href="{{ route('login') }}" class="hidden md:block text-gray-300 hover:text-white transition text-sm">
                    Iniciar sesión
                </a>

                <a href="{{ route('register') }}"
                   class="hidden md:block px-4 py-2 rounded-full font-semibold text-black bg-white hover:bg-gray-200 transition text-sm">
                    Registrarse
                </a>
            @endguest

        </div>

    </div>

    <!-- 🔥 MENU MOBILE -->
    <div id="menuMobile"
         class="hidden md:hidden bg-black border-t border-white/10 px-6 py-4 space-y-4 text-white">

        <a href="/" class="block">Home</a>
        <a href="/categoria/caballero" class="block">Caballero</a>
        <a href="/categoria/dama" class="block">Dama</a>
        <a href="/categoria/ninos" class="block">Niños</a>
        <a href="/categoria/pisa-huevos" class="block">Pisa huevos</a>
        <a href="/categoria/vans" class="block">Vans</a>
        <a href="/categoria/botas" class="block">Botas</a>

        @guest
            <a href="{{ route('login') }}" class="block">Iniciar sesión</a>
            <a href="{{ route('register') }}" class="block">Registrarse</a>
        @endguest

    </div>

</nav>

<script>
function toggleMenu() {
    document.getElementById('menuMobile').classList.toggle('hidden');
}
</script>