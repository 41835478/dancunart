<?php

namespace App\Http\Controllers;

use Request,Validator;
use App\Http\Model\SiteCSRModel as CSR;
class AdminCSRController extends Controller
{
    public function index(){
        $title = "客服管理";
        $nav   = '1-4';
        $data = CSR::get();

        return view('Admin.CSR.index',compact('title','nav','data'));
    }

    public function create(){
        $title="新增客服";
        $nav   = '1-4';
        return view('Admin.CSR.add',compact('title','nav'));
    }

    public function store(){
        $data = Request::all();
        unset($data['_token']);

        $validator = Validator::make($data, [
            'name' => 'required',
            'qq'=> 'numeric',
            'mob' => 'required',
            'rank' => 'numeric',
            'status'=>'boolean'
        ]);
        if ($validator->fails()) {
            self::json_return(20001);
        }

        $res = CSR::insertDo($data);
        if($res)
            self::json_return(20000);
        else
            self::json_return(20001);
    }

    public function edit($id){
        $title = "修改客服";
        $nav   = '1-4';
        $data = CSR::find($id);

        return view('Admin.CSR.edit',compact('title','data','nav','id'));
    }

    public function update($id){
        $data = Request::all();
        unset($data['_token']);

        $validator = Validator::make($data, [
            'name' => 'required',
            'qq'=> 'numeric',
            'mob' => 'required',
            'rank' => 'numeric',
            'status'=>'boolean'
        ]);
        if ($validator->fails()) {
            self::json_return(30001);
        }

        $res = CSR::updateDo($id,$data);
        if($res)
            self::json_return(30000);
        else
            self::json_return(30001);
    }

    public function destroy($id){
        $res = CSR::where('id',$id)->delete();
        if($res)
            self::json_return(50000);
        else
            self::json_return(50001);
    }
}
