<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\DB;

class BannerController extends Controller
{
    public function banner(){
    	$info = Banner::select(DB::raw('CONCAT("'.env('APP_URL').'/storage/banner/",`banners`.`img`) as img'))->get();
    	return response()->json(['result'=>1,'msg'=>'成功','data'=>$info]);
    }
}
