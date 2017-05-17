@extends('Admin.app')
@section('content')
    <section class="rt_wrap content mCustomScrollbar">
        <div class="rt_content">
            <h1>{{$title}}</h1>
            <section>

                <form id="data">

                    <ul class="ulColumn2">
                        <li>
                            <span class="item_name " style="width:120px;">友链名称：</span>
                            <input type="text" class="textbox" name="link_name" value="{{$data->link_name}}" datatype="*" nullmsg="名称不能为空！" errormsg="名称不能为空"/>
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">友链图片：</span>
                            <input type="button" class="link_btn" id="click_btn" value="选择图片"/>

                            <input id="link_img" name="link_img" type="hidden"  value="{{$data->link_img}}">
                            <!--隐藏file按钮-->
                            <input id="upload_btn" type="file" name="file" >
                            <!--上传后显示的img-->
                            <img  id="img_url" style="display: inline" name="id" src="{{asset('/')}}{{$data->link_img}}" />
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">友链网址：</span>
                            <input type="text" class="textbox textbox_295" name="link_url" value="{{$data->link_url}}" datatype="*" nullmsg="请填写网址！" errormsg="请填写网址"/>
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">友链权重：</span>
                            <input type="number" class="textbox" name="rank" value="{{$data->rank}}" datatype="*" value="0" nullmsg="请填写权重！" errormsg="请填写权重"/>
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">是否展示：</span>
                            <label class="single_selection"><input type="radio" name="status" @if($data->status) checked="true" @endif value='1'/>展示</label>
                            <label class="single_selection"><input type="radio" name="status" @if(!$data->status) checked="true" @endif value='0' datatype="*" errormsg="请选择！" />不展示</label>
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;"></span>
                            <input type="submit" class="link_btn" value="提交"/>
                        </li>
                    </ul>

                </form>
            </section>

        </div>
    </section>

@endsection
@section('footer')
    <script src="{{asset('static/js/jquery.ajaxfileupload.js')}}"></script>
    <script>
        //上传图片相关
        function applyAjaxFileUpload(element) {
            $(element).AjaxFileUpload({
                action: "{{asset('/admin/upload')}}",
                onChange: function(filename) {
                    var $span = $("<span />").attr("class", $(this).attr("id")).text("Uploading").insertAfter($(this));
                    $(this).remove();
                    interval = window.setInterval(function() {
                        var text = $span.text();
                        if (text.length < 13) {
                            $span.text(text + ".");
                        } else {
                            $span.text("Uploading");
                        }
                    }, 200);
                },
                onComplete: function(filename,result) {
                    window.clearInterval(interval);

                    var $span = $("span." + $(this).attr("id")).text("");
                    $("#link_img").val(result.name);
                    $("#img_url").attr('src',"{{asset('/')}}"+result.name_thumb);
                    $("#img_url").show();
                    $("#upload_li").append("<input id='upload_btn' type='file' name='file' >");
                }
            });
        }

        //上传图片相关
        $('#click_btn').on('click',function(){
            $('#upload_btn').trigger('click');
            applyAjaxFileUpload("#upload_btn");
        })

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
                    url: "{{URL::to('admin/siteFriendlink')}}/{{$data->id}}",
                    type: "put",
                    data: $("#data").serialize() + "&_token={{csrf_token()}}",
                    dataType: "json",
                    beforeSend: function () {
                        $(".loading_area").fadeIn();
                    },
                    success: function (result) {
                        if (result.errorno == 30000) {
                            $(".loading_area").fadeOut(1500);
                            showAlert(result.msg, '{{URL::to('admin/siteFriendlink')}}', '{{URL::to('admin/siteFriendlink')}}');
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