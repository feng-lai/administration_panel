
[English](README.md) | [日本語](README-jp.md) | [العربية](README-ar.md) | [Português](README-pt.md) | [Español](README-es.md)

# Introdução do Aplicativo

## Visão Geral

Este aplicativo serve como um painel de administração para gerenciar vários aspectos de uma plataforma web. Ele utiliza o framework laravel-admin para fornecer uma interface de backend robusta e intuitiva para gerenciamento de dados.

## Principais Funcionalidades

Baseado nos arquivos de controlador fornecidos, o aplicativo inclui as seguintes funcionalidades:

* **Gerenciamento de Usuários:**  
  * Visualizar uma lista de usuários registrados com detalhes como nome, foto de perfil, status de autenticação, país, província, cidade e gênero.  
  * Gerenciar o status de autenticação do usuário.  
* **Gerenciamento de Artigos:**  
  * Gerenciar artigos, incluindo visualização, edição e atualização dos títulos e conteúdos.  
  * Revisar e alterar o status dos artigos (por exemplo, pendente de revisão, aprovado, rejeitado).  
  * Lidar com diferentes tipos de artigos (por exemplo, "Eu Preciso", "Eu Forneço") e categorias (por exemplo, "Produto", "Tecnologia", "Equipamento", "Trabalho", "Outro").  
  * Gerenciar arquivos associados aos artigos.  
* **Gerenciamento de Empresas:**  
  * Administrar informações da empresa, incluindo nome da empresa, representante legal, capital registrado, detalhes de contato (telefone, e-mail) e escopo de negócios.  
  * Marcar empresas como "recomendadas".  
  * Gerenciar campos extras para perfis de empresas, com controle sobre a visibilidade no mini programa (provavelmente um mini programa do WeChat ou similar).  
* **Aplicações de Autenticação:**  
  * Revisar e gerenciar solicitações de autenticação dos usuários (por exemplo, aplicações para certificação da empresa).  
* **Gerenciamento de Banners:**  
  * Fazer upload, visualizar e gerenciar imagens de banner para a exibição na interface do aplicativo.  
* **Análise de Palavras-Chave:**  
  * Analisar e classificar palavras-chave usadas dentro do aplicativo, exibindo contagem e porcentagem.  
* **Gerenciamento de Contato:**  
  * Gerenciar entradas de "Contato", incluindo títulos e conteúdos, provavelmente provenientes de submissões dos usuários.  
* **Autenticação de Administrador:**  
  * Autenticação básica para o painel de administração.

## Guia de Implantação

Este aplicativo é construído sobre o framework Laravel e utiliza o laravel-admin. O processo de implantação geralmente envolve os seguintes passos:

1. **Requisitos do Servidor:**  
   * PHP (versão compatível com Laravel 8/9 e laravel-admin)  
   * Composer  
   * MySQL ou outro banco de dados suportado  
   * Servidor Web (Nginx ou Apache)  
2. **Clonar o Repositório:**  
   ```bash
   git clone <your-repository-url>
   cd <your-application-directory>
````

3. **Instalar Dependências do Composer:**

   ```bash
   composer install
   ```
4. **Configuração do Ambiente:**

   * Copie o arquivo .env.example para .env:

     ```bash
     cp .env.example .env
     ```
   * Gere uma chave de aplicativo:

     ```bash
     php artisan key:generate
     ```
   * Configure sua conexão de banco de dados no arquivo .env:

     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=your_database_name
     DB_USERNAME=your_db_username
     DB_PASSWORD=your_db_password
     ```
   * Configure quaisquer outras variáveis de ambiente necessárias, como APP\_URL.
5. **Migração e Seed do Banco de Dados:**

   * Execute as migrações para criar as tabelas necessárias:

     ```bash
     php artisan migrate
     ```
   * Se possuir seeders para dados iniciais (ex.: usuário admin, configurações padrão), execute-os:

     ```bash
     php artisan db:seed
     ```
6. **Instalar Laravel Admin:**

   * Instale o pacote laravel-admin:

     ```bash
     composer require encore/laravel-admin
     ```
   * Publique os assets e configure o laravel-admin:

     ```bash
     php artisan vendor:publish --provider="Encore\Admin\AdminServiceProvider"
     php artisan admin:install
     ```
   * Este comando também criará um usuário admin inicial.
7. **Link de Storage:**

   * Crie um link simbólico para storage:

     ```bash
     php artisan storage:link
     ```
   * Certifique-se de que as permissões dos diretórios de storage estão corretas.
8. **Configuração do Servidor Web (Exemplo Nginx):**

   * Configure seu servidor web (ex.: Nginx) para apontar para o diretório public da aplicação Laravel.
   * Exemplo de configuração Nginx:

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
             fastcgi_pass unix:/var/run/php/php-fpm.sock; # Ajuste para o socket PHP-FPM do seu sistema
             fastcgi_index index.php;
             fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
             include fastcgi_params;
         }

         location ~ /\.(?!well-known).* {
             deny all;
         }
     }
     ```
   * Reinicie seu servidor web.
9. **Acessar o Painel Admin:**

   * Após a implantação, normalmente é possível acessar o painel admin navegando para /admin na URL da aplicação (ex.: [http://yourdomain.com/admin](http://yourdomain.com/admin)). Use as credenciais criadas durante o admin\:install.

Este é um guia geral. Configurações específicas podem variar conforme o ambiente do servidor e requisitos personalizados.

