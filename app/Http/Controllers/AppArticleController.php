<?php

namespace App\Http\Controllers;

use Request,Redis;
use App\Http\Model\ArticleModel as Article;
class AppArticleController extends AppController
{
    public function index($id=0){
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
            $data = Article::where('status',1)->find($id);
            Redis::set('article_'.$id,$data);
        }

        if($data) {
            $site->title = $data->title.'|'.$site->title;
            $site->keywords = $data->keywords;
            $site->description = $data->description;

            echo 'end  :'.microtime(true).'<br />';
            return view('App.article',compact('site','user_name','banner','artwork_nav','footer_nav','data'));
        }
        else abort(404);
        }
    }
}
