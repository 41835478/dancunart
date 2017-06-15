<?php

namespace App\Http\Controllers;

use Request,DB,Session,Validator;
use App\Http\Model\OrderModel as Order;
use App\Http\Model\OrderAuctionModel as Auction;
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
    public function Auction(){
        $title = "参拍记录";
        $nav   = '5-3';
        $key=Request::input('key','');

        $searchitem = [];
        if($key) $searchitem['key'] = $key;

        $data = Auction::getAll($key);

        return view('Admin.Order.Auction',compact('title','key','nav','searchitem','data'));
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
        $res2 = Order::changeStatus($id);

        if($res1 && $res2 ) {
            DB::commit();
            self::json_return(30000);
        }

        else {
            DB::rollback();
            self::json_return(30001);
        }
    }

    public function invalid($id){
        $oid = OrderExpress::where('id',$id)->first();
        $oid = $oid->oid;
        DB::beginTransaction();
        $res1 = OrderExpress::changeStatus($id);
        $res2 = Order::InitSendFlag($oid);

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

    public function create(){
        $title = "新增发货单";
        $nav   = '5-2';
        $id = Request::input('id',0);
        $data = Order::getOne($id);
        $option = Express::showlist();
        $option_list = "<option value>请选择快递公司</option>";
        foreach($option as $key=>$vo){
            $option_list.="<option value='{$vo->express_name}'>{$vo->express_name}</option>";
        }
        return view('Admin.OrderExpress.add',compact('title','nav','option_list','data'));
    }

    public function store(){
        $data = Request::all();
        unset($data['_token']);

        $validator = Validator::make($data, [
            'uid' => 'required',
            'oid' => 'required',
            'express_name' => 'required',
            'express_no' => 'required',
        ]);

        if ($validator->fails())
            self::json_return(20001);

        $rs = OrderExpress::ExpressCount($data);
        if($rs) self::json_return(20002);

        DB::beginTransaction();
        $res1 = OrderExpress::insertDo($data);
        $res2 = Order::changeSendFlag($data['oid']);

        if($res1 && $res2) {
            DB::commit();
            self::json_return(20000);
        }
        else {
            DB::rollback();
            self::json_return(20001);
        }
    }
}
