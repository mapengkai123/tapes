<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Session;
header("content-type:text/html;charset=utf8");
class Index extends Controller
{
    public function index()
    {
    	return view('login');
    }
    /**
     * 用户注册
     * @return [type] [description]
     */
    public function reg(){
    	$data=$_POST;
    	$user=$data['user'];
    	$passwd=md5($data['passwd']);
    	$qq=$data['qq'];
    	$db=Db::table('a_user')->where('username',$user)->find();
    	if($db){
    		echo "<script>alert('用户名已存在')</script>";
    		header('refresh:0.1; ../index');die;
    	}else{
	    	$arr = [
		    	['username' => $user, 'pwd' => $passwd,'qq'=>$qq]   
			];
			$re=Db::name('a_user')->insertAll($arr);
			if($re){
				return view('index');
			} 
    	}

    }
    /**
     *
     * 登录
     * @return [type] [description]
     */
    public function login(){
    	$date=$_POST;
    	$username=$date['username'];
    	 $pwd=md5($date['pwd']);
    	 if($username){
            $res= DB::table('a_user')->where('username',$username)->find();
            // print_r($res);die;
            if($res){
                if($pwd==$res['pwd']){
                	Session::set('username',$username);
                 	// echo Session::get('username');die;
//                    $request->session()->put('key', 'value');
                    return view('index');
                }else{
                    echo "<script>alert('密码错误');</script>";
                    header('refresh:0.1;../index');die;
                }
            }else{
                echo "<script>alert('账号错误');</script>";
                header('refresh:0.1;../index');
            }
        }else{
            echo "<script>alert('请输入账号');</script>";
            header('refresh:0.1;../index');
        }
    	 
    }
}
