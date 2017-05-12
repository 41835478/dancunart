<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Model\ArtistClassModel as ArtistClass;

class AdminArtistClassController extends Controller
{
    public function index(){
        $title = "艺术家分类管理";
        $nav   = '2-2';
        $data = ArtistClass::get();

        return view('Admin.ArtistClass.index',compact('title','nav','data'));
    }

    public function create(){
        $title="新增艺术家分类";
        $nav   = '2-2';
        return view('Admin.ArtistClass.add',compact('title','nav'));
    }

    public function store(){
        $data = Request::all();
        unset($data['_token']);

        $res = ArtistClass::insert($data);
        if($res)
            self::json_return(20000);
        else
            self::json_return(20001);
    }

    public function edit($id){
        $title = "修改艺术家分类";
        $nav   = '2-2';
        $data = ArtistClass::find($id);

        return view('Admin.ArtistClass.edit',compact('title','data','nav','id'));
    }

    public function update($id){
        $data = Request::all();
        unset($data['_token']);

        $res = ArtistClass::where('id',$id)->update($data);
        if($res)
            self::json_return(30000);
        else
            self::json_return(30001);
    }

    public function destroy($id){
        $res = ArtistClass::where('id',$id)->delete();
        if($res)
            self::json_return(50000);
        else
            self::json_return(50001);
    }
}
