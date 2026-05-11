<footer class="bg-black text-white mt-20">

    <div class="max-w-7xl mx-auto px-6 py-12">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-10">

            {{-- MARCA --}}
            <div>
                <h2 class="text-2xl font-bold mb-4">Marents</h2>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Calzado diseñado para tu estilo.  
                    Personaliza cada paso y deja tu huella 👟
                </p>
            </div>

            {{-- CATEGORÍAS --}}
            <div>
                <h3 class="font-semibold mb-4">Categorías</h3>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li><a href="/categoria/caballero" class="hover:text-white">Caballero</a></li>
                    <li><a href="/categoria/dama" class="hover:text-white">Dama</a></li>
                    <li><a href="/categoria/ninas" class="hover:text-white">Niñas</a></li>
                    <li><a href="/categoria/ninos" class="hover:text-white">Niños</a></li>
                </ul>
            </div>

            {{-- PERSONALIZADOS --}}
            <div>
                <h3 class="font-semibold mb-4">Personalizados</h3>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li><a href="/personalizados/pisa-huevos" class="hover:text-white">Pisa huevos</a></li>
                    <li><a href="/personalizados/vans" class="hover:text-white">Vans</a></li>
                    <li><a href="/personalizados/botas" class="hover:text-white">Botas</a></li>
                </ul>
            </div>

            {{-- CONTACTO --}}
            <div>
                <h3 class="font-semibold mb-4">Contacto</h3>

                <p class="text-gray-400 text-sm mb-3">
                    ¿Quieres personalizar tus zapatos?
                </p>

                <a href="#"
                   class="inline-block bg-white text-black px-6 py-2 font-semibold hover:bg-gray-200 transition">
                    Escríbenos
                </a>

                <div class="flex gap-4 mt-4 text-lg">
                    <span class="hover:scale-110 transition cursor-pointer">📘</span>
                    <span class="hover:scale-110 transition cursor-pointer">📸</span>
                    <span class="hover:scale-110 transition cursor-pointer">💬</span>
                </div>
            </div>

        </div>

    </div>

    {{-- LINEA FINAL --}}
    <div class="border-t border-gray-800 text-center py-4 text-gray-500 text-sm">
        © {{ date('Y') }} Marents — Todos los derechos reservados
    </div>

</footer>