@extends('Admin.app')
@section('content')
    <section class="rt_wrap content mCustomScrollbar">
        <div class="rt_content">
            <h1>{{$title}}</h1>

            <section>
<form class="registerform" action="ajax_post.php">
    <ul class="ulColumn2">

        <li>
            <span class="item_name label" style="width:120px;">用户账号：</span>
            <input type="text" class="textbox textbox_295 inputxt" name="account" datatype="s4-16" nullmsg="请设置账号！" errormsg="账号至少4个字符,最多16个字符！"/>
        </li>

        <li>
            <span class="item_name label" style="width:120px;">用户密码：</span>
            <input type="text" class="textbox inputxt" name="pwd" datatype="*6-16" nullmsg="请设置密码！" errormsg="密码范围在6~16位之间！"/>
        </li>

        <li>
            <span class="item_name label" style="width:120px;">用户昵称：</span>
            <input type="text" class="textbox inputxt" name="nick" datatype="s" nullmsg="请设置昵称！" errormsg="昵称至少4个字符,最多16个字符！"/>
        </li>

        <li>
            <span class="item_name label" style="width:120px;">用户邮箱：</span>
            <input type="text" class="textbox textbox_295 inputxt" name="email" datatype="e" nullmsg="请设置邮箱！" errormsg="邮箱验证失败"/>
        </li>

        <li>
            <span class="item_name label" style="width:120px;">用户手机：</span>
            <input type="text" class="textbox textbox_295 inputxt" name="mob" datatype="m" nullmsg="请设置手机！" errormsg="手机验证失败"/>
        </li>

    </ul>
    <div class="action">
        <input type="submit" value="提 交" /> <input type="reset" value="重 置" />
    </div>
</form>

</section>

</div>
</section>
@endsection
@section('footer')

<script type="text/javascript">
    $(function(){
//        $(".registerform").Validform();  //就这一行代码！;

        $(".registerform").Validform({
            tiptype:3,
            showAllError:true,
            ajaxPost:true
        });
//
//        //通过$.Tipmsg扩展默认提示信息;
//        //$.Tipmsg.w["zh1-6"]="请输入1到6个中文字符！";
//        demo.tipmsg.w["zh1-6"]="请输入1到6个中文字符！";
////
////        demo.addRule([{
////            ele:".inputxt:eq(0)",
////            datatype:"zh2-4"
////        },
////            {
////                ele:".inputxt:eq(1)",
////                datatype:"*6-20"
////            },
////            {
////                ele:".inputxt:eq(2)",
////                datatype:"*6-20",
////                recheck:"userpassword"
////            },
////            {
////                ele:"select",
////                datatype:"*"
////            },
////            {
////                ele:":radio:first",
////                datatype:"*"
////            },
////            {
////                ele:":checkbox:first",
////                datatype:"*"
////            }]);
//
    })
</script>


</body>
</html>
@endsection