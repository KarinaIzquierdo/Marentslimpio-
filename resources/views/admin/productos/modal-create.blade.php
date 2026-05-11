<div id="modalProducto"
     class="modal fixed inset-0 bg-black/70 backdrop-blur hidden items-center justify-center z-50">

    <div class="bg-white w-full max-w-3xl rounded-2xl p-6 shadow-2xl">

        {{-- HEADER --}}
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Crear producto</h2>

            <button type="button"
                class="cerrarModal text-gray-400 hover:text-black text-xl">
                ✕
            </button>
        </div>

        <form method="POST" action="/admin/productos" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-2 gap-4">

                {{-- MODELO --}}
                <input type="text" name="modelo_nombre"
                    placeholder="Nombre del modelo"
                    class="border rounded-lg px-3 py-2 col-span-2">

                {{-- CATEGORIA --}}
                <select name="categoria_id" class="border p-2 rounded">
                    <option value="">Categoría</option>

                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}">
                            {{ $cat->nombre }}
                        </option>
                    @endforeach
                </select>

                {{-- COLOR --}}
                <input type="text" name="color_nombre"
                    placeholder="Color"
                    class="border rounded-lg px-3 py-2">

                {{-- TALLA --}}
                <input type="number" name="talla_numero"
                    placeholder="Talla"
                    class="border rounded-lg px-3 py-2">

                {{-- STOCK --}}
                <input type="number" name="stock"
                    placeholder="Stock"
                    class="border rounded-lg px-3 py-2">

                {{-- PRECIO --}}
                <input type="number" name="precio"
                    placeholder="Precio"
                    class="border rounded-lg px-3 py-2">

                {{-- COSTO --}}
                <input type="number" name="costo"
                    placeholder="Costo"
                    class="border rounded-lg px-3 py-2">

                {{-- DESCUENTO --}}
                <div class="flex items-center gap-3 col-span-2">
                    <label class="text-sm">¿Tiene descuento?</label>

                    <input type="checkbox" id="toggleDescuento"
                        class="w-4 h-4">
                </div>

                {{-- INPUT DESCUENTO --}}
                <input type="number" name="valor_descuento"
                    id="inputDescuento"
                    placeholder="Valor descuento"
                    class="border rounded-lg px-3 py-2 col-span-2 hidden">

                {{-- IMAGEN --}}
                <input type="file" name="imagen"
                    class="border rounded-lg px-3 py-2 col-span-2">

            </div>

            {{-- BOTONES --}}
            <div class="flex justify-end gap-3 mt-6">

                <button type="button"
                    class="cerrarModal px-4 py-2 bg-gray-200 rounded-lg">
                    Cancelar
                </button>

                <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Guardar producto
                </button>

            </div>

        </form>

    </div>
</div>