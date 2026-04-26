function actualizarCampos() {
  const seccion = document.getElementById("seccion_id").value;

  // 1. Seleccionamos todos los campos que tengan la clase 'campo'
  const campos = document.querySelectorAll(".campo");

  // 2. Ocultamos todos de golpe
  campos.forEach((campo) => (campo.style.display = "none"));

  // 3. Definimos qué campos mostrar según el ID de sección

  const configuracion = {
    5: [".campo-titulo", ".campo-contenido", ".campo-video", ".campo-fecha"], // Vídeo
    2: [".campo-imagen"], // Galería
    6: [".campo-titulo", ".campo-contenido", ".campo-imagen", ".campo-enlace"], // Entrevista
  };

  // 4. Mostramos solo los que correspondan
  const camposAMostrar = configuracion[seccion];
  if (camposAMostrar) {
    camposAMostrar.forEach((selector) => {
      document.querySelector(selector).style.display = "block";
    });
  }
}

// Evento y ejecución inicial
document
  .getElementById("seccion_id")
  .addEventListener("change", actualizarCampos);
actualizarCampos();
