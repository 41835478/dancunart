<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Model\OrderAuctionModel as OrderAuction;
class AppAuctionController extends Controller
{
    public function index(){
        $data = Request::all();
        $res = OrderAuction::getDetail($data['id']);
        $step = 0;
        foreach($res as $key=>$vo){
            if($vo->old_price > $res[$step]->old_price) $step = $key;
            $res[$key]->account = substr_replace($vo->account,"***",2,3);
            $res[$key]->nick = substr_replace($vo->nick,"***",2,3);
            $res[$key]->status = 'false';
        }
        $res[$step]->status = 'true';
        return $res;
    }
}
