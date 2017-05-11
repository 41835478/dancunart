<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Model\ArtistModel as Artist;
use App\Http\Model\ArtistClassModel as ArtistClass;

class AdminArtistController extends Controller
{
    public function index(){
        $title = "艺术家管理";
        $nav   = '2-1';
        $key=Request::input('key','');

        $searchitem = [];
        if($key) $searchitem['key'] = $key;

        $data = Artist::paginate(25);
        $artist_class = ArtistClass::get();

        foreach($data as $key=>$vo){
            $self_class = explode(',',$data[$key]['art_class']);
            foreach($artist_class as $key2=>$vo2){
                if(in_array($vo2->id,$self_class))
                    $data[$key]['art_class_name'] .= $vo2->class_name.' ';
            }
        }

        return view('Admin.Artist.index',compact('title','key','nav','searchitem','data'));
    }

    public function create(){
        $title="新增艺术家";
        $nav   = '2-1';
        $artist_class = ArtistClass::get();
        $artist_class_list='';
        foreach($artist_class as $vo){
            $artist_class_list .="<input type='checkbox' name='artist_class[{$vo->id}]' value='{$vo->id}'>{$vo->class_name}</input>   &nbsp;&nbsp;&nbsp;&nbsp;";
        }
        return view('Admin.Artist.add',compact('title','nav','artist_class_list'));
    }

    public function store(){
        $data = Request::all();

        $data['art_class']=implode(',',$data['artist_class']);
        unset($data['_token']);
        unset($data['artist_class']);

        $res = Artist::insert($data);
        if($res)
            self::json_return(20000);
        else
            self::json_return(20001);
    }

    public function edit($id){
        $title = "修改艺术家";
        $nav   = '2-1';
        $data = Artist::find($id);
        $data['art_class']=explode(',',$data['art_class']);

        $artist_class = ArtistClass::get();
        $artist_class_list='';
        foreach($artist_class as $vo){
            $flag = '';
            if(in_array($vo->id,$data['art_class'])) $flag='checked';
            $artist_class_list .="<input type='checkbox' $flag name='artist_class[{$vo->id}]' value='{$vo->id}'>{$vo->class_name}</input>   &nbsp;&nbsp;&nbsp;&nbsp;";
        }
        return view('Admin.Artist.edit',compact('title','data','nav','id','artist_class_list'));
    }

    public function update($id){
        $data = Request::all();
        $data['art_class']=implode(',',$data['artist_class']);
        unset($data['_token']);
        unset($data['artist_class']);

        $res = Artist::where('id',$id)->update($data);
        if($res)
            self::json_return(30000);
        else
            self::json_return(30001);
    }

    public function destroy($id){
        $res = Artist::where('id',$id)->delete();
        if($res)
            self::json_return(50000);
        else
            self::json_return(50001);
    }
}
