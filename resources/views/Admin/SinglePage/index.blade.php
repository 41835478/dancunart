@extends('Admin.app')
@section('content')
    <section class="rt_wrap content mCustomScrollbar">
        <div class="rt_content">
            <h1>{{$title}}</h1>
            <hr />
            <section>
                <div class="page_title">
                    <a class="fr top_rt_btn" onClick="window.location.href='{{URL::to('admin/singlePage/create')}}'">新增顶级栏目</a>
                </div>
                <table class="table">
                    <tr>
                        <th>编号</th>
                        <th>单页名称</th>
                        <th>创建时间</th>
                        <th>更改时间</th>
                        <th>操作</th>
                    </tr>

                    {!! $data !!}
                </table>

            </section>


        </div>
    </section>

@endsection
@section('footer')
    <script>
        function isdelete(id){
            var res=confirm("确定删除该单页？");
            if(res==true){
                $.ajax({
                    url  : "{{URL::to('admin/singlePage')}}/"+id,
                    type : "delete",
                    data : "&_token={{csrf_token()}}",
                    dataType: "json",
                    beforeSend:function(){
                        $(".loading_area").fadeIn();
                    },
                    success:function(result){
                        if(result.errorno==50000){
                            $(".loading_area").fadeOut(1500);
                            showAlert(result.msg,'{{URL::to('admin/singlePage')}}','{{URL::to('admin/singlePage')}}');
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