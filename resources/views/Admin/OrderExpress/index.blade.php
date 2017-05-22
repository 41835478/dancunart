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
                        <th>用户账号（昵称）</th>
                        <th>地址</th>
                        <th>备注</th>
                        <th>快递名称</th>
                        <th>快递单号</th>
                        <th>生成时间</th>
                        <th>修改时间</th>
                        <th>操作</th>
                    </tr>

                    @foreach ($data as $key=>$rs)
                        <tr>
                            <td>{{ $rs->id }}</td>
                            <td>{{ $rs->account }}（{{ $rs->nick }}）</td>

                            <td>
                                地址：{{ $rs->province }}、{{ $rs->city }}、{{ $rs->area }}、{{ $rs->detail }}<br />
                                收件人：{{ $rs->consignor }}<br />
                                手机：{{ $rs->mob }}<br/>
                            </td>
                            <td>{{ $rs->remark }}</td>
                            <td>{{ $rs->express_name }}</td>
                            <td>{{ $rs->express_no }}</td>
                            <td>{{ $rs->created_at }}</td>
                            <td>{{ $rs->updated_at }}</td>

                            <td>
                                <a href="{{URL::to('admin/artistclass')}}/{{ $rs->id }}/edit">修改</a>
                                <a href="javascript:;" onClick='isdelete({{ $rs->id }})'>删除</a>
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
        function isdelete(id){
            var res=confirm("确定删除该分类？");
            if(res==true){
                $.ajax({
                    url  : "{{URL::to('admin/artistclass')}}/"+id,
                    type : "delete",
                    data : "&_token={{csrf_token()}}",
                    dataType: "json",
                    beforeSend:function(){
                        $(".loading_area").fadeIn();
                    },
                    success:function(result){
                        if(result.errorno==50000){
                            $(".loading_area").fadeOut(1500);
                            showAlert(result.msg,'{{URL::to('admin/artistclass')}}','{{URL::to('admin/artistclass')}}');
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