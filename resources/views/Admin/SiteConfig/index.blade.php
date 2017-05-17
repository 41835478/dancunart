@extends('Admin.app')
@section('content')
    <section class="rt_wrap content mCustomScrollbar">
        <div class="rt_content">
            <h1>{{$title}}</h1>

            <section>
                <form id="data">
                    <ul class="ulColumn2">

                        <li>
                            <span class="item_name" style="width:120px;">兑换规则：</span>
                            <textarea placeholder="网站兑换规则" class="textarea" style="width:400px;height:80px;"
                                      name="role" datatype="*" nullmsg="请填写规则！" errormsg="请填写规则！">{{$data->role}}</textarea>
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