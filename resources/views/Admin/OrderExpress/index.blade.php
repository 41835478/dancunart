@extends('Admin.app')
@section('content')
    <section class="rt_wrap content mCustomScrollbar">
        <div class="rt_content">
            <h1>{{$title}}</h1>
            <section>

                <input type="text" name="keywords" class="textbox" placeholder="订单号/用户账号..." value="{{$key}}"/>
                <input type="button" value="查询" class="group_btn" id="search"/>
                <input type="button" value="重置" onClick="window.location.href='{{URL::to('admin/orderExpress')}}'" class="group_btn"/>

            </section>
            <hr />
            <section>
                <table class="table">
                    <tr>
                        <th>编号</th>
                        <th>订单号</th>
                        <th>用户账号（昵称）</th>
                        <th>地址</th>
                        <th>备注</th>
                        <th>快递名称</th>
                        <th>快递单号</th>
                        <th>快递状态</th>
                        <th>生成时间</th>
                        <th>修改时间</th>
                        <th>操作</th>
                    </tr>

                    @foreach ($data as $key=>$rs)
                        <tr>
                            <td>{{ $rs->id }}</td>
                            <td><a href="{{URL::to('admin/order')}}?key={{ $rs->order_id }}">{{ $rs->order_id }}</a></td>
                            <td>{{ $rs->account }}（{{ $rs->nick }}）</td>

                            <td>
                                地址：{{ $rs->province }}、{{ $rs->city }}、{{ $rs->area }}、{{ $rs->detail }}<br />
                                收件人：{{ $rs->consignor }}<br />
                                手机：{{ $rs->mob }}<br/>
                            </td>
                            <td>{{ $rs->remark }}</td>
                            <td>{{ $rs->express_name }}</td>
                            <td>{{ $rs->express_no }}</td>
                            <td>@if($rs->status) 作废 @elseif($rs->status==0 && $rs->send_flag==2) 已完结 @else 途中 @endif</td>
                            <td>{{ $rs->created_at }}</td>
                            <td>{{ $rs->updated_at }}</td>

                            <td>
                                @if($rs->status==0 && $rs->send_flag!=2)
                                <a href="javascript:;" class="inner_btn" onClick='invalid({{ $rs->id }})'>作废</a>
                                @endif
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
        function invalid(id){
            var res=confirm("确定作废本条快递信息？");
            if(res==true){
                $.ajax({
                    url  : "{{URL::to('admin/orderExpress/invalid')}}/"+id,
                    type : "get",
                    data : "&_token={{csrf_token()}}",
                    dataType: "json",
                    beforeSend:function(){
                        $(".loading_area").fadeIn();
                    },
                    success:function(result){
                        if(result.errorno==30000){
                            $(".loading_area").fadeOut(1500);
                            showAlert(result.msg,'{{URL::to('admin/orderExpress')}}','{{URL::to('admin/orderExpress')}}');
                        }
                        else {
                            $(".loading_area").fadeOut(1500);
                            showAlert(result.msg,'','');
                        }
                    }
                })
            }
        }
    </script>

    </body>
    </html>
@endsection