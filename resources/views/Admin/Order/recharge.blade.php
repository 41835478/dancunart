@extends('Admin.app')
@section('content')
    <section class="rt_wrap content mCustomScrollbar">
        <div class="rt_content">
            <h1>{{$title}}</h1>
            <section>

                <input type="text" name="keywords" class="textbox" placeholder="订单号/用户账号..." value="{{$key}}"/>
                <input type="button" value="查询" class="group_btn" id="search"/>
                <input type="button" value="重置" onClick="window.location.href='{{URL::to('admin/orderRecharge')}}'" class="group_btn"/>

            </section>
            <hr />
            <section>
                <table class="table">
                    <tr>
                        <th>编号</th>
                        <th>订单号</th>
                        <th>用户</th>
                        <th>状态</th>
                        <th>创建时间</th>
                        <th>更新时间</th>
                    </tr>

                    @foreach ($data as $key=>$rs)
                        <tr>
                            <td>{{ $rs->id }}</td>
                            <td>{{ $rs->order_id }}</td>
                            <td>{{ $rs->account }}({{$rs->nick}})</td>
                            <td>@if($rs->status) 已支付 @else 未支付 @endif</td>
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
    </script>
    </body>
    </html>
@endsection