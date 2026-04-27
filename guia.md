# 🎷 Documentación Técnica: Ecosistema MVC Carlos Ordoñez

Bienvenido a la documentación oficial del proyecto. Este sistema ha sido transformado de un modelo monolítico a una arquitectura **MVC (Modelo-Vista-Controlador)** de alto rendimiento, diseñada para ofrecer una experiencia administrativa fluida y una presencia pública impecable.

---

## 🏛️ Arquitectura del Sistema

El proyecto se divide en capas de responsabilidad clara para garantizar la escalabilidad y seguridad.

### 📁 Núcleo de la Aplicación (`/app`)
Contiene la lógica de negocio y el motor del sistema.
- **`/core`**: Clases fundamentales:
    - `App.php`: Router principal que procesa URLs amigables.
    - `Controller.php`: Clase base para la gestión de flujos, carga de modelos e inyección dinámica de activos (CSS/JS).
    - `Database.php`: Capa de persistencia robusta utilizando **PDO**.
    - `Model.php`: Abstracción base para consultas a la base de datos.
- **`/controllers`**: Gestionan las peticiones y orquestan la respuesta.
- **`/models`**: Entidades que interactúan con el motor de base de datos.
- **`/views`**: Plantillas modulares organizadas por dominios y layouts maestros.

### 🌐 Acceso Público (`/public`)
Único punto de entrada permitido desde el servidor web.
- `index.php`: El **Front Controller** que inicializa el sistema.
- `.htaccess`: Gestión de reescritura de URLs y seguridad de directorios.
- `/css`, `/js`, `/img`: Activos estáticos optimizados.

---

## 🎨 Sistema de Diseño: "Yamaha Vibes"

El panel administrativo implementa una identidad visual inspirada en la estética **Synthwave/Yamaha**, caracterizada por:
- **Esquema de Color**: Fondos Ultra-Dark con gradientes radiales en tonos morados (`#7c3aed`) y acentos de luz.
- **Responsive "App Nativa"**: El panel se transforma en móviles para ofrecer una experiencia táctil fluida, con menús horizontales y tarjetas de datos de ancho total (borde a borde).
- **Tipografía**: Uso de la familia **Rubik** para maximizar la legibilidad en interfaces de gestión.

### Archivos de Estilo Clave:
- `admin.css`: Estructura base y topbar.
- `entradas.css`: Gestión de listados y adaptabilidad móvil (Card View).
- `formulario.css`: Diseño optimizado de formularios y controles de entrada.

---

## 🔐 Seguridad y Persistencia

- **Protección de Datos**: Todas las consultas SQL utilizan sentencias preparadas (**PDO**) para mitigar ataques de inyección.
- **Gestión de Identidad**: Autenticación de administradores mediante `password_hash` y `password_verify`.
- **Integridad de Sesión**: Renovación de identificadores de sesión tras el login para evitar secuestro de sesiones.
- **Privacidad**: El código fuente y los archivos de configuración están protegidos mediante directivas de servidor.

---

## 🔄 Flujo de Desarrollo

Para extender la funcionalidad del sistema:

1. **Definición de Ruta**: Las URLs siguen el patrón `dominio.com/controlador/metodo/parametro`.
2. **Implementación de Controlador**: Crear o modificar métodos en `/app/controllers`.
3. **Carga Dinámica de Activos**:
   ```php
   // Ejemplo en el controlador
   $this->appendCSS('css/mi_estilo.css');
   $this->appendJS('js/mi_logica.js');
   ```
4. **Renderizado de Vistas**: Los datos se pasan como un array asociativo `$data` que se extrae automáticamente en la vista.

---

## 🚀 Mantenimiento y Despliegue

- **Configuración Centralizada**: Todas las constantes globales se definen en `app/config/config.php`.
- **Variables de Entorno**: Se utiliza un archivo `.env` en la raíz para la configuración de credenciales en entornos locales y de producción.
- **Versionado de Activos**: El sistema añade automáticamente una marca de tiempo (`filemtime`) a los archivos CSS/JS para invalidar la caché del navegador tras cada actualización.

---
_Esta guía se mantiene actualizada con las últimas evoluciones arquitectónicas del proyecto._
