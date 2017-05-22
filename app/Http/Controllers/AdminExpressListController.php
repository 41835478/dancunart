<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Model\ExpressListModel as Express;

class AdminExpressListController extends Controller
{
    public function index(){
        $title = "快递公司管理";
        $nav   = '1-5';
        $data = Express::get();

        return view('Admin.ExpressList.index',compact('title','nav','data'));
    }

    public function create(){
        $title="新增快递公司";
        $nav   = '1-5';
        return view('Admin.ExpressList.add',compact('title','nav'));
    }
    public function store(){
        $data = Request::all();
        unset($data['_token']);

        $res = Express::insertDo($data);
        if($res)
            self::json_return(20000);
        else
            self::json_return(20001);
    }

    public function edit($id){
        $title = "修改快递公司";
        $nav   = '1-5';
        $data = Express::find($id);

        return view('Admin.ExpressList.edit',compact('title','data','nav','id'));
    }
    public function update($id){
        $data = Request::all();
        unset($data['_token']);

        $res = Express::updateDo($id,$data);
        if($res)
            self::json_return(30000);
        else
            self::json_return(30001);
    }

    public function destroy($id){
        $res = Express::where('id',$id)->delete();
        if($res)
            self::json_return(50000);
        else
            self::json_return(50001);
    }


}
