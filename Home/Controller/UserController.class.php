<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
    //登录
    public function login(){
        if (!IS_POST) {
             $this->display();
        }else{
            if($this->checkyzm( I('post.yzm') )) {
                $username = I('post.username');
                $user = D('User')->where("username='$username'")->find();
                // var_dump($user);exit;
                //判断用户密码
                if(md5(I('post.password').$user['salt']) === $user['password']) {
                    //设置cookie
                    cookie('username',$user['username']);
                    //设置加盐的cookie
                    cookie('coode',md5($user['username'].C('SALT')));
                    $this->redirect('/');//跳转到index.html
            }else{
                echo "用户名或者密码错误!";
            }
            
        }
    }    
 }


    public function msg(){
        $this->display();    
    }

    //用户注册功能
    public function reg(){
        if (!IS_POST) {
            $this->display();
        }else{
            $usermodel = D('User');
            //验证
            if (!$usermodel->create()) {
                echo $usermodel->getError();
            }else{
                $yan = $this->yan();
                //面对对象赋值,加入数据库
                $usermodel->password = md5($usermodel->password.$yan);
                $usermodel->salt = $yan;
                if ($usermodel->add()) {
                    $this->redirect('Home/User/login');
                }
            }
        }
            
    }

    //密码盐,好吃又健康
    public function yan(){
        return mt_rand(1000,9999);
    }

    //验证码
    public function yzm(){
    	$v =  new \Think\Verify();//实例化
    	$v ->imageW = 150;	//设置宽
    	$v ->imageH = 40;	//设置高
        $v->fontSize = 20;   //字体大小
        $v->length = 4;//设置验证码字数
        $v->useNoise = false;//斑点
        $v->useCurve = false;//干扰线
        $v->entry();//验证码输出

    }
    //验证码验证在login中调用
    public function checkyzm($yzm){
    	$v =  new \Think\Verify();//实例化
    	if($v->check($yzm)){
    		return true;
    	}else{
    		echo "验证码错误!";
            exit();
    	}
    }


    public function logout(){
        cookie('username',null);
        cookie('coode',null);
        $this->redirect('/');
    }


}