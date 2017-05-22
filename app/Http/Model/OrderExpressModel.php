<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class OrderExpressModel extends Model
{
    protected  $table  = 'order_express';

    public static function getAll($key){
        $order  = new self;
        return $order->leftJoin('user as u','u.id','=',$order->table.'.uid')
                    ->leftJoin('order as o','o.id','=',$order->table.'.oid')
                    ->leftJoin('user_address as a','a.id','=','o.address_id')
            ->where(function($q) use($key,$order){
                if($key) $q->where('o.order_id','like','%'.$key.'%')
                    ->orWhere('u.account','like','%'.$key.'%')
                    ->orWhere('u.nick','like','%'.$key.'%');
            })
            ->select($order->table.'.*','u.account','u.nick','o.updated_at as buy_time','a.province','a.city','a.area','a.detail','a.consignor','a.mob','a.remark')
            ->paginate(25);
    }
}
