<?php

namespace App\Http\Controllers\v1;

use App\Models\user;

use GuzzleHttp\Client;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;

class LoginController extends Controller
{
    //用户登录
    public function login(Request $request){
    	//判断用户是否已存在
    	$api_token = User::where('name',request('nickName'))->value('api_token');
    	if($api_token){
    		return response()->json(['result'=>1,'msg'=>'成功','data'=>$api_token]);
    	}
    	$api_token = \Str::random(60);
    	$user = New user;
    	$user->api_token = $api_token;
    	$user->profile_pic = $this->saveImg(request('avatarUrl'));
    	$user->name = request('nickName');
    	$user->country = request('country');
    	$user->province = request('province');
    	$user->city = request('city');
    	$user->gender = request('gender');
    	$is = $user->save();
    	if($is){
    		return response()->json(['result'=>1,'msg'=>'成功','data'=>$api_token]);
    	}else{
    		return response()->json(['result'=>-1,'msg'=>'失败，请稍后重试']);
    	}
    }
    //头像保存
    public function saveImg($imges){
    	//微信头像保存
		$img = $this->file_get_contents_by_curl($imges);
		$result=$this->data_uri($img,'image/png');
		$name = md5(uniqid(time())).".jpg";
		$bool=Storage::disk('user_img')->put($name,file_get_contents($result));
		return $name;
    }
}
