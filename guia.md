# Guia tecnica del proyecto web_carlos

Esta guia resume la estructura actual del proyecto, el despliegue en InfinityFree y el funcionamiento de la seccion Agenda con CRUD desde el panel de administracion.

## Estado actual

- Proyecto PHP con arquitectura MVC.
- Punto de entrada principal: `index.php`.
- Rutas amigables gestionadas por `.htaccess`.
- Assets publicos en raiz: `css/`, `js/`, `img/`, `doc/`.
- Codigo privado en `app/`, protegido desde `.htaccess`.
- Configuracion de base de datos en `.env`.
- URLs generadas con `asset_url()` y `site_url()` para evitar rutas rotas entre localhost e InfinityFree.
- Panel admin protegido por sesion.
- Agenda publica y CRUD de Agenda implementados.

## Estructura recomendada para subir a InfinityFree

Subir el contenido de `web_carlos` directamente dentro de `htdocs/`:

```text
htdocs/
|-- index.php
|-- .htaccess
|-- .env
|-- app/
|-- css/
|-- js/
|-- img/
|-- doc/
|-- README.md
\-- guia.md
```

No subir una carpeta extra tipo `web_carlos/` dentro de `htdocs/`, salvo que quieras que la web viva en una subcarpeta.

## Archivos importantes

- `index.php`: arranca la aplicacion.
- `.htaccess`: redirige rutas al front controller y bloquea carpetas privadas.
- `app/config/config.php`: define constantes como `URLROOT`, `APPROOT` y `PUBLICROOT`.
- `app/config/helpers.php`: contiene `asset_url()` y `site_url()`.
- `app/core/App.php`: router MVC.
- `app/core/Controller.php`: carga modelos, vistas y assets.
- `app/core/Database.php`: conexion PDO con MySQL/MariaDB.

## Agenda publica

La Agenda aparece en la home mediante:

- Controlador: `app/controllers/HomeController.php`
- Modelo: `app/models/AgendaModel.php`
- Vista publica: `app/views/home/sections/agenda.php`
- Inclusion en home: `app/views/home/index.php`
- Estilos: `css/pagweb.css`
- Enlace de menu: `app/views/partials/menunav.php`

Funcionamiento:

- "Proximos eventos": eventos con `fecha >= CURDATE()`.
- "Eventos anteriores": eventos con `fecha < CURDATE()`.
- Los proximos eventos se ordenan por fecha ascendente.
- Los eventos anteriores se ordenan por fecha descendente.
- Si no hay proximos eventos se muestra: `Muy pronto anunciaremos nuevos conciertos y eventos.`
- Si no hay eventos anteriores, esa seccion no se muestra.
- Los datos se imprimen con `htmlspecialchars()`.
- La descripcion usa `nl2br(htmlspecialchars(...))`, por lo que etiquetas como `<script>` se muestran como texto y no se ejecutan.

## CRUD de Agenda en admin

Rutas disponibles:

- Listado: `/admin/agenda`
- Crear evento: `/admin/agendaNueva`
- Editar evento: `/admin/agendaEditar/{id}`
- Borrar evento: `/admin/agendaBorrar/{id}`

Archivos implicados:

- Controlador: `app/controllers/AdminController.php`
- Modelo: `app/models/AgendaModel.php`
- Listado admin: `app/views/admin/agenda_index.php`
- Formulario admin: `app/views/admin/agenda_formulario.php`
- Layout admin: `app/views/layouts/admin.php`
- Estilos admin: `css/admin.css`

Seguridad aplicada:

- Todas las rutas de Agenda llaman a `checkSession()`.
- Si no hay login, redirigen a `/admin/login`.
- `titulo` y `fecha` son obligatorios.
- `fecha` se valida con formato `Y-m-d`.
- `descripcion` y `lugar` son opcionales.
- Las consultas usan PDO preparado.
- Las vistas escapan los datos con `htmlspecialchars()`.

El campo fecha del formulario usa `type="date"` y abre el calendario nativo del navegador cuando esta soportado.

## Base de datos necesaria

Tabla minima esperada:

```sql
CREATE TABLE agenda (
  id int(11) NOT NULL AUTO_INCREMENT,
  titulo varchar(255) NOT NULL,
  descripcion text DEFAULT NULL,
  fecha date DEFAULT NULL,
  lugar varchar(255) DEFAULT NULL,
  seccion_id int(11) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
```

Si tu tabla ya existe pero `id` no es `AUTO_INCREMENT`, aplica esto en phpMyAdmin antes de usar el CRUD:

```sql
ALTER TABLE agenda
MODIFY id int(11) NOT NULL AUTO_INCREMENT,
ADD PRIMARY KEY (id);
```

Si ya existe una clave primaria en `id`, usa solo:

```sql
ALTER TABLE agenda
MODIFY id int(11) NOT NULL AUTO_INCREMENT;
```

## Archivo .env en InfinityFree

Ejemplo:

```ini
DB_HOST=sqlXXX.infinityfree.com
DB_USER=if0_xxxxxxxx
DB_PASS=tu_password
DB_NAME=if0_xxxxxxxx_nombrebd
APP_BASE_PATH=
```

Si subes el proyecto directamente a `htdocs/`, deja `APP_BASE_PATH` vacio o no lo declares.

Si lo subes dentro de una subcarpeta, por ejemplo `htdocs/web_carlos/`, usa:

```ini
APP_BASE_PATH=web_carlos
```

## Checklist antes de subir

- La carpeta `css/` existe en minusculas.
- La carpeta `js/` existe en minusculas.
- La carpeta `img/` existe en minusculas.
- Los nombres llamados desde HTML, PHP, CSS y JS coinciden exactamente en mayusculas/minusculas.
- `.htaccess` esta en la raiz de `htdocs/`.
- `index.php` esta en la raiz de `htdocs/`.
- `.env` tiene las credenciales reales de InfinityFree.
- La tabla `agenda` tiene `id` como `PRIMARY KEY AUTO_INCREMENT`.
- En produccion, desactivar errores visibles en `index.php` si se quiere evitar mostrar detalles sensibles.

## Checklist de pruebas de Agenda

1. Entrar a `/admin/login`.
2. Acceder a `/admin/agenda`.
3. Crear un evento con fecha futura y comprobar que aparece en "Proximos eventos".
4. Crear un evento con fecha de hoy y comprobar que aparece como proximo/actual.
5. Crear un evento pasado y comprobar que aparece en "Eventos anteriores".
6. Editar un evento y comprobar que cambia en la web publica.
7. Eliminar un evento y comprobar que desaparece.
8. Intentar entrar a `/admin/agenda` sin login y comprobar que redirige a `/admin/login`.
9. Escribir en descripcion `<script>alert(1)</script>` y comprobar que no se ejecuta.
10. Probar la seccion en movil.

## Si el CSS falla en InfinityFree

Abrir F12 -> Network y revisar:

- Que `css/pagweb.css` devuelve estado `200`.
- Que no devuelve `404`.
- Que la URL no contiene una carpeta duplicada, por ejemplo `/web_carlos/web_carlos/css/...`.
- Que no se esta llamando a `public/css/...`.
- Que las mayusculas/minusculas coinciden exactamente.
- Que no queda cache antigua del navegador. Probar Ctrl+F5 o modo incognito.

## Comprobacion tecnica realizada

Se ha revisado la sintaxis PHP del proyecto con:

```bash
php -l
```

Resultado: no hay errores de sintaxis detectados en los archivos PHP revisados.
