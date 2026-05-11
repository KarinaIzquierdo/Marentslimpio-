import $ from 'jquery';
window.$ = window.jQuery = $;

import 'datatables.net';

console.log('PRODUCTOS JS PRO');

// =========================
// VARIABLES GLOBALES
// =========================
let variacionesGlobal = [];
let imagenProducto = null;
let colorSeleccionado = null;

// =========================
// INIT
// =========================
document.addEventListener('DOMContentLoaded', function () {

    const tablaElement = document.getElementById('tabla-productos');
    if (!tablaElement) return; // 🔥 solo admin

    let tabla;

    // =========================
    // 🔥 FIX DEFINITIVO DATATABLE
    // =========================
    if ($.fn.DataTable.isDataTable('#tabla-productos')) {
        $('#tabla-productos').DataTable().destroy();
    }

    tabla = $('#tabla-productos').DataTable({
        responsive: false, // 🔥 elimina bug
        autoWidth: false,
        pageLength: 10,
        scrollX: true,
        ordering: true,

        dom: '<"top-bar"l>rt<"bottom-bar"ip>',
        pagingType: "simple_numbers",

        language: {
            info: "Mostrando _START_ a _END_ de _TOTAL_ productos",
            lengthMenu: "Mostrar _MENU_",
            paginate: {
                next: "›",
                previous: "‹"
            }
        }
    });

    // =========================
    // BUSCADOR
    // =========================
    let timeoutBusqueda;

    $('#buscar').on('keyup', function () {
        clearTimeout(timeoutBusqueda);

        let input = this;

        timeoutBusqueda = setTimeout(() => {
            tabla.search(input.value).draw();
        }, 250);
    });

    // =========================
    // FILTRO CATEGORIA
    // =========================
    $('#filtroCategoria').on('change', function () {
        tabla.column(0).search(this.value).draw();
    });

    // =========================
    // ORDEN STOCK
    // =========================
    $('#ordenStock').on('change', function () {
        let val = this.value;
        tabla.order([4, val === 'mayor' ? 'desc' : 'asc']).draw();
    });

    // =========================
    // CLICK FILA
    // =========================
    $('#tabla-productos tbody').on('click', 'tr', function () {
        $(this).toggleClass('bg-blue-50');
    });

    // =========================
    // MODAL STOCK PRODUCTO
    // =========================
    $('#tabla-productos').on('click', '.btn-stock', function (e) {
        e.stopPropagation();

        let modeloId = $(this).data('modelo');

        $('#modalStockProducto').removeClass('hidden').addClass('flex');
        $('#tallasProductoContainer').html('Cargando...');
        $('#infoProducto').html('');

        fetch(`/admin/producto-info/${modeloId}`)
            .then(res => res.json())
            .then(data => {

                if (!data) return;

                let nombre = data.modelo?.nombre ?? '';
                let categoria = data.modelo?.categoria?.nombre ?? '';

                $('#infoProducto').html(`
                    <p class="font-semibold text-lg">${nombre}</p>
                    <p class="text-sm text-gray-500">${categoria}</p>
                `);

                let html = '';

                data.variaciones.forEach(v => {
                    let talla = v.talla?.numero ?? '-';
                    let stock = v.stock ?? 0;
                    let color = v.color_primario?.nombre ?? 'Sin color';

                    html += `
                        <div class="variacion-item cursor-pointer border rounded-lg px-3 py-2 flex justify-between hover:bg-gray-100"
                             data-id="${v.id}">
                            <span>${color} - Talla ${talla}</span>
                            <span class="text-xs text-gray-500">Stock: ${stock}</span>
                        </div>
                    `;
                });

                $('#tallasProductoContainer').html(html);
            });
    });

    // =========================
    // VER IMAGEN
    // =========================
    $('#tabla-productos').on('click', '.ver-imagen', function (e) {
        e.stopPropagation();

        let src = $(this).data('img');

        $('#imagenGrande').attr('src', src);
        $('#modalImagen').removeClass('hidden').addClass('flex');
    });

    // =========================
    // BOTONES
    // =========================
    $('#btnNuevoProducto').on('click', function () {
        $('#modalProducto').removeClass('hidden').addClass('flex');
    });

    $('#btnStockGlobal').on('click', function () {
        $('#modalStockGlobal').removeClass('hidden').addClass('flex');
    });

    // =========================
    // CATEGORIA → MODELOS
    // =========================
    $('#selectCategoria').on('change', function () {

        let categoriaId = $(this).val();

        $('#selectModelo')
            .prop('disabled', true)
            .html('<option>Cargando...</option>');

        $('#coloresContainer').html('');
        $('#tallasContainer').html('');
        $('#previewImagenContainer').addClass('hidden');

        fetch(`/admin/modelos/${categoriaId}`)
            .then(res => res.json())
            .then(data => {

                let options = '<option value="">Seleccionar modelo</option>';

                data.forEach(m => {
                    options += `<option value="${m.id}">${m.nombre}</option>`;
                });

                $('#selectModelo')
                    .html(options)
                    .prop('disabled', false);
            });
    });

    // =========================
    // MODELO → VARIACIONES
    // =========================
    $('#selectModelo').on('change', function () {

        let modeloId = $(this).val();

        $('#coloresContainer').html('Cargando...');
        $('#tallasContainer').html('');
        $('#previewImagenContainer').addClass('hidden');

        fetch(`/admin/producto-info/${modeloId}`)
            .then(res => res.json())
            .then(data => {

                if (!data) return;

                variacionesGlobal = data.variaciones || [];

                imagenProducto = data.imagen
                    ? '/' + data.imagen.url.replace(/^\/+/, '')
                    : null;

                if (variacionesGlobal.length === 0) {
                    $('#coloresContainer').html(
                        '<p class="text-gray-400 text-sm">Sin variaciones registradas</p>'
                    );
                    return;
                }

                let coloresUnicos = {};

                variacionesGlobal.forEach(v => {
                    if (v.color_primario) {
                        coloresUnicos[v.color_primario.id] = v.color_primario;
                    }
                });

                let html = '';

                Object.values(coloresUnicos).forEach(c => {
                    html += `
                        <div class="color-item cursor-pointer border px-3 py-1 rounded transition hover:bg-gray-100"
                             data-id="${c.id}">
                            ${c.nombre}
                        </div>
                    `;
                });

                $('#coloresContainer').html(html);
            });
    });

});

