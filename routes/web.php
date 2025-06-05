<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

use Illuminate\Http\File;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/admin/upload', function (Request $request) {
    $pic = $request['upload'];
	$name=$pic->getClientOriginalName();//得到图片名；
	$ext=$pic->getClientOriginalExtension();//得到图片后缀；
	$filesize=$pic->getSize();
	if($filesize>50*1024*1024){
		return response()->json(['result'=>-1,'msg'=>'文件不能大于50M']);
	}
	$fileName=md5(uniqid($name)); 
	$fileName=$fileName.'.'.$ext;//生成新的的文件名		
	$bool=Storage::disk('file')->put($fileName,file_get_contents($pic->getRealPath()));
	return env('APP_URL').'/storage/file/'.$fileName;
	return response()->json(['result'=>1,'msg'=>'成功','data'=>$fileName]);
});
