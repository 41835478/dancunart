<?php

namespace App\Http\Controllers;

use Request,Storage,Image;

class AdminUploadController extends Controller
{
    public function upload(){
        $file = Request::file('file');
        if ($file->isValid()) {
            // 获取文件相关信息
            $originalName = $file->getClientOriginalName(); // 文件原名
            $ext = $file->getClientOriginalExtension();     // 扩展名
            $realPath = $file->getRealPath();   //临时文件的绝对路径
            $type = $file->getClientMimeType();     // image/jpeg

            // 上传文件
            $filename = date('H-i-s') . '-' . uniqid() . '.' . $ext;
            $filename_thumb =  'thumb-'.date('H-i-s') . '-' . uniqid() . '.' . $ext;
            // 使用我们新建的uploads本地存储空间（目录）
            Storage::disk('uploads')->put($filename, file_get_contents($realPath));
        }

        $img = Image::make('uploads/'.date('Y').'/'.date('m').'_'.date('d').'/'.$filename);
        $img->resize(100, 100);
        $img->save('uploads/'.date('Y').'/'.date('m').'_'.date('d').'/'.$filename_thumb);

        echo json_encode(array(
            'name'=> 'uploads/'.date('Y').'/'.date('m').'_'.date('d').'/'.$filename,
            'name_thumb'  => 'uploads/'.date('Y').'/'.date('m').'_'.date('d').'/'.$filename_thumb
        ));
    }
}
