<?php
namespace app\index\controller;
use think\Controller;
use think\facade\Cookie;//session存储
use think\facade\Session;//session存储
use think\facade\Request;//路径
use app\index\model\Article;//博文数据表
use app\index\model\Blog_user;//用户列表管理
use app\index\model\Blog_user_msg;//用户列表管理
use app\index\model\Attention;//关注管理
use app\index\model\Email;//博文数据表
use app\index\model\Bean;//粉丝表
use app\index\model\Good_bad;//粉丝表
use app\index\model\Comment;//评论表
/**
 * 
 */
class Blog extends Controller
{
    private $article;
    private $blog_user;
    private $blog_user_msg;
    private $attention;
    private $bean;
    private $good_bad;
    private $comment;
	public function initialize(){//公共的方法
        $this->article = new Article;//实例化表
        $this->blog_user = new Blog_user;//实例化表
        $this->blog_user_msg = new Blog_user_msg;//实例化表
        $this->attention = new Attention;//实例化表
        $this->bean = new Bean;//实例化表
        $this->good_bad = new Good_bad;//实例化表
        $this->comment = new Comment;//实例化表
        if(Request::action()!='blog_login_tow'&&Request::action()!='email_code'&&Request::action()!='email_code_num'&&Request::action()!='blog_register'&&Request::action()!='blog_login'&&Request::action()!='new_blog_tow'&&Request::action()!='forget_pwd'){
            $login_name = session('login_name');
            if(empty($login_name)){
                $this->error('请先登录','blog_login_tow');
            }
        }
        $show_name = session('show_name');
        $this->assign('show_name',$show_name);
	}
    public function blog_login(){//博客园首页展示
        return $this->fetch();
    }
    public function index(){//个人主页
        $blog_id = session('blog_id');
        $msg = $this->blog_user_msg->where('blog_id',$blog_id)->find();
        $user = $this->blog_user->where('blog_id',$blog_id)->find();
        $data = $this->article->where('article_type',1)->where('blog_id',$blog_id)->select()->toArray();
        $atten = $this->attention->where('blog_id',$blog_id)->where('attention_type',1)->select()->toarray();//查询关注的人
        $bean = $this->attention->where('boke_id',$blog_id)->where('attention_type',1)->select()->toarray();//查询粉丝的人
        $gb = $this->good_bad->where('boke_id',$blog_id)->where('gb_type',1)->select()->toarray();//查询收藏
        // print_r($msg['msg_content']);die;
        $this->assign('atten',count($atten));//关注数量
        $this->assign('bean',count($bean));//粉丝数量
        $this->assign('gb',count($gb));//收藏数量
        $this->assign('data',$data);
        $this->assign('reg_time',$user['register_time']);
        $this->assign('msg_content',$msg['msg_content']);
        $this->assign('show_name',$msg['show_name']);
        $this->assign('msg',$msg);
        return $this->fetch();
    }
    public function my_msg_tow(){//个人信息修改页面
        $blog_id = session('blog_id');
        // print_r($blog_id);die;
        $info = input('post.');
        if($info){
            $info['msg_img'] = '/static/uploads/'.$this->upload();
            $info['msg_age'] = strtotime($info['msg_age']);
            // print_r($info);die;
            $this->blog_user->save(['show_name'=>$info['show_name']],['blog_id'=>$blog_id]);
            $res = $this->blog_user_msg->where('blog_id',$blog_id)->update($info);
            if($res){
                session('show_name',$info['show_name']);
                $this->redirect('index');
            }else{
                $this->error('信息修改失败');   
            }
        }
        $blog_id = session('blog_id');
        $data = $this->blog_user_msg->where('blog_id',$blog_id)->find()->toarray();
        $this->assign('data',$data);
        return $this->fetch();
    }

    public function blog_update(){//用户修改
        $info = input('post.');
        $blog_id = session('blog_id');
        if($info){
            $info['pwd'] = md5($info['pwd']);
            //  print_r($info);die; 
            $yx = $this->blog_user->where('blog_id',$blog_id)->where('email',$info['email'])->find();
            if($yx){
                $this->error('修改的邮箱已存在');
            }
            $res = $this->blog_user->where('blog_id',$blog_id)->update($info);
            if($res){
                $this->redirect('index');
            }else{
                $this->error('修改失败');
            }
        }
        
        $data = $this->blog_user->where('blog_id',$blog_id)->find();
        $this->assign('data',$data);
        return $this->fetch();
    }
    
