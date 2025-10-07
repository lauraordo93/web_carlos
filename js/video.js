const miniaturasVideo = Array.from(document.querySelectorAll(".video-miniaturas .miniatura"));
const videoGrande = document.getElementById("video-grande");
const prevVideoBtn = document.querySelector(".prev-video");
const nextVideoBtn = document.querySelector(".next-video");

// Comprobar si el usuario aceptó cookies
let cookiesAceptadas = localStorage.getItem("cookiesAceptadas") === "true";

let indiceVideo = 0;

function mostrarVideo(indice) {
    const v = miniaturasVideo[indice];

    if (cookiesAceptadas) {
        videoGrande.src = v.dataset.url; // Solo carga el vídeo si hay consentimiento
    } else {
        videoGrande.src = ""; // No cargar nada si no acepta cookies
        alert("Debes aceptar las cookies para ver los vídeos.");
    }

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

// Botón de aceptar cookies (de tu banner)
const aceptarBtn = document.querySelector(".banner-cookies button.aceptar");
if (aceptarBtn) {
    aceptarBtn.addEventListener("click", () => {
        cookiesAceptadas = true;
        localStorage.setItem("cookiesAceptadas", "true");
        // Cargar automáticamente el primer vídeo cuando acepten cookies
        mostrarVideo(indiceVideo);
    });
}

// Inicial: mostrar primer vídeo solo si ya aceptó cookies
if (cookiesAceptadas) {
    mostrarVideo(0);
} else {
    videoGrande.src = ""; // No cargar nada
}

