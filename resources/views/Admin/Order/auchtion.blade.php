@extends('Admin.app')
@section('content')
    <section class="rt_wrap content mCustomScrollbar">
        <div class="rt_content">
            <h1>{{$title}}</h1>
            <section>

                <input type="text" name="keywords" class="textbox" placeholder="订单号/用户账号..." value="{{$key}}"/>
                <input type="button" value="查询" class="group_btn" id="search"/>
                <input type="button" value="重置" onClick="window.location.href='{{URL::to('admin/orderAuchtion')}}'" class="group_btn"/>

            </section>
            <hr />
            <section>
                <table class="table">
                    <tr>
                        <th>编号</th>
                        <th>用户</th>
                        <th>拍品</th>
                        <th>拍前价格</th>
                        <th>本次加价幅度</th>
                        <th>创建时间</th>
                    </tr>

                    @foreach ($data as $key=>$rs)
                        <tr>
                            <td>{{ $rs->id }}</td>
                            <td>{{ $rs->account }}({{$rs->nick}})</td>
                            <td>{{ $rs->name }}</td>
                            <td>{{ $rs->old_price/100 }}</td>
                            <td>{{ $rs->price_increase/100 }}</td>
                            <td>{{ $rs->created_at }}</td>
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