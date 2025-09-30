document.addEventListener('DOMContentLoaded', () => {
    const imagenGrande = document.getElementById('imagen-grande');
    const miniaturas = document.querySelectorAll('.galeria-miniaturas img');
    const prevBtn = document.querySelector('.prev-img');
    const nextBtn = document.querySelector('.next-img');

    let indiceActual = 0;
    const visibles = 8;

    function mostrarImagen(indice) {
        indiceActual = indice;
        // Cambiar imagen grande
        imagenGrande.src = miniaturas[indiceActual].src;

        // Resaltar miniatura activa
        miniaturas.forEach(img => img.classList.remove('active'));
        miniaturas[indiceActual].classList.add('active');

        // Mostrar siempre 8 miniaturas ciclando
        miniaturas.forEach(img => img.style.display = 'none');
        for (let j = 0; j < visibles; j++) {
            const mostrarIndice = (indiceActual + j) % miniaturas.length;
            miniaturas[mostrarIndice].style.display = 'inline-block';
        }
    }

    // Flecha siguiente
    nextBtn.addEventListener('click', () => {
        const nuevoIndice = (indiceActual + 1) % miniaturas.length;
        mostrarImagen(nuevoIndice);
    });

    // Flecha anterior
    prevBtn.addEventListener('click', () => {
        const nuevoIndice = (indiceActual - 1 + miniaturas.length) % miniaturas.length;
        mostrarImagen(nuevoIndice);
    });

    // Clic en miniatura
    miniaturas.forEach((img, i) => {
        img.addEventListener('click', () => mostrarImagen(i));
    });

    // Inicial
    mostrarImagen(0);
});
