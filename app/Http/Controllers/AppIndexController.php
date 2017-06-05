<?php

namespace App\Http\Controllers;

use Request,Redis;
use App\Http\Model\SiteConfigModel as Site;
use App\Http\Model\BannerModel as Banner;
use App\Http\Model\ArtworkClassModel as ArtWorkClass;
use App\Http\Model\ArticleModel as Article;
use App\Http\Model\SinglePageModel as SinglePage;
use App\Http\Model\SiteFriendlinkModel as FriendLink;
use App\Http\Model\ArtworkModel as ArtWork;
class AppIndexController extends Controller
{

    public function index(){
        echo 'start:'.microtime(true).'<br />';
        //缓存site
        if(Redis::exists('site') && in_array('site',config('app.redis_array_cache'))){
            $site = json_decode(Redis::get('site'));
        }
        else {
            $site = Site::first();
            Redis::set('site',$site);
        }

        //缓存banner
        if(Redis::exists('banner') && in_array('banner',config('app.redis_array_cache')) ){
            $banner = json_decode(Redis::get('banner'));
        }
        else {
            $banner =Banner::where('status',1)->get();
            Redis::set('banner',$banner);
        }

        //缓存artwork_nav
        if(Redis::exists('artwork_nav') && in_array('artwork_nav',config('app.redis_array_cache'))){
            $artwork_nav = json_decode(Redis::get('artwork_nav'));
        }
        else {
            $artwork_nav = ArtWorkClass::get();
            $artwork_nav = $this->list_to_array($artwork_nav);

            Redis::set('artwork_nav',json_encode($artwork_nav));
        }

        //缓存article
        if(Redis::exists('article') && in_array('article',config('app.redis_array_cache'))){
            $article = json_decode(Redis::get('article'));
        }
        else {
            $article = Article::where('status',1)->get();
            Redis::set('article',$article);
        }

        //缓存friend_link
        if(Redis::exists('friend_link') && in_array('friend_link',config('app.redis_array_cache'))){
            $friend_link = json_decode(Redis::get('friend_link'));
        }
        else {
            $friend_link = FriendLink::where('status',1)->get();
            Redis::set('friend_link',$friend_link);
        }

        //缓存art_work_list
        if(Redis::exists('art_work_list') && in_array('art_work_list',config('app.redis_array_cache'))){
            $art_work_list = json_decode(Redis::get('art_work_list'));
        }
        else {
            $art_work_list = ArtWork::where('video','<>','')->where('status',1)->limit(4)->get();
            Redis::set('art_work_list',$art_work_list);
        }

        //缓存footer_nav
        if(Redis::exists('footer_nav') && in_array('footer_nav',config('app.redis_array_cache'))){
            $footer_nav = json_decode(Redis::get('footer_nav'));
        }
        else {
            $footer_nav =SinglePage::get();
            $footer_nav = $this->list_to_array($footer_nav);
            Redis::set('footer_nav',json_encode($footer_nav));
        }

        echo 'end  :'.microtime(true).'<br />';

        return view('App.index',compact('site','banner','artwork_nav','article','art_work_list','friend_link','footer_nav'));
    }

    /**
     * 查询子分类
     */
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