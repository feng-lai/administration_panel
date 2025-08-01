
[English](README.md) | [日本語](README-jp.md) | [العربية](README-ar.md) | [Português](README-pt.md) | [Español](README-es.md)

# アプリケーション紹介

## 概要

本アプリケーションは、ウェブプラットフォームの様々な管理を行う管理パネルです。Laravel-admin フレームワークを利用し、データ管理のための堅牢で直感的なバックエンドインターフェースを提供します。

## 主な機能

提供されたコントローラーファイルに基づき、以下の機能を含みます：

* **ユーザー管理:**  
  * 登録ユーザーの一覧表示（名前、プロフィール画像、認証状況、国、省、市、性別など）  
  * ユーザー認証状況の管理  
* **記事管理:**  
  * 記事の閲覧、編集、タイトルおよび内容の更新  
  * 記事のステータス変更（例：審査待ち、承認済み、拒否）  
  * 記事タイプの管理（例：「欲しい」「提供」）およびカテゴリ管理（例：「製品」「技術」「設備」「労働」「その他」）  
  * 記事に関連するファイルの管理  
* **企業管理:**  
  * 企業情報の管理（企業名、法定代表者、登録資本金、連絡先（電話、メール）、事業内容など）  
  * 企業の「おすすめ」マーク付け  
  * 企業プロフィールの追加項目管理とミニプログラムでの表示制御  
* **認証申請:**  
  * ユーザー認証申請の審査・管理（例：企業認証申請）  
* **バナー管理:**  
  * アプリケーションのフロントエンド表示用バナー画像のアップロード・閲覧・管理  
* **タグワード分析:**  
  * アプリ内で使用されているタグワードの分析・ランキング表示（出現数、割合）  
* **お問い合わせ管理:**  
  * 「お問い合わせ」エントリの管理（タイトル、内容、ユーザーからの送信内容等）  
* **管理者認証:**  
  * 管理パネルの基本認証機能

## デプロイ手順

本アプリケーションは Laravel フレームワークと laravel-admin を利用しています。一般的なデプロイ手順は以下の通りです：

1. **サーバー要件:**  
   * PHP（Laravel 8/9 と laravel-admin に対応したバージョン）  
   * Composer  
   * MySQL または対応するデータベース  
   * Webサーバー（Nginx または Apache）  
2. **リポジトリのクローン:**  
   ```bash
   git clone <your-repository-url>
   cd <your-application-directory>
````

3. **Composer依存関係のインストール:**

   ```bash
   composer install
   ```
4. **環境設定:**

   * `.env.example` ファイルを `.env` にコピー

     ```bash
     cp .env.example .env
     ```
   * アプリケーションキーの生成

     ```bash
     php artisan key:generate
     ```
   * `.env` ファイル内でデータベース接続情報を設定

     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=your_database_name
     DB_USERNAME=your_db_username
     DB_PASSWORD=your_db_password
     ```
   * その他必要な環境変数（例：APP\_URL）を設定
5. **データベースマイグレーションとシーディング:**

   * 必要なテーブルを作成するマイグレーションの実行

     ```bash
     php artisan migrate
     ```
   * 初期データ（管理者ユーザーやデフォルト設定など）がある場合はシーダーを実行

     ```bash
     php artisan db:seed
     ```
6. **Laravel Adminのインストール:**

   * laravel-admin パッケージのインストール

     ```bash
     composer require encore/laravel-admin
     ```
   * アセットの公開と設定

     ```bash
     php artisan vendor:publish --provider="Encore\Admin\AdminServiceProvider"
     php artisan admin:install
     ```
   * `admin:install` コマンドは初期管理者ユーザーも作成します
7. **ストレージのシンボリックリンク作成:**

   ```bash
   php artisan storage:link
   ```

   * ストレージディレクトリのパーミッションを適切に設定
8. **Webサーバー設定（Nginx例）:**

   * Laravel アプリケーションの `public` ディレクトリをドキュメントルートに設定
   * 例:

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
           fastcgi_pass unix:/var/run/php/php-fpm.sock; # PHP-FPMのソケットに合わせて調整
           fastcgi_index index.php;
           fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
           include fastcgi_params;
       }

       location ~ /\.(?!well-known).* {
           deny all;
       }
   }
   ```

   * Webサーバーを再起動
9. **管理パネルへのアクセス:**

   * デプロイ後、通常は `/admin` パスで管理パネルへアクセス可能（例：`http://yourdomain.com/admin`）。
   * `admin:install` 実行時に作成された管理者アカウントでログイン

---

環境や要件に応じて、設定内容を適宜調整してください。

