<?php

namespace App\Http\Controllers;

use Request,Session;

class AppIndexController extends AppController
{

    public function index(){
        $site = $this->site;
        $banner = $this->banner;
        $artwork_nav = $this->artwork_nav;
        $article = $this->article;
        $art_work_list = $this->art_work_list;
        $friend_link = $this->friend_link;
        $footer_nav = $this->footer_nav;
        $user_name = $this->user_name;

        echo 'end  :'.microtime(true).'<br />';
        return view('App.index',compact('site','user_name','banner','artwork_nav','article','art_work_list','friend_link','footer_nav'));
    }

}