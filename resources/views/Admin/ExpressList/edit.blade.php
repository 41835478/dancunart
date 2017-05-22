@extends('Admin.app')
@section('content')
    <section class="rt_wrap content mCustomScrollbar">
        <div class="rt_content">
            <h1>{{$title}}</h1>

            <section>
                <form id="data">
                    <ul class="ulColumn2">
                        <li>
                            <span class="item_name" style="width:120px;">快递公司名称：</span>
                            <input type="text" class="textbox" name="express_name" value="{{$data->express_name}}" datatype="*2-16" nullmsg="请填写！" errormsg="名称至少2个字符,最多16个字符！"/>
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">是否展示：</span>
                            <label class="single_selection"><input type="radio" name="status" @if($data->status) checked="true" @endif value='1'/>展示</label>
                            <label class="single_selection"><input type="radio" name="status" @if(!$data->status) checked="true" @endif value='0' datatype="*" errormsg="请选择！" />不展示</label>
                        </li>

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
                    url: "{{URL::to('admin/ExpressList')}}/{{$id}}",
                    type: "PUT",
                    data: $("#data").serialize() + "&_token={{csrf_token()}}",
                    dataType: "json",
                    beforeSend: function () {
                        $(".loading_area").fadeIn();
                    },
                    success: function (result) {
                        if (result.errorno == 30000) {
                            $(".loading_area").fadeOut(1500);
                            showAlert(result.msg, '{{URL::to('admin/ExpressList')}}', '{{URL::to('admin/ExpressList')}}');
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