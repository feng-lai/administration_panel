<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\User;

use App\Models\Article;

use App\Models\Comment;

use App\Models\FootprintArticle;

use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    public function save(Request $request){
    	if(!request('api_token')){
    		return response()->json(['result'=>-1,'msg'=>'api_token不能为空']);
    	}
    	if(!request('title')){
    		return response()->json(['result'=>-1,'msg'=>'title不能为空']);
    	}
    	if(!request('type')){
    		return response()->json(['result'=>-1,'msg'=>'type不能为空']);
    	}
    	if(!request('cid')){
    		return response()->json(['result'=>-1,'msg'=>'cid不能为空']);
    	}
    	if(!request('content')){
    		return response()->json(['result'=>-1,'msg'=>'content不能为空']);
    	}
    	if(!request('phone')){
    		return response()->json(['result'=>-1,'msg'=>'phone不能为空']);
    	}
    	if(!request('name')){
    		return response()->json(['result'=>-1,'msg'=>'name不能为空']);
    	}
    	if(!preg_match("/^13[0-9]{1}[0-9]{8}$|15[0189]{1}[0-9]{8}$|189[0-9]{8}$/",request('phone'))){
    		return response()->json(['result'=>-1,'msg'=>'电话号码不合法']);
    	}
    	$uid = User::where('api_token',request('api_token'))->value('id');
    	if(!$uid){
    		return response()->json(['result'=>-2,'msg'=>'用户无效，请重新登陆']);
    	}
    	if(request('id')){
    		$article = Article::find(request('id'));
    	}else{
    		$article = new Article;
    	}
    	$article->uid = $uid;
    	$article->title = request('title');
    	$article->type = request('type');
    	$article->cid = request('cid');
    	$article->content = request('content');
    	$article->phone = request('phone');
    	$article->file = request('file');
    	$article->name = request('name');
    	$is = $article->save();
    	if($is){
    		return response()->json(['result'=>1,'msg'=>'成功']);
    	}else{
    		return response()->json(['result'=>-1,'msg'=>'失败，请稍后重试']);
    	}
    }
    //详情
    public function detail(Request $request){
        if(!request('id') || !intval(request('id'))){
            return response()->json(['result'=>-1,'msg'=>'id不合法']);
        }
        //增加查看次数
        Article::where('id',request('id'))->increment('view');
        //足迹
        if(request('api_token')){
            $uid = User::where('api_token',request('api_token'))->value('id');
            $is = FootprintArticle::where(['uid'=>$uid,'aid'=>request('id')])->whereDate('created_at',date('Y-m-d',time()))->count();
            if($uid && !$is){
                $res = new FootprintArticle;
                $res->uid = $uid;
                $res->aid = request('id');
                $res->save();
            }
        }
        $info = Article::select(
            'articles.name as contactName',
            'articles.phone',
            'articles.title',
            'articles.content',
            'articles.id',
            'articles.uid',
            'articles.cid',
            'articles.type',
            'articles.file',
            'users.name'
        )
        ->leftJoin('users','users.id','=','articles.uid')
        ->where('articles.id',request('id'))
        ->first();
        $info->commentNum = Comment::where('aid',request('id'))->count();
        $info->comment = Comment::select(
            'comments.content',
            'users.name',
            DB::raw('CONCAT("'.env('APP_URL').'/storage/userImg/",`users`.`profile_pic`) as profile_pic'),
        )
        ->leftJoin('users','users.id','=','comments.uid')
        ->where(['comments.aid'=>request('id'),'comments.pid'=>0])
        ->orderBy('comments.created_at','desc')
        ->get();
        if($info->type == 1){
            $info->type = '我需要';
        }else{
            $info->type = '我提供';
        }
        switch ($info->cid) {
            case 1:
                $info->cid = '产品';
                break;

            case 2:
                $info->cid = '设备';
                break;

            case 3:
                $info->cid = '技术';
                break;

            case 4:
                $info->cid = '人工';
                break;
            
            default:
                $info->cid = '其他';
                break;
        }
        return response()->json(['result'=>1,'msg'=>'成功','data'=>$info]);
    }
    //列表
    public function entry(Request $request){
        if(!request('num') || !intval(request('num'))){
            return response()->json(['result'=>-1,'msg'=>'num不合法']);
        }
        $where = [
            ['articles.status','=',2]
        ];
        if(request('api_token')){
            $uid = User::where('api_token',request('api_token'))->value('id');
            if($uid){
                $where[] = ['articles.uid','=',$uid];
            }
        }
        $info = Article::select(
            'articles.id',
            'articles.title',
            'articles.type',
            'articles.content',
            'users.name',
            DB::raw('CONCAT("'.env('APP_URL').'/storage/userImg/",`users`.`profile_pic`) as profile_pic'),
            'articles.created_at'
        )
        ->leftJoin('users','users.id','=','articles.uid')
        ->orderBy('created_at','desc')
        ->where($where)
        ->paginate(request('num'));
        return response()->json(['result'=>1,'msg'=>'成功','data'=>$info->items(),'lastPage'=>$info->lastPage()]);
    }
}
