<a href="{{ url('/producto/' . $id) }}" class="block group">

<div class="bg-white rounded-3xl overflow-hidden 
            transition-all duration-300 
            hover:shadow-xl hover:-translate-y-1 border border-gray-200">

    {{-- IMAGEN --}}
    <div class="relative bg-[#f6f6f6] aspect-square flex items-center justify-center overflow-hidden">

        @php
            $categoriaPath = strtolower($categoria ?? 'caballero');
            // Normalizar nombres de categorías para las rutas de archivos
            $categoriaPath = str_replace(['ñ', ' '], ['n', '_'], $categoriaPath);
        @endphp

        <img 
            src="{{ asset(
                $imagen 
                ? 'img/productos/' . $categoriaPath . '/' . $imagen 
                : 'img/default.png'
            ) }}"
            class="h-[75%] object-contain 
                   transition duration-500 
                   group-hover:scale-110"
            onerror="this.onerror=null; this.src='{{ asset('img/default.png') }}';">

        {{-- GRADIENT OVERLAY --}}
        <div class="absolute inset-0 bg-gradient-to-t from-black/5 to-transparent opacity-0 group-hover:opacity-100 transition"></div>

        {{-- FAVORITO --}}
        <button type="button"
            onclick="event.preventDefault(); event.stopPropagation();"
            class="absolute top-3 right-3 bg-white/90 backdrop-blur-md 
                   rounded-full p-2 shadow-sm 
                   hover:scale-110 hover:bg-white transition">

            <span class="text-gray-700 text-sm">❤️</span>
        </button>

    </div>

    {{-- INFO --}}
    <div class="p-4 space-y-2">

        {{-- PRECIO --}}
        <p class="text-lg font-bold text-black">
            ${{ number_format($precio ?? 0, 0, ',', '.') }}
        </p>

        {{-- NOMBRE --}}
        <p class="text-sm font-semibold text-gray-900 leading-tight line-clamp-2">
            {{ $nombre }}
        </p>

        {{-- SUB --}}
        <p class="text-[11px] text-gray-400 uppercase tracking-widest">
            Performance
        </p>

        {{-- TALLAS --}}
        <div class="flex flex-wrap gap-1 mt-2">

            @foreach(explode(',', $tallas ?? '') as $t)
                @if(trim($t) !== '')
                    <span class="text-[10px] border border-gray-300 px-2 py-0.5 rounded-md 
                                 text-gray-600 bg-gray-50">
                        {{ trim($t) }}
                    </span>
                @endif
            @endforeach

        </div>

    </div>

</div>

</a>