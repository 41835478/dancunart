<?php

namespace App\Http\Controllers;

use Request,Validator,Crypt;
use App\Http\Model\UserModel as User;

class AdminUserController extends Controller
{
    public function index(){
        $title = "用户管理";
        $nav   = '4-1';
        $key=Request::input('key','');

        $searchitem = [];
        if($key) $searchitem['key'] = $key;

        $data = User::where(function($q) use ($key){
            if($key) $q->where('account','like','%'.$key.'%')
                ->orwhere('nick','like','%'.$key.'%');
        })->paginate(25);

        return view('Admin.User.index',compact('title','key','nav','searchitem','data'));
    }

    public function create(){
        $title="新增用户";
        $nav   = '2-1';
        return view('Admin.User.bbb',compact('title','nav'));
    }

    public function store(){
//        $validator = Validator::make(Request::all(), [
//            'pwd' => 'required|min:6',
//        ]);
//        if ($validator->fails()) {
//            self::json_return(30001);
//        }
//        $de_pwd = Crypt::encrypt(Request::input('pwd'));
//        $res = Admin::changePwd(Session::get('admin'),$de_pwd);
    }
}
