<nav class="bg-black text-white px-6 py-4 flex justify-between items-center">

    <h1 class="text-xl font-bold">Panel Admin</h1>

    <div class="flex space-x-6 text-sm">

        <a href="/admin/dashboard" class="hover:underline">Dashboard</a>
        <a href="/admin/usuarios" class="hover:underline">Usuarios</a>
        <a href="/admin/productos" class="hover:underline">Productos</a>

    </div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="text-red-400 hover:text-red-600">Salir</button>
    </form>

</nav>