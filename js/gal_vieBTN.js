document.addEventListener('DOMContentLoaded', () => {
    const tabBtns = document.querySelectorAll(".tab-btn");

    tabBtns.forEach(btn => {
        btn.addEventListener("click", () => {
            const tabId = btn.dataset.tab; 

            // 1. Gestión del Audio
            if (tabId === 'imagenes') {
                const videoIframe = document.getElementById("video-grande");
                if(videoIframe && videoIframe.src !== "") {
                    const currentSrc = videoIframe.src;
                    videoIframe.src = ""; 
                    videoIframe.src = currentSrc; 
                }
            }

            // 2. Gestión de Clases
            tabBtns.forEach(b => b.classList.remove("active"));
            // En tu index.php usas la clase "galeria" para ambos contenedores
            document.querySelectorAll(".galeria").forEach(g => g.classList.remove("active"));
            
            // 3. Activación
            btn.classList.add("active");
            const contenedor = document.getElementById(tabId);
            if (contenedor) {
                contenedor.classList.add("active");
            }

            // 4. Refrescar Swiper (para que las imágenes no salgan a 0px)
            setTimeout(() => {
                window.dispatchEvent(new Event('resize'));
            }, 100);
        });
    });
});