<?php

namespace App\Http\Controllers;

use Request,Redis,Session;
use App\Http\Model\SiteConfigModel as Site;
use App\Http\Model\BannerModel as Banner;
use App\Http\Model\ArtworkClassModel as ArtWorkClass;
use App\Http\Model\ArticleModel as Article;
use App\Http\Model\SinglePageModel as SinglePage;
use App\Http\Model\SiteFriendlinkModel as FriendLink;
use App\Http\Model\ArtworkModel as ArtWork;

class AppController extends Controller
{
    protected $site='';
    protected $banner='';
    protected $artwork_nav='';
    protected $article='';
    protected $friend_link='';
    protected $art_work_list='';
    protected $footer_nav='';

    protected $user_name = '';

    public function __construct()
    {
//        echo 'start:'.microtime(true).'<br />';
        //缓存site
        if(Redis::exists('site')){
            $this->site = json_decode(Redis::get('site'));
        }
        else {
            $this->site = Site::first();
            Redis::set('site',$this->site);
        }
        //缓存banner
        if(Redis::exists('banner')){
            $this->banner = json_decode(Redis::get('banner'));
        }
        else {
            $this->banner =Banner::where('status',1)->get();
            Redis::set('banner',$this->banner);
        }
        //缓存artwork_nav
        if(Redis::exists('artwork_nav')){
            $this->artwork_nav = json_decode(Redis::get('artwork_nav'));
        }
        else {
            $this->artwork_nav = ArtWorkClass::get();
            $this->artwork_nav = $this->list_to_array($this->artwork_nav);

            Redis::set('artwork_nav',json_encode($this->artwork_nav));
        }
        //缓存article
        if(Redis::exists('article')){
            $this->article = json_decode(Redis::get('article'));
        }
        else {
            $this->article = Article::where('status',1)->get();
            Redis::set('article',$this->article);
        }
        //缓存friend_link
        if(Redis::exists('friend_link')){
            $this->friend_link = json_decode(Redis::get('friend_link'));
        }
        else {
            $this->friend_link = FriendLink::where('status',1)->get();
            Redis::set('friend_link',$this->friend_link);
        }
        //缓存art_work_list
        if(Redis::exists('art_work_list')){
            $this->art_work_list = json_decode(Redis::get('art_work_list'));
        }
        else {
            $this->art_work_list = ArtWork::where('video','<>','')->where('status',1)->limit(4)->get();
            Redis::set('art_work_list',$this->art_work_list);
        }
        //缓存footer_nav
        if(Redis::exists('footer_nav')){
            $this->footer_nav = json_decode(Redis::get('footer_nav'));
        }
        else {
            $this->footer_nav =SinglePage::get();
            $this->footer_nav = $this->list_to_array($this->footer_nav);
            Redis::set('footer_nav',json_encode($this->footer_nav));
        }

        //登录状态
        if(Session::has('userLogin')){
            if(Session::get('userLogin')->nick != '')
                $this->user_name=Session::get('userLogin')->nick;
            else $this->user_name=Session::get('userLogin')->account;
        }
    }
    /**
     * 查询子分类
     */
    public function __destruct()
    {
        echo 'end  :'.microtime(true).'<br />';
    }
    public function position($array){
        $url = "<a href=".URL('/').">首页</a>>>";
        foreach($array as $key=>$vo){
            if($vo['url']!='#')
                $url.="<a href=".$vo['url'].">".$vo['name']."</a>>>";
            else
                $url.=$vo['name'].">>";
        }
        $url=rtrim($url,'>>');
        return $url;
    }
    public function list_to_array($list, $pid = 0)
    {
        $new_array = array();
        $middle_array = array();
        foreach ($list as $vo) {
            if ($vo['parent_id'] == $pid) {
                $middle_array = $this->list_to_array($list, $vo['id']);
                if (!empty($middle_array))
                    $vo['son'] = $middle_array;
                $new_array[] = $vo;
            }
        }
        return $new_array;
    }
}
