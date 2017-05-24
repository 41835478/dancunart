<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class SiteCSRModel extends Model
{
    protected $table="site_CSR";

    public static function insertDo($data){
        $CSR = new self;
        foreach($data as $key=>$vo){
            $CSR->$key=$vo;
        }
        return $CSR->save();
    }

    public static function updateDo($id,$data){
        $CSR = self::where('id',$id)->first();
        foreach($data as $key=>$vo){
            $CSR->$key=$vo;
        }
        return $CSR->save();
    }
}
