<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\CompanyImage;
use App\Models\CompanyExtraField;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    //
    public function recommend(Request $request){
    	if(!request('num')|| !intval(request('num'))){
    		return response()->json(['result'=>-1,'msg'=>'num不合法']);
    	}
    	
    	//$field = CompanyExtraField::where('view',1)->pluck('fields')->toArray();
    	//$field = 'id,'.implode(',',$field);
    	//$info = Company::select(DB::raw($field))->where('recommend',1)->orderBy('created_at','desc')->paginate(request('num'));
    	$info = Company::select('id','Company_name','Industry','Date_Incorporation','Legal_representative')
    	->where('recommend',1)
    	->orderBy('created_at','desc')
    	->paginate(request('num'));
    	foreach($info as $k=>$v){
    		$images = CompanyImage::where('cid',$v->id)->value('img');
    		if($images){
    			$info[$k]->img = env('APP_URL').'/storage/company/'.$images;
    		}else{
    			$info[$k]->img = env('APP_URL').'/images/company.png';
    		}
    	}
    	return response()->json(['result'=>1,'msg'=>'成功','data'=>$info->items(),'lastPage'=>$info->lastPage()]);
    }
}
