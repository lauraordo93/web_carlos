const toggleBtn = document.querySelector('.nav-toggle');
        const navMenu = document.querySelector('.nav-menu');

        toggleBtn.addEventListener('click', () => {
            navMenu.classList.toggle('open');
        });

        // Cerrar menú al hacer clic en un enlace
        document.querySelectorAll('.nav-menu a').forEach(link => {
            link.addEventListener('click', () => {
                navMenu.classList.remove('open');
            });
        });