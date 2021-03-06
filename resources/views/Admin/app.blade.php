<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>{{config('app.title')}}</title>
    <meta name="author" content="Charis"/>
    <link rel="stylesheet" type="text/css" href="{{asset('static/css/style.css')}}"/>
    <!--[if lt IE 9]>
    <script src="js/html5.js"></script>
    <![endif]-->

</head>

<body>
<!--header-->
<header>
    <h1><img src="{{asset('static/images/admin_logo.png')}}"/></h1>
    <ul class="rt_nav">
        <li><a href="javascript:;" onClick="cleanRedis()" class="errorTips">清除缓存</a></li>
        <li><a href="{{URL::to('admin')}}" class="website_icon">系统首页</a></li>
        <li><a href="{{URL::to('admin/auth')}}" class="set_icon">用户设置</a></li>
        <li><a href="{{URL::to('admin/loginOut')}}" class="quit_icon">安全退出</a></li>
    </ul>
</header>

<!--aside nav-->
<aside class="lt_aside_nav content mCustomScrollbar">
    <ul id="left_nav">
        <li>
            <dl>
                <dt>系统设置</dt>
                <dd><a href="{{URL::to('admin/siteConfig')}}" @if ($nav == '1-1') class="active" @endif >基础配置</a></dd>
                <dd><a href="{{URL::to('admin/siteFriendlink')}}" @if ($nav == '1-2') class="active" @endif >友情链接</a></dd>
                <dd><a href="{{URL::to('admin/singlePage')}}" @if ($nav == '1-3') class="active" @endif >单页配置</a></dd>
                <dd><a href="{{URL::to('admin/CSR')}}" @if ($nav == '1-4') class="active" @endif >客服配置</a></dd>
                <dd><a href="{{URL::to('admin/ExpressList')}}" @if ($nav == '1-5') class="active" @endif >快递公司配置</a></dd>
                <dd><a href="{{URL::to('admin/banner')}}" @if ($nav == '1-6') class="active" @endif >banner轮播配置</a></dd>
            </dl>
        </li>
        <li>
            <dl>
                <dt>艺术家管理</dt>
                <dd><a href="{{URL::to('admin/artist')}}" @if ($nav == '2-1') class="active" @endif >艺术家列表</a></dd>
                <dd><a href="{{URL::to('admin/artistclass')}}" @if ($nav == '2-2') class="active" @endif >艺术家分类</a></dd>
            </dl>
        </li>

        <li>
            <dl>
                <dt>拍品管理</dt>
                <dd><a href="{{URL::to('admin/artwork')}}" @if ($nav == '3-1') class="active" @endif >拍品列表</a></dd>
                <dd><a href="{{URL::to('admin/artworkclass')}}" @if ($nav == '3-2') class="active" @endif >拍品分类</a></dd>
            </dl>
        </li>

        <li>
            <dl>
                <dt>用户管理</dt>
                <dd><a href="{{URL::to('admin/user')}}" @if ($nav == '4-1') class="active" @endif >用户列表</a></dd>
            </dl>
        </li>

        <li>
            <dl>
                <dt>订单管理</dt>
                <dd><a href="{{URL::to('admin/order')}}" @if ($nav == '5-1') class="active" @endif >订单列表</a></dd>
                <dd><a href="{{URL::to('admin/orderExpress')}}" @if ($nav == '5-2') class="active" @endif >发货单列表</a></dd>
                <dd><a href="{{URL::to('admin/orderAuction')}}" @if ($nav == '5-3') class="active" @endif >参拍记录</a></dd>
            </dl>
        </li>

        <li>
            <dl>
                <dt>提现管理</dt>
                <dd><a href="{{URL::to('admin/orderWithdraw')}}" @if ($nav == '6-1') class="active" @endif >提现申请</a></dd>
            </dl>
        </li>

        <li>
            <dl>
                <dt>管理员操作日志</dt>
                <dd><a href="{{URL::to('admin/user/Log')}}" @if ($nav == '7-1') class="active" @endif >敏感操作日志</a></dd>
            </dl>
        </li>

        <li>
            <dl>
                <dt>文章管理</dt>
                <dd><a href="{{URL::to('admin/article')}}" @if ($nav == '8-1') class="active" @endif >文章列表</a></dd>
                <dd><a href="{{URL::to('admin/articleClass')}}" @if ($nav == '8-2') class="active" @endif >文章分类</a></dd>
            </dl>
        </li>


    </ul>

</aside>
<p class="fix_btm_infor">{{config('app.title')}} | {{config('app.copyright')}} | {{config('app.versionCMS')}}</p>
<!--全屏遮罩-->
<section class="loading_area">
    <div class="loading_cont">
        <div class="loading_icon"><i></i><i></i><i></i><i></i><i></i></div>
        <div class="loading_txt">
            <mark>数据正在加载，请稍后！</mark>
        </div>
    </div>
</section>
<!--全屏遮罩-->

<!--弹出提示框-->
<section class="pop_bg">
    <div class="pop_cont">
        <!--title-->
        <h3>{{config('app.title')}}</h3>
        <!--以pop_cont_text分界-->
        <div class="pop_cont_text" id="pop_cont_text"></div>
        <!--bottom:operate->button-->
        <div class="btm_btn">
            <input type="button" value="确认" class="input_btn trueBtn"/>
            <input type="button" value="取消" class="input_btn falseBtn"/>
        </div>
    </div>
</section>

@yield('content')

<script src="{{asset('static/js/jquery.js')}}"></script>
<script src="{{asset('static/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<script src="{{asset('static/js/admin.js')}}"></script>

<link rel="stylesheet" type="text/css" href="{{asset('static/timepicker/css/jquery-ui.css')}}" />
<script src="{{asset('static/timepicker/js/jquery-ui.js')}}"></script>
<script src="{{asset('static/timepicker/js/jquery-ui-slide.min.js')}}"></script>
<script src="{{asset('static/timepicker/js/jquery-ui-timepicker-addon.js')}}"></script>
<script src="{{asset('static/js/validform.5.3.2.min.js')}}"></script>
<script>
    function cleanRedis(){
        $.ajax({
            url: "{{URL::to('admin/cleanRedis')}}",
            type: "get",
            data: "_token={{csrf_token()}}",
            dataType: "json",
            beforeSend: function () {
                $(".loading_area").fadeIn();
            },
            success: function (result) {
                $(".loading_area").fadeOut(1500);
                showAlert(result.msg, '', '');
            }
        })
    }
</script>
@yield('footer')