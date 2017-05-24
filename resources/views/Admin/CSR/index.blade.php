@extends('Admin.app')
@section('content')
    <section class="rt_wrap content mCustomScrollbar">
        <div class="rt_content">
            <h1>{{$title}}</h1>
            <hr />
            <section>
                <div class="page_title">
                    <a class="fr top_rt_btn" onClick="window.location.href='{{URL::to('admin/CSR/create')}}'">新增客服</a>
                </div>
                <table class="table">
                    <tr>
                        <th>编号</th>
                        <th>客服名称</th>
                        <th>客服QQ</th>
                        <th>客服电话</th>
                        <th>排序</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>

                    @foreach ($data as $key=>$rs)
                        <tr>
                            <td>{{ $rs->id }}</td>
                            <td>{{ $rs->name }}</td>
                            <td>{{ $rs->qq }}</td>
                            <td>{{ $rs->mob }}</td>
                            <td>{{ $rs->rank }}</td>
                            <td>@if($rs->status) 下架 @else 展示 @endif</td>
                            <td>
                                <a href="{{URL::to('admin/CSR')}}/{{ $rs->id }}/edit">修改</a>
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
            var res=confirm("确定删除该客服？");
            if(res==true){
                $.ajax({
                    url  : "{{URL::to('admin/CSR')}}/"+id,
                    type : "delete",
                    data : "&_token={{csrf_token()}}",
                    dataType: "json",
                    beforeSend:function(){
                        $(".loading_area").fadeIn();
                    },
                    success:function(result){
                        if(result.errorno==50000){
                            $(".loading_area").fadeOut(1500);
                            showAlert(result.msg,'{{URL::to('admin/CSR')}}','{{URL::to('admin/CSR')}}');
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