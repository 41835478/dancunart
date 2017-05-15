<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table='user';

    public static function insertUser($data){
        $user = new self;
        foreach($data as $key=>$vo){
            $user->$key = $vo;
        }
        if($user->save()) return $user->id;
        else return false;
    }
}
