<?php

namespace App\Http\Controllers;

use Request,DB;
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
        foreach($data as $key0=>$vo){
            $self_class = explode(',',$data[$key0]['artist']);
            foreach($artist as $key2=>$vo2){
                if(in_array($vo2->id,$self_class))
                    $data[$key0]['artist_list'] .= $vo2->name.' ';
            }
        }

        $artwork_class = ArtworkClass::get();
        foreach($data as $key0=>$vo){
            $self_class = explode(',',$data[$key0]['artwork_class']);
            foreach($artwork_class as $key2=>$vo2){
                if(in_array($vo2->id,$self_class))
                    $data[$key0]['artwork_class_list'] .= $vo2->class_name.' ';
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
        unset($data['_token']);
        unset($data['artwork_class']);

        DB::beginTransaction();
            //给相关艺术家新增关联
            $res1 = Artist::whereIn('id',$data['artist'])->increment('artwork_count');

            $data['artwork_class']=implode(',',$data['artwork_class']);
            $data['artist']=implode(',',$data['artist']);
            $res2 = Artwork::insert($data);

        if($res1 && $res2){
            DB::commit();
            self::json_return(20000);
        }
        else{
            DB::rollBack();
            self::json_return(20001);
        }
    }

    public function edit($id){
        $title = "修改拍品";
        $nav   = '3-1';
        $data = Artwork::find($id);
        //所属艺术家
        $data['artist']=explode(',',$data['artist']);
        $artist_list = Artist::get();
        $artist_list_html='';
        foreach($artist_list as $vo){
            $flag = '';
            if(in_array($vo->id,$data['artist'])) $flag='checked';
            $artist_list_html .="<input type='checkbox' $flag name='artist[{$vo->id}]' value='{$vo->id}'>{$vo->name}($vo->nick)</input>   &nbsp;&nbsp;&nbsp;&nbsp;";
        }

        //拍品分类
        $data['artwork_class']=explode(',',$data['artwork_class']);
        $artwork_list = ArtworkClass::get();

        $artwork_class_html='';
        foreach($artwork_list as $vo){
            $flag = '';
            if(in_array($vo->id,$data['artwork_class'])) $flag='checked';
            $artwork_class_html .="<input type='checkbox' $flag name='artwork_class[{$vo->id}]' value='{$vo->id}'>{$vo->class_name}</input>   &nbsp;&nbsp;&nbsp;&nbsp;";
        }
        return view('Admin.Artwork.edit',compact('title','data','nav','id','artist_list_html','artwork_class_html'));
    }

    public function update($id){
        $data = Request::all();
        unset($data['_token']);
        $data['artist'] = array_values($data['artist']);
        $artist = Artwork::where('id',$id)->pluck('artist')->toarray();

        DB::beginTransaction();
            //艺术家有变动
            if(explode(',',$artist[0]) != $data['artist']){
                //老艺术家们减数据
                $res1 = Artist::whereIn('id',explode(',',$artist[0]))->decrement('artwork_count');
                //新艺术家们加数据
                $res2 = Artist::whereIn('id',$data['artist'])->increment('artwork_count');
            }
            else {$res1 = 1 ; $res2 = 1;}

            $data['artist']=implode(',',$data['artist']);
            $data['artwork_class']=implode(',',$data['artwork_class']);
            $res3 = Artwork::where('id',$id)->update($data);

        if($res1 && $res2 && $res3){
            DB::commit();
            self::json_return(30000);
        }
        else{
            DB::rollBack();
            self::json_return(30001);
        }
    }

    public function destroy($id){
        $artist = Artwork::where('id',$id)->pluck('artist')->toarray();
        DB::beginTransaction();
            //老艺术家们减数据
            $res1 = Artist::whereIn('id',explode(',',$artist[0]))->decrement('artwork_count');
            $res2 = Artwork::where('id',$id)->delete();
        if($res1 && $res2) {
            DB::commit();
            self::json_return(50000);
        }
        else{
            DB::rollBack();
            self::json_return(50001);
        }
    }
}
