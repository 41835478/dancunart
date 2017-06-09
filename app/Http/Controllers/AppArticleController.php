<?php

namespace App\Http\Controllers;

use Request,Redis;
use App\Http\Model\ArticleModel as Article;
use App\Http\Model\ArticleClassModel as ArticleClass;
class AppArticleController extends AppController
{
    public function getlist($list){
        $page = Request::input('page',1);
        $list=(int)$list;
        if($list<=0) abort(404);
        else{
            $site=$this->site;
            $banner=$this->banner;
            $artwork_nav=$this->artwork_nav;
            $footer_nav=$this->footer_nav;
            $user_name = $this->user_name;

//            if(Redis::exists('article_list_'.$list.'_page_'.$page)){
//                $data = json_decode(Redis::get('article_list_'.$list.'_page_'.$page));
//            }
//            else {
//                $data = Article::getAllWithClass($list);
//                Redis::set('article_list_'.$list.'_page_'.$page,json_encode($data));
//            }

            $data = Article::getAllWithClass($list);
            $data2=Redis::set('article_list_'.$list.'_page_'.$page,json_encode($data));
            dd($data,$data2);
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
            $position = "<a href=".URL('/').">首页</a>>><a href=".URL('/').">$data->class_name</a>";
            echo 'end  :'.microtime(true).'<br />';
            return view('App.article',compact('site','user_name','position','banner','artwork_nav','footer_nav','data'));
        }
        else abort(404);
        }
    }
}
