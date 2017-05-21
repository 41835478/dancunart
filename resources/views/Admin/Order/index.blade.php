@extends('Admin.app')
@section('content')
    <section class="rt_wrap content mCustomScrollbar">
        <div class="rt_content">
            <h1>{{$title}}</h1>
            <section>

                <input type="text" name="keywords" class="textbox" placeholder="订单号/用户账号..." value="{{$key}}"/>
                <input type="button" value="查询" class="group_btn" id="search"/>
                <input type="button" value="重置" onClick="window.location.href='{{URL::to('admin/order')}}'" class="group_btn"/>

            </section>
            <hr />
            <section>
                <table class="table">
                    <tr>
                        <th>编号</th>
                        <th>订单号</th>
                        <th>用户</th>
                        <th>本单金额</th>
                        <th>支付方式</th>
                        <th>支付方式</th>
                        <th>状态</th>
                        <th>创建时间</th>
                        <th>更新时间</th>
                        <th>操作</th>
                    </tr>

                    @foreach ($data as $key=>$rs)
                        <tr>
                            <td>{{ $rs->id }}</td>
                            <td>{{ $rs->order_id }}</td>
                            <td>{{ $rs->account }}({{$rs->nick}})</td>
                            <td>{{ $rs->pay_money }}</td>
                            <td>{{ $rs->pay_way }}</td>
                            <td>@if($rs->flag) 付尾款 @else 充押金 @endif</td>
                            <td>@if($rs->status) 已支付 @else 未支付 @endif</td>
                            <td>{{ $rs->created_at }}</td>
                            <td>{{ $rs->updated_at }}</td>
                            <td>@if($rs->flag && $rs->status && $rs->send_flag==0) 去发货 @endif
                                @if(!$rs->status) <a href="javascript:;" onClick="ajax_pay({{ $rs->id }})" class="inner_btn">修改状态</a> @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </section>
        </div>
    </section>

@endsection
@section('footer')
    <script>
        $("#search").click(function(){
            var key = $("input[name = 'keywords']").val();
            window.location.href="{{URL::to('admin/order')}}?key="+key;
        })

        function ajax_pay(id) {
            var res = confirm("确定该订单已通过其他渠道支付？");

            if (res == true) {
                $.ajax({
                    url: "{{URL::to('admin/order')}}/"+id,
                    type: "post",
                    data: "&_token={{csrf_token()}}",
                    dataType: "json",
                    beforeSend: function () {
                        $(".loading_area").fadeIn();
                    },
                    success: function (result) {
                        console.log(result);
                        if (result.errorno == 30000) {
                            $(".loading_area").fadeOut(1500);
                            showAlert(result.msg, '{{URL::to('admin/order')}}', '{{URL::to('admin/order')}}');
                        }
                        else {
                            $(".loading_area").fadeOut(1500);
                            showAlert(result.msg, '', '');
                        }
                    }
                })
            }
        }
    </script>
    </body>
    </html>
@endsection