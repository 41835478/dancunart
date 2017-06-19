<?php

namespace App\Http\Controllers;

use Request,Redis;
use App\Http\Model\SinglePageModel as Single;
class AppSingleController extends AppController
{
    public function index($id=0){
        $id=(int)$id;
        if($id<=0) abort(404);
        else{
            $site=$this->site;
            $banner=$this->banner;
            $artwork_nav=$this->artwork_nav;
            $footer_nav=$this->footer_nav;
            $user_name = $this->user_name;

            if(Redis::exists('single_'.$id)){
                $data = json_decode(Redis::get('single_'.$id));
            }
            else {
                $data = Single::find($id);
                Redis::set('single_'.$id,$data);
            }

            if($data) {
                $site->title = $data->page_name.'|'.$site->title;

                $position = $this->position([
                    ['url'=>'#',
                        'name'=>$data->page_name],
                ]);

                return view('App.single',compact('site','user_name','position','banner','artwork_nav','footer_nav','data'));
            }
            else abort(404);
        }
    }
}
