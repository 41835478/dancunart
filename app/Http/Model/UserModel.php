<?php

namespace App\Http\Model;

use DB;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table='user';

    public static function getAllUser($key){
        $user = new self;
        return $user->leftJoin('user_attention as ua','ua.uid','=',$user->table.'.id')
                ->where(function($q) use($key,$user){
                    if($key) $q->where($user->table.'.account','like','%'.$key.'%')
                    ->orwhere($user->table.'.nick','like','%'.$key.'%');
                })
                ->select($user->table.'.*',DB::raw('count(ua.id) as attention'))
                ->groupby($user->table.'.account')
                ->paginate(25);
    }

    public static function insertUser($data){
        $user = new self;
        foreach($data as $key=>$vo){
            $user->$key = $vo;
        }
        if($user->save()) return $user->id;
        else return false;
    }
}
