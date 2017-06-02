<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class BannerModel extends Model
{
    protected $table ='site_banner';

    public static function insertDo($data){
        $banner = new self;
        foreach($data as $key=>$vo){
            $banner->$key = $vo;
        }
        return $banner->save();
    }

    public static function updateDo($id,$data){
        $banner = self::find($id);
        foreach($data as $key=>$vo){
            $banner->$key = $vo;
        }
        return $banner->save();
    }
}
