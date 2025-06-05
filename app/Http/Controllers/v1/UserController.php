<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    //
    public function info(Request $request){
    	if(!request('api_token')){
    		return response()->json(['result'=>-1,'msg'=>'api_token不能为空']);
    	}
    	$info = User::select(DB::raw('CONCAT("'.env('APP_URL').'/storage/userImg/",`users`.`profile_pic`) as profile_pic'),'name','auths')->where('api_token',request('api_token'))->first();
    	return response()->json(['result'=>1,'msg'=>'成功','data'=>$info]);
    }
}
