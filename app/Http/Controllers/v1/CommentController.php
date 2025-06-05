<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\User;

use App\Models\Comment;

use App\Models\Article;

use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
	//帖子评论数据
    public function entry(Request $request){
    	if(!request('id') && !intval(request('id'))){
    		return response()->json(['result'=>-1,'msg'=>'id非法参数']);
    	}
    	if(!request('num') && !intval(request('num'))){
    		return response()->json(['result'=>-1,'msg'=>'num非法参数']);
    	}
    	//评论
		$comment = Comment::select(
			'comments.content',
			'comments.id',
			'comments.pid',
			'comments.uid',
			'users.name',
			DB::raw('CONCAT("'.env('APP_URL').'/storage/userImg/",`users`.`profile_pic`) as profile_pic'),
			'comments.updated_at'
		)
		->leftJoin('users','users.id','=','comments.uid')
		->where(['comments.pid'=>0,'comments.aid'=>request('id')])
		->paginate(request('num'));
		foreach($comment as $k=>$v){
			$comment[$k]->time = date("Y-m-d",strtotime($v->updated_at));
			$child = Comment::select(
				'uid',
				'to_uid',
				'aid',
				'pid',
				'content',
				'updated_at',
				'id'
			)
			->where('pid',$v->id)
			->get();
			foreach($child as $key=>$val){
				$name  = User::select('name',DB::raw('CONCAT("'.env('APP_URL').'/storage/userImg/",`users`.`profile_pic`) as profile_pic'))->where('id',$val->uid)->first();
				$to_name  = User::where('id',$val->to_uid)->value('name');
				if($name){
					$child[$key]->name = $name->name;
					$child[$key]->profile_pic = $name->profile_pic;
				}
				$child[$key]->to_name = $to_name;
				$child[$key]->time = date("Y-m-d",strtotime($val->updated_at));
			}
			$comment[$k]->child = $child;
		}
		return response()->json(['result'=>1,'msg'=>'成功','data'=>$comment->items(),'lastPage'=>$comment->lastPage()]);
    }
    public function add(Request $request){
    	if(!request('api_token')){
			return response()->json(['msg'=>'api_token不能为空','result'=>-1]);
		}
		//是否登录
		$uid = User::where('api_token',request('api_token'))->value('id');
		if(!$uid){
			return response()->json(['msg'=>'请先登录','result'=>-2]); 
		}
    	if(!request('content')){
    		return response()->json(['result'=>-1,'msg'=>'评论内容不能为空']);
    	}
    	if(!request('aid')){
    		return response()->json(['result'=>-1,'msg'=>'aid不能为空']);
    	}
    	if(!request('to_uid')){
    		return response()->json(['result'=>-1,'msg'=>'to_uid不能为空']);
    	}
    	$com = new Comment;
    	$com -> content = request('content');
		$com -> aid = request('aid');
		$com -> uid = $uid;
		$com -> to_uid = request('to_uid');
		$com -> pid = request('pid');
		$com -> save();
    	return response()->json(['result'=>1,'msg'=>'成功']);
    }
}