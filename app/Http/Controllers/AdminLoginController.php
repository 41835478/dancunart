<?php

namespace App\Http\Controllers;

use Request,Session,Validator,Crypt;
use App\Http\Model\AdminLoginModel;

class AdminLoginController extends Controller
{

	public function login(){

		//有session直接跳转到后台主页面
		if(Session::has('admin')){
			header('Location:../admin');
			exit;
		}
		return view('Admin.login');
    }

    public function loginCheck(){
        $validator = Validator::make(Request::all(), [
            'user_name' => 'required|max:255',
            'user_password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return self::json_return(40001);
        }

        $name = Request::input('user_name');
        $pwd = Request::input('user_password');
        $ip=Request::getClientIp();


        $user_info = Admin::getAdmin($name);
        if(isset($user_info)){
        	$md5_pwd = md5($user_info->salt.$pwd);
        	if($user_info->pwd == $md5_pwd){
        		Session::put('admin', $name);
                Session::save();
				$res = Admin::updateAdmin($name,$ip);
				if($res)
					echo self::json_return(0,'登录成功');
				else
					echo self::json_return(10002,'数据连接异常，请重试');
        	}
        	else 
        		echo self::json_return(10001,'账号或密码错误');
        	exit;
        }
        	echo self::json_return(10001,'账号或密码错误');
        exit;
    }

	public function loginOut(){
		Session::forget('admin');
		Session::save();
		$url = route('adminLogin');
		header('Location:'.$url);
		exit;
	}
}
