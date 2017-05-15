<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class UserLogModel extends Model
{
    protected  $table="user_log";
    public static function insertLog($uid,$action,$admin_id){
        $userlog = new self;
        $userlog->uid = $uid;
        $userlog->action = $action;
        $userlog->admin_id = $admin_id;
        return $userlog->save();
    }
    public static function showAll($key){
        $_this = new self;
        return self::leftJoin('user','user.id','=',$_this->table.'.uid')
            ->leftJoin('admin','admin.id','=',$_this->table.'.admin_id')
            ->where(function($q) use($key){
                if($key) $q->where('user.account','like','%'.$key.'%')
                            ->orwhere('user.nick','like','%'.$key.'%');
                })
            ->select($_this->table.'.*','user.account','user.nick','admin.nick as anick')
            ->paginate(25);
    }


}
