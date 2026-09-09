function cargarGoogleAnalytics() {
  if (window.gtagCargado) return;
  window.gtagCargado = true;

  const scriptGt = document.createElement('script');
  scriptGt.async = true;
  scriptGt.src = "https://www.googletagmanager.com/gtag/js?id=G-H3W4025HLX";
  document.head.appendChild(scriptGt);

  window.dataLayer = window.dataLayer || [];
  function gtag() {
      dataLayer.push(arguments);
  }
  gtag('js', new Date());
  gtag('config', 'G-H3W4025HLX');
}

document.addEventListener('DOMContentLoaded', () => {
  const overlay = document.getElementById('overlay-cookies');
  const btnAceptar = document.getElementById('btn-aceptar-cookies');
  const btnRechazar = document.getElementById('btn-rechazar-cookies');

  const cookiesAceptadas = localStorage.getItem('cookiesAceptadas');

  if (cookiesAceptadas === 'true') {
      cargarGoogleAnalytics();
  }

  if (!cookiesAceptadas) {
    overlay.style.display = 'flex';
  }

  if (btnAceptar) {
      btnAceptar.addEventListener('click', () => {
        localStorage.setItem('cookiesAceptadas', 'true');
        overlay.style.display = 'none';
        cargarGoogleAnalytics();
      });
  }

  if (btnRechazar) {
      btnRechazar.addEventListener('click', () => {
        localStorage.setItem('cookiesAceptadas', 'false');
        overlay.style.display = 'none';
      });
  }
});
