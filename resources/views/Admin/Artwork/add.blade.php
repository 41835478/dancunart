@extends('Admin.app')
@section('content')
    <section class="rt_wrap content mCustomScrollbar">
        <div class="rt_content">
            <h1>{{$title}}</h1>

            <section>
                <form id="data">
                    <ul class="ulColumn2">
                        <li>
                            <span class="item_name" style="width:120px;">拍品名称：</span>
                            <input type="text" class="textbox textbox_295" name="name" datatype="*" errormsg="拍品名称不能为空！"/>
                        </li>

                        <li id="upload_li">
                            <span class="item_name" style="width:120px;">拍品图片：</span>
                            <input type="button" class="link_btn" id="click_btn" value="选择图片"/>

                            <input id="avatar_url" name="img" type="hidden"  value="">
                            <input id="avatar_thumb_url" name="img_thumb" type="hidden"  value="">
                            <!--隐藏file按钮-->
                            <input id="upload_btn" type="file" name="file" >
                            <!--上传后显示的img-->
                            <img  id="img_url" name="id" src="" />
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">视频地址：</span>
                            <input type="text" class="textbox textbox_295" name="video" datatype="url" errormsg="视频地址必须是网址！"/>
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">拍品描述：</span>
                            <textarea placeholder="拍品简略描述" class="textarea" style="width:400px;height:80px;" name="desc"></textarea>
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">起拍价：</span>
                            <input type="number" class="textbox" name="start_price" datatype="n" errormsg="请填写！"/> 单位：元
                        </li>
                        <li>
                            <span class="item_name" style="width:120px;">加价幅度：</span>
                            <input type="number" class="textbox" name="each_increase" datatype="n" errormsg="请填写！"/> 单位：元
                        </li>
                        <li>
                            <span class="item_name" style="width:120px;">延迟周期：</span>
                            <input type="number" class="textbox" name="delay_seconds" datatype="n" errormsg="请填写！"/> 单位：分
                        </li><li>
                            <span class="item_name" style="width:120px;">保留价：</span>
                            <input type="number" class="textbox" name="reserve_price" datatype="n" errormsg="请填写！"/> 单位：元
                        </li>
                        <li>
                            <span class="item_name" style="width:120px;">保证金：</span>
                            <input type="number" class="textbox" name="margin" datatype="n" errormsg="请填写！"/> 单位：元
                        </li>

                        <li class="time_handle">
                            <span class="item_name">开始时间：</span>
                            <input type="text" class="textbox" id="start_time" name="start_time" datatype="*" errormsg="请填写！"  placeholder="请输入开始销售时间..." />
                        </li>

                        <li class="time_handle">
                            <span class="item_name">结束时间：</span>
                            <input type="text" class="textbox" id="end_time" name="end_time"  datatype="*" errormsg="请填写！" placeholder="请输入结束销售时间..." />
                        </li>

                        <li style="overflow:hidden;">
                            <span class="item_name" style="width:120px; display:block; float:left">拍品分类：</span>
                            <div id="artwork_class_id" style="float:left;margin-top:-15px;">{!!$artwork_class_list!!}</div>
                        </li>

                        <li id="artist_list_id">
                            <span class="item_name" style="width:120px;">艺术家选择：</span>
                                {!!$artist_list!!}
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">是否上架展示：</span>
                            <label class="single_selection"><input type="radio" name="status"  checked='true' value='1'/>上架展示</label>
                            <label class="single_selection"><input type="radio" name="status" datatype="*" errormsg="请选择！" value='0'/>不上架</label>
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">拍品详细信息：</span>
                        </li>

                        <div style="margin:0px 5%;">
                            <script id="container" name="content" type="text/plain" style="width:100%;height:500px;"></script>
                        </div>

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
    <link href="{{asset('umeditor/themes/default/_css/umeditor.css')}}" type="text/css" rel="stylesheet">
    <script type="text/javascript" src="{{asset('umeditor/third-party/template.min.js')}}"></script>
    <script type="text/javascript" charset="utf-8" src="{{asset('umeditor/umeditor.config.js')}}"></script>
    <script type="text/javascript" charset="utf-8" src="{{asset('umeditor/editor_api.js')}}"></script>
    <script type="text/javascript" src="{{asset('umeditor/lang/zh-cn/zh-cn.js')}}"></script>

    <script src="{{asset('static/js/jquery.ajaxfileupload.js')}}"></script>
    <script src="{{asset('static/js/linkchecked.js')}}"></script>
    <script>
        //开启checkbox多选模式
        $.linkchecked('dep');
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

        $("#parent_1").change(function(){
            console.log(this.attr('class'))
            $('#'+this.attr('class')).checked();
        })

        //编辑器相关
        var um = UM.getEditor('container');

        $(function(){
            $('#start_time ,#end_time').datetimepicker({
                changeYear: true,
                regional:"zh-CN",
                dateFormat:"yy-mm-dd",
                timeFormat: "hh:mm:ss"
            });
        });

        $(function() {
            var demo = $("#data").Validform({
                tiptype: 3,
                ajaxPost: true,
                beforeSubmit: function () {
                    ajax_send();
                    return false;
                }
            });

            demo.addRule([
                {
                    ele:":checkbox",
                    datatype:"*",
                }]);


            function ajax_send() {
                $.ajax({
                    url: "{{URL::to('admin/artwork')}}",
                    type: "post",
                    data: $("#data").serialize() + "&_token={{csrf_token()}}",
                    dataType: "json",
                    beforeSend: function () {
                        $(".loading_area").fadeIn();
                    },
                    success: function (result) {
                        if (result.errorno == 20000) {
                            $(".loading_area").fadeOut(1500);
                            showAlert(result.msg, '{{URL::to('admin/artwork')}}', '{{URL::to('admin/artwork')}}');
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