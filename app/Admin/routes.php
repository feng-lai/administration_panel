<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    //公司信息
    $router->resource('companies', CompanyController::class);
    //幻灯图
    $router->resource('banners', BannerController::class);
    //文章中心
    $router->resource('articles', ArticleController::class);
    //联系我们
    $router->resource('contact-uses', ContactUsController::class);
    //注册用户管理
    $router->resource('users', UserController::class);
    //用户认证审核
    $router->resource('auth-users', AuthUserController::class);
    //tag词管理
    $router->resource('tag-words', TagWordController::class);
    //邀请用户列表
    $router->resource('invites', InviteController::class);
    //公司字段管理
    $router->resource('company-extra-fields', CompanyExtraFieldController::class);

});