    public function pwd_yz(){//用户修改之密码验证
        $login_name = session('login_name');
        $pwd = md5(input('pwd'));
        $res = $this->blog_user->where('login_name',$login_name)->where('pwd',$pwd)->find();
        if($res){
            return true;
        }else{
            return false;
        }
    }
    public function article_titile(){//通过他人发布的文章进入他人的信息页面
        $article_id = input('article_id');//别人的文章的id
        $blog_id = input('blog_id');//别人的id
        $my_blog_id = session('blog_id');
        $data = $this->article->where('article_id',$article_id)->find();//查询文章
        $info = $this->blog_user_msg->where('blog_id',$blog_id)->find();//查询博主信息
        $atten = $this->attention->where('blog_id',$my_blog_id)->where('boke_id',$blog_id)->order("attention_id desc")->find();//是否关注
        $dataAll = $this->comment->alias('a')
        ->join('blog_user_msg b','a.blog_id=b.blog_id')
        ->where('a.article_id',$data['article_id'])
        ->field('a.blog_id,a.article_id,a.cmt_content,a.cmt_time,b.msg_img,b.show_name')
        ->order('a.cmt_id desc')
        ->select()->toarray();
        $this->assign('count_num',count($dataAll));//返回评论数
        $this->assign('dataAll',$dataAll);//返回评论内容
        $this->assign('atten',$atten['attention_type']);//返回关注的状态
        $this->assign('v',$data);//返回单篇文章内容
        $this->assign('info',$info);//返回文章作者的信息
        return $this->fetch();
    }
    public function blog_all_article(){
        $boke_id = input('boke_id');//别人的id
        $my_blog_id = session('blog_id');
        // $data = $this->article->where('article_id',$article_id)->find();//查询文章
        $info = $this->blog_user_msg->where('blog_id',$boke_id)->find();//查询博主信息
        $atten = $this->attention->where('blog_id',$my_blog_id)->where('boke_id',$boke_id)->order("attention_id desc")->find();//是否关注
        $article_all = $this->article->where('blog_id',$boke_id)->select()->toarray();
        $this->assign('data',$article_all);
        $this->assign('atten',$atten['attention_type']);
        $this->assign('info',$info);
        return $this->fetch();
    }
    public function blog_cmt_add(){//评论添加
        $data = input('post.');
        $data['blog_id'] = session('blog_id');
        $data['cmt_time'] = time();
        $data['cmt_type'] = 1;
        // print_r(json_encode($data));die;
        $res = $this->comment->insert($data);
        if($res){
            $dataAll = $this->comment->alias('a')
            ->join('blog_user_msg b','a.blog_id=b.blog_id')
            ->where('a.article_id',$data['article_id'])
            ->field('a.blog_id,a.article_id,a.cmt_content,a.cmt_time,b.msg_img,b.show_name')
            ->order('a.cmt_id desc')
            ->select()->toarray();
            foreach($dataAll as $k=>$v){
                $dataAll[$k]['cmt_time'] = date("m-d H:i",$v['cmt_time']);
            }
            echo json_encode($dataAll);
        }else{
            return 0;
        }
    }

