<?php

namespace App\Http\Controllers;

use Request,Redis,Session;
use App\Http\Model\ArtworkModel as Artwork;
use App\Http\Model\ArtworkClassModel as ArtworkClass;
class AppArtworkController extends AppController
{
    public function getlist($list){
        $list=(int)$list;
        if($list<=0) abort(404);
        else{
            $site=$this->site;
            $banner=$this->banner;
            $artwork_nav=$this->artwork_nav;
            $footer_nav=$this->footer_nav;
            $user_name = $this->user_name;

            $data = Artwork::whereRaw('FIND_IN_SET(?,artwork_class)', [$list])->get();
            $artwork_class = ArtworkClass::getArtworkClass($list);

            if(isset($artwork_class->sonclass))
                $position = $this->position([
                    ['url'=>''.url('/').'/Artwork/'.$artwork_class->id,'name'=>$artwork_class->class_name],
                    ['url'=>'#','name'=>$artwork_class->sonclass->class_name],
                ]);
            else
                $position = $this->position([['url'=>'#','name'=>$artwork_class->class_name]]);

            return view('App.Artwork.artworkList',compact('site','user_name','position','banner','artwork_nav','footer_nav','data','list'));
        }
    }

    public function index($list=0,$id=0){

        $id=(int)$id;
        $list=(int)$list;
        if($id<=0 || $list<=0) abort(404);
        else{
            $site=$this->site;
            $banner=$this->banner;
            $artwork_nav=$this->artwork_nav;
            $footer_nav=$this->footer_nav;
            $user_name = $this->user_name;

            if(Redis::exists('artwork_'.$id)){
                $data = json_decode(Redis::get('artwork_'.$id));
            }
            else {
                $data = Artwork::getArtwork($id);
                Redis::set('artwork_'.$id,$data);
            }

            if($data) {
                $site->title = $data->name.'|'.$site->title;
                $site->keywords .= ','.$data->name;
                $site->description = $data->desc;
                $artwork_array = explode(',',$data->artwork_class);
                $position_array = [];
                //父面包屑
                foreach($artwork_nav as $key=>$vo){
                    if(in_array($vo->id,$artwork_array)){
                        array_push($position_array,['url'=>''.url('/').'/Artwork/'.$vo->id,'name'=>$vo->class_name]);
                        break;
                    }
                }
                //娃面包屑
                foreach($artwork_nav as $key=>$vo) {
                    foreach ($vo->son as $key2 => $vo2) {
                        if (in_array($vo2->id, $artwork_array)) {
                            array_push($position_array, ['url' => '' . url('/') . '/Artwork/' . $vo->id . '/' . $vo2->id, 'name' => $vo2->class_name, 'same_level' => 'true']);
                        }
                    }
                }

                $position = $this->position($position_array);
                if(Session::has('userLogin'))
                    $user_cash = Session::get('userLogin')->user_cash;
                else $user_cash=0;
                return view('App.Artwork.artwork',compact('site','user_name','user_cash','position','banner','artwork_nav','footer_nav','data'));
            }
            else abort(404);
        }
    }
}
