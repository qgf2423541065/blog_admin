<?php
namespace app\index\controller;
use think\Controller;
use think\facade\Session;//session存储
use think\facade\Request;//路径
use app\index\model\Admin_user;//数据表
use app\index\model\Admin_role;//数据表
use app\index\model\Admin_role_node;//数据表
use app\index\model\Admin_node;//数据表
use app\index\model\Admin_pwd;//数据表
use app\index\model\Article;//博文数据表
use app\index\model\Comment;//评论词
use app\index\model\Admin_advertising;//广告数据表
use app\index\model\Keyword;//敏感词
use app\index\model\Blog_user;//用户列表管理
use app\index\model\Friendship;//友情链接
use app\index\model\Seal;//封号列表

/**
 * 
 */
class Admin extends Controller
{
	private $admin_user;
	private $admin_role;
	private $admin_role_node;
	private $admin_node;
	private $admin_pwd;//过期密码
	private $article;//博文
	private $comment;//评论
	private $admin_advertising;//广告
	private $Keyword;//敏感词
	private $blog_user;//用户列表
	private $friendship;//友情链接
	private $seal;//封号
	public function initialize(){//公共的方法
		if(Request::action()!='admin_login'&&Request::action()!='pwd_update'){
            $user_name = session('user_name');
            if(empty($user_name)){
                $this->error('非法访问，请先登录','admin_login');
            }
		}
		$this->admin_user = new Admin_user;//实例化表
		$this->admin_role = new Admin_role;
		$this->admin_role_node = new Admin_role_node;
		$this->admin_node = new Admin_node;
		$this->admin_pwd = new Admin_pwd;
		$this->article = new Article;//实例化表
		$this->comment = new Comment;//实例化表
		$this->admin_advertising = new Admin_advertising;//实例化表
		$this->keyword = new Keyword;//实例化表
		$this->blog_user = new Blog_user;//实例化表
		$this->friendship = new Friendship;//实例化表
		$this->seal = new Seal;//实例化表
	}
	public function admin(){//超级管理员后台首页
		$user_name = session('user_name');
		$this->assign('user_name',$user_name);
		return $this->fetch();
	}
	public function admin_login(){//后台登录页面
		Session::clear();//清空session里面的数据
		$data = input('post.');
		if($data){
			$re = md5($data['pwd']);
			$res = $this->admin_user->where('user_name',$data['username'])->where('user_pwd',$re)->find();
			if($res){
					$time1 = time();//当前时间戳
					$time2 = intval($res['pwd_time']);//密码上次修改的时间戳
					$now_time = $time1-$time2;
					// var_dump($res);
					if($now_time>='2592000'){//判断时间戳是否过期
						$id = $res['user_id'];
						unset($res['user_id']);
						$res['user_type'] = '0';//过期了就把状态改为0 无法登陆
						$res = json_decode($res,true);//转换数组格式
						$this->admin_user->where('user_id',$id)->update($res);//修改状态
						$this->error('密码时间已过期，必须重新设置密码才能登陆');
					}elseif($res['user_type']!=1){
						$this->error('密码时间已过期，必须重新设置密码才能登陆');
					}
					session('user_id',$res['user_id']);//从sesion中存入管理员的id
					session('user_name',$res['user_name']);//从sesion中存入管理员的名称
					session('role_id',$res['role_id']);//从sesion中存入管理员的角色id
					$this->redirect('admin');
			}else{
				$this->error('登录失败');
			}
		}
		return $this->fetch();
	}
	public function admin_admin(){//管理员管理
		$this->node();
		$data = input('post.');
		if($data){
			$id = $data['id'];
			if($data['type']==1){
				$res = $this->admin_user->save(['user_type'=>0],['user_id'=>$id]);
			}else{
				$res = $this->admin_user->save(['user_type'=>1],['user_id'=>$id]);
			}
			$ty = $this->ajax($res,$data);
			return json($ty);
		}
		$info = $this->admin_user->where('role_id',2)->select()->toArray();
		$this->assign('data',$info);
		return $this->fetch();
	}

	public function number_admin(){
		$user_name = session('user_name');
		$data = $this->admin_user->where('user_name',$user_name)->find()->toarray();
		$this->assign('data',$data);
		return $this->fetch();
	}