    public function attention(){//关注
        $data['blog_id'] = session('blog_id');//博主的id
        $data['boke_id'] = input('boke_id');//关注人的id
        $pro['blog_id'] = session('blog_id');//博主的id
        $pro['boke_id'] = input('boke_id');//关注人的id
        // $data['attention_type'] = input('atten_type');//关注人的状态
        $info = $this->attention->where('blog_id',$data['blog_id'])->where('boke_id',$data['boke_id'])->find();
        if(!empty($info)){
            // var_dump($data);die;
            if($info['attention_type']==1){
                $res = $this->attention->save(['attention_type'=>0],['blog_id'=>$data['blog_id'],'boke_id'=>$data['boke_id']]);
                $this->bean->save(['bean_type'=>0],['blog_id'=>$pro['blog_id'],'boke_id'=>$pro['boke_id']]);
                return 2;
            }else if($info['attention_type']==0){
                $res = $this->attention->save(['attention_type'=>1],['blog_id'=>$data['blog_id'],'boke_id'=>$data['boke_id']]);
                $this->bean->save(['bean_type'=>1],['blog_id'=>$pro['blog_id'],'boke_id'=>$pro['boke_id']]);
                return 3;
            }
        }elseif(empty($info)){
            $data['attention_time'] = time();
            $data['attention_type'] = 1;
            $pro['bean_time'] = time();
            $pro['bean_type'] = 1;
            // var_dump($pro);die;
            $this->attention->insert($data);
            $res = $this->bean->insert($pro);
            if($res){
                return 1;
            }else{
                return 0;
            }
        }
        
    }
    public function blog_atten_my(){//查看自己关注的博友
        $blog_id = session('blog_id');
        $data = $this->attention->alias('a')
        ->join('blog_user_msg b','a.boke_id=b.blog_id')
        ->where('a.blog_id',$blog_id)
        ->where('a.attention_type',1)
		->field('a.boke_id,a.attention_time,a.attention_type,b.show_name,b.msg_img,b.msg_content')
        ->select()->toArray();
        $this->assign('data',$data);
        return $this->fetch();
    }
    public function blog_fans(){//我的粉丝
        $blog_id = session('blog_id');
       
        $data = $this->attention->alias('a')
        ->join('blog_user_msg b','a.blog_id=b.blog_id')
        ->where('a.boke_id',$blog_id)
        ->where('a.attention_type',1)
		->field('a.boke_id,a.attention_time,a.attention_type,b.show_name,b.msg_img,b.msg_content')
        ->select()->toArray();
        $this->assign('data',$data);
        return $this->fetch();
    }
    public function upload(){//文件上传
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('msg_img');
        // 移动到框架应用根目录/uploads/ 目录下
        $info = $file->move( './static/uploads');
        if($info){
            return $info->getSaveName();
        }else{
            // 上传失败获取错误信息
            echo $file->getError();
        }
    }
	public function blog_login_tow(){//博客登录
        Session::clear();
        $data = input('post.');
        if($data){
            $data['pwd'] = md5($data['pwd']);
            $res = $this->blog_user->where('login_name',$data['login_name'])->where('pwd',$data['pwd'])->find();
            if($res){
                session('blog_id',$res['blog_id']);
                session('login_name',$data['login_name']);
                session('show_name',$res['show_name']);
                $this->redirect('index');
            }else{
                $this->error('登录失败');
            }
        }
		return $this->fetch();
    }
    public function forget_pwd(){//重置密码
        $data = input('post.');
        if($data){
            $res = $this->blog_user->where('email',$data['email'])->where('login_name',$data['login_name'])->find();
            if($res){
                $data['pwd'] = md5($data['pwd']);
                $this->blog_user->save(['pwd'=>$data['pwd'],'login_name'=>$data['login_name']]);
            }else{
                $this->error('登录名与邮箱不匹配');
            }
        }
        return $this->fetch();
    }
    public function email_code(){//邮箱发送
        $email = input('post.email');
        $rand = rand('99999',1000000);
        // Session::set('email',$rand);
        Cookie::set('email',$rand,60);
        $content = '您获取的验证码为：'.$rand;
        $new = new Email;
        $data = $new->SendEmail($email,$content);
        return $data;
    }
    public function email_code_num(){//邮箱验证码验证
        $code = input('code');
        $email_code = cookie('email');
        if($email_code==""){
            return 2;
        }elseif($email_code!=$code){
            return 0;
        }else{
            return 1;
        }
    }
    public function blog_register(){//博客注册
        $data = input('post.');
        print_r($data);die;
        if($data){
            $login_name = $this->blog_user->where('login_name',$data['login_name'])->find();
            $show_name = $this->blog_user->where('show_name',$data['show_name'])->find();
            $email = $this->blog_user->where('email',$data['email'])->find();
            if($login_name){
                $this->error('登录名已存在');
            }elseif($show_name){
                $this->error('显示名已存在');
            }elseif($email){
                $this->error('邮箱已存在');
            }else{
                $data['pwd'] = md5($data['pwd']);
                $data['register_time'] = time();
                $data['blog_type'] = 1;
                $data['blog_type_ruan'] = 0;
                $res = $this->blog_user->insert($data);
                $res_tow = $this->blog_user->where('login_name',$data['login_name'])->find();
                $info['blog_id'] = $res_tow['blog_id'];
                $info['show_name'] = $res_tow['show_name'];
                $info['msg_img'] = '/boke_fanhua/images/4.jpg';
                $this->blog_user_msg->insert($info);
                if($res){
                    $this->redirect('blog_login_tow');
                }else{
                    $this->error('注册失败');
                }
            }
           
        }
        return $this->fetch();
    }
    
