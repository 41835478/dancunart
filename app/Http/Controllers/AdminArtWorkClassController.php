<?php

namespace App\Http\Controllers;

use Request,URL,DB;
use App\Http\Model\ArtworkClassModel as ArtWorkClass;

class AdminArtWorkClassController extends Controller
{
    public function index(){
        $title = "拍品分类管理";
        $nav   = '3-2';
        $data = ArtWorkClass::get();
        $new_array = $this->list_to_array($data);
        $data = $this->list_to_html($new_array);

        return view('Admin.ArtworkClass.index',compact('title','nav','data','aaa'));
    }

    public function create(){
        $title="新增拍品分类";
        $nav   = '3-2';
        $pid = Request::input('pid',0);
        return view('Admin.ArtworkClass.add',compact('title','nav','pid'));
    }

    public function store(){
        $data = Request::all();
        unset($data['_token']);

        $res = ArtWorkClass::insert($data);
        if($res)
            self::json_return(20000);
        else
            self::json_return(20001);
    }

    public function edit($id){
        $title = "修改拍品分类";
        $nav   = '3-2';
        $data = ArtWorkClass::find($id);

        return view('Admin.ArtworkClass.edit',compact('title','data','nav','id'));
    }

    public function update($id){
        $data = Request::all();
        unset($data['_token']);

        $res = ArtWorkClass::where('id',$id)->update($data);
        if($res)
            self::json_return(30000);
        else
            self::json_return(30001);
    }

    public function destroy($id){
        $foo = ArtWorkClass::find($id);
        DB::beginTransaction();
        $res1 = ArtWorkClass::where('id',$id)->delete();
        if($foo->parent_id==0)
            $res2 = ArtWorkClass::where('parent_id',$id)->delete();
        else $res2 = 1;

        if($res1 && $res2){
            DB::commit();
            self::json_return(50000);
        }
        else{
            DB::rollBack();
            self::json_return(50001);
        }
    }

    /**
     * 查询子分类
     */
    public function list_to_array($list, $pid = 0, $prefix = '&nbsp;&nbsp;')
    {
        $new_array = array();
        $middle_array = array();
        foreach ($list as $vo) {
            if ($vo['parent_id'] == $pid) {
                $middle_array = $this->list_to_array($list, $vo['id'], $prefix . '&nbsp;&nbsp;&nbsp;&nbsp;');
                if (!empty($middle_array))
                    $vo['son'] = $middle_array;

                if ($pid > 0)
                    $vo->class_name = $prefix . '|----&nbsp;' . $vo->class_name;
                $new_array[] = $vo;
            }
        }
        return $new_array;
    }

    /*
     * 递归转换成html
     */
    public function list_to_html($list)
    {
        $html = '';

        foreach ($list as $key => $vo) {
            $html .= "<tr><td>";
            $html .= $vo->id;
            $html .= "</td><td>";
            $html .= $vo->class_name;
            $html .= "</td><td>";
            if($vo->status)
                $html .= '展示';
            else $html .= '不展示';
            $html .= "</td><td>";
            $html .= "<a href='" . URL::to('admin/artworkclass') . "/" . $vo->id . "/edit'>修改</a>";
            $html .= "<a href='javascript:;' onClick='isdelete(" . $vo->id . ")'>删除</a>";
            if($vo->parent_id==0)
                $html .= "<a href='" . URL::to('admin/artworkclass/create') . "?pid=" . $vo->id . "'>新增子分类</a>";
            $html .= "</td></tr>";

            if (is_array($vo->son)) {
                $html .= $this->list_to_html($vo->son);
            }
        }

        return $html;
    }

}
