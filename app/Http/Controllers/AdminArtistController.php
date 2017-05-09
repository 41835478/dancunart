<?php

namespace App\Http\Controllers;

use Request,Session,Storage,Image;
use App\Http\Model\ArtistModel as Artist;
use App\Http\Model\ArtistClassModel as ArtistClass;

class AdminArtistController extends Controller
{
    public function index(){
        $title = "艺术家管理";
        $key=Request::input('key','');

        $searchitem = [];
        if($key) $searchitem['key'] = $key;

        $data = Artist::paginate(25);
        $artist_class = ArtistClass::get();

        foreach($data as $key=>$vo){
            $self_class = explode(',',$data[$key]['art_class']);

            foreach($self_class as $key2=>$vo2){
                foreach($artist_class as $key3=>$vo3){
                    if($vo2 == $key3) $data[$key]['art_class_name'] .= $artist_class[$key3]['class_name'].' ';
                }
            }
        }

        return view('Admin.Artist.index',compact('title','key','searchitem','data'));
    }
    public function upload(){
        $file = Request::file('file');
        if ($file->isValid()) {
            // 获取文件相关信息
            $originalName = $file->getClientOriginalName(); // 文件原名
            $ext = $file->getClientOriginalExtension();     // 扩展名
            $realPath = $file->getRealPath();   //临时文件的绝对路径
            $type = $file->getClientMimeType();     // image/jpeg

            // 上传文件
            $filename = date('H-i-s') . '-' . uniqid() . '.' . $ext;
            $filename_thumb =  'thumb-'.date('H-i-s') . '-' . uniqid() . '.' . $ext;
            // 使用我们新建的uploads本地存储空间（目录）
            Storage::disk('uploads')->put($filename, file_get_contents($realPath));
        }

        $img = Image::make('uploads/'.date('Y').'/'.date('m').'_'.date('d').'/'.$filename);
        $img->resize(100, 100);
        $img->save('uploads/'.date('Y').'/'.date('m').'_'.date('d').'/'.$filename_thumb);

        echo json_encode(array(
            'name'=> 'uploads/'.date('Y').'/'.date('m').'_'.date('d').'/'.$filename,
            'name_thumb'  => 'uploads/'.date('Y').'/'.date('m').'_'.date('d').'/'.$filename_thumb
        ));
    }

    public function create(){
        $title="新增艺术家";
        $artist_class = ArtistClass::get();
        $artist_class_list='';
        foreach($artist_class as $vo){
            $artist_class_list .="<input type='checkbox' name='artist_class[{$vo->id}]' value='{$vo->id}'>{$vo->class_name}</input>   &nbsp;&nbsp;&nbsp;&nbsp;";
        }
        return view('Admin.Artist.add',compact('title','artist_class_list'));
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
}
