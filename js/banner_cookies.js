
document.addEventListener('DOMContentLoaded', () => {
  const overlay = document.getElementById('overlay-cookies');
  const btnAceptar = document.getElementById('btn-aceptar-cookies');
  const btnRechazar = document.getElementById('btn-rechazar-cookies');

  const cookiesAceptadas = localStorage.getItem('cookiesAceptadas');

  // Si aún no ha aceptado o rechazado, mostrar el modal
  if (!cookiesAceptadas) {
    overlay.style.display = 'flex';
  }

  btnAceptar.addEventListener('click', () => {
    localStorage.setItem('cookiesAceptadas', 'true');
    overlay.style.display = 'none';
  });

  btnRechazar.addEventListener('click', () => {
    localStorage.setItem('cookiesAceptadas', 'false');
    overlay.style.display = 'none';
  });
});

