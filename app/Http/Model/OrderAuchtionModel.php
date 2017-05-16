<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class OrderAuchtionModel extends Model
{
    protected $table='order_auction';

    public static function getAll($key){
        $order  = new self;
        return $order->leftJoin('user as u','u.id','=',$order->table.'.uid')
                ->leftJoin('art_artwork as aw','aw.id','=',$order->table.'.artwork_id')
                ->where(function($q) use($key,$order){
                    if($key) $q->where($order->table.'.order_id','like','%'.$key.'%')
                        ->orWhere('u.account','like','%'.$key.'%')
                        ->orWhere('u.nick','like','%'.$key.'%');
                })
                ->select($order->table.'.*','u.account','u.nick','aw.name')
                ->paginate(25);
    }
}
