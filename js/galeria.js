document.addEventListener('DOMContentLoaded', () => {
    const imagenGrande = document.getElementById('imagen-grande');
    const miniaturas = document.querySelectorAll('.galeria-miniaturas img');
    const prevBtn = document.querySelector('.prev-img');
    const nextBtn = document.querySelector('.next-img');

    let indiceActual = 0;
    const visibles = 8; // número máximo de miniaturas visibles al principio

    // Inicial: ocultar todas las miniaturas excepto las primeras 8
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

        // Si la miniatura siguiente no está visible, hacerla visible
        const siguiente = indice + 1;
        if (siguiente < miniaturas.length && miniaturas[siguiente].style.display === 'none') {
            miniaturas[siguiente].style.display = 'inline-block';
        }

        // Ajustar scroll horizontal si quieres (opcional)
        // Con display: none, el scroll no afecta, así que esto es solo si quieres mover la fila
        // actualizarMiniaturas();
    }

    // Función opcional para mover la fila si quieres usar translateX
    function actualizarMiniaturas() {
        const miniaturasContainer = document.querySelector('.galeria-miniaturas');
        const miniaturasInicio = Math.max(0, indiceActual - visibles + 1);
        const offset = -miniaturasInicio * (miniaturas[0].offsetWidth + 10); // gap = 10px
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
