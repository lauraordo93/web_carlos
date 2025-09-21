// ---- Cambio de pestañas ----
const tabBtns = document.querySelectorAll(".tab-btn");
const galerias = document.querySelectorAll(".galeria");

tabBtns.forEach(btn => {
    btn.addEventListener("click", () => {
        // Quitar active a todos los botones y galerías
        tabBtns.forEach(b => b.classList.remove("active"));
        galerias.forEach(g => g.classList.remove("active"));

        // Activar la pestaña y galería seleccionada
        btn.classList.add("active");
        const tab = btn.dataset.tab;
        document.getElementById(tab).classList.add("active");
    });
});

// ---- Función para miniaturas de imágenes ----
function mostrarImagen(elem) {
    const visor = elem.closest(".galeria").querySelector("#imagen-grande");
    if (visor) {
        visor.src = elem.src;
    }
}

// ---- Función para miniaturas de vídeos ----
function mostrarVideo(url) {
    const visor = document.getElementById("video-grande");
    if (visor) {
        visor.src = url;
    }
}
