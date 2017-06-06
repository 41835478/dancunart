<?php

namespace App\Http\Controllers;

use Request,Redis,Captcha,Session;
use App\Http\Model\SiteConfigModel as Site;

class AppPassportController extends Controller
{
    public function index(){
        //缓存site
        if(Redis::exists('site') && in_array('site',config('app.redis_array_cache'))){
            $site = json_decode(Redis::get('site'));
        }
        else {
            $site = Site::first();
            Redis::set('site',$site);
        }
        $banner = json_decode(Redis::get('banner'));
        $footer_nav  = json_decode(Redis::get('footer_nav'));

        return view('App.Passport.index',compact('site','banner','footer_nav'));
    }

    public function captcha(){
//        Session::flash('captcha','abcde');

        $builder = new Captcha;
        $builder->build($width = 120, $height = 30, $font = null);
        Session::flash('captcha', $builder->getPhrase());
        header("Cache-Control: no-cache, must-revalidate");
        header('Content-type: image/jpeg');
        $builder->output();
    }

    //检测验证码
    public function checkCaptcha($captcha){

        if(Session::has('captcha') && Session::get('captcha') == $captcha){
            return 1;
        }
        else return 0;
    }

    public function create(){

    }
}
