let indiceVideo = 0;
const videos = document.querySelectorAll(".slider-videos .video");
const totalVideos = videos.length;

function mostrarVideo(indice) {
    videos.forEach(v => v.classList.remove("activo"));
    videos[indice].classList.add("activo");
}

// Botones
document.querySelector(".next-video").addEventListener("click", () => {
    indiceVideo = (indiceVideo + 1) % totalVideos;
    mostrarVideo(indiceVideo);
});

document.querySelector(".prev-video").addEventListener("click", () => {
    indiceVideo = (indiceVideo - 1 + totalVideos) % totalVideos;
    mostrarVideo(indiceVideo);
});