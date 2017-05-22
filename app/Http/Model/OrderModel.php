<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    protected $table='order';

    public static function getAll($key){
        $order  = new self;
        return $order->leftJoin('user as u','u.id','=',$order->table.'.uid')
                ->leftJoin('art_artwork as a','a.id','=',$order->table.'.artwork_id')
            ->where(function($q) use($key,$order){
                if($key) $q->where($order->table.'.order_id','like','%'.$key.'%')
                    ->orWhere('u.account','like','%'.$key.'%')
                    ->orWhere('u.nick','like','%'.$key.'%');
            })
            ->select($order->table.'.*','u.account','u.nick','a.name as artwork_name')
            ->paginate(25);
    }

    public static function getOne($id){
        $order  = new self;

        return $order->leftJoin('user as u','u.id','=',$order->table.'.uid')
            ->leftJoin('art_artwork as a','a.id','=',$order->table.'.artwork_id')
            ->leftJoin('user_address as ad','ad.id','=',$order->table.'.address_id')
            ->where($order->table.'.id',$id)
            ->select($order->table.'.*','u.account','u.nick','a.name as artwork_name','ad.province','ad.city','ad.area','ad.detail','ad.consignor','ad.mob','ad.remark')
            ->first();
    }

    public static function change_status($id){
        $order = self::where('id',$id)->where('status',0)->first();
        $order->status = 1;
        return $order->save();
    }
}
