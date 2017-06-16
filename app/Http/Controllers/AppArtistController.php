<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Model\ArtistModel as Artist;
use App\Http\Model\ArtworkModel as Artwork;
class AppArtistController extends AppController
{
    public function index(){
        $site=$this->site;
        $banner=$this->banner;
        $artwork_nav=$this->artwork_nav;
        $footer_nav=$this->footer_nav;
        $user_name = $this->user_name;
        $data = Artist::getAll();

        $position = $this->position([
            ['url'=>'#',
                'name'=>'艺术家'],
        ]);

        return view('App.Artist.index',compact('site','user_name','position','banner','artwork_nav','footer_nav','data'));
    }
    public function getlist(){
        return view('App.Artist.list');
    }
    public function getdetail($id){
        $site=$this->site;
        $banner=$this->banner;
        $artwork_nav=$this->artwork_nav;
        $footer_nav=$this->footer_nav;
        $user_name = $this->user_name;
        $base_info = Artist::getDetail($id);
        $art_info = Artwork::getArtworkByArtist($id);

        foreach($art_info as $key=>$vo){
            $artwork_array = explode(',',$vo->artwork_class);
            foreach($artwork_nav as $key2=>$vo2){
                if(in_array($vo2->id,$artwork_array)){
                    $art_info[$key]->single_art_class = $vo2->id;
                    break;
                }
            }
        }

        $position = $this->position([
            ['url'=>'#',
                'name'=>'艺术家'],
        ]);

        return view('App.Artist.detail',compact('site','user_name','position','banner','artwork_nav','footer_nav','base_info','art_info'));
    }
}
