# Bienes Raíces (PHP + MySQL)

Proyecto de la **Práctica 6** de Desarrollo de Aplicaciones Web (BUAP, Facultad de Ciencias de la Computación). Es un sitio de venta de casas y departamentos con una parte pública y un administrador protegido con inicio de sesión.

El desarrollo sigue las secciones 26 a 31 del curso de Udemy indicado en clase.

## Funcionalidades

**Sitio público**
- Páginas de inicio, nosotros, anuncios, blog y contacto.
- Encabezado y pie de página reutilizables mediante plantillas de PHP.
- Modo oscuro.

**Administrador** (requiere iniciar sesión)
- Listado de propiedades en una tabla dinámica leída desde MySQL.
- Crear propiedades con validación y sanitización de datos y subida de imagen.
- Actualizar y eliminar propiedades.
- Inicio y cierre de sesión con contraseñas cifradas (`password_hash` y `password_verify`).

## Tecnologías

- PHP (extensión `mysqli`)
- MySQL y MySQL Workbench
- Sass (SCSS), JavaScript y Gulp (Node.js)
- Git y GitHub

## Estructura del proyecto

```
Practica-6/
├── admin/
│   ├── index.php                  # Listado de propiedades
│   └── propiedades/
│       ├── crear.php
│       ├── actualizar.php
│       └── borrar.php
├── build/                         # CSS, JS e imágenes compilados (Gulp)
├── imagenes/                      # Imágenes subidas desde el formulario
├── includes/
│   ├── app.php                    # Constantes de rutas
│   ├── funciones.php              # incluirTemplate, estaAutenticado
│   ├── config/
│   │   ├── database.example.php   # Molde de la conexión (se sube a GitHub)
│   │   └── database.php           # Conexión local (NO se sube)
│   └── templates/
│       ├── header.php
│       └── footer.php
├── src/                           # Código fuente (SCSS y JS)
├── index.php, nosotros.php, anuncios.php, anuncio.php,
│   blog.php, entrada.php, contacto.php
├── login.php, cerrar-sesion.php, usuario.php
├── gulpfile.js
├── package.json
└── .gitignore
```

> La carpeta `build/` se genera con Gulp: los estilos y scripts se editan en `src/`, no en `build/`.

## Requisitos

- [PHP](https://www.php.net/) 8 o superior, con la extensión `mysqli` activada (viene incluido en XAMPP).
- [MySQL](https://dev.mysql.com/downloads/) (MySQL Server o el de XAMPP) y, opcionalmente, MySQL Workbench.
- [Node.js](https://nodejs.org/) (versión LTS), solo para compilar estilos con Gulp.
- [Git](https://git-scm.com/) o GitHub Desktop.

## Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/Samara-AG/Practica-6.git
cd Practica-6
```

### 2. Instalar dependencias de Node

```bash
npm install
```

Solo es necesario si se van a modificar los estilos en `src/`. La carpeta `build/` ya incluye lo compilado.

### 3. Crear el archivo de conexión

El archivo `includes/config/database.php` **no se sube a GitHub** porque contiene datos privados. Cada integrante crea el suyo a partir del ejemplo:

```bash
copy includes\config\database.example.php includes\config\database.php
```

Después, abrir `database.php` y poner los datos propios:

```php
<?php

function conectarDB() {
    $db = mysqli_connect('localhost', 'root', 'TU_CONTRASEÑA', 'bienesraices_crud', 3306);

    if (!$db) {
        echo 'Error: no se pudo conectar';
        exit;
    }

    return $db;
}
```

- Si MySQL usa otro puerto (por ejemplo 3307), cambiar el último parámetro.
- En XAMPP, el usuario `root` normalmente no tiene contraseña.

### 4. Crear la base de datos

Crear la base `bienesraices_crud`:

```sql
CREATE DATABASE bienesraices_crud
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;
```

Luego crear las tablas `propiedades`, `vendedores` y `usuarios`, ya sea con *Forward Engineer* desde el modelo de MySQL Workbench (`.mwb`) o importando el script `bd.sql`, si está disponible.

La tabla de usuarios debe tener esta estructura. La columna `password` es `CHAR(60)`, la longitud exacta del hash:

```sql
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(50) NOT NULL,
    password CHAR(60) NOT NULL
);
```

Para crear propiedades debe existir al menos un registro en la tabla `vendedores`.

## Ejecutar el proyecto

Con MySQL iniciado, abrir una terminal en la carpeta del proyecto y ejecutar:

```bash
php -S localhost:3000
```

Después abrir en el navegador:

- Sitio público: <http://localhost:3000>
- Administrador: <http://localhost:3000/admin>

Para compilar los estilos mientras se trabaja, en otra terminal:

```bash
npm run dev
```

> **No usar Live Server:** no ejecuta PHP. Tampoco abrir los archivos con doble clic, porque las rutas del proyecto empiezan con `/` y necesitan estar en la raíz del servidor.

## Crear un usuario para el administrador

Para entrar al administrador se necesita un usuario en la tabla `usuarios`. El archivo `usuario.php` crea uno de prueba. Abrirlo **una sola vez** en el navegador:

<http://localhost:3000/usuario.php>

Después, iniciar sesión en <http://localhost:3000/login.php> con los datos definidos en ese archivo.

> `usuario.php` solo es para desarrollo: cada vez que se abre crea un usuario nuevo. Eliminarlo del proyecto una vez creado el usuario.

## Flujo de trabajo con Git

- `main` contiene la versión integrada del proyecto.
- Nadie trabaja directo en `main`: cada integrante crea su rama y la mezcla con un **Pull Request**.
- Antes de empezar a trabajar: `git pull origin main`.
- Antes de cada commit, revisar que **no** se incluyan `database.php` ni `node_modules` (ya están en el `.gitignore`).

## Problemas comunes

| Problema | Posible causa |
|---|---|
| `'php' no se reconoce` | PHP no está en el PATH. Agregar la carpeta de PHP (por ejemplo `C:\xampp\php`) o usar la ruta completa. |
| `Failed opening required ... database.php` | Falta crear `includes/config/database.php` a partir del ejemplo. |
| `Access denied for user 'root'` | Contraseña o usuario incorrectos en `database.php`. |
| `Unknown database 'bienesraices_crud'` | La base no existe o tiene otro nombre. |
| `Table '...' doesn't exist` | Faltan las tablas: ejecutar el modelo o el script SQL. |
| `/admin` regresa al inicio | No se ha iniciado sesión en `/login.php`. |
| Página sin estilos ni imágenes | No se está usando `php -S` desde la raíz del proyecto. |

## Integrantes

| Integrante | Aportación |
|---|---|
| Samara Arias Gil | Estructura del proyecto, repositorio y ramas, plantillas, funciones compartidas y base de datos |
| Carlos Alexander Castillo Gómez | Conexión a la base de datos, tabla dinámica del administrador y formulario de creación |
| Jesús Daniel Espinosa Solano | _(completar)_ |
| Alfredo Ramos López | Inicio y cierre de sesión, sesiones y cifrado de contraseñas |

## Repositorio

<https://github.com/Samara-AG/Practica-6>