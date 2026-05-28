document.addEventListener("DOMContentLoaded", () => {
    const img = document.querySelector('.imagen-derecha img');

    if (img) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    img.classList.add('visible');
                }
            });
        }, {
            threshold: 0.3
        });

        observer.observe(img);
    }
});