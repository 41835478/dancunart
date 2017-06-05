@extends('Admin.app')
@section('content')
    <section class="rt_wrap content mCustomScrollbar">
        <div class="rt_content">
            <h1>{{$title}}</h1>

            <section>
                <form id="data">
                    <ul class="ulColumn2">
                        <li>
                            <span class="item_name" style="width:120px;">文章名称：</span>
                            <input type="text" class="textbox textbox_295" name="title" datatype="*" errormsg="名称不能为空！"/>
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">文章关键词：</span>
                            <input type="text" class="textbox textbox_295" name="keywords" /> &nbsp;&nbsp;&nbsp;&nbsp;请用逗号（,）隔开
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;display: block;float: left;">描述：</span>
                            <textarea placeholder="文章描述" class="textarea" style="width:400px;height:80px;" name="description"></textarea>
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">文章分类：</span>
                                {!!$article_class_list!!}
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">文章浏览次数：</span>
                            <input type="text" class="textbox textbox_295" value="{{mt_rand(50,150)}}"  datatype="n" errormsg="请填写数字" name="view_count" />
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">是否头条：</span>
                            <label class="single_selection"><input type="radio" name="flag"   value='1'/>头条</label>
                            <label class="single_selection"><input type="radio" name="flag"  datatype="*" errormsg="请选择！" checked='true' value='0'/>非头条</label>
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">是否上架展示：</span>
                            <label class="single_selection"><input type="radio" name="status"  checked='true' value='1'/>上架展示</label>
                            <label class="single_selection"><input type="radio" name="status"  datatype="*" errormsg="请选择！" value='0'/>不上架</label>
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">文章内容：</span>
                        </li>

                        <div style="margin:0px 5%;">
                            <script id="container" name="content" type="text/plain" style="width:100%;height:500px;"></script>
                        </div>

                        <li>
                            <span class="item_name" style="width:120px;"></span>
                            <input type="submit" class="link_btn"  value="提交"/>
                        </li>
                    </ul>
                </form>
            </section>

        </div>
    </section>
@endsection
@section('footer')
    <link href="{{asset('umeditor/themes/default/_css/umeditor.css')}}" type="text/css" rel="stylesheet">
    <script type="text/javascript" src="{{asset('umeditor/third-party/template.min.js')}}"></script>
    <script type="text/javascript" charset="utf-8" src="{{asset('umeditor/umeditor.config.js')}}"></script>
    <script type="text/javascript" charset="utf-8" src="{{asset('umeditor/editor_api.js')}}"></script>
    <script type="text/javascript" src="{{asset('umeditor/lang/zh-cn/zh-cn.js')}}"></script>

    <script>

        //编辑器相关
        var um = UM.getEditor('container');

        $(function() {
            var demo = $("#data").Validform({
                tiptype: 3,
                ajaxPost: true,
                beforeSubmit: function () {
                    ajax_send();
                    return false;
                }
            });
            function ajax_send(){
                $.ajax({
                    url  : "{{URL::to('admin/article')}}",
                    type : "post",
                    data : $("#data").serialize()+"&_token={{csrf_token()}}",
                    dataType: "json",
                    beforeSend:function(){
                        $(".loading_area").fadeIn();
                    },
                    success:function(result){
                        if(result.errorno==20000){
                            $(".loading_area").fadeOut(1500);
                            showAlert(result.msg,'{{URL::to('admin/article')}}','{{URL::to('admin/article')}}');
                        }
                        else {
                            $(".loading_area").fadeOut(1500);
                            showAlert(result.msg,'','');
                        }
                    }
                })
            }
        })

    </script>

    </body>
    </html>
@endsection