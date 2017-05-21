<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    protected $table='order';

    public static function getAll($key){
        $order  = new self;
        return $order->leftJoin('user as u','u.id','=',$order->table.'.uid')
            ->where(function($q) use($key,$order){
                if($key) $q->where($order->table.'.order_id','like','%'.$key.'%')
                    ->orWhere('u.account','like','%'.$key.'%')
                    ->orWhere('u.nick','like','%'.$key.'%');
            })
            ->select($order->table.'.*','u.account','u.nick')
            ->paginate(25);
    }

    public static function change_status($id){
        $order = self::where('id',$id)->where('status',0)->first();
        $order->status = 1;
        return $order->save();
    }
}
