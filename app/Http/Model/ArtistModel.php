<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class ArtistModel extends Model
{
    protected $table = 'art_artist';

    public static function getAll(){
        return self::where('status',1)->paginate(25);
    }

    public static function getDetail($id){
        return self::where('id',$id)->first();
    }
}
