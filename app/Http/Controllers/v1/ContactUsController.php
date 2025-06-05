<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactUs;

class ContactUsController extends Controller
{
    //
    public function index(){
    	$info = ContactUs::orderBy('updated_at','desc')->first();
    	return response()->json(['result'=>1,'msg'=>'成功','data'=>$info]);
    }
}
