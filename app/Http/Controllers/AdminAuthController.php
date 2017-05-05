<?php

namespace App\Http\Controllers;

use Request,Session,Validator,Crypt;
use App\Http\Model\AdminModel as Admin;

class AdminAuthController extends Controller
{
    //管理员修改个人信息
    public function index(){
        $title = "修改我的信息";
        $data = Admin::where('name',Session::get('admin'))->first();
        return view('Admin.Auth.index',compact('title','data'));
    }

    public function store(){
        $validator = Validator::make(Request::all(), [
            'pwd' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            self::json_return(30001);
        }

        $de_pwd = Crypt::encrypt(Request::input('pwd'));
        $res = Admin::changePwd(Session::get('admin'),$de_pwd);
        if($res){
            Session::forget('admin');
            Session::save();
            self::json_return(30000);
        }
        else
            self::json_return(30001);
    }
}