	public function admin_add(){//管理员添加
		$this->node();
		$data = input('post.');
		if($data){
			$once = $this->admin_user->where('user_name',$data['user_name'])->find();
			if($once){
				$this->error('管理员已经存在');
			}else{
				$data['user_type'] = 1;
				$data['user_pwd'] = md5($data['user_pwd']);
				$data['role_id'] = 2;
				$data['pwd_time'] = time();
				$res = $this->admin_user->insert($data);
				if($res){
					$this->redirect('admin');
				}else{
					$this->error('添加失败');
				}
			}
		}
		return $this->fetch();
	}
	public function pwd_update(){//修改密码
		$data = input('post.');
		$mm_data = [];
		if($data){
			$re = md5($data['pwd']);
			$res = $this->admin_user->where('user_name',$data['username'])->where('user_pwd',$re)->find();
			$mm = $this->admin_pwd->where('user_id',$res['user_id'])->limit(3)->order("admin_pwd_id desc")->select()->toArray();
			if($res){
				foreach($mm as $key =>$val){
					$mm_data[] = $val['user_pwd'];
				}
				if(in_array(md5($data['new_pwd']),$mm_data)){
					$this->error('新密码不能与前三次密码一样');
				}else{
					$id = $res['user_id'];
					unset($res['user_id']);
					unset($res['new_pwd']);
					$res['user_pwd'] = md5($data['new_pwd']);
					$res['user_type'] = 1;
					$res['pwd_time'] = time();
					$pwd_data['user_id'] = $id;
					$pwd_data['user_pwd'] = $res['user_pwd'];
					$res = json_decode($res,true);//转换数组格式
					$yes = $this->admin_user->where('user_id',$id)->update($res);//修改密码 状态 已经密码修改的时间
					$this->admin_pwd->insert($pwd_data);//添加过期的密码
					if($yes){
						$this->redirect('admin_login');
					}else{
						$this->error('密码修改失败');
					}
				}
			}else{
				$this->error('用户名或者旧密码有误');
			}
		}
		return $this->fetch();
	}

	public function user_list(){//用户列表
		$data = input('post.');
		if($data){
			$id = $data['id'];
			if($data['type']==1){//执行改为冻结状态
				$res = $this->blog_user->save(['blog_type'=>0],['blog_id'=>$id]);
			}elseif($data['type']==0){//冻结改为执行状态
				$res = $this->blog_user->save(['blog_type'=>1],['blog_id'=>$id]);
			}elseif($data['type']==2){
				$res = $this->blog_user->save(['blog_type'=>3],['blog_id'=>$id]);
			}
			$ty = $this->ajax($res,$data);//调用返回值的方法
			return json($ty);
		}
		$data = $this->blog_user->select()->toArray();
		$this->assign('data',$data);
		return $this->fetch();
	}

	public function user_ruan_del(){//软删除
		$data = input('post.');
		$id = $data['id'];
		if($data['type']==1){
			$res = $this->blog_user->save(['blog_type_ruan'=>0],['blog_id'=>$id]);
			$this->article->save(['article_radio'=>0],['article_id'=>$id]);//用户删除后把用户名下的所有文章设置为私有不可查看
		}else{
			$res = $this->blog_user->save(['blog_type_ruan'=>1],['blog_id'=>$id]);
			$this->article->save(['article_radio'=>1],['article_id'=>$id]);//用户删除后把用户名下的所有文章设置为私有不可查看
		}
		$ty = $this->ajax($res,$data);//调用返回值的方法
		return json($ty);
	}

	public function update_user(){//封号列表
		$data = $this->seal->select()->toArray();
		foreach($data as $k=>$v){
			$time1 = $v['seal_over_time'];//结束时间
			$time2 = $v['seal_start_time'];//开始时间
			$time3 = time();//当前时间
			$cha_time = $time1-$time2;
			$now_time = $time3-$time2;
			$id = $v['seal_id'];
			if($cha_time>$now_time){
				$this->seal->save(['seal_type'=>0],['seal_id'=>$id]);
			}else{
				$this->seal->save(['seal_type'=>1],['seal_id'=>$id]);
			}
		}
		$res = $this->seal->alias('a')
		->join('blog_user w','a.blog_id = w.blog_id')
		->where('a.seal_type',0)
		->field('a.seal_id,a.seal_start_time,a.seal_over_time,a.seal_cause,a.seal_type,a.blog_id,w.show_name')
		->select()->toArray();
		$this->assign('data',$res);
		return $this->fetch();
	}

