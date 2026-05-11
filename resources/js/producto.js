// =========================
// TOAST
// =========================
function showToast(message, isError = false) {
    const toast = document.getElementById('toast');
    const content = document.getElementById('toastContent');

    if (!toast || !content) return;

    content.innerText = message;

    content.classList.remove('bg-green-500', 'bg-red-500', 'bg-black');
    content.classList.add(isError ? 'bg-red-500' : 'bg-black');

    toast.classList.remove('hidden');

    setTimeout(() => {
        toast.classList.add('hidden');
    }, 2000);
}

// =========================
// MODAL GUIA
// =========================
window.toggleGuia = function () {
    const modal = document.getElementById('guiaTallas');
    if (modal) modal.classList.toggle('hidden');
};

// =========================
// INIT
// =========================
document.addEventListener('DOMContentLoaded', function () {

    const form = document.querySelector('#formProducto');
    if (!form) return; // 🔥 SOLO PRODUCTO

    let stockActual = 0;

    const tallaInput = document.getElementById('tallaSeleccionada');
    const cantidadInput = document.getElementById('cantidad');

    // =========================
    // TALLAS
    // =========================
    document.querySelectorAll('.talla-btn').forEach(btn => {

        btn.addEventListener('click', function () {

            if (this.disabled) return;

            document.querySelectorAll('.talla-btn').forEach(b => {
                b.classList.remove('bg-white', 'text-black');
            });

            this.classList.add('bg-white', 'text-black');

            if (tallaInput) {
                tallaInput.value = this.dataset.talla;
            }

            stockActual = parseInt(this.dataset.stock || 0);

            showToast(`Stock disponible: ${stockActual}`);
        });

    });

    // =========================
    // VALIDACION
    // =========================
    form.addEventListener('submit', function (e) {

        const talla = tallaInput?.value;
        const cantidad = parseInt(cantidadInput?.value || 0);

        if (!talla) {
            e.preventDefault();
            showToast('Selecciona una talla', true);
            return;
        }

        if (cantidad <= 0) {
            e.preventDefault();
            showToast('Cantidad inválida', true);
            return;
        }

        if (stockActual > 0 && cantidad > stockActual) {
            e.preventDefault();
            showToast('Stock insuficiente', true);
        }

    });

});