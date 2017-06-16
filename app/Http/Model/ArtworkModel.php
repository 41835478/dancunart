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
        $artwork->save();
        return $artwork->id;
    }

    public static function updateDo($id,$data){
        $artwork = self::find($id);
        foreach($data as $key=>$vo){
            $artwork->$key = $vo;
        }
        $artwork->save();
        return $artwork->id;
    }

    public static function getArtwork($id){
        return self::where('id',$id)
            ->where('status',1)
            ->first();
    }

    public static function getArtworkByArtist($id){
        return self::whereRaw('FIND_IN_SET(?,artist)', [$id])
            ->where('status',1)
            ->paginate(25);
    }
}
