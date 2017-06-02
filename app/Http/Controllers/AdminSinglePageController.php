<?php

namespace App\Http\Controllers;

use Request,URL,DB;
use App\Http\Model\SinglePageModel as SinglePage;
class AdminSinglePageController extends Controller
{
    public function index(){
        $title = "单页管理";
        $nav   = '1-3';
        $data = SinglePage::get();

        $new_array = $this->list_to_array($data);
        $data = $this->list_to_html($new_array);
        return view('Admin.SinglePage.index',compact('title','nav','data'));
    }

    public function create(){
        $title="新增顶级单页";
        $nav   = '1-3';
        $pid = Request::input('pid',0);
        return view('Admin.SinglePage.add',compact('title','nav','pid'));
    }

    public function store(){
        $data = Request::all();
        unset($data['_token']);

        $res = SinglePage::insertDo($data);
        if($res)
            self::json_return(20000);
        else
            self::json_return(20001);
    }

    public function edit($id){
        $title = "修改单页内容";
        $nav   = '1-3';
        $data = SinglePage::find($id);

        return view('Admin.SinglePage.edit',compact('title','data','nav','id'));
    }

    public function update($id){
        $data = Request::all();
        unset($data['_token']);

        $res = SinglePage::updateDo($id,$data);
        if($res)
            self::json_return(30000);
        else
            self::json_return(30001);
    }

    public function destroy($id){
        $foo = SinglePage::find($id);
        DB::beginTransaction();
        $res1 = SinglePage::where('id',$id)->delete();
        if($foo->parent_id==0)
            $res2 = SinglePage::where('parent_id',$id)->delete();
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
                    $vo->page_name = $prefix . '|----&nbsp;' . $vo->page_name;
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
            $html .= $vo->page_name;
            $html .= "</td><td>";
            $html .= $vo->created_at;
            $html .= "</td><td>";
            $html .= $vo->updated_at;
            $html .= "</td><td>";
            $html .= "<a href='" . URL::to('admin/singlePage') . "/" . $vo->id . "/edit'>修改</a>";
            $html .= "<a href='javascript:;' onClick='isdelete(" . $vo->id . ")'>删除</a>";
            if($vo->parent_id==0)
                $html .= "<a href='" . URL::to('admin/singlePage/create') . "?pid=" . $vo->id . "'>新增子页</a>";
            $html .= "</td></tr>";

            if (is_array($vo->son)) {
                $html .= $this->list_to_html($vo->son);
            }
        }

        return $html;
    }

}