	public function update_user_type(){//用户解封
		$id = input('id');
		$res = $this->seal->save(['seal_type'=>1],['blog_id'=>$id]);
		$this->blog_user->save(['blog_type'=>1],['blog_id'=>$id]);
		if($res){
			$this->success('解封成功','update_user');
		}
	}

	public function update_user_show(){//封号记录添加
		$id = input('id');
		$data = input('post.');
		if($data){
			$data['blog_id'] = $id;
			$data['seal_over_time'] = strtotime($data['seal_over_time']);
			$data['seal_start_time'] = time();
			$data['seal_type'] = 0;
			$res = $this->seal->insert($data);
			print_r($data);die;
			if($res){
				$this->redirect('update_user');
			}else{
				$this->error('封号失败');
			}
		}
		$data = $this->blog_user->where('blog_id',$id)->find()->toArray();
		$this->assign('v',$data);
		return $this->fetch();
	}

	public function admin_blog(){//博文管理
		$data = $this->article->select()->toArray();
		$arr = $this->screen($data);//查询所有关键词
		foreach($data as $key=>$val){//循环数据进行判断
			$prg = "<span style='color: red'>**</span>";
			$data[$key]['article_excerpt'] = preg_replace($arr, $prg, $val['article_excerpt']);//preg_replace('我要换啥','我要换成啥','在哪换')
		}
		$this->assign('data',$data);
		return $this->fetch();
	}
	public function admin_blog_list(){//博文未审核列表查看
		$data = $this->article->where('article_type',0)->select()->toArray();
		$this->assign('data',$data);
		return $this->fetch();
	}
	public function admin_blog_show(){//博文展示个人数据
		$id = input('id');
		$data = $this->article->where('article_id',$id)->find()->toarray();
		$arr = $this->screen();//查询所有关键词
		$prg = "<span style='color: red'>**</span>";
		$data['article_excerpt'] = preg_replace($arr, $prg, $data['article_excerpt']);//preg_replace('我要换啥','我要换成啥','在哪换')
		// print_r($data);die;
		$this->assign('v',$data);
		return $this->fetch();
	}
	public function admin_blog_update(){//博文管理状态修改
		$data = input('post.');
		$id = $data['id'];
		// print_r($data);die;
		if($data['type']==1){
			$res = $this->article->save(['article_type'=>0],['article_id'=>$id]);
		}else{
			$res = $this->article->save(['article_type'=>1],['article_id'=>$id]);
		}
		$ty = $this->ajax($res,$data);//调用返回值的方法
		return json($ty);
	}

	public function screen(){//关键字数据库调用
		$arr = [];
		$res = $this->keyword->select()->toArray();//查询关键字
		foreach($res as $key=>$val){
			$arr[] = $val['keyword_content'];//把关键词单独取出来
		}
		return $arr;
	}

	public function ajax($res,$data){//返回状态
		$ty = [];
		if($res){
			$ty['success'] = true;
			if($data['type']==1){
				$ty['type'] = 0;
				$ty['code'] = 200;
			}else{
				$ty['type']= 1;
				$ty['code']=201;
			}
			$ty['msg']='状态修改成功';
			
		}else{
			$ty['success']=false;
			$ty['msg']='状态修改失败';
		}
		return $ty;
	}

	public function admin_comment(){//评论管理
		$data = input('post.');
		if($data){
			$id = $data['id'];
			if($data['type']==1){
				$res = $this->comment->save(['cmt_type'=>0],['cmt_id'=>$id]);
			}else{
				$res = $this->comment->save(['cmt_type'=>1],['cmt_id'=>$id]);
			}
			$ty = $this->ajax($res,$data);//调用返回值的方法
			return json($ty);
		}
		$data = $this->comment->select()->toArray();
		$arr = $this->screen($data);//查询所有关键词
		foreach($data as $key=>$val){//循环数据进行判断
			$prg = "<span style='color: crimson'>**</span>";
			$data[$key]['cmt_content'] = preg_replace($arr, $prg, $val['cmt_content']);//preg_replace('我要换啥','我要换成啥','在哪换')
		}
		$this->assign('data',$data);
		return $this->fetch();
	}
	public function admin_comment_list(){//评论未审核列表查看
		$data = $this->comment->where('cmt_type',0)->select()->toArray();
		// $data['article_content'] = ;
		$arr = $this->screen($data);//查询所有关键词
		foreach($data as $key=>$val){//循环数据进行判断
			$prg = "<span style='color: red'>**</span>";
			$data[$key]['cmt_content'] = preg_replace($arr, $prg, $val['cmt_content']);//preg_replace('我要换啥','我要换成啥','在哪换')
		}
		$this->assign('data',$data);
		return $this->fetch();
	}

