<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class UserAttentionModel extends Model
{
    protected $table='user_attention';

    public static function insertAttention($data){
        $attention = new self;
        $attention->uid = $data['uid'];
        $attention->status = $data['status'];
        if($data['status'])
            $attention->aid = $data['id'];
        else
            $attention->artwork = $data['id'];

        return $attention->save();
    }
}
