@extends('Admin.app')
@section('content')
    <section class="rt_wrap content mCustomScrollbar">
        <div class="rt_content">
            <h1>{{$title}}</h1>

            <section>
                <form id="data">
                    <ul class="ulColumn2">
                        <li>
                            <span class="item_name" style="width:120px;">网站名称：</span>
                            <input type="text" class="textbox textbox_295" value='{{$data->title}}' name="title" datatype="*"/>
                        </li>
                        <li>
                            <span class="item_name" style="width:120px;">网站关键词：</span>
                            <input type="text" class="textbox textbox_295" value='{{$data->keywords}}' name="keywords" datatype="*"/>
                        </li>
                        <li>
                            <span class="item_name" style="width:120px;">网站描述：</span>
                            <input type="text" class="textbox textbox_295" value='{{$data->description}}' name="description" datatype="*"/>
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">网站底部版权：</span>
                            <textarea placeholder="网站底部版权" class="textarea" style="width:400px;height:80px;"
                                      name="copyright" datatype="*" errormsg="请填写！">{{$data->copyright}}</textarea>
                        </li>

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
    <script>
        $(function() {
            $("#data").Validform({
                tiptype: 3,
                ajaxPost: true,
                beforeSubmit: function () {
                    ajax_send();
                    return false;
                }
            });
            function ajax_send() {
                $.ajax({
                    url: "{{URL::to('admin/siteConfig')}}",
                    type: "post",
                    data: $("#data").serialize() + "&_token={{csrf_token()}}",
                    dataType: "json",
                    beforeSend: function () {
                        $(".loading_area").fadeIn();
                    },
                    success: function (result) {
                        if (result.errorno == 20000) {
                            $(".loading_area").fadeOut(1500);
                            showAlert(result.msg, '{{URL::to('admin/siteConfig')}}', '{{URL::to('admin/siteConfig')}}');
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