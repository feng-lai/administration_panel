<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Search;

use App\Models\Article;

use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
	//更多词
    public function word(Request $request)
    {
		$info = Search::select('word')->where([['word','like','%'.request('word').'%']])->orderBy('num','desc')->limit(10)->get();
		return response()->json(['result'=>1,'msg'=>'成功','data'=>$info]);
    }
    /**热门词*/
	public function hot(request $request){
		$info = Search::orderBy('num','desc')->limit(10)->get();
		return response()->json(['result'=>1,'msg'=>'成功','data'=>$info]); 
	}
    //搜索结果
    public function result(){
    	if(!request('word')){
			return response()->json(['result'=>-1,'msg'=>'word不能为空']);
		}
		if(!request('num') || !intval(request('num'))){
			return response()->json(['result'=>-1,'msg'=>'num非法参数']);
		}
		//关键词加入词库
		$is = Search::where('word',request('word'))->count();
		if($is == 0){
			$search = New Search;
			$search->word = request('word');
			$search->save();
		}else{
			Search::where('word',request('word'))->increment('num');
		}
		$keyword = request('word');
		$info = Article::select(
			'users.name',
			DB::raw('CONCAT("'.env('APP_URL').'/storage/userImg/",`users`.`profile_pic`) as profile_pic'),
			'articles.title',
			'articles.content',
			'articles.created_at'
		)
			->where(function ($query) use ($keyword) {
				$query->where('articles.title', 'like', "%{$keyword}%")->orWhere('articles.content', 'like', "%{$keyword}%");
			})
			->where('articles.status','2')
			->leftJoin('users','users.id','=','articles.uid')
			->paginate(request('num'));
    	return response()->json(['result'=>1,'msg'=>'成功','data'=>$info->items(),'lastPage'=>$info->lastPage()]); 
    }
}
