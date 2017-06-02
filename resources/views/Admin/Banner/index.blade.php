@extends('Admin.app')
@section('content')
    <section class="rt_wrap content mCustomScrollbar">
        <div class="rt_content">
            <h1>{{$title}}</h1>
            <hr />
            <section>
                <div class="page_title">
                    <a class="fr top_rt_btn" onClick="window.location.href='{{URL::to('admin/banner/create')}}'">新增banner</a>
                </div>
                <table class="table">
                    <tr>
                        <th>编号</th>
                        <th>名称</th>
                        <th>图片</th>
                        <th>排序</th>
                        <th>状态</th>
                        <th>创建时间</th>
                        <th>修改时间</th>
                        <th>操作</th>
                    </tr>

                    @foreach ($data as $key=>$rs)
                        <tr>
                            <td>{{ $rs->id }}</td>
                            <td><a href="{{$rs->url}}" target="_blank">{{ $rs->name }}</a></td>
                            <td><img style="max-width:150px;" src="../{{ $rs->img }}"/></td>
                            <td>{{$rs->rank}}</td>
                            <td>@if($rs->status) 展示 @else 不展示 @endif</td>
                            <td>{{$rs->created_at}}</td>
                            <td>{{$rs->updated_at}}</td>
                            <td>
                                <a href="{{URL::to('admin/banner')}}/{{ $rs->id }}/edit">修改</a>
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
            var res=confirm("确定删除该banner？");
            if(res==true){
                $.ajax({
                    url  : "{{URL::to('admin/banner')}}/"+id,
                    type : "delete",
                    data : "&_token={{csrf_token()}}",
                    dataType: "json",
                    beforeSend:function(){
                        $(".loading_area").fadeIn();
                    },
                    success:function(result){
                        if(result.errorno==50000){
                            $(".loading_area").fadeOut(1500);
                            showAlert(result.msg,'{{URL::to('admin/banner')}}','{{URL::to('admin/banner')}}');
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