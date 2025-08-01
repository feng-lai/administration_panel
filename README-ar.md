
[English](README.md) | [日本語](README-jp.md) | [العربية](README-ar.md) | [Português](README-pt.md) | [Español](README-es.md)

# مقدمة التطبيق

## نظرة عامة

يعمل هذا التطبيق كلوحة إدارة لإدارة مختلف جوانب منصة الويب. يستخدم إطار عمل laravel-admin لتوفير واجهة خلفية قوية وسهلة الاستخدام لإدارة البيانات.

## الميزات الرئيسية

استنادًا إلى ملفات وحدة التحكم المقدمة، يشمل التطبيق الوظائف التالية:

* **إدارة المستخدمين:**  
  * عرض قائمة المستخدمين المسجلين مع تفاصيل مثل الاسم، صورة الملف الشخصي، حالة التحقق، البلد، المحافظة، المدينة، والجنس.  
  * إدارة حالة التحقق للمستخدمين.  
* **إدارة المقالات:**  
  * إدارة المقالات، بما في ذلك عرضها، تحريرها، وتحديث عناوينها ومحتواها.  
  * مراجعة وتغيير حالة المقالات (مثل: في انتظار المراجعة، موافق عليه، مرفوض).  
  * التعامل مع أنواع المقالات المختلفة (مثل "أحتاج"، "أوفر") والفئات (مثل "منتج"، "تقنية"، "معدات"، "عمل"، "أخرى").  
  * إدارة الملفات المرتبطة بالمقالات.  
* **إدارة الشركات:**  
  * إدارة معلومات الشركات، بما في ذلك اسم الشركة، الممثل القانوني، رأس المال المسجل، تفاصيل الاتصال (الهاتف، البريد الإلكتروني)، ونطاق العمل.  
  * تمييز الشركات كـ "موصى بها".  
  * إدارة الحقول الإضافية لملفات الشركات، مع التحكم في ظهورها في البرنامج المصغر (غالبًا برنامج WeChat المصغر أو ما شابه).  
* **طلبات التحقق:**  
  * مراجعة وإدارة طلبات تحقق المستخدمين (مثل طلبات شهادة الشركة).  
* **إدارة البانرات:**  
  * رفع، عرض، وإدارة صور البانرات لواجهة التطبيق الأمامية.  
* **تحليل الكلمات المفتاحية:**  
  * تحليل وترتيب كلمات الوسم المستخدمة داخل التطبيق، مع عرض العدد والنسبة.  
* **إدارة اتصل بنا:**  
  * إدارة إدخالات "اتصل بنا"، بما في ذلك العناوين والمحتويات، غالبًا من إرسال المستخدمين.  
* **التحقق من المشرف:**  
  * التحقق الأساسي للوصول إلى لوحة الإدارة.

## دليل النشر

يُبنى هذا التطبيق على إطار Laravel ويستخدم laravel-admin. تتضمن عملية النشر بشكل عام الخطوات التالية:

1. **متطلبات الخادم:**  
   * PHP (الإصدار المتوافق مع Laravel 8/9 وlaravel-admin)  
   * Composer  
   * MySQL أو قاعدة بيانات مدعومة أخرى  
   * خادم ويب (Nginx أو Apache)  
2. **استنساخ المستودع:**  
   ```bash
   git clone <your-repository-url>
   cd <your-application-directory>
````

3. **تثبيت تبعيات Composer:**

   ```bash
   composer install
   ```
4. **تهيئة البيئة:**

   * نسخ ملف .env.example إلى .env

     ```bash
     cp .env.example .env
     ```
   * إنشاء مفتاح التطبيق:

     ```bash
     php artisan key:generate
     ```
   * تكوين اتصال قاعدة البيانات في ملف .env:

     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=your_database_name
     DB_USERNAME=your_db_username
     DB_PASSWORD=your_db_password
     ```
   * إعداد أي متغيرات بيئية أخرى ضرورية مثل APP\_URL.
5. **هجرة وقاعدة بيانات الزرع:**

   * تنفيذ عمليات الهجرة لإنشاء الجداول اللازمة:

     ```bash
     php artisan migrate
     ```
   * إذا كان لديك بيانات أولية (مثل مستخدم مسؤول، إعدادات افتراضية)، قم بتشغيل الزرع:

     ```bash
     php artisan db:seed
     ```
6. **تثبيت Laravel Admin:**

   * تثبيت حزمة laravel-admin:

     ```bash
     composer require encore/laravel-admin
     ```
   * نشر الأصول وتكوين laravel-admin:

     ```bash
     php artisan vendor:publish --provider="Encore\Admin\AdminServiceProvider"
     php artisan admin:install
     ```
   * هذا الأمر ينشئ أيضًا مستخدم مسؤول مبدئي.
7. **رابط التخزين:**

   * إنشاء رابط رمزي للتخزين:

     ```bash
     php artisan storage:link
     ```
   * تأكد من صلاحيات المجلدات بشكل صحيح.
8. **تكوين خادم الويب (مثال Nginx):**

   * قم بتكوين خادم الويب ليشير إلى مجلد public لتطبيق Laravel.
   * مثال على تكوين Nginx:

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
             fastcgi_pass unix:/var/run/php/php-fpm.sock; # عدل لتناسب مقبس PHP-FPM الخاص بك
             fastcgi_index index.php;
             fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
             include fastcgi_params;
         }

         location ~ /\.(?!well-known).* {
             deny all;
         }
     }
     ```
   * أعد تشغيل خادم الويب.
9. **الوصول إلى لوحة الإدارة:**

   * بعد النشر، عادةً ما يمكنك الوصول إلى لوحة الإدارة عبر /admin على عنوان التطبيق (مثلاً [http://yourdomain.com/admin](http://yourdomain.com/admin)). استخدم بيانات الاعتماد التي تم إنشاؤها أثناء admin\:install.

هذا دليل عام. قد تختلف التكوينات المحددة حسب بيئة الخادم ومتطلباتك الخاصة.
