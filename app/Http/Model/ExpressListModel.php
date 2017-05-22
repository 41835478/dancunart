<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class ExpressListModel extends Model
{
    protected $table = 'express_list';

    public static function showlist(){
        return self::where('status',1)->get();
    }

    public static function insertDo($data){
        $express = new self;
        foreach($data as $key=>$vo){
            $express->$key = $vo;
        }
        return $express->save();
    }

    public static function updateDo($id,$data){
        $express = self::where('id',$id)->first();
        foreach($data as $key=>$vo){
            $express->$key = $vo;
        }
        return $express->save();
    }
}
