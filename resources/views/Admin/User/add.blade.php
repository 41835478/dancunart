@extends('Admin.app')
@section('content')
    <section class="rt_wrap content mCustomScrollbar">
        <div class="rt_content">
            <h1>{{$title}}</h1>
            <section>

                <form id="data">

                    <ul class="ulColumn2">
                        <li>
                            <span class="item_name " style="width:120px;">用户账号：</span>
                            <input type="text" class="textbox textbox_295" name="account" datatype="*4-16" nullmsg="请设置账号！" errormsg="账号至少4个字符,最多16个字符！"/>
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">用户密码：</span>
                            <input type="password" class="textbox" name="pwd" datatype="*6-16" nullmsg="请设置密码！" errormsg="密码范围在6~16位之间！"/>
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">确认密码：</span>
                            <input type="password" class="textbox" datatype="*6-16" recheck="pwd" nullmsg="请再次设置密码！" errormsg="您两次输入的密码不一致！"/>
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">用户昵称：</span>
                            <input type="text" class="textbox" name="nick" datatype="*2-16" nullmsg="请设置昵称！" errormsg="昵称至少2个字符,最多16个字符！"/>
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">用户邮箱：</span>
                            <input type="text" class="textbox textbox_295" name="email" datatype="e" nullmsg="请设置邮箱！" errormsg="邮箱验证失败"/>
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">用户手机：</span>
                            <input type="text" class="textbox textbox_295" name="mob" datatype="m" nullmsg="请设置手机！" errormsg="手机验证失败"/>
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;"></span>
                            <input type="submit" class="link_btn" value="提交"/>
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
//            $(".link_btn").click(function(){
//                ajax_send();
//                return false;
//            })
            function ajax_send() {
                $.ajax({
                    url: "{{URL::to('admin/user')}}",
                    type: "post",
                    data: $("#data").serialize() + "&_token={{csrf_token()}}",
                    dataType: "json",
                    beforeSend: function () {
                        $(".loading_area").fadeIn();
                    },
                    success: function (result) {
                        if (result.errorno == 20000) {
                            $(".loading_area").fadeOut(1500);
                            showAlert(result.msg, '{{URL::to('admin/user')}}', '{{URL::to('admin/user')}}');
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