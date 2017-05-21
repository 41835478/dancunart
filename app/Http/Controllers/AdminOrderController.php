<?php

namespace App\Http\Controllers;

use Request,DB,Session;
use App\Http\Model\OrderModel as Order;
use App\Http\Model\OrderAuchtionModel as Auchtion;
use App\Http\Model\OrderWithdrawModel as Withdraw;
use App\Http\Model\UserLogModel as UserLog;
class AdminOrderController extends Controller
{
    public function index(){
        $title = "订单列表";
        $nav   = '5-1';
        $key=Request::input('key','');

        $searchitem = [];
        if($key) $searchitem['key'] = $key;

        $data = Order::getAll($key);

        return view('Admin.Order.index',compact('title','key','nav','searchitem','data'));
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

    public function orderhandle($id){
        $admin_id=Session::get('admin_id');
        $order_info = Order::find($id);
        $action  = "修改用户订单 ".$order_info->order_id." 状态为 已支付 （".($order_info->pay_money/100)." 元）";

        DB::beginTransaction();
        $res1 = UserLog::insertLog($order_info->uid,$action,$admin_id);
        $res2 = Order::change_status($id);

        if($res1 && $res2 ) {
            DB::commit();
            self::json_return(30000);
        }

        else {
            DB::rollback();
            self::json_return(30001);
        }
    }
}
