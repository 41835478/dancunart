@extends('Admin.app')
@section('content')
    <section class="rt_wrap content mCustomScrollbar">
        <div class="rt_content">
            <h1>{{$title}}</h1>
            <section>

                <input type="text" name="keywords" class="textbox" placeholder="关键词..." value="{{$key}}"/>
                <input type="button" value="查询" class="group_btn" id="search"/>
                <input type="button" value="重置" onClick="window.location.href='{{URL::to('admin/userLog')}}'" class="group_btn"/>

            </section>
            <hr />
            <section>
                <table class="table">
                    <tr>
                        <th>编号</th>
                        <th>用户账号</th>
                        <th>用户昵称</th>
                        <th>操作员</th>
                        <th>行为</th>
                        <th>更新时间</th>
                    </tr>

                    @foreach ($data as $key=>$rs)
                        <tr>
                            <td>{{ $rs->id }}</td>
                            <td>{{ $rs->account }}</td>
                            <td>{{ $rs->nick }}</td>
                            <td>{{ $rs->anick }}</td>
                            <td>{{ $rs->action }}</td>
                            <td>{{ $rs->created_at }}</td>
                        </tr>
                    @endforeach
                </table>
            </section>
        </div>
    </section>

@endsection
@section('footer')
    </body>
    </html>
@endsection