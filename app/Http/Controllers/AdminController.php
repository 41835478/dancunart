<?php

namespace App\Http\Controllers;

use Request,Session,URL,Route;
use App\Http\Model\AdminModel as Admin;

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
        $nav = 0 ;
        $data = Admin::where('name',Session::get('admin'))->first();
		return view('Admin.index',compact('title','nav','data'));
    }
}
