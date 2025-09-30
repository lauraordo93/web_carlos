document.addEventListener('DOMContentLoaded', () => {
    const imagenGrande = document.getElementById('imagen-grande');
    const miniaturas = document.querySelectorAll('.galeria-miniaturas img');
    const prevBtn = document.querySelector('.prev-img');
    const nextBtn = document.querySelector('.next-img');

    let indiceActual = 0;
    const visibles = 8; // Número máximo de miniaturas visibles al principio

    // Inicial: ocultar todas las miniaturas excepto las primeras 'visibles'
    miniaturas.forEach((img, i) => {
        if (i >= visibles) img.style.display = 'none';
    });

    function mostrarImagen(indice) {
        // Cambiar imagen grande
        imagenGrande.src = miniaturas[indice].src;

        // Resaltar miniatura activa
        miniaturas.forEach(img => img.classList.remove('active'));
        miniaturas[indice].classList.add('active');
        indiceActual = indice;

        // Mostrar un bloque de miniaturas alrededor de la activa
        miniaturas.forEach((img, i) => {
            if (i >= indiceActual && i < indiceActual + visibles) {
                img.style.display = 'inline-block';
            } else {
                img.style.display = 'none';
            }
        });

        // Opcional: desplazar miniaturas con translateX si quieres scroll
        actualizarMiniaturas();
    }

    function actualizarMiniaturas() {
        const miniaturasContainer = document.querySelector('.galeria-miniaturas');
        const miniaturasInicio = indiceActual;
        const offset = -miniaturasInicio * (miniaturas[0].offsetWidth + 10); // 10px de gap
        miniaturasContainer.style.transform = `translateX(${offset}px)`;
    }

    // Hacer clic en una miniatura
    miniaturas.forEach((img, i) => {
        img.addEventListener('click', () => mostrarImagen(i));
    });

    // Flecha anterior
    prevBtn.addEventListener('click', () => {
        let nuevoIndice = indiceActual - 1;
        if (nuevoIndice < 0) nuevoIndice = miniaturas.length - 1;
        mostrarImagen(nuevoIndice);
    });

    // Flecha siguiente
    nextBtn.addEventListener('click', () => {
        let nuevoIndice = (indiceActual + 1) % miniaturas.length;
        mostrarImagen(nuevoIndice);
    });

    // Inicial: mostrar la primera imagen
    mostrarImagen(0);
});
