<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class SinglePageModel extends Model
{
    protected $table='single_page';

    public static function insertDo($data){
        $sp = new self;
        foreach($data as $key=>$vo){
            $sp->$key = $vo;
        }
        return $sp->save();
    }

    public static function updateDo($id,$data){
        $sp = self::find($id);
        foreach($data as $key=>$vo){
            $sp->$key = $vo;
        }
        return $sp->save();
    }
}
