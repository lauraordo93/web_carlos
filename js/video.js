document.addEventListener('DOMContentLoaded', () => {
    const miniaturasVideo = Array.from(document.querySelectorAll(".video-miniaturas .miniatura"));
    const videoGrande = document.getElementById("video-grande");
    const prevVideoBtn = document.querySelector(".prev-video");
    const nextVideoBtn = document.querySelector(".next-video");
    const cookieAviso = document.getElementById("video-cookie-aviso");

    let cookiesAceptadas = localStorage.getItem("cookiesAceptadas") === "true";
    let indiceVideo = 0;
    let interaccionUsuario = false;

    // 1. Inyectar URLs de miniaturas SOLO si hay consentimiento
    function cargarMiniaturas() {
        if (cookiesAceptadas) {
            miniaturasVideo.forEach(m => {
                if (m.dataset.src) {
                    m.src = m.dataset.src;
                }
            });
        }
    }

    function seleccionarVideo(indice, interactuado = true) {
        if (miniaturasVideo.length === 0) return;
        
        if (interactuado) interaccionUsuario = true;
        const v = miniaturasVideo[indice];

        // Actualizar textos
        document.getElementById("video-titulo").textContent = v.dataset.titulo;
        document.getElementById("video-contenido").textContent = `${v.dataset.contenido} (Año ${v.dataset.anio})`;

        // Marcar miniatura activa
        miniaturasVideo.forEach(m => m.classList.remove("activo"));
        v.classList.add("activo");
        indiceVideo = indice;

        // Gestión del Iframe y Aviso
        if (interaccionUsuario) {
            if (cookiesAceptadas) {
                videoGrande.style.display = "block";
                cookieAviso.style.display = "none";
                videoGrande.src = v.dataset.url;
                videoGrande.title = 'Carlos Ordóñez de Arce - ' + v.dataset.titulo;
            } else {
                videoGrande.style.display = "none";
                cookieAviso.style.display = "flex";
                videoGrande.src = "";
            }
        }
    }

    // Inicializar sin reproducir nada
    cargarMiniaturas();
    if (miniaturasVideo.length > 0) {
        seleccionarVideo(0, false); // false = inicialización, no interacción
    }

    // Eventos
    miniaturasVideo.forEach((v, i) => {
        v.addEventListener("click", () => seleccionarVideo(i, true));
        v.addEventListener("keydown", (e) => {
            if (e.key === "Enter" || e.key === " ") {
                e.preventDefault();
                seleccionarVideo(i, true);
            }
        });
    });
    
    if (prevVideoBtn) prevVideoBtn.addEventListener("click", () => {
        indiceVideo = (indiceVideo - 1 + miniaturasVideo.length) % miniaturasVideo.length;
        seleccionarVideo(indiceVideo, true);
    });

    if (nextVideoBtn) nextVideoBtn.addEventListener("click", () => {
        indiceVideo = (indiceVideo + 1) % miniaturasVideo.length;
        seleccionarVideo(indiceVideo, true);
    });

    // Escuchar el botón de aceptar cookies del banner
    const aceptarBtn = document.getElementById("btn-aceptar-cookies");
    if (aceptarBtn) {
        aceptarBtn.addEventListener("click", () => {
            cookiesAceptadas = true;
            cargarMiniaturas();
            if (interaccionUsuario) {
                seleccionarVideo(indiceVideo, true);
            }
        });
    }
});