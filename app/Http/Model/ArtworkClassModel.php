<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class ArtworkClassModel extends Model
{
    protected $table ='art_artwork_class';
    public $timestamps = false;

    public static function getArtworkClass($id){
        $class = self::where('id',$id)->first();

        if($class->parent_id==0)
            return $class;
        else{
            $p_class = self::where('id',$class->parent_id)->first();
            $p_class->sonclass = $class;
            return $p_class;
        }
    }
}
