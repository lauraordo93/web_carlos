let indiceVideo = 0;
const miniaturas = document.querySelectorAll(".miniatura");
const videoGrande = document.getElementById("video-grande");
const tituloGrande = document.getElementById("video-titulo");
const contenidoGrande = document.getElementById("video-contenido");
const prevBtn = document.querySelector(".prev-video");
const nextBtn = document.querySelector(".next-video");

function mostrarVideo(indice) {
    const v = miniaturas[indice];
    videoGrande.src = v.dataset.url;
    tituloGrande.textContent = v.dataset.titulo;
    contenidoGrande.textContent = `${v.dataset.contenido} (Año ${v.dataset.anio})`;
    indiceVideo = indice;

    // Miniatura activa
    miniaturas.forEach(m => m.classList.remove("activo"));
    v.classList.add("activo");
}

// Miniaturas clicables
miniaturas.forEach((v, idx) => v.addEventListener("click", () => mostrarVideo(idx)));

// Flechas
prevBtn.addEventListener("click", () => {
    indiceVideo = (indiceVideo - 1 + miniaturas.length) % miniaturas.length;
    mostrarVideo(indiceVideo);
});

nextBtn.addEventListener("click", () => {
    indiceVideo = (indiceVideo + 1) % miniaturas.length;
    mostrarVideo(indiceVideo);
});
