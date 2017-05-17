<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class SiteFriendlinkModel extends Model
{
    protected  $table = 'site_friendlink';

    public static function insert_do($data){
        $friendlink = new self;
        foreach($data as $key=>$vo){
            $friendlink->$key = $vo;
        }
        return $friendlink->save();
    }

    public static function update_do($id,$data){
        $friendlink = self::find($id);
        foreach($data as $key=>$vo){
            $friendlink->$key = $vo;
        }

        return $friendlink->save();
    }
}
