<?php

namespace App\Http\Controllers;

use Request,Validator;
use App\Http\Model\SiteConfigModel as SiteConfig;

class AdminSiteConfigController extends Controller
{
    public function index(){
        $title = "网站配置";
        $nav   = '1-1';
        $data = SiteConfig::first();

        return view('Admin.SiteConfig.index',compact('title','nav','data'));
    }

    public function store(){
        $data = Request::all();
        unset($data['_token']);

        $validator = Validator::make($data, [
            'role' => 'required'
        ]);

        if ($validator->fails())
            self::json_return(30001);

        $res = SiteConfig::where('id',1)->update($data);
        if($res) self::json_return(30000);
        else self::json_return(30001);
    }
}
