<?php

namespace App\Http\Controllers;

use Request,Validator,Crypt,Session,DB;
use App\Http\Model\UserModel as User;
use App\Http\Model\UserLogModel as UserLog;

class AdminUserController extends Controller
{
    public function index(){
        $title = "用户管理";
        $nav   = '4-1';
        $key=Request::input('key','');

        $searchitem = [];
        if($key) $searchitem['key'] = $key;

        $data = User::getAllUser($key);

        return view('Admin.User.index',compact('title','key','nav','searchitem','data'));
    }

    public function create(){
        $title="新增用户";
        $nav   = '4-1';
        return view('Admin.User.add',compact('title','nav'));
    }

    public function store(){
        $data = Request::all();
        unset($data['_token']);

        $validator = Validator::make($data, [
            'account' => 'required|min:4|max:16',
            'nick'=> 'required|min:2|max:16',
            'pwd' => 'required|min:6',
            'email' => 'email',
            'mob'=>'regex:/^1[34578][0-9]{9}$/'
        ]);
        if ($validator->fails()) {
            self::json_return(20001);
        }

        $data['pwd'] = Crypt::encrypt($data['pwd']);

        DB::beginTransaction();
        $uid = User::insertUser($data);
        $res = $this->updateLog($uid,'新增用户');
        if($uid && $res){
            DB::commit();
            self::json_return(20000);
        }
        else{
            DB::rollBack();
            self::json_return(20001);
        }

    }

    public function edit($id){
        $title = '用户修改';
        $nav   = '4-1';
        $data = User::find($id);
        return view('Admin.User.edit',compact('title','data','nav'));
    }

    public function update($id){
        $data = Request::all();
        unset($data['_token']);

        $validator = Validator::make($data, [
            'account' => 'required|min:4|max:16',
            'nick'=> 'required|min:2|max:16',
            'email' => 'email',
            'mob'=>'regex:/^1[34578][0-9]{9}$/'
        ]);
        if ($validator->fails()) {
            self::json_return(30001);
        }

        $action = '';
        $old_info = User::find($id);
        //找出更新的是 account nick email mob
        $action .= ($old_info->account != $data['account']) ? '账户由 \''.$old_info->account.'\'更替为 '.$data['account'].' ' : '';
        $action .= ($old_info->nick != $data['nick']) ? '昵称由 \''.$old_info->nick.'\'更替为 '.$data['nick'].' ' : '';
        $action .= ($old_info->email != $data['email']) ? '邮箱由 \''.$old_info->email.'\'更替为 '.$data['email'].' ' : '';
        $action .= ($old_info->mob != $data['mob']) ? '电话由 \''.$old_info->mob.'\'更替为 '.$data['mob'].' ' : '';


        DB::beginTransaction();
        $res1 = User::where('id',$id)->update($data);
        $res2 = $this->updateLog($id,$action);

        if($res1 && $res2){
            DB::commit();
            self::json_return(30000);
        }
        else{
            DB::rollBack();
            self::json_return(30001);
        }
    }

    public function userlog(){

        $title = "用户操作日志管理";
        $nav   = '7-1';
        $key=Request::input('key','');

        $searchitem = [];
        if($key) $searchitem['key'] = $key;

        $data = UserLog::showAll($key);

        return view('Admin.User.log',compact('title','key','nav','searchitem','data'));

    }

    public function updateLog($uid,$action){
        $admin_id=Session::get('admin_id');
        return UserLog::insertLog($uid,$action,$admin_id);
    }

    public function accountset($id,$nav){
        $userinfo = DB::table('user')->where('id',$id)->first();
        $data = DB::table('user_accountset')->where('uid',$id)->get();

        $title = $userinfo->account.'('.$userinfo->nick.') 收款账户';
        $nav   = $nav;
        return view('Admin.User.accountset',compact('title','nav','data'));
    }
}
