<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

use Illuminate\Http\File;

class UploadController extends Controller
{
    //文件上传
    public function file(Request $request){
    	$pic = $request['file'];
		$name=$pic->getClientOriginalName();//得到图片名；
		$ext=$pic->getClientOriginalExtension();//得到图片后缀；
		$filesize=$pic->getSize();
		if($filesize>50*1024*1024){
			return response()->json(['result'=>-1,'msg'=>'文件不能大于50M']);
		}
		$fileName=md5(uniqid($name)); 
		$fileName=$fileName.'.'.$ext;//生成新的的文件名		
		$bool=Storage::disk('file')->put($fileName,file_get_contents($pic->getRealPath()));
		return response()->json(['result'=>1,'msg'=>'成功','data'=>$fileName]);
    }
    //认证图片上传
    public function company(Request $request){
    	$pic = $request['file'];
		$name=$pic->getClientOriginalName();//得到图片名；
		$ext=$pic->getClientOriginalExtension();//得到图片后缀；
		$filesize=$pic->getSize();
		if($filesize>50*1024*1024){
			return response()->json(['result'=>-1,'msg'=>'文件不能大于50M']);
		}
		$fileName=md5(uniqid($name)); 
		$fileName=$fileName.'.'.$ext;//生成新的的文件名		
		$bool=Storage::disk('company')->put($fileName,file_get_contents($pic->getRealPath()));
		return response()->json(['result'=>1,'msg'=>'成功','data'=>['src'=>env('APP_URL').'/storage/company/'.$fileName,'name'=>$fileName]]);
    }
}
