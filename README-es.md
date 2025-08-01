
[English](README.md) | [日本語](README-jp.md) | [العربية](README-ar.md) | [Português](README-pt.md) | [Español](README-es.md)

# Introducción a la Aplicación

## Visión General

Esta aplicación sirve como un panel de administración para gestionar varios aspectos de una plataforma web. Utiliza el framework laravel-admin para proporcionar una interfaz de backend robusta e intuitiva para la gestión de datos.

## Características Principales

Basado en los archivos de controlador proporcionados, la aplicación incluye las siguientes funcionalidades:

* **Gestión de Usuarios:**  
  * Visualizar una lista de usuarios registrados con detalles como nombre, foto de perfil, estado de autenticación, país, provincia, ciudad y género.  
  * Gestionar el estado de autenticación del usuario.  
* **Gestión de Artículos:**  
  * Gestionar artículos, incluyendo visualizar, editar y actualizar títulos y contenidos.  
  * Revisar y cambiar el estado de los artículos (por ejemplo, pendiente de revisión, aprobado, rechazado).  
  * Manejar diferentes tipos de artículos (por ejemplo, "Necesito", "Ofrezco") y categorías (por ejemplo, "Producto", "Tecnología", "Equipo", "Trabajo", "Otro").  
  * Gestionar archivos asociados a los artículos.  
* **Gestión de Empresas:**  
  * Administrar información de empresas, incluyendo nombre de la empresa, representante legal, capital registrado, detalles de contacto (teléfono, correo electrónico) y ámbito de negocio.  
  * Marcar empresas como "recomendadas".  
  * Gestionar campos extras para perfiles de empresas, con control sobre la visibilidad en el mini programa (probablemente un mini programa de WeChat o similar).  
* **Solicitudes de Autenticación:**  
  * Revisar y gestionar solicitudes de autenticación de usuarios (por ejemplo, solicitudes de certificación de empresa).  
* **Gestión de Banners:**  
  * Subir, visualizar y gestionar imágenes de banner para la interfaz frontal de la aplicación.  
* **Análisis de Palabras Clave:**  
  * Analizar y clasificar palabras clave utilizadas dentro de la aplicación, mostrando su conteo y porcentaje.  
* **Gestión de Contacto:**  
  * Gestionar entradas de "Contáctanos", incluyendo títulos y contenidos, probablemente enviados por los usuarios.  
* **Autenticación de Administradores:**  
  * Autenticación básica para el panel de administración.

## Guía de Despliegue

Esta aplicación está construida sobre el framework Laravel y utiliza laravel-admin. El proceso de despliegue generalmente involucra los siguientes pasos:

1. **Requisitos del Servidor:**  
   * PHP (versión compatible con Laravel 8/9 y laravel-admin)  
   * Composer  
   * MySQL u otra base de datos soportada  
   * Servidor Web (Nginx o Apache)  
2. **Clonar el Repositorio:**  
   ```bash
   git clone <your-repository-url>
   cd <your-application-directory>
````

3. **Instalar Dependencias de Composer:**

   ```bash
   composer install
   ```
4. **Configuración del Entorno:**

   * Copiar el archivo .env.example a .env:

     ```bash
     cp .env.example .env
     ```
   * Generar una clave para la aplicación:

     ```bash
     php artisan key:generate
     ```
   * Configurar la conexión de base de datos en el archivo .env:

     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=your_database_name
     DB_USERNAME=your_db_username
     DB_PASSWORD=your_db_password
     ```
   * Configurar cualquier otra variable de entorno necesaria, como APP\_URL.
5. **Migración y Seed de Base de Datos:**

   * Ejecutar migraciones para crear las tablas necesarias:

     ```bash
     php artisan migrate
     ```
   * Si tienes seeders para datos iniciales (ej. usuario admin, configuración por defecto), ejecútalos:

     ```bash
     php artisan db:seed
     ```
6. **Instalar Laravel Admin:**

   * Instalar el paquete laravel-admin:

     ```bash
     composer require encore/laravel-admin
     ```
   * Publicar assets y configurar laravel-admin:

     ```bash
     php artisan vendor:publish --provider="Encore\Admin\AdminServiceProvider"
     php artisan admin:install
     ```
   * Este comando también creará un usuario administrador inicial.
7. **Enlace de Storage:**

   * Crear un enlace simbólico para storage:

     ```bash
     php artisan storage:link
     ```
   * Asegurarse de que los permisos de los directorios de storage sean correctos.
8. **Configuración del Servidor Web (Ejemplo Nginx):**

   * Configurar el servidor web (ej. Nginx) para apuntar al directorio public de la aplicación Laravel.
   * Ejemplo de configuración Nginx:

     ```nginx
     server {
         listen 80;
         server_name yourdomain.com;
         root /path/to/your/application/public;

         add_header X-Frame-Options "SAMEORIGIN";
         add_header X-XSS-Protection "1; mode=block";
         add_header X-Content-Type-Options "nosniff";

         index index.php index.html index.htm;

         charset utf-8;

         location / {
             try_files $uri $uri/ /index.php?$query_string;
         }

         location ~ \.php$ {
             fastcgi_pass unix:/var/run/php/php-fpm.sock; # Ajusta según el socket PHP-FPM de tu sistema
             fastcgi_index index.php;
             fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
             include fastcgi_params;
         }

         location ~ /\.(?!well-known).* {
             deny all;
         }
     }
     ```
   * Reiniciar el servidor web.
9. **Acceder al Panel de Administración:**

   * Después del despliegue, usualmente puedes acceder al panel de administración navegando a /admin en la URL de tu aplicación (ej. [http://yourdomain.com/admin](http://yourdomain.com/admin)). Usa las credenciales creadas durante admin\:install.

Esta es una guía general. Las configuraciones específicas pueden variar según tu entorno de servidor y requisitos personalizados.

 
