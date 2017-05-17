<?php

namespace App\Http\Controllers;

use Request,Validator;
use App\Http\Model\SiteFriendlinkModel as  Friendlink;

class AdminSiteFriendlinkController extends Controller
{
    public function index(){
        $title = "友情链接";
        $nav   = '1-2';
        $data = Friendlink::get();

        return view('Admin.Friendlink.index',compact('title','nav','data'));
    }

    public function create(){
        $title="新增友情";
        $nav   = '1-2';
        return view('Admin.Friendlink.add',compact('title','nav'));
    }

    public function store(){
        $data = Request::all();
        unset($data['_token']);

        $validator = Validator::make($data, [
            'link_name' => 'required',
            'link_img'=> 'required',
            'link_url' => 'required',
            'rank' => 'numeric',
            'status'=>'numeric'
        ]);
        if ($validator->fails()) {
            self::json_return(20001);
        }
        $res = Friendlink::insert_do($data);
        if($res) self::json_return(20000);
        else self::json_return(20001);
    }

    public function edit($id){
        $title = '修改友情';
        $nav   = '1-2';
        $data = Friendlink::find($id);
        return view('Admin.Friendlink.edit',compact('title','data','nav'));
    }

    public function update($id){
        $data = Request::all();
        unset($data['_token']);

        $validator = Validator::make($data, [
            'link_name' => 'required',
            'link_img'=> 'required',
            'link_url' => 'required',
            'rank' => 'numeric',
            'status'=>'numeric'
        ]);
        if ($validator->fails()) {
            self::json_return(30001);
        }

        $res = Friendlink::update_do($id,$data);
        if($res) self::json_return(30000);
        else self::json_return(30001);
    }

    public function destroy($id){
        if(Friendlink::where('id',$id)->delete())
            self::json_return(50000);
        else
            self::json_return(50001);
    }

}
