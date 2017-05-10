@extends('Admin.app')
@section('content')
    <section class="rt_wrap content mCustomScrollbar">
        <div class="rt_content">
            <h1>{{$title}}</h1>

            <section>
                <form id="data">
                    <ul class="ulColumn2">
                        <li>
                            <span class="item_name" style="width:120px;">艺术家名称：</span>
                            <input type="text" class="textbox textbox_295" name="name" />
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">艺术家昵称：</span>
                            <input type="text" class="textbox textbox_295" name="nick" />
                        </li>

                        <li id="upload_li">
                            <span class="item_name" style="width:120px;">头像：</span>
                            <input type="button" class="link_btn" id="click_btn" value="选择图片"/>

                            <input id="avatar_url" name="avatar" type="hidden"  value="">
                            <input id="avatar_thumb_url" name="avatar_thumb" type="hidden"  value="">
                            <!--隐藏file按钮-->
                            <input id="upload_btn" type="file" name="file" >
                            <!--上传后显示的img-->
                            <img  id="img_url" name="id" src="" />
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">描述：</span>
                            <textarea placeholder="艺术家简略描述" class="textarea" style="width:400px;height:80px;" name="desc"></textarea>
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">艺术分类：</span>
                                {!!$artist_class_list!!}
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">是否上架展示：</span>
                            <label class="single_selection"><input type="radio" name="status"  checked='true' value='1'/>上架展示</label>
                            <label class="single_selection"><input type="radio" name="status" value='0'/>不上架</label>
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">艺术家博客：</span>
                        </li>

                        <div style="margin:0px 5%;">
                            <script id="container" name="blog" type="text/plain" style="width:100%;height:500px;"></script>
                        </div>

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
    <link href="{{asset('umeditor/themes/default/_css/umeditor.css')}}" type="text/css" rel="stylesheet">
    <script type="text/javascript" src="{{asset('umeditor/third-party/template.min.js')}}"></script>
    <script type="text/javascript" charset="utf-8" src="{{asset('umeditor/umeditor.config.js')}}"></script>
    <script type="text/javascript" charset="utf-8" src="{{asset('umeditor/editor_api.js')}}"></script>
    <script type="text/javascript" src="{{asset('umeditor/lang/zh-cn/zh-cn.js')}}"></script>

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
                    $("#avatar_url").val(result.name);
                    $("#avatar_thumb_url").val(result.name_thumb);
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

        //编辑器相关
        var um = UM.getEditor('container');

        $("#link_btn").click(function(){
            var name = $("input[name = 'name']").val();

            if(name=='')  showAlert('请填写艺术家名称','','');
            else{
                $.ajax({
                    url  : "{{URL::to('admin/artist')}}",
                    type : "post",
                    data : $("#data").serialize()+"&_token={{csrf_token()}}",
                    dataType: "json",
                    beforeSend:function(){
                        $(".loading_area").fadeIn();
                    },
                    success:function(result){
                        if(result.errorno==20000){
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
        })
    </script>

    </body>
    </html>
@endsection