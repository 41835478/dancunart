<?php

namespace App\Http\Controllers;

use Request,DB,Session;
use App\Http\Model\OrderModel as Order;
use App\Http\Model\OrderAuchtionModel as Auchtion;
use App\Http\Model\OrderWithdrawModel as Withdraw;
use App\Http\Model\UserLogModel as UserLog;
use App\Http\Model\OrderExpressModel as OrderExpress;
use App\Http\Model\ExpressListModel as Express;
class AdminOrderController extends Controller
{
    public function order(){
        $title = "订单列表";
        $nav   = '5-1';
        $key=Request::input('key','');

        $searchitem = [];
        if($key) $searchitem['key'] = $key;

        $data = Order::getAll($key);

        return view('Admin.Order.index',compact('title','key','nav','searchitem','data'));
    }
    public function auchtion(){
        $title = "参拍记录";
        $nav   = '5-3';
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

    //--------订单物流相关操作
    public function index(){
        $title = "发货单列表";
        $nav   = '5-2';
        $key=Request::input('key','');

        $searchitem = [];
        if($key) $searchitem['key'] = $key;

        $data = OrderExpress::getAll($key);

        return view('Admin.OrderExpress.index',compact('title','key','nav','searchitem','data'));
    }

    public function edit($id){
        $title = "新增发货单";
        $nav   = '5-2';
        $data = Order::getOne($id);
        $option = Express::showlist();
        $option_list = "<option value>请选择快递公司</option>";
        foreach($option as $key=>$vo){
            $option_list.="<option value='{$vo->id}'>{$vo->express_name}</option>";
        }
        return view('Admin.OrderExpress.add',compact('title','nav','option_list','data'));
    }
}
