<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class OrderWithdrawModel extends Model
{
    protected $table='order_withdraw';

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

    //后台流水手动操作
    public static function withdrawDo($w_id,$status){
            $widtdraw_info = self::find($w_id);
            $widtdraw_info->status = $status;
            return $widtdraw_info->save();

//        $widtdraw_info = self::find($w_id);
//        $user_info = User::where('id',$widtdraw_info->user_id)->first();
//
//        if($widtdraw_info->status == $status) return false;
//        if($widtdraw_info->price > $user_info->account_cash) return false;
//
//        DB::beginTransaction();
//        //目前是驳回状态的话，不操作user表
//        if($widtdraw_info->status == 2) $rs1 = 1;
//        //如果要修改为驳回状态，不操作user表
//        else if($status==2)
//            $rs1 = 1;
//        //修改为未审核状态，需要把钱加回去
//        else if($status==0)
//            $rs1 = $user_info->where(['account_cash'=>$user_info->account_cash,'id'=>$widtdraw_info->user_id])
//                ->increment('account_cash',$widtdraw_info->price);
//        //修改为审核状态，给玩家减钱
//        else if($status==1)
//            $rs1 = $user_info->where(['account_cash'=>$user_info->account_cash,'id'=>$widtdraw_info->user_id])
//                ->decrement('account_cash',$widtdraw_info->price);
//
//        $widtdraw_info->status=$status;
//        $rs2 = $widtdraw_info->save();
//
//        if($rs1 && $rs2){
//            DB::commit();
//            return true;
//        }
//        else {
//            DB::rollback();
//            return false;
//        }
    }
}
