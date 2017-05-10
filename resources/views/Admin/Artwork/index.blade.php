@extends('Admin.app')
@section('content')
    <section class="rt_wrap content mCustomScrollbar">
        <div class="rt_content">
            <h1>{{$title}}</h1>

            <section>

                <input type="text" name="keywords" class="textbox" placeholder="关键词..." value="{{$key}}"/>
                <input type="button" value="查询" class="group_btn" id="search"/>
                <input type="button" value="重置" onClick="window.location.href='{{URL::to('admin/artwork')}}'" class="group_btn"/>

            </section>
            <hr />
            <section>
                <div class="page_title">
                    <a class="fr top_rt_btn" onClick="window.location.href='{{URL::to('admin/artwork/create')}}'">新增拍品</a>
                </div>
                <table class="table">
                    <tr>
                        <th>编号</th>
                        <th>拍品名称</th>
                        <th>相关艺术家</th>
                        <th>拍品图片</th>
                        <th>拍品分类</th>
                        <th>起拍价</th>
                        <th>加价幅度</th>
                        <th>保留价</th>
                        <th>延时周期</th>
                        <th>保证金</th>
                        <th>出价次数</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>

                    @foreach ($data as $key=>$rs)
                        <tr>
                            <td>{{ $rs->id }}</td>
                            <td>{{ $rs->name }}</td>
                            <td>{{ $rs->artist_list }}</td>
                            <td><img src="{{asset($rs->img_thumb)}}" /></td>
                            <td>{{ $rs->artwork_class_list }}</td>
                            <td>{{ $rs->start_price }}元</td>
                            <td>{{ $rs->each_increase }}元</td>
                            <td>{{ $rs->reserve_price }}元</td>
                            <td>{{ $rs->delay_seconds }}分钟</td>
                            <td>{{ $rs->margin }}元</td>
                            <td>{{ $rs->buy_num }}</td>
                            <td>@if($rs->status)上架展示@else 不展示 @endif</td>
                            <td>
                                <a href="{{URL::to('admin/artwork')}}/{{ $rs->id }}/edit">修改</a>
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
            window.location.href="{{URL::to('admin/artwork')}}?key="+key;
        })
        function isdelete(id){
            var res=confirm("确定删除该拍品，并且退还？");
            if(res==true){
                $.ajax({
                    url  : "{{URL::to('admin/artist')}}/"+id,
                    type : "delete",
                    data : "&_token={{csrf_token()}}",
                    dataType: "json",
                    beforeSend:function(){
                        $(".loading_area").fadeIn();
                    },
                    success:function(result){
                        if(result.errorno==50000){
                            $(".loading_area").fadeOut(1500);
                            showAlert(result.msg,'{{URL::to('admin/artist')}}','{{URL::to('admin/artist')}}');
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