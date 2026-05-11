<nav class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between h-16">

            {{-- LOGO --}}
            <div class="flex items-center">
                <a href="/">
                    <span class="text-xl font-bold">Marents</span>
                </a>
            </div>

            {{-- LINKS --}}
            <div class="hidden sm:flex sm:items-center sm:space-x-8">

                <a href="/" class="text-gray-700 hover:text-black font-medium">
                    Inicio
                </a>

                <a href="/categoria/caballero" class="text-gray-700 hover:text-black">
                    Caballero
                </a>

                <a href="/categoria/dama" class="text-gray-700 hover:text-black">
                    Dama
                </a>

                <a href="/categoria/ninos" class="text-gray-700 hover:text-black">
                    Niños
                </a>

                <a href="/personalizados/pisa-huevos" class="text-gray-700 hover:text-black">
                    Personalizados
                </a>

            </div>

            {{-- USUARIO --}}
            <div class="flex items-center space-x-4">

                @auth
                    <span class="text-sm text-gray-700">
                        👤 {{ auth()->user()->nombres }}
                    </span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-red-500 hover:underline text-sm">
                            Salir
                        </button>
                    </form>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="text-gray-700 hover:underline text-sm">
                        Login
                    </a>

                    <a href="{{ route('register') }}" class="bg-black text-white px-3 py-1 rounded text-sm">
                        Registro
                    </a>
                @endguest

            </div>

        </div>
    </div>
</nav>