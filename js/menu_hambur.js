const toggleBtn = document.querySelector('.nav-toggle');
const navMenu = document.querySelector('.nav-menu');

if (toggleBtn && navMenu) {
    toggleBtn.addEventListener('click', () => {
        const isOpen = navMenu.classList.toggle('open');
        toggleBtn.setAttribute('aria-expanded', isOpen);
    });

    // Cerrar menú al hacer clic en un enlace
    document.querySelectorAll('.nav-menu a').forEach(link => {
        link.addEventListener('click', () => {
            navMenu.classList.remove('open');
            toggleBtn.setAttribute('aria-expanded', 'false');
        });
    });
}