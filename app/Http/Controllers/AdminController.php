<?php

namespace App\Http\Controllers;

use Request,Session,URL;

class AdminController extends Controller
{
    //判断session是否存在 直接跳转
    public function __construct(){
    	if(!Session::has('admin')){
    		$url = route('adminLogin');
    		header('Location:'.$url);
    		exit;
    	}
    }

    public function index(){
        $title="首页";
        $nav="0";
        $admin_info = Admin::getAdmin(Session::get('admin'));
		return view('Admin.index',compact('title','nav','admin_info'));
    }

    public function show(){
    }
}
