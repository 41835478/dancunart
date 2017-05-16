<?php

namespace App\Http\Controllers;

use Request,DB,Session,Validator;
use App\Http\Model\UserAttentionModel as Attention;

class AppUserController extends Controller
{
    public function attention($status=-1,$id=0){
        $data['status'] = $status;
        $data['id'] = $id;
        $data['uid'] = 1;

        $validator = Validator::make($data, [
            'status' => 'boolean',
            'id'=> 'numeric|min:1'
        ]);

        if ($validator->fails())
            self::json_return(20001);

        if(Attention::insertAttention($data))
            self::json_return(20000);
        else
            self::json_return(20001);

    }
}
