<?php

namespace App\Http\Controllers;

use Request,Redis;
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
        if($id<=0) abort(404);
        else{
            $site=$this->site;
            $banner=$this->banner;
            $artwork_nav=$this->artwork_nav;
            $footer_nav=$this->footer_nav;
            $user_name = $this->user_name;

            if(Redis::exists('article_'.$id)){
                $data = json_decode(Redis::get('article_'.$id));
            }
            else {
                $data = Article::getSingleWithClass($id);
                Redis::set('article_'.$id,$data);
            }

            if($data) {
                $site->title = $data->title.'|'.$site->title;
                $site->keywords = $data->keywords;
                $site->description = $data->description;

                $position = $this->position([
                    ['url'=>''.url('/').'/Article/'.$data->article_class,
                        'name'=>$data->class_name],
                    ['url'=>'#',
                        'name'=>'正文'],
                ]);

                return view('App.Article.article',compact('site','user_name','position','banner','artwork_nav','footer_nav','data'));
            }
            else abort(404);
        }
    }
}
