<?php

namespace App\Http\Controllers;

use Request,Session,Storage,Image;
use App\Http\Model\ArtistModel as Artist;
use App\Http\Model\ArtworkModel as Artwork;
use App\Http\Model\ArtworkClassModel as ArtworkClass;

class AdminArtWorkController extends Controller
{
    public function index(){
        $title = "拍品列表";
        $nav   = '3-1';
        $key=Request::input('key','');

        $searchitem = [];
        if($key) $searchitem['key'] = $key;
        $data = Artwork::paginate(25);

        $artist = Artist::get();
        foreach($data as $key=>$vo){
            $self_class = explode(',',$data[$key]['artist']);
            foreach($artist as $key2=>$vo2){
                if(in_array($vo2->id,$self_class))
                    $data[$key]['artist_list'] .= $vo2->name.' ';
            }
        }

        $artwork_class = ArtworkClass::get();
        foreach($data as $key=>$vo){
            $self_class = explode(',',$data[$key]['art_class']);
            foreach($artwork_class as $key2=>$vo2){
                if(in_array($vo2->id,$self_class))
                    $data[$key]['artwork_class_list'] .= $vo2->class_name.' ';
            }
        }

        return view('Admin.Artwork.index',compact('title','key','nav','searchitem','data'));
    }

    public function create(){
        $title = "新增拍品";
        $nav   = '3-1';

        $artwork_class = ArtworkClass::get();
        $artwork_class_list='';
        foreach($artwork_class as $vo){
            $artwork_class_list .="<input type='checkbox' name='artwork_class[{$vo->id}]' value='{$vo->id}'>{$vo->class_name}</input>   &nbsp;&nbsp;&nbsp;&nbsp;";
        }

        $artist = Artist::get();
        $artist_list='';
        foreach($artist as $vo){
            $artist_list .="<input type='checkbox' name='artist[{$vo->id}]' value='{$vo->id}'>{$vo->name}({$vo->nick})</input>   &nbsp;&nbsp;&nbsp;&nbsp;";
        }

        return view('Admin.Artwork.add',compact('title','nav','artist_list','artwork_class_list'));
    }

    public function store(){
        $data = Request::all();

        $data['art_class']=implode(',',$data['artwork_class']);
        $data['artist']=implode(',',$data['artist']);

        unset($data['_token']);
        unset($data['artwork_class']);

        $res = Artwork::insert($data);
        if($res)
            self::json_return(20000);
        else
            self::json_return(20001);
    }

    public function edit($id){
        $title = "修改拍品";
        $nav   = '3-1';
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
