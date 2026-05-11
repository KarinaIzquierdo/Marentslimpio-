<section class="py-20 bg-gradient-to-b from-gray-100 to-white">

    <div class="max-w-7xl mx-auto px-6">

        {{-- TITULO --}}
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold mb-4">
                Personalización
            </h2>

            <p class="text-gray-600 max-w-3xl mx-auto text-lg">
                Imagine caminar con zapatos que no sólo se ajusten perfectamente a sus pies, sino que también expresen su personalidad y autenticidad.
            </p>
        </div>

        {{-- CONTENIDO --}}
        <div class="grid md:grid-cols-2 gap-16 items-center">

            {{-- IMAGENES GRANDES --}}
            <div class="flex flex-col gap-6">

                <img src="{{ asset('img/Moldes/molde1.png') }}"
                     class="w-full h-[300px] object-contain rounded-2xl shadow-lg hover:scale-105 transition">

                <img src="{{ asset('img/Moldes/molde2.png') }}"
                     class="w-full h-[300px] object-contain rounded-2xl shadow-lg hover:scale-105 transition">

            </div>

            {{-- TEXTO --}}
            <div class="space-y-6">

                <p class="text-gray-700 text-lg leading-relaxed">
                    Con nuestro servicio de personalización, esto es posible. Le invitamos a enviarnos su diseño, para hacerlo realidad, creando un par de zapatos exclusivos para usted.
                </p>

                <p class="text-gray-600 leading-relaxed">
                    Para comenzar el proceso de personalización o si tiene alguna pregunta sobre nuestros servicios, por favor, no dude en ponerse en contacto con nosotros.
                </p>

                <p class="text-gray-600 leading-relaxed">
                    Estaremos encantados de guiarle en cada paso hacia la creación de su calzado ideal.
                </p>

                {{-- BOTON --}}
                <div>
                    <a href="#"
                       class="inline-block bg-green-500 hover:bg-green-600 text-white px-10 py-4 rounded-full font-semibold text-lg shadow-lg transition transform hover:scale-105">
                        Contáctanos
                    </a>
                </div>

            </div>

        </div>

    </div>

</section>