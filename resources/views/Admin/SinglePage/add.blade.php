@extends('Admin.app')
@section('content')
    <section class="rt_wrap content mCustomScrollbar">
        <div class="rt_content">
            <h1>{{$title}}</h1>

            <section>
                <form id="data">
                    <ul class="ulColumn2">
                        <input type="hidden" name="parent_id" value="{{$pid}}" />
                        <li>
                            <span class="item_name" style="width:120px;">单页名称：</span>
                            <input type="text" class="textbox textbox_295" name="page_name" datatype="*" errormsg="名称不能为空！"/>
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">单页展示内容：</span>
                        </li>

                        <div style="margin:0px 5%;">
                            <script id="container" name="content" type="text/plain" style="width:100%;height:500px;"></script>
                        </div>

                        <li>
                            <span class="item_name" style="width:120px;"></span>
                            <input type="submit" class="link_btn" id="link_btn" value="提交"/>
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

        function ajax_send() {
            $.ajax({
                url: "{{URL::to('admin/singlePage')}}",
                type: "post",
                data: $("#data").serialize() + "&_token={{csrf_token()}}",
                dataType: "json",
                beforeSend: function () {
                    $(".loading_area").fadeIn();
                },
                success: function (result) {
                    if (result.errorno == 20000) {
                        $(".loading_area").fadeOut(1500);
                        showAlert(result.msg, '{{URL::to('admin/singlePage')}}', '{{URL::to('admin/singlePage')}}');
                    }
                    else {
                        $(".loading_area").fadeOut(1500);
                        showAlert(result.msg, '', '');
                    }
                }
            })
        }

        })
    </script>

    </body>
    </html>
@endsection