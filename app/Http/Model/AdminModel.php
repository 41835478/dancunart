<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class AdminModel extends Model
{
    protected $table = 'admin';

    //登录更新
    public static function updateAdmin($name,$ip){
        $now_user = self::where('name',$name)->first();
        $now_user->last_login_ip = $ip;
        $now_user->login_count = $now_user->login_count + 1;
        return $now_user->save();
    }

    //修改密码
    public static function changePwd($name,$new_pwd){
        $now_user = self::where('name',$name)->first();
        $now_user->pwd = $new_pwd;
        return $now_user->save();
    }

}
