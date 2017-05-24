@extends('Admin.app')
@section('content')
    <section class="rt_wrap content mCustomScrollbar">
        <div class="rt_content">
            <h1>{{$title}}</h1>

            <section>
                <form id="data">
                    <ul class="ulColumn2">
                        <li>
                            <span class="item_name" style="width:120px;">客服名称：</span>
                            <input type="text" class="textbox" name="name" value="{{$data->name}}" datatype="*" nullmsg="请填写" errormsg="不能为空"/>
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">客服QQ：</span>
                            <input type="text" class="textbox" name="qq" value="{{$data->qq}}" datatype="n" nullmsg="请填写" errormsg="只能填写数字"/>
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">客服电话：</span>
                            <input type="text" class="textbox" name="mob" value="{{$data->mob}}" datatype="*" nullmsg="请填写" errormsg="不能为空"/>
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">客服排序：</span>
                            <input type="text" class="textbox" name="rank" value="{{$data->rank}}" datatype="n" nullmsg="请填写" errormsg="只能填写数字"/>&nbsp;&nbsp;数字，按大->小排序
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">状态：</span>
                            <label class="single_selection"><input type="radio" name="status" @if($data->status) checked='true' @endif  value='1'/>下架</label>
                            <label class="single_selection"><input type="radio" name="status"  @if($data->status==0) checked='true' @endif value='0' datatype="*" nullmsg="请填写" errormsg="不能为空"/>上架</label>
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;"></span>
                            <input type="submit" class="link_btn" id="link_btn" value="提交"/>
                        </li>
                    </ul>
                </form>
            </section>

        </div>
    </section>

@endsection
@section('footer')

    <script>
        $(function() {
            $("#data").Validform({
                tiptype: 3,
                ajaxPost: true,
                beforeSubmit: function () {
                    ajax_send();
                    return false;
                }
            });

            function ajax_send() {
                $.ajax({
                    url: "{{URL::to('admin/CSR')}}/{{$data->id}}",
                    type: "PUT",
                    data: $("#data").serialize() + "&_token={{csrf_token()}}",
                    dataType: "json",
                    beforeSend: function () {
                        $(".loading_area").fadeIn();
                    },
                    success: function (result) {
                        if (result.errorno == 30000) {
                            $(".loading_area").fadeOut(1500);
                            showAlert(result.msg, '{{URL::to('admin/CSR')}}', '{{URL::to('admin/CSR')}}');
                        }
                        else {
                            $(".loading_area").fadeOut(1500);
                            showAlert(result.msg, '', '');
                        }
                    }
                })
            }
        })
    </script>

    </body>
    </html>
@endsection