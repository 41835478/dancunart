<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class ArtworkModel extends Model
{
    protected $table = 'art_artwork';

    public static function insertDo($data){
        $artwork = new self;
        foreach($data as $key=>$vo){
            $artwork->$key = $vo;
        }
        return $artwork->save();
    }

    public static function updateDo($id,$data){
        $artwork = self::find($id);
        foreach($data as $key=>$vo){
            $artwork->$key = $vo;
        }
        return $artwork->save();
    }
}
