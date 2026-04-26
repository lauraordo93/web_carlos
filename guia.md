# Guía Técnica: Arquitectura MVC - Carlos Ordoñez Web

Este proyecto ha sido evolucionado de un modelo PHP monolítico a una arquitectura **MVC (Modelo-Vista-Controlador)** profesional, modular y segura. Esta estructura facilita el mantenimiento, la escalabilidad y protege la lógica de negocio.

---

## 🏗️ Estructura del Proyecto

La organización de archivos sigue el estándar de aplicaciones web modernas:

- **`/app`**: Lógica privada del servidor. Inaccesible directamente desde el navegador.
  - **`/config`**: Configuración global (`config.php`) y funciones de ayuda (`helpers.php`).
  - **`/core`**: El motor del sistema. Contiene las clases base:
    - `App.php`: Procesa la URL y carga el controlador correspondiente.
    - `Controller.php`: Clase base para todos los controladores (carga modelos y vistas).
    - `Database.php`: Conexión segura usando **PDO**.
    - `Model.php`: Clase base para los modelos.
  - **`/controllers`**: El cerebro que gestiona las peticiones.
    - `HomeController.php`: Página pública principal.
    - `AdminController.php`: Gestión total del panel de administración.
    - `LegalController.php`: Páginas de aviso legal y privacidad.
  - **`/models`**: Comunicación con la base de datos.
    - `EntradaModel`, `AdminModel`, `AcademiaModel`, `HeaderModel`, `MenuModel`, `RedSocialModel`.
  - **`/views`**: Plantillas HTML.
    - `/layouts`: Estructuras maestras (`default.php` y `admin.php`).
    - Subcarpetas por controlador (`/home`, `/admin`, `/legal`, etc.).

- **`/public`**: Única carpeta accesible públicamente.
  - `index.php`: Punto de entrada único (Front Controller).
  - `.htaccess`: Redirige las peticiones al Front Controller.
  - `/css`, `/js`, `/img`: Recursos estáticos (estilos, scripts e imágenes).

---

## ⚙️ Configuración y Variables de Entorno

El sistema es flexible y se adapta a diferentes entornos (local/producción):

1.  **`.env`**: Archivo en la raíz para credenciales sensibles (DB_USER, DB_PASS, etc.).
2.  **`app/config/config.php`**: Centraliza todas las constantes. Define `URLROOT` (ruta base) y `SITENAME`.
3.  **Base de Datos**: Se utiliza **PDO** con sentencias preparadas para eliminar cualquier riesgo de Inyección SQL.

---

## 🔐 Panel de Administración 

El panel de administración se ha integrado completamente en el flujo MVC:

- **Rutas**: Acceso mediante `/admin`.
- **Seguridad**: Sistema de login con `password_verify` y protección de sesiones.
- **Gestión CRUD**: Permite Crear, Leer, Actualizar y Borrar contenidos de las diferentes secciones de la web.
- **Carga de Imágenes**: Gestión automática de subidas a `public/img/` con nombres únicos.

---

## 🔄 Flujo de una Petición (Request)

1.  El usuario solicita una URL (ej: `carlosordonez.com/admin/editar/25`).
2.  El `.htaccess` redirige la petición a `public/index.php`.
3.  `App.php` analiza la URL y detecta: **Controlador** (`AdminController`), **Método** (`editar`) y **Parámetros** (`25`).
4.  El **Controlador** solicita los datos al **Modelo**.
5.  El **Modelo** ejecuta la consulta segura en la DB y devuelve los datos.
6.  El **Controlador** carga la **Vista** correspondiente pasando los datos obtenidos.
7.  La **Vista** se renderiza dentro de un **Layout** maestro y se envía al navegador.

---

## 🛠️ Mantenimiento Común

### Añadir una nueva página:
1. Crea el método en el controlador correspondiente (o crea uno nuevo).
2. Crea la vista en `app/views/nombre_controlador/`.
3. Accede mediante `/controlador/metodo`.

### Cambiar estilos o scripts:
Modifica los archivos en `public/css/` o `public/js/`. Estos se cargan automáticamente en los layouts.

#### Carga dinámica desde el Controlador:
Si necesitas cargar un CSS o JS solo para una página específica, usa los métodos `appendCSS` y `appendJS` en el constructor o método de tu controlador:

```php
// En un controlador (ej: AdminController.php)
public function index() {
    // Carga simple
    $this->appendCSS('css/mi_estilo_especifico.css');
    
    // Carga con versionado (para evitar cache)
    $version = filemtime(PUBLICROOT . '/css/admin.css');
    $this->appendCSS('css/admin.css?v=' . $version);
    
    $this->view('admin/index', $data);
}
```

---

## 🛡️ Notas de Seguridad

- **Protección de carpetas**: El archivo `.htaccess` en la raíz y en `/app` aseguran que nadie pueda ver el código fuente.
- **Sanitización**: Todos los datos mostrados pasan por `htmlspecialchars`.
- **PDO**: No se concatenan variables en las consultas SQL; se usan marcadores de posición.

---

_Desarrollado para ofrecer un rendimiento óptimo y una gestión de contenidos intuitiva._

