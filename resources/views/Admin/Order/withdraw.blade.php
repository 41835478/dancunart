@extends('Admin.app')
@section('content')
    <section class="rt_wrap content mCustomScrollbar">
        <div class="rt_content">
            <h1>{{$title}}</h1>
            <section>

                <input type="text" name="keywords" class="textbox" placeholder="订单号/用户账号..." value="{{$key}}"/>
                <input type="button" value="查询" class="group_btn" id="search"/>
                <input type="button" value="重置" onClick="window.location.href='{{URL::to('admin/orderWithdraw')}}'" class="group_btn"/>

            </section>
            <hr />
            <section>
                <table class="table">
                    <tr>
                        <th>编号</th>
                        <th>用户</th>
                        <th>提现之前余额</th>
                        <th>本次提现金额</th>
                        <th>状态</th>
                        <th>创建时间</th>
                        <th>更新时间</th>
                    </tr>

                    @foreach ($data as $key=>$rs)
                        <tr>
                            <td>{{ $rs->id }}</td>
                            <td>{{ $rs->account }}({{$rs->nick}})</td>
                            <td>{{ $rs->old_cash/100 }}</td>
                            <td>{{ $rs->withdraw_price/100 }}</td>
                            <td>
                                @if($rs->status==0)审核中
                                <a href="javascript:;" onClick="ajax_withdraw('check',{{ $rs->id }})" class="inner_btn">审核</a>
                                <a href="javascript:;" onClick="ajax_withdraw('pass',{{ $rs->id }})" class="inner_btn">驳回</a>
                                @elseif($rs->status==1)已提现
                                {{--<a href="javascript:;" onClick="ajax_withdraw('reset',{{ $rs->id }})" class="inner_btn">重置</a>--}}
                                @elseif($rs->status==2)已驳回
                                {{--<a href="javascript:;" onClick="ajax_withdraw('reset',{{ $rs->id }})" class="inner_btn">重置</a>--}}
                                @else -
                                @endif
                            </td>
                            <td>{{ $rs->created_at }}</td>
                            <td>{{ $rs->updated_at }}</td>

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
            window.location.href="{{URL::to('admin/orderRecharge')}}?key="+key;
        })

        function ajax_withdraw(flag,id) {
            if(flag=='check')
                var res = confirm("确定审核该提现记录？");
            else if(flag=='pass')
                var res = confirm("确定驳回该提现记录？");
            else if(flag=='reset')
                var res = confirm("确定重置该提现记录？用户的钱会被加回去");

            if (res == true) {
                $.ajax({
                    url: "{{URL::to('admin/withdraw')}}/"+id,
                    type: "post",
                    data: "flag=" + flag + "&_token={{csrf_token()}}",
                    dataType: "json",
                    beforeSend: function () {
                        $(".loading_area").fadeIn();
                    },
                    success: function (result) {
                        console.log(result);
                        if (result.errorno == 30000) {
                            $(".loading_area").fadeOut(1500);
                            showAlert(result.msg, '{{URL::to('admin/orderWithdraw')}}', '{{URL::to('admin/orderWithdraw')}}');
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