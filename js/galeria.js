document.addEventListener('DOMContentLoaded', () => {
    // 1. Configuración de las miniaturas
    const swiperThumbs = new Swiper(".thumbSwiper", {
        spaceBetween: 10,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesProgress: true,
        grabCursor: true,
        observer: true,
        observeParents: true,
        breakpoints: {
            640: { slidesPerView: 6 },
            1024: { slidesPerView: 8 }
        }
    });

    // 2. Configuración del visor principal
    const swiperMain = new Swiper(".mainSwiper", {
        spaceBetween: 10,
        loop: true,
        grabCursor: true,
        // Activa el módulo de Zoom nativo
        zoom: {
            maxRatio: 3,
            minRatio: 1,
        },
        // Configuración de la Barra de Progreso
        pagination: {
            el: ".swiper-pagination",
            type: "progressbar",
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        thumbs: {
            swiper: swiperThumbs,
        },
        // Evento para activar zoom con un clic
        on: {
            click: function () {
                this.zoom.toggle(); 
            },
        },
        observer: true,
        observeParents: true,
        preloadImages: false,
        lazy: true
    });
});