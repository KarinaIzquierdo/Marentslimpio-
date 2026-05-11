<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Marents')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="icon" href="{{ asset('img/logo/logo_letras_negro.png') }}">
</head>

<body class="bg-black text-white">

    {{-- 🔥 NAVBAR --}}
    @include('components.navbar')

    {{-- 🔥 FONDO GLOBAL --}}
    <div class="fixed inset-0 -z-10">

        {{-- GRADIENTE --}}
        <div class="absolute inset-0 bg-gradient-to-br from-black via-gray-900 to-black"></div>

        {{-- BURBUJAS --}}
        <div class="absolute w-[600px] h-[600px] bg-white/5 rounded-full blur-[150px] top-[-100px] left-[-100px]"></div>
        <div class="absolute w-[500px] h-[500px] bg-white/5 rounded-full blur-[120px] bottom-[-100px] right-[-100px]"></div>

    </div>

    {{-- 🔥 BANNER --}}
    @yield('banner')

    {{-- 🔥 CONTENIDO --}}
    <main class="min-h-screen px-4">
        @yield('content')
    </main>

    {{-- 🔥 FOOTER --}}
    @include('components.footer')

</body>
</html>