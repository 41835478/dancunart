@extends('Admin.app')
@section('content')
    <section class="rt_wrap content mCustomScrollbar">
        <div class="rt_content">
            <h1>{{$title}}</h1>

            <section>
                <form id="data">
                    <ul class="ulColumn2">
                        <li>
                            <span class="item_name" style="width:120px;">新类别名称：</span>
                            <input type="text" class="textbox textbox_295" name="class_name" value="{{$data->class_name}}"/>
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;"></span>
                            <input type="button" class="link_btn" id="link_btn" value="提交"/>
                        </li>
                    </ul>
                </form>
            </section>

        </div>
    </section>

@endsection
@section('footer')

    <script>
        $("#link_btn").click(function(){
            var name = $("input[name = 'class_name']").val();

            if(name=='')  showAlert('请填写分类名称','','');
            else{
                $.ajax({
                    url  : "{{URL::to('admin/articleClass')}}/{{$data->id}}",
                    type : "PUT",
                    data : $("#data").serialize()+"&_token={{csrf_token()}}",
                    dataType: "json",
                    beforeSend:function(){
                        $(".loading_area").fadeIn();
                    },
                    success:function(result){
                        if(result.errorno==30000){
                            $(".loading_area").fadeOut(1500);
                            showAlert(result.msg,'{{URL::to('admin/articleClass')}}','{{URL::to('admin/articleClass')}}');
                        }
                        else {
                            $(".loading_area").fadeOut(1500);
                            showAlert(result.msg,'','');
                        }
                    }
                })
            }
        })
    </script>

    </body>
    </html>
@endsection