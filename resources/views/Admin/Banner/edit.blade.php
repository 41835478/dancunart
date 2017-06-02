@extends('Admin.app')
@section('content')
    <section class="rt_wrap content mCustomScrollbar">
        <div class="rt_content">
            <h1>{{$title}}</h1>

            <section>
                <form id="data">
                    <ul class="ulColumn2">
                        <li>
                            <span class="item_name" style="width:120px;">banner名称：</span>
                            <input type="text" class="textbox textbox_295" name="name" value="{{$data->name}}" datatype="*" errormsg="名称不能为空！"/>
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">banner链接：</span>
                            <input type="text" class="textbox textbox_295" name="url" value="{{$data->url}}" datatype="url" errormsg="链接不能为空！"/>
                        </li>

                        <li id="upload_li">
                            <span class="item_name" style="width:120px;">banner图片：</span>
                            <input type="button" class="link_btn" id="click_btn" value="选择图片"/>

                            <input id="img" name="img" type="hidden"  value="{{$data->img}}">
                            <!--隐藏file按钮-->
                            <input id="upload_btn" type="file" name="file" >
                            <!--上传后显示的img-->
                            <img  id="img_url" src="{{asset('/')}}{{$data->img}}" style="display: inline" />
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">权重：</span>
                            <input type="text" class="textbox" value="{{$data->rank}}" name="rank" datatype="n"/> &nbsp;&nbsp;&nbsp;权重越高 排名越靠前
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">是否上架展示：</span>
                            <label class="single_selection"><input type="radio" name="status" @if($data->status)   checked='true' @endif value='1'/>上架展示</label>
                            <label class="single_selection"><input type="radio" name="status" @if($data->status==0)   checked='true' @endif datatype="*" errormsg="请选择！" value='0'/>不上架</label>
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
                    $("#img").val(result.name);
                    $("#img_url").attr('src',"{{asset('/')}}"+result.name);
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
            var demo = $("#data").Validform({
                tiptype: 3,
                ajaxPost: true,
                beforeSubmit: function () {
                    ajax_send();
                    return false;
                }
            });
            function ajax_send(){
                $.ajax({
                    url  : "{{URL::to('admin/banner')}}/{{$data->id}}",
                    type : "PUT",
                    data : $("#data").serialize()+"&_token={{csrf_token()}}",
                    dataType: "json",
                    beforeSend:function(){
                        $(".loading_area").fadeIn();
                    },
                    success:function(result){
                        if(result.errorno==30000){
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
        })

    </script>

    </body>
    </html>
@endsection