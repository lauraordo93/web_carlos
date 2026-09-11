document.addEventListener('DOMContentLoaded', function() {
    const adminForms = document.querySelectorAll('form');
    
    adminForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (e.defaultPrevented) {
                return;
            }
            // Permitir validación HTML5. Si el evento se dispara, HTML5 ha validado los 'required'.
            
            // Bloquear doble submit
            if (this.dataset.submitting === 'true') {
                e.preventDefault();
                return;
            }
            
            this.dataset.submitting = 'true';
            
            const btn = this.querySelector('button[type="submit"]');
            if (btn) {
                let texto = 'Guardando...';
                
                // Detectar login por id o acción
                if (this.action.includes('/admin/login') || document.querySelector('#usuario')) {
                    texto = 'Entrando...';
                } 
                // Detectar si hay imagen lista para subir
                else if (this.enctype === 'multipart/form-data') {
                    const fileInput = this.querySelector('input[type="file"]');
                    if (fileInput && fileInput.files.length > 0) {
                        texto = 'Subiendo...';
                    }
                }
                
                // Usar setTimeout para evitar que el navegador aborte el submit
                // al detectar que el botón ha sido desactivado síncronamente.
                setTimeout(() => {
                    btn.disabled = true;
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ' + texto;
                    btn.style.opacity = '0.7';
                    btn.style.cursor = 'not-allowed';
                }, 10);
            }
        });
    });
});
