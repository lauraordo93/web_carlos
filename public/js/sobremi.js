document.addEventListener("DOMContentLoaded", () => {
    const intro = document.querySelector(".intro");
    if (intro) {
        // Espera 900ms y luego hace aparecer el bloque con animación
        setTimeout(() => {
            intro.style.opacity = "1";
            intro.style.transform = "translateY(0)";
        }, 1000);
    }
    
});