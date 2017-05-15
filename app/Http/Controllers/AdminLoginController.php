<?php

namespace App\Http\Controllers;

use Request,Session,Validator,Crypt;
use App\Http\Model\AdminModel as Admin;

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
            'user_password' => 'required|min:1',
        ]);

        if ($validator->fails()) {
            self::json_return(40001);
        }

        $name = Request::input('user_name');
        $pwd = Request::input('user_password');
        $ip=Request::getClientIp();

        $user_info = Admin::where('name',$name)->first();

        if(isset($user_info)){
        	$de_pwd = Crypt::decrypt($user_info->pwd);
        	if($pwd == $de_pwd){
				$res = Admin::updateAdmin($name,$ip);
                //登录成功
				if($res){
                    Session::put('admin', $name);
                    Session::put('admin_id', $user_info->id);
                    Session::save();
                    self::json_return(40000);
                }
				else
					self::json_return(40002);
        	}
        }
        self::json_return(40001);
    }

	public function loginOut(){
		Session::forget('admin');
		Session::forget('admin_id');
		Session::save();
		$url = route('adminLogin');
		header('Location:'.$url);
		exit;
	}
}
