const miniaturasVideo = Array.from(document.querySelectorAll(".video-miniaturas .miniatura"));
const videoGrande = document.getElementById("video-grande");
const prevVideoBtn = document.querySelector(".prev-video");
const nextVideoBtn = document.querySelector(".next-video");

let indiceVideo = 0;

function mostrarVideo(indice) {
    const v = miniaturasVideo[indice];
    videoGrande.src = v.dataset.url;
    document.getElementById("video-titulo").textContent = v.dataset.titulo;
    document.getElementById("video-contenido").textContent = `${v.dataset.contenido} (Año ${v.dataset.anio})`;

    // Miniatura activa
    miniaturasVideo.forEach(m => m.classList.remove("activo"));
    v.classList.add("activo");

    indiceVideo = indice;
}

// Clic en miniaturas
miniaturasVideo.forEach((v, i) => v.addEventListener("click", () => mostrarVideo(i)));

// Flechas
prevVideoBtn.addEventListener("click", () => mostrarVideo((indiceVideo - 1 + miniaturasVideo.length) % miniaturasVideo.length));
nextVideoBtn.addEventListener("click", () => mostrarVideo((indiceVideo + 1) % miniaturasVideo.length));

// Mostrar primer video
mostrarVideo(0);
