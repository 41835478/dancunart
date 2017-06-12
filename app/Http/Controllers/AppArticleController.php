<?php

namespace App\Http\Controllers;

use Request,Redis;
use App\Http\Model\ArticleModel as Article;
use App\Http\Model\ArticleClassModel as ArticleClass;
class AppArticleController extends AppController
{
    public function getlist($list){
        $list=(int)$list;
        if($list<=0) abort(404);
        else{
            $site=$this->site;
            $banner=$this->banner;
            $artwork_nav=$this->artwork_nav;
            $footer_nav=$this->footer_nav;
            $user_name = $this->user_name;
            $data = Article::getAllByClass($list);
            $class_name = ArticleClass::find($list);

            $position = $this->position([['url'=>'#','name'=>$class_name->class_name]]);

            return view('App.Article.articleList',compact('site','user_name','position','banner','artwork_nav','footer_nav','data'));
        }
    }

    public function index($list=0,$id=0){
        $id=(int)$id;
        if($id<=0) abort(404);
        else{
        $site=$this->site;
        $banner=$this->banner;
        $artwork_nav=$this->artwork_nav;
        $footer_nav=$this->footer_nav;
        $user_name = $this->user_name;

        if(Redis::exists('article_'.$id)){
            $data = json_decode(Redis::get('article_'.$id));
        }
        else {
            $data = Article::getSingleWithClass($id);
            Redis::set('article_'.$id,$data);
        }

        if($data) {
            $site->title = $data->title.'|'.$site->title;
            $site->keywords = $data->keywords;
            $site->description = $data->description;

            $position = $this->position([
                ['url'=>''.url('/').'/Article/'.$data->article_class,
                    'name'=>$data->class_name],
                ['url'=>'#',
                    'name'=>'正文'],
            ]);

            return view('App.Article.article',compact('site','user_name','position','banner','artwork_nav','footer_nav','data'));
        }
        else abort(404);
        }
    }
}
