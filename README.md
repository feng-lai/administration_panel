[English](README.md) | [日本語](README-jp.md) | [العربية](README-ar.md) | [Português](README-pt.md) | [Español](README-es.md)

# **Application Introduction**

This document provides an overview of the web application, highlighting its key features and a general guide for deployment.

## **Overview**

This application serves as an administration panel for managing various aspects of a web platform. It leverages the laravel-admin framework to provide a robust and intuitive backend interface for data management.

## **Key Features**

Based on the provided controller files, the application includes the following functionalities:

* **User Management:**  
  * View a list of registered users with details like name, profile picture, authentication status, country, province, city, and gender.  
  * Manage user authentication status.  
* **Article Management:**  
  * Manage articles, including viewing, editing, and updating their titles and content.  
  * Review and change the status of articles (e.g., pending review, approved, rejected).  
  * Handle different types of articles (e.g., "I Need," "I Provide") and categories (e.g., "Product," "Technology," "Equipment," "Labor," "Other").  
  * Manage associated files for articles.  
* **Company Management:**  
  * Administer company information, including company name, legal representative, registered capital, contact details (phone, email), and business scope.  
  * Mark companies as "recommended."  
  * Manage extra fields for company profiles, with control over their visibility on the mini-program (likely a WeChat mini-program or similar).  
* **Authentication Applications:**  
  * Review and manage user authentication requests (e.g., company certification applications).  
* **Banner Management:**  
  * Upload, view, and manage banner images for the application's front-end display.  
* **Tag Word Analysis:**  
  * Analyze and rank tag words used within the application, displaying their count and percentage.  
* **Contact Us Management:**  
  * Manage "Contact Us" entries, including titles and content, likely from user submissions.  
* **Admin Authentication:**  
  * Basic authentication for the administration panel.

## **Deployment Guide**

This application is built on the Laravel framework and utilizes laravel-admin. The deployment process generally involves the following steps:

1. **Server Requirements:**  
   * PHP (version compatible with Laravel 8/9 and laravel-admin)  
   * Composer  
   * MySQL or other supported database  
   * Web Server (Nginx or Apache)  
2. **Clone the Repository:**  
   git clone \<your-repository-url\>  
   cd \<your-application-directory\>

3. **Install Composer Dependencies:**  
   composer install

4. **Environment Configuration:**  
   * Copy the .env.example file to .env:  
     cp .env.example .env

   * Generate an application key:  
     php artisan key:generate

   * Configure your database connection in the .env file:  
     DB\_CONNECTION=mysql  
     DB\_HOST=127.0.0.1  
     DB\_PORT=3306  
     DB\_DATABASE=your\_database\_name  
     DB\_USERNAME=your\_db\_username  
     DB\_PASSWORD=your\_db\_password

   * Set up any other necessary environment variables, such as APP\_URL.  
5. **Database Migration and Seeding:**  
   * Run database migrations to create the necessary tables:  
     php artisan migrate

   * If you have seeders for initial data (e.g., admin user, default settings), run them:  
     php artisan db:seed

6. **Install Laravel Admin:**  
   * Install the laravel-admin package:  
     composer require encore/laravel-admin

   * Publish assets and configure laravel-admin:  
     php artisan vendor:publish \--provider="Encore\\Admin\\AdminServiceProvider"  
     php artisan admin:install

     This command will also create an initial admin user.  
7. **Storage Link:**  
   * Create a symbolic link for storage:  
     php artisan storage:link

   * Ensure proper permissions for storage directories.  
8. **Web Server Configuration (Nginx Example):**  
   * Configure your web server (e.g., Nginx) to point to the public directory of your Laravel application.  
   * Example Nginx configuration:  
     server {  
         listen 80;  
         server\_name yourdomain.com;  
         root /path/to/your/application/public;

         add\_header X-Frame-Options "SAMEORIGIN";  
         add\_header X-XSS-Protection "1; mode=block";  
         add\_header X-Content-Type-Options "nosniff";

         index index.php index.html index.htm;

         charset utf-8;

         location / {  
             try\_files $uri $uri/ /index.php?$query\_string;  
         }

         location \~ \\.php$ {  
             fastcgi\_pass unix:/var/run/php/php-fpm.sock; \# Adjust for your PHP-FPM socket  
             fastcgi\_index index.php;  
             fastcgi\_param SCRIPT\_FILENAME $realpath\_root$fastcgi\_script\_name;  
             include fastcgi\_params;  
         }

         location \~ /\\.(?\!well-known).\* {  
             deny all;  
         }  
     }

   * Restart your web server.  
9. **Access the Admin Panel:**  
   * Once deployed, you can usually access the admin panel by navigating to /admin on your application's URL (e.g., http://yourdomain.com/admin). Use the credentials created during admin:install.

This is a general guide. Specific configurations may vary based on your server environment and any custom requirements.
