@extends('Admin.app')
@section('content')
    <section class="rt_wrap content mCustomScrollbar">
        <div class="rt_content">
            <h1>{{$title}}</h1>

            <section>
                <form id="data">

                    <ul class="ulColumn2">
                        <li>
                            <span class="item_name" style="width:120px;">用户账号：</span>
                            <input type="text" class="textbox textbox_295" name="account" datatype="s5-16" errormsg="昵称至少5个字符,最多16个字符！"/>
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">用户密码：</span>
                            <input type="text" class="textbox" name="pwd" />
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">用户昵称：</span>
                            <input type="text" class="textbox" name="nick" />
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">用户邮箱：</span>
                            <input type="text" class="textbox textbox_295" name="email" />
                        </li>

                        <li>
                            <span class="item_name" style="width:120px;">用户手机：</span>
                            <input type="text" class="textbox textbox_295" name="mob" />
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
    <script type="text/javascript" src="http://validform.rjboy.cn/wp-content/themes/validform/js/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="http://validform.rjboy.cn/Validform/v5.1/Validform_v5.1_min.js"></script>
    <script>
        $(function(){
            //$(".registerform").Validform();  //就这一行代码！;

            var demo=$("#data").Validform({
                tiptype:3,
                label:".label",
                showAllError:true,
                datatype:{
                    "zh1-6":/^[\u4E00-\u9FA5\uf900-\ufa2d]{1,6}$/
                },
                ajaxPost:true
            });

            //通过$.Tipmsg扩展默认提示信息;
            //$.Tipmsg.w["zh1-6"]="请输入1到6个中文字符！";
//            demo.tipmsg.w["zh1-6"]="请输入1到6个中文字符！";

            demo.addRule([{
                ele:".inputxt:eq(0)",
                datatype:"zh2-4"
            },
                {
                    ele:".inputxt:eq(1)",
                    datatype:"*6-20"
                },
                {
                    ele:".inputxt:eq(2)",
                    datatype:"*6-20",
                    recheck:"userpassword"
                },
                {
                    ele:"select",
                    datatype:"*"
                },
                {
                    ele:":radio:first",
                    datatype:"*"
                },
                {
                    ele:":checkbox:first",
                    datatype:"*"
                }]);

        })

        $("#link_btn").click(function(){
            var name = $("input[name = 'class_name']").val();

            if(name=='')  showAlert('请填写分类名称','','');
            else{
                $.ajax({
                    url  : "{{URL::to('admin/artistclass')}}",
                    type : "post",
                    data : $("#data").serialize()+"&_token={{csrf_token()}}",
                    dataType: "json",
                    beforeSend:function(){
                        $(".loading_area").fadeIn();
                    },
                    success:function(result){
                        if(result.errorno==20000){
                            $(".loading_area").fadeOut(1500);
                            showAlert(result.msg,'{{URL::to('admin/artistclass')}}','{{URL::to('admin/artistclass')}}');
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