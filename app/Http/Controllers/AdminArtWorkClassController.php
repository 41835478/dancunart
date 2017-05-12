<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Model\ArtworkClassModel as ArtWorkClass;

class AdminArtWorkClassController extends Controller
{
    public function index(){
        $title = "拍品分类管理";
        $nav   = '3-2';
        $data = ArtWorkClass::get();

        return view('Admin.ArtworkClass.index',compact('title','nav','data'));
    }

    public function create(){
        $title="新增拍品分类";
        $nav   = '3-2';
        return view('Admin.ArtworkClass.add',compact('title','nav'));
    }

    public function store(){
        $data = Request::all();
        unset($data['_token']);

        $res = ArtWorkClass::insert($data);
        if($res)
            self::json_return(20000);
        else
            self::json_return(20001);
    }

    public function edit($id){
        $title = "修改拍品分类";
        $nav   = '3-2';
        $data = ArtWorkClass::find($id);

        return view('Admin.ArtworkClass.edit',compact('title','data','nav','id'));
    }

    public function update($id){
        $data = Request::all();
        unset($data['_token']);

        $res = ArtWorkClass::where('id',$id)->update($data);
        if($res)
            self::json_return(30000);
        else
            self::json_return(30001);
    }

    public function destroy($id){
        $res = ArtWorkClass::where('id',$id)->delete();
        if($res)
            self::json_return(50000);
        else
            self::json_return(50001);
    }
}
