<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    /**
     * 返回json
     * @param $status
     * @param $info
     */
    public function json_return($status,$info=''){
        $data['errorno']=$status;
        $data['msg']=config('app.error_no.'.$status.'');
        if(is_array($info)){
            foreach ($info as $keys => $vo) {
                $data[$keys] = $vo;
            }
        }
        echo json_encode($data);
        unset($arr);
        exit;
    }
}
