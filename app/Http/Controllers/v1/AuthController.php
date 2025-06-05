<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AuthRecord;

class AuthController extends Controller
{
    //认证记录
    public function record(Request $request){
    	if(!request('api_token')){
    		return response()->json(['result'=>-1,'msg'=>'api_token不能为空']);
    	}
    	$uid = User::where('api_token',request('api_token'))->value('id');
    	$info = AuthRecord::select('status','reason','created_at')->where('uid',$uid)->orderBy('created_at','asc')->get();
    	return response()->json(['result'=>1,'msg'=>'成功','data'=>$info]);
    }
    //用户认证
    public function save(Request $request){

    }
}