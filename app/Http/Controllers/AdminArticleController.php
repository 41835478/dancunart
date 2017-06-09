<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Model\ArticleModel as Article;
use App\Http\Model\ArticleClassModel as ArticleClass;
class AdminArticleController extends Controller
{
    public function index(){
        $title = '文章列表';
        $nav = '8-1';
        $key=Request::input('key','');

        $searchitem = [];
        if($key) $searchitem['key'] = $key;

        $data = Article::getAll($key);

        $class_list = ArticleClass::get();

        foreach($data as $keys=>$vo){
            $self_class = explode(',',$data[$keys]['article_class']);
            foreach($class_list as $key2=>$vo2){
                if(in_array($vo2->id,$self_class))
                    $data[$keys]['article_class_name'] .= $vo2->class_name.' ';
            }
        }

        return view('Admin.Article.index',compact('title','nav','key','searchitem','data'));
    }

    public function create(){
        $title = '新增文章';
        $nav = '8-1';
        $article_class = ArticleClass::get();
        $article_class_list='';
        foreach($article_class as $vo){
            $article_class_list .="<input type='radio' name='article_class' value='{$vo->id}' datatype='*' errormsg='请选择！'>{$vo->class_name}</input>   &nbsp;&nbsp;&nbsp;&nbsp;";
        }
        return view('Admin.Article.add',compact('title','nav','data','article_class_list'));
    }

    public function store(){
        $data = Request::all();
        unset($data['_token']);

        $res = Article::insertDo($data);
        if($res)
            self::json_return(20000);
        else
            self::json_return(20001);
    }

    public function edit($id){
        $title = "修改文章";
        $nav   = '8-1';
        $data = Article::find($id);

        $class_list = ArticleClass::get();
        $article_class_list='';
        foreach($class_list as $vo){
            $flag = '';
            if($vo->id==$data['article_class']) $flag='checked';
            $article_class_list .="<input type='radio' $flag name='article_class' value='{$vo->id}'>{$vo->class_name}</input>   &nbsp;&nbsp;&nbsp;&nbsp;";
        }
        return view('Admin.Article.edit',compact('title','data','nav','id','article_class_list'));
    }

    public function update($id){
        $data = Request::all();
        unset($data['_token']);

        $res = Article::updateDo($id,$data);
        if($res)
            self::json_return(30000);
        else
            self::json_return(30001);
    }

    public function destroy($id){
        $res = Article::where('id',$id)->delete();
        if($res)
            self::json_return(50000);
        else
            self::json_return(50001);
    }


}
