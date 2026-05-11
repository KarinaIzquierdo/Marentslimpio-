<div id="modalStockGlobal"
class="modal hidden fixed inset-0 bg-black/70 z-[9999] flex items-center justify-center p-4">

    <div class="bg-white w-[500px] max-w-full rounded-2xl p-6 shadow-2xl">

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Gestión global de stock</h2>

            <button class="cerrarModal text-gray-400 text-xl">✕</button>
        </div>

        <form method="POST" action="/admin/stock-global">
            @csrf

            <!-- CATEGORIA -->
            <div class="mb-4">
                <label class="text-sm font-semibold">Categoría</label>

                <select id="selectCategoria"
                    class="w-full border p-2 rounded mt-1">
                    <option value="">Seleccionar...</option>

                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}">
                            {{ $cat->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- MODELO -->
            <div class="mb-4">
                <label class="text-sm font-semibold">Modelo</label>

                <select id="selectModelo"
                    class="w-full border p-2 rounded mt-1"
                    disabled>
                    <option value="">Selecciona categoría</option>
                </select>
            </div>

            <!-- COLORES -->
            <div class="mb-4">
                <label class="text-sm font-semibold">Color</label>

                <div id="coloresContainer"
                     class="flex flex-wrap gap-2 mt-2">
                </div>
            </div>

            <!-- IMAGEN PRODUCTO -->
            <div id="previewImagenContainer"
                 class="hidden mb-4">

                <label class="text-sm font-semibold">Vista previa</label>

                <div class="mt-2 flex justify-center">
                    <img id="previewImagen"
                         src=""
                         class="w-32 h-32 object-cover rounded border shadow">
                </div>

            </div>

            <!-- TALLAS -->
            <div class="mb-4">
                <label class="text-sm font-semibold">Tallas</label>

                <div id="tallasContainer"
                     class="flex flex-wrap gap-2 mt-2">
                </div>
            </div>

            <!-- INPUT OCULTO -->
            <input type="hidden" name="variacion_id" id="inputVariacion">

            <!-- CANTIDAD -->
            <div class="mb-4">
                <label class="text-sm font-semibold">Cantidad a agregar</label>

                <input type="number" name="cantidad"
                    class="w-full border p-2 rounded mt-1"
                    placeholder="Ej: 10" required>
            </div>

            <!-- BOTONES -->
            <div class="flex justify-end gap-3 mt-4">
                <button type="button"
                    class="cerrarModal bg-gray-200 px-4 py-2 rounded">
                    Cancelar
                </button>

                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded">
                    Guardar
                </button>
            </div>

        </form>

    </div>
</div>