@extends('Admin.app')
@section('content')
    <section class="rt_wrap content mCustomScrollbar">
        <div class="rt_content">
            <h1>{{$title}}</h1>

            <section>
                <form id="data">
                    <ul class="ulColumn2">
                        <input type="hidden" name="uid" value="{{$data->uid}}" />
                        <input type="hidden" name="oid" value="{{$data->id}}" />
                        <li>
                            <span class="item_name" style="width:120px;">用户：</span>
                            <input type="text" class="textbox" readonly value="{{$data->account}}({{$data->nick}})"/>
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">订单号：</span>
                            <input type="text" class="textbox" readonly value="{{$data->order_id}}"/>
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">拍品：</span>
                            <input type="text" class="textbox" readonly value="{{$data->artwork_name}}"/>
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">地址：</span>
                            <textarea type="text" readonly class="textarea" style="width:400px;height:80px;">
地址：{{ $data->province }}、{{ $data->city }}、{{ $data->area }}、{{ $data->detail }}
收件人：{{ $data->consignor }}
手机：{{ $data->mob }}
                            </textarea>
                        </li>

                        <li>
                            <span class="item_name" name="express_name" style="width:120px;">快递公司：</span>
                            <select name="express_name" datatype="*" errormsg="请选择！">
                                {!! $option_list !!}
                            </select>
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">快递单号：</span>
                            <input type="text" name="express_no" class="textbox" value="" datatype="*2-20" nullmsg="请填写！" errormsg="快递单号至少2个字符,最多20个字符！"/>
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;"></span>
                            <input type="submit" class="link_btn" id="link_btn" value="提交" />
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
                    url: "{{URL::to('admin/orderExpress')}}",
                    type: "post",
                    data: $("#data").serialize() + "&_token={{csrf_token()}}",
                    dataType: "json",
                    beforeSend: function () {
                        $(".loading_area").fadeIn();
                    },
                    success: function (result) {
                        if (result.errorno == 20000) {
                            $(".loading_area").fadeOut(1500);
                            showAlert(result.msg, '{{URL::to('admin/orderExpress')}}', '{{URL::to('admin/orderExpress')}}');
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