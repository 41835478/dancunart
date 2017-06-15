<?php

namespace App\Http\Controllers;

use Request,Redis,Captcha,Session,Validator,Crypt,URL;
use App\Http\Model\SiteConfigModel as Site;
use App\Http\Model\UserModel as User;
class AppPassportController extends AppController
{
    public function login(){
        $site=$this->site;
        $footer_nav=$this->footer_nav;
        $redirect = Request::input('redirect','/');
        return view('App.Passport.login',compact('site','redirect','footer_nav'));
    }

    public function loginOut(){
        $redirect = Request::input('redirect','/');
        Session::forget('userLogin');
        Session::save();
        header('Location:'.URL(''.$redirect.''));
        exit;
    }

    public function register(){
        $site=$this->site;
        $footer_nav=$this->footer_nav;
        $redirect = Request::input('redirect','/');
        return view('App.Passport.register',compact('site','redirect','footer_nav'));
    }

    public function captcha($width=120,$height=30){
        $builder = new Captcha;
        $builder->build($width,$height,$font = null);
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

    public function postLogin(){
        $data = Request::all();

        if($data['status']=='account'){
            $validator = Validator::make($data, [
                'account' => 'required|min:3',
                'password' => 'required|min:6'
            ]);

            if ($validator->fails()) self::json_return(40002);

            $user_info = User::login_get($data['account']);
            if(empty($user_info)) self::json_return(40001);
            $de_pwd = Crypt::decrypt($user_info->pwd);

            if($de_pwd==$data['password']){
                Session::put('userLogin',$user_info);
                Session::save();
                self::json_return(40000);
            }

            else
                self::json_return(40001);
        }
        else if($data['status']=='mob'){
            $validator = Validator::make($data, [
                'account' => 'regex:/^1[34578]\d{9}$/',
                'vercode'=> 'required|min:6|max:6'
            ]);

            if ($validator->fails()) self::json_return(40002);

            $user_info = User::where('mob',$data['account'])->first();
            if(empty($user_info)) self::json_return(40001);
            //leee 需要短信验证码 验证

            if(Session::has('vercode') && Session::get('vercode')==$data['vercode']){
                Session::put('userLogin',$user_info);
                Session::save();
                self::json_return(40000);
            }
            else
                self::json_return(40001);
        }
        else self::json_return(40002);
    }
    public function postRegister(){
        $data = Request::all();
        $validator = Validator::make($data, [
            'account' => 'regex:/^1[34578]\d{9}$/',
            'vercode'=> 'required|min:6|max:6',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) self::json_return(70002);
        //leee 验证短信验证码
        $res = User::register($data['account'],Crypt::encrypt($data['password']));
        if($res){
            $user_info = User::login_get($data['account']);
            Session::put('userLogin',$user_info);
            Session::save();
            self::json_return(70000);
        }
        else
            self::json_return(70001);
    }
}
