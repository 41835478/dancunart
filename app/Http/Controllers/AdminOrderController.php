<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Model\OrderRechargeModel as Recharge;
use App\Http\Model\OrderAuchtionModel as Auchtion;
use App\Http\Model\OrderWithdrawModel as Withdraw;
class AdminOrderController extends Controller
{
    public function recharge(){
        $title = "充值记录";
        $nav   = '5-1';
        $key=Request::input('key','');

        $searchitem = [];
        if($key) $searchitem['key'] = $key;

        $data = Recharge::getAll($key);

        return view('Admin.Order.recharge',compact('title','key','nav','searchitem','data'));
    }
    public function auchtion(){
        $title = "拍卖记录";
        $nav   = '5-2';
        $key=Request::input('key','');

        $searchitem = [];
        if($key) $searchitem['key'] = $key;

        $data = Auchtion::getAll($key);

        return view('Admin.Order.auchtion',compact('title','key','nav','searchitem','data'));
    }
    public function withdraw(){
        $title = "提现管理";
        $nav   = '6-1';
        $key=Request::input('key','');

        $searchitem = [];
        if($key) $searchitem['key'] = $key;

        $data = Withdraw::getAll($key);

        return view('Admin.Order.withdraw',compact('title','key','nav','searchitem','data'));
    }

    public function withdrawhandle($id){
        $flag = Request::input('flag');
        if ($flag == 'check')
            $return = Withdraw::withdrawDo($id, 1);
        else if ($flag == 'pass')
            $return = Withdraw::withdrawDo($id, 2);
        else if ($flag == 'reset')
            $return = Withdraw::withdrawDo($id, 0);

        if($return) self::json_return(30000);
        else self::json_return(30001);
    }
}