	public function admin_comment_show(){
		$id = input('id');
		$data = $this->comment->where('cmt_id',$id)->find();
		$arr = $this->screen($data);//查询所有关键词
		$prg = "<span style='color: red'>**</span>";
		$data['cmt_content'] = preg_replace($arr, $prg, $data['cmt_content']);//preg_replace('我要换啥','我要换成啥','在哪换')
		// print_r($data);
		$this->assign('v',$data);
		return $this->fetch();
	}

	public function admin_advertising(){//广告管理
		$data = input('post.');
		if($data){
			$data['adv_url'] = 'https://'.$data['adv_url'];
			$data['adv_img'] = $this->upload();
			$data['adv_type'] = 1;
			$data['adv_time'] = time();
			$res = $this->admin_advertising->insert($data);
			if($res){
				$this->success('广告添加成功','admin_adv_list');
			}else{
				$this->error('广告添加失败');
			}

		}
		return $this->fetch();
	}

	public function admin_adv_list(){//广告列表展示
		$data = input('post.');
		if($data){
			$id = $data['id'];
			if($data['type']==1){
				$res = $this->admin_advertising->save(['adv_type'=>0],['adv_id'=>$id]);
			}else{
				$res = $this->admin_advertising->save(['adv_type'=>1],['adv_id'=>$id]);
			}
			$ty = $this->ajax($res,$data);
			return json($ty);
		}
		$info = $this->admin_advertising->select()->toArray();
		$this->assign('data',$info);
		return $this->fetch();
	}

	public function friendship_add(){//友情链接添加
		$data = input('post.');
		if($data){
			$data['friendship_url'] = 'https://'.$data['friendship_url'];
			$data['friendship_time'] = time();
			$res = $this->friendship->insert($data);
			if($res){
				$this->success('友情链接添加成功','friendship_admin');
			}else{
				$this->error('友情链接添加失败');
			}

		}
		return $this->fetch();
	}
	public function friendship_admin(){//友情链接列表管理
		$info = $this->friendship->select()->toArray();
		$this->assign('data',$info);
		return $this->fetch();
	}

	public function upload(){//文件上传
		$file = request()->file('adv_img');
		$info = $file->move('./uploads');
		if ($info) {
			return $info->getSaveName();
		}else{
			$this->getError();
		}
	}

	public function keyword(){//关键字添加
		$data = input('post.');
		if($data){
			$data['keyword_content'] = '/'.$data['keyword_content'].'/';
			$res = $this->keyword->save($data);
			if($res){
				$this->redirect('keyword_list');
			}else{
				$this->error('关键字添加失败');
			}
		}
		return $this->fetch();
	}

	public function keyword_list(){//关键字管理
		$data = [];
		$res = $this->keyword->select()->toArray();
		foreach($res as $key=>$val){
			$data[$key]['keyword_id'] = $val['keyword_id'];
			$data[$key]['keyword_content'] = trim($val['keyword_content'],'/');
		}
		$this->assign('data',$data);
		return $this->fetch();
	}

	public function keyword_list_del(){//全部的删除功能都在这里
		$id = input('id');
		$what = input('what');
		if($what=='keyword'){//关键字删除
			$res = $this->keyword->where('keyword_id',$id)->delete();
			$this->redirect('keyword_list');
		}elseif($what=='adv'){//广告删除
			$res = $this->admin_advertising->where('adv_id',$id)->delete();
			$this->redirect('admin_adv_list');
		}elseif($what=='admin'){//管理员删除
			$res = $this->admin_user->where('user_id',$id)->delete();
			$this->redirect('admin_admin');
		}elseif($what=='friend'){//友情链接删除
			$res = $this->friendship->where('friend_id',$id)->delete();
			$this->redirect('friendship_admin');
		}	
	}
	public function node(){//对用户的权限进行判断
		$role_id = session('role_id');
		if($role_id!=1){
			$this->error('抱歉您的权限不够');
		}
	}
}