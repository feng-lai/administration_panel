<?php
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;

//登陆
Route::post('/login','LoginController@login');

//banner图
Route::get('/banner','BannerController@banner');

//文件上传
Route::post('/upload_file','UploadController@file');

//认证公司图片上传
Route::post('/upload_company','UploadController@company');

//文章
Route::group(['prefix' => 'article'], function () {
	//详情
	Route::get('/detail', 'ArticleController@detail');
	//保存
	Route::post('/save', 'ArticleController@save');
	//列表
	Route::get('/entry', 'ArticleController@entry');
});

//搜索
Route::group(['prefix' => 'search'], function () {
	//更多词
	Route::get('/word', 'SearchController@word');
	//hot词
	Route::get('/hot', 'SearchController@hot');
	//搜索结果
	Route::get('/result', 'SearchController@result');
});

//评论
Route::prefix('comment')->group(function () {
	Route::get('/entry','CommentController@entry');
	
	Route::post('/add','CommentController@add')->middleware('throttle:1,0.16');
});

//联系我们
Route::prefix('contact_us')->group(function () {
	Route::get('/','ContactUsController@index');
});

//公司
Route::prefix('company')->group(function () {
	//推荐公司
	Route::get('/recommend','CompanyController@recommend');
});

//用户
Route::prefix('user')->group(function () {
	//信息
	Route::get('/info','UserController@info');
});

//认证记录
Route::prefix('auths')->group(function () {
	//信息
	Route::get('/record','AuthController@record');
});