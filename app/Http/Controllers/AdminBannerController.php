<?php

namespace App\Http\Controllers;

use Request,URL;
use App\Http\Model\BannerModel as Banner;

class AdminBannerController extends Controller
{
    public function index(){
        $title = "banner管理";
        $nav   = '1-6';
        $data = Banner::get();

        return view('Admin.Banner.index',compact('title','nav','data'));
    }

    public function create(){
        $title="新增banner";
        $nav   = '1-6';
        return view('Admin.Banner.add',compact('title','nav'));
    }

    public function store(){
        $data = Request::all();
        unset($data['_token']);

        $res = Banner::insertDo($data);
        if($res)
            self::json_return(20000);
        else
            self::json_return(20001);
    }

    public function edit($id){
        $title = "修改banner";
        $nav   = '1-6';
        $data = Banner::find($id);

        return view('Admin.Banner.edit',compact('title','data','nav','id'));
    }

    public function update($id){
        $data = Request::all();
        unset($data['_token']);

        $res = Banner::updateDo($id,$data);
        if($res)
            self::json_return(30000);
        else
            self::json_return(30001);
    }

    public function destroy($id){
        $res = Banner::where('id',$id)->delete();
        if($res)
            self::json_return(50000);
        else
            self::json_return(50001);
    }
}
