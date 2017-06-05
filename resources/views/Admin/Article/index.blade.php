@extends('Admin.app')
@section('content')
    <section class="rt_wrap content mCustomScrollbar">
        <div class="rt_content">
            <h1>{{$title}}</h1>

            <section>

                <input type="text" name="keywords" class="textbox" placeholder="关键词..." value="{{$key}}"/>
                <input type="button" value="查询" class="group_btn" id="search"/>
                <input type="button" value="重置" onClick="window.location.href='{{URL::to('admin/article')}}'" class="group_btn"/>

            </section>
            <hr />
            <section>
                <div class="page_title">
                    <a class="fr top_rt_btn" onClick="window.location.href='{{URL::to('admin/article/create')}}'">新增文章</a>
                </div>
                <table class="table">
                    <tr>
                        <th>编号</th>
                        <th>文章名称</th>
                        <th>文章分类</th>
                        <th>点击次数</th>
                        <th>文章状态</th>
                        <th>是否上架展示</th>
                        <th>发布时间</th>
                        <th>最近修改时间</th>
                        <th>操作</th>
                    </tr>

                    @foreach ($data as $key=>$rs)
                        <tr>
                            <td>{{ $rs->id }}</td>
                            <td>{{ $rs->title }}</td>
                            <td>{{ $rs->article_class_name }}</td>
                            <td>{{ $rs->view_count }}</td>
                            <td>@if($rs->flag)头条@else 非头条 @endif</td>
                            <td>@if($rs->status)上架展示@else 不展示 @endif</td>
                            <td>{{ $rs->created_at }}</td>
                            <td>{{ $rs->updated_at }}</td>
                            <td>
                                <a href="{{URL::to('admin/article')}}/{{ $rs->id }}/edit">修改</a>
                                <a href="javascript:;" onClick='isdelete({{ $rs->id }})'>删除</a>
                            </td>
                        </tr>
                    @endforeach

                </table>

                <aside class="paging">
                    {!! $data->appends($searchitem)->render() !!}
                </aside>
            </section>


        </div>
    </section>

@endsection
@section('footer')
    <script>
        $("#search").click(function(){
            var key = $("input[name = 'keywords']").val();
            window.location.href="{{URL::to('admin/article')}}?key="+key;
        })
        function isdelete(id){
            var res=confirm("确定删除该文章？");
            if(res==true){
                $.ajax({
                    url  : "{{URL::to('admin/article')}}/"+id,
                    type : "delete",
                    data : "&_token={{csrf_token()}}",
                    dataType: "json",
                    beforeSend:function(){
                        $(".loading_area").fadeIn();
                    },
                    success:function(result){
                        if(result.errorno==50000){
                            $(".loading_area").fadeOut(1500);
                            showAlert(result.msg,'{{URL::to('admin/article')}}','{{URL::to('admin/article')}}');
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