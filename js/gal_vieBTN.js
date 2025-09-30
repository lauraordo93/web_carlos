const tabBtns = document.querySelectorAll(".tab-btn");

tabBtns.forEach(btn => {
    btn.addEventListener("click", () => {
        tabBtns.forEach(b => b.classList.remove("active"));
        // Oculta todo lo que tenga clase galeria o video
        document.querySelectorAll(".galeria, .video").forEach(g => g.classList.remove("active"));
        
        btn.classList.add("active");
        const tab = btn.dataset.tab; // 'imagenes' o 'videos'
        const contenedor = document.getElementById(tab);
        if (contenedor) contenedor.classList.add("active");
    });
});
