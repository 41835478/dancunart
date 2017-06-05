<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Model\ArticleClassModel as ArticleClass;
class AdminArticleClassController extends Controller
{
    public function index(){
        $title = '文章分类';
        $nav = '8-2';
        $data = ArticleClass::get();
        return view('Admin.ArticleClass.index',compact('title','nav','data'));
    }

    public function create(){
        $title="新增文章分类";
        $nav   = '8-2';
        return view('Admin.ArticleClass.add',compact('title','nav'));
    }

    public function store(){
        $data = Request::all();
        unset($data['_token']);

        $res = ArticleClass::insert($data);
        if($res)
            self::json_return(20000);
        else
            self::json_return(20001);
    }

    public function edit($id){
        $title = "修改文章分类";
        $nav   = '8-2';
        $data = ArticleClass::find($id);

        return view('Admin.ArticleClass.edit',compact('title','data','nav','id'));
    }

    public function update($id){
        $data = Request::all();
        unset($data['_token']);

        $res = ArticleClass::where('id',$id)->update($data);
        if($res)
            self::json_return(30000);
        else
            self::json_return(30001);
    }

    public function destroy($id){
        $res = ArticleClass::where('id',$id)->delete();
        if($res)
            self::json_return(50000);
        else
            self::json_return(50001);
    }
}