// =========================
// COLOR
// =========================
$(document).on('click', '.color-item', function () {

    $('.color-item')
        .removeClass('bg-black text-white')
        .addClass('bg-white');

    $(this).addClass('bg-black text-white');

    colorSeleccionado = $(this).data('id');

    let filtradas = variacionesGlobal.filter(v => v.color_id == colorSeleccionado);

    let html = '';

    filtradas.forEach(v => {
        let talla = v.talla?.numero ?? '-';
        let stock = v.stock ?? 0;

        html += `
            <div class="talla-item cursor-pointer border px-3 py-1 rounded text-sm transition hover:bg-gray-100"
                 data-id="${v.id}">
                Talla ${talla} (Stock: ${stock})
            </div>
        `;
    });

    $('#tallasContainer').html(html);

    if (imagenProducto) {
        $('#previewImagen').attr('src', imagenProducto);
        $('#previewImagenContainer').removeClass('hidden');
    }
});

// =========================
// TALLA
// =========================
$(document).on('click', '.talla-item', function () {

    $('.talla-item').removeClass('bg-black text-white');

    $(this).addClass('bg-black text-white');

    $('#inputVariacion').val($(this).data('id'));
});

// =========================
// MODALES
// =========================
$(document).on('click', '.cerrarModal', function () {
    $(this).closest('.modal')
        .addClass('hidden')
        .removeClass('flex');
});

$(document).on('click', '.modal', function (e) {
    if (e.target === this) {
        $(this)
            .addClass('hidden')
            .removeClass('flex');
    }
});

// =========================
// SELECCION VARIACION
// =========================
$(document).on('click', '.variacion-item', function () {

    $('.variacion-item').removeClass('bg-black text-white');

    $(this).addClass('bg-black text-white');

    $('#inputVariacionProducto').val($(this).data('id'));
});