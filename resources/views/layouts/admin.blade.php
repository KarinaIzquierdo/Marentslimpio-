<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin - Marents</title>

    {{-- 🔥 VITE --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- 🔥 DATATABLES CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">

</head>

<body class="bg-gray-100">

<div class="flex min-h-screen">

    {{-- 🔥 SIDEBAR --}}
    <aside class="w-64 bg-[#1f1f1f] text-white flex flex-col">

        <div class="p-6 text-xl font-bold border-b border-white/10">
            Marents
        </div>

        <nav class="flex-1 p-4 space-y-2 text-sm">

            <a href="/" class="sidebar-item hover:text-white/80 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Inicio
            </a>

            <div class="border-t border-white/10 my-2"></div>

            <a href="/admin/dashboard" class="sidebar-item hover:text-white/80">
                Dashboard
            </a>

            <a href="/admin/usuarios" class="sidebar-item hover:text-white/80">
                Usuarios
            </a>

            <a href="/admin/productos" class="sidebar-item hover:text-white/80">
                Productos
            </a>

            <div class="border-t border-white/10 my-2"></div>

            <a href="/login" class="sidebar-item hover:text-white/80 flex items-center gap-2 text-xs">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Volver al inicio
            </a>

        </nav>

    </aside>

    {{-- 🔥 MAIN --}}
    <div class="flex-1 flex flex-col">

        {{-- 🔥 TOPBAR --}}
        <header class="bg-white shadow px-6 py-3 flex justify-between items-center">

            <div class="font-semibold text-gray-700">
                Panel administrativo
            </div>

            <div class="flex items-center gap-4">

                <a href="/login" class="text-blue-500 text-xs hover:underline flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Volver al inicio</span>
                </a>

                <span class="text-sm text-gray-600">
                    {{ auth()->user()->nombres }}
                </span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-red-500 text-sm hover:underline">
                        Salir
                    </button>
                </form>

            </div>

        </header>

        {{-- 🔥 CONTENIDO --}}
        <main class="p-6">
            @yield('content')
        </main>

    </div>

</div>

{{-- 🔥 STACK GLOBAL DE MODALES (CLAVE 💣) --}}
@stack('modals')

</body>
</html>