document.addEventListener('DOMContentLoaded', () => {
    const miniaturasVideo = Array.from(document.querySelectorAll(".video-miniaturas .miniatura"));
    const videoGrande = document.getElementById("video-grande");
    const prevVideoBtn = document.querySelector(".prev-video");
    const nextVideoBtn = document.querySelector(".next-video");

    let cookiesAceptadas = localStorage.getItem("cookiesAceptadas") === "true";
    let indiceVideo = 0;

    function mostrarVideo(indice) {
        if (miniaturasVideo.length === 0) return;
        
        const v = miniaturasVideo[indice];

        if (cookiesAceptadas) {
            videoGrande.src = v.dataset.url; // Carga segura
        } else {
            videoGrande.src = ""; 
            // Mostramos el aviso solo si el usuario intenta activarlo manualmente
            if(indice !== 0 || !cookiesAceptadas) {
                alert("Debes aceptar las cookies para ver los vídeos de YouTube.");
            }
        }

        document.getElementById("video-titulo").textContent = v.dataset.titulo;
        document.getElementById("video-contenido").textContent = `${v.dataset.contenido} (Año ${v.dataset.anio})`;

        miniaturasVideo.forEach(m => m.classList.remove("activo"));
        v.classList.add("activo");
        indiceVideo = indice;
    }

    // Eventos
    miniaturasVideo.forEach((v, i) => v.addEventListener("click", () => mostrarVideo(i)));
    
    if(prevVideoBtn) prevVideoBtn.addEventListener("click", () => {
        indiceVideo = (indiceVideo - 1 + miniaturasVideo.length) % miniaturasVideo.length;
        mostrarVideo(indiceVideo);
    });

    if(nextVideoBtn) nextVideoBtn.addEventListener("click", () => {
        indiceVideo = (indiceVideo + 1) % miniaturasVideo.length;
        mostrarVideo(indiceVideo);
    });

    // Escuchar el botón de aceptar cookies del banner
    const aceptarBtn = document.getElementById("btn-aceptar-cookies"); // ID de tu modal de cookies
    if (aceptarBtn) {
        aceptarBtn.addEventListener("click", () => {
            cookiesAceptadas = true;
            mostrarVideo(indiceVideo);
        });
    }

    if (cookiesAceptadas) mostrarVideo(0);
});