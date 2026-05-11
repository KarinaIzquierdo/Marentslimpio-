<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Marents</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="icon" href="{{ asset('img/logo/logo_letras_negro.png') }}">

    <style>
        /* 🔥 BRILLO MOUSE */
        .glow {
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 60%);
            pointer-events: none;
            transform: translate(-50%, -50%);
        }

        /* 🔥 PARTÍCULAS */
        .particle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            transition: transform 0.2s;
        }

        /* 🔥 ANIMACIÓN ENTRADA */
        .login-card {
            opacity: 0;
            transform: translateY(40px) scale(0.95);
            animation: fadeIn 0.8s ease forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
    </style>
</head>

<body class="relative min-h-screen flex items-center justify-center overflow-hidden bg-black">

    {{-- 🔥 GLOW --}}
    <div id="glow" class="glow"></div>

    {{-- 🔥 PARTÍCULAS --}}
    <div id="particles"></div>

    {{-- CONTENIDO --}}
    <div class="relative w-full max-w-md login-card">

        <div class="bg-white/10 backdrop-blur-2xl border border-white/20 rounded-2xl shadow-2xl p-8">

            <a href="/" class="text-sm text-gray-300 hover:text-white mb-4 inline-block">
                ← Volver al inicio
            </a>

            <div class="flex justify-center mb-6">
                <img src="{{ asset('img/logo/logo_letras_negro.png') }}" class="h-14 brightness-200">
            </div>

            <h2 class="text-2xl font-bold text-center text-white mb-2">
                Bienvenido a Marents 👟
            </h2>

            <p class="text-center text-gray-300 mb-6">
                Inicia sesión para continuar
            </p>

            @if ($errors->any())
                <div class="mb-4 p-3 rounded-lg bg-red-500/20 border border-red-400 text-red-200 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm text-gray-300 mb-1">Correo electrónico</label>
                    <input type="email" name="email"
                        value="{{ old('email') }}"
                        class="w-full bg-white/10 border border-white/20 text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-white/40">
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-gray-300 mb-1">Contraseña</label>
                    <input type="password" name="password"
                        class="w-full bg-white/10 border border-white/20 text-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-white/40">
                </div>

                <button type="submit"
    onclick="console.log('CLICK FUNCIONA')"
    class="w-full bg-white text-black py-2 rounded-lg font-semibold hover:bg-gray-200 transition">
                    Iniciar sesión
                </button>

                <p class="text-center text-sm text-gray-300 mt-6">
                    ¿No tienes cuenta?
                    <a href="{{ route('register') }}" class="text-white font-semibold hover:underline">
                        Regístrate
                    </a>
                </p>

            </form>

        </div>

    </div>

    {{-- 🔥 JS INTERACTIVO --}}
    <script>
        const glow = document.getElementById('glow');

        document.addEventListener('mousemove', e => {
            glow.style.left = e.clientX + 'px';
            glow.style.top = e.clientY + 'px';
        });

        const container = document.getElementById('particles');

        for (let i = 0; i < 40; i++) {
            let p = document.createElement('div');
            p.classList.add('particle');

            let size = Math.random() * 6 + 4;
            p.style.width = size + 'px';
            p.style.height = size + 'px';
            p.style.left = Math.random() * 100 + '%';
            p.style.top = Math.random() * 100 + '%';

            container.appendChild(p);
        }

        document.addEventListener('mousemove', e => {
            document.querySelectorAll('.particle').forEach(p => {
                let x = e.clientX / window.innerWidth;
                let y = e.clientY / window.innerHeight;

                p.style.transform = `translate(${x * 20}px, ${y * 20}px)`;
            });
        });
    </script>

</body>
</html>