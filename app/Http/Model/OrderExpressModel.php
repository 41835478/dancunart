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
            ->orderby($order->table.'.id','desc')
            ->select($order->table.'.*','u.account','u.nick','o.order_id','o.send_flag','o.updated_at as buy_time','a.province','a.city','a.area','a.detail','a.consignor','a.mob','a.remark')
            ->paginate(25);
    }

    public static function ExpressCount($data){
        return self::where('uid',$data['uid'])
            ->where('oid',$data['oid'])
            ->where('status',0)
            ->count();
    }

    public static function insertDo($data){
        $express = new self;

        foreach($data as $key=>$vo){
            $express->$key=$vo;
        }
        return $express->save();
    }

    public static function changeStatus($id){
        $foo  = self::where('id',$id)->where('status',0)->first();

        if($foo){
            $foo->status=1;
            return $foo->save();
        }
        else
            return false;
    }

}