    public function new_blog(){//最新博文
        $blog_id = session('blog_id');
        $data = $this->article->where('article_type',1)->select()->toArray();
        // print_r($data);die;
        foreach($data as $k=>$v){//查询博文的点赞信息
            $info = $this->good_bad->where('article_id',$v['article_id'])->where('boke_id',$blog_id)->order('article_id desc')->find();
            // print_r($info);die;
            if($info==""){
                $data[$k]['gb_type'] = "";
            }else{
                $data[$k]['gb_type'] = $info['gb_type'];
            }
            
        }
        $this->assign('data',$data);
        return $this->fetch();
    }
    public function good_insert(){//点赞or踩添加
        $info = input('post.');
        $info['boke_id'] = session('blog_id');
        
        $look = $this->good_bad->where('article_id',$info['article_id'])->where('blog_id',$info['blog_id'])->where('boke_id',$info['boke_id'])->find();
        // print_r($look);die;
        if($look==""){
            if($info['gb_type']==1){
                $res = $this->good_bad->insert($info);
                return 1;
            }elseif($info['gb_type']==2){
                $res = $this->good_bad->insert($info);
                return 2;
            }
        }else{
            return 3;
        }
        
    }
    public function new_blog_tow(){//游客登录
        $data = $this->article->where('article_type',1)->select()->toArray();
        $this->assign('data',$data);
        return $this->fetch();
    }

    public function blog_list(){//博文展示
        $blog_id = session('blog_id');
        $data = $this->article->where('blog_id',$blog_id)->select()->toArray();
        $this->assign('data',$data);
        return $this->fetch();
    }

    public function blog_list_add(){//博文添加
        $data = input('post.');
        $data['blog_id'] = session('blog_id');
        $data['show_name'] = session('show_name');
        $data['issue_time'] = time();
        $data['article_type'] = 0;
        $res = $this->article->insert($data);
        if($res){
            $this->redirect('blog_list');
        }else{
            $this->error('博文发布失败');
        }
    }

    public function blog_about(){//我的评论
        $blog_id = session('blog_id');
        $id = input('id');
        if($id){
            $this->comment->where('cmt_id',$id)->delete();
        }
        // print_r($blog_id);die;
        $info = $this->blog_user_msg->where('blog_id',$blog_id)->find();//查询博主信息
        $data = $this->comment->alias('a')
        ->join('article b','a.article_id=b.article_id')
        ->join('blog_user_msg c','b.blog_id=c.blog_id')
        ->where('a.blog_id',$blog_id)
        ->where('a.cmt_type',1)
		->field('a.cmt_id,a.boke_id,b.tmp_tit,b.article_excerpt,a.cmt_time,b.show_name,a.cmt_content,b.issue_time')
        ->select()->toArray();
        $this->assign('data',$data);
        $this->assign('info',$info);
        return $this->fetch();
    }

    public function blog_collect(){//我的收藏
        $boke_id = session('blog_id');
        $data = $this->good_bad->alias('a')
        ->join('article b','a.article_id=b.article_id')
        ->where('a.boke_id',$boke_id)
        ->where('a.gb_type',1)
		->field('a.article_id,a.blog_id,a.gb_type,b.tmp_tit,b.article_excerpt,b.issue_time')
        ->select()->toArray();
        // print_r($data);die;
        $this->assign('data',$data);
        return $this->fetch();
    }
    
    //获取数据
    // public function getData()
    // {
    //     $page = input('page')?input('page'):1;  //当前页
    //     $size = 3; // 每页条数
    //     $pagesize = ($page-1)*$size; // 偏移量
    //     $total = 100;  //总条数
    //     $totalpage = ceil($totalpage/$size);// 总页数
    //     $yema = $this->getPage($totalpage);

    // }

    // 生成分页
    public function getPage($totalpage)
    {
          // 生成分页
          $str = "";
          $str .= "<ul>";
          for($i=1;$i<=$totalpage;$i++){
              // 如果i等于当前页 page
              if(i==page){
                  $str .="<li><a href='#?page=".i."' class='red'>".i."</a></li>";
              }else{
                  $str .="<li><a href='#?page=".i."'>".i."</a></li>";
              }
          };
          $str .= "</ul>";
          return $str;
    }
}