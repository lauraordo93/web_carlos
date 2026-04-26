document.addEventListener("DOMContentLoaded", () => {
  const thumbEl = document.querySelector(".thumbSwiper");
  const mainEl = document.querySelector(".mainSwiper");

  if (!thumbEl || !mainEl) return;

  const totalSlides = mainEl.querySelectorAll(".swiper-slide").length;

  // Miniaturas
  const swiperThumbs = new Swiper(".thumbSwiper", {
    spaceBetween: 8,
    slidesPerView: 4,
    freeMode: true,
    watchSlidesProgress: true,
    grabCursor: true,
    speed: 300,
    preloadImages: false,
    watchOverflow: true,
    breakpoints: {
      640: { slidesPerView: 5 },
      1024: { slidesPerView: 7 },
    },
  });

  // Principal
  const swiperMain = new Swiper(".mainSwiper", {
    spaceBetween: 10,
    loop: totalSlides > 1, // solo si hay más de una imagen
    grabCursor: true,
    speed: 300,
    preloadImages: false,
    lazyPreloadPrevNext: 1,
    watchOverflow: true,

    zoom: {
      maxRatio: 3,
      minRatio: 1,
      toggle: false, // lo gestionamos manualmente en click/doble click
    },

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

    on: {
      click(swiper, event) {
        // Evita hacer toggle si han pulsado en navegación
        const isNav =
          event.target.closest(".swiper-button-next") ||
          event.target.closest(".swiper-button-prev");

        if (isNav) return;

        swiper.zoom.toggle();
      },
    },
  });
});
