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
        <li><a href="{{URL::to('admin')}}" class="website_icon">系统首页</a></li>
        {{--<li><a href="#" class="admin_icon">DeathGhost</a></li>--}}
        <li><a href="{{URL::to('admin/auth')}}" class="set_icon">用户设置</a></li>
        <li><a href="{{URL::to('admin/loginOut')}}" class="quit_icon">安全退出</a></li>
    </ul>
</header>

<!--aside nav-->
<aside class="lt_aside_nav content mCustomScrollbar">
    <ul id="left_nav">
        <li>
            <dl>
                <dt onClick="window.location.href='{{URL::to('admin/conf')}}'">系统设置</dt>
                <dd><a href="{{URL::to('admin/conf')}}" @if ($nav == '1-1') class="active" @endif >活动配置</a></dd>
                <dd><a href="{{URL::to('admin/conf')}}" @if ($nav == '1-2') class="active" @endif >合作单位</a></dd>
                <dd><a href="{{URL::to('admin/conf')}}" @if ($nav == '1-3') class="active" @endif >排行榜</a></dd>
                <dd><a href="{{URL::to('admin/conf')}}" @if ($nav == '1-4') class="active" @endif >客服配置</a></dd>
                {{--<dd><a href="{{URL::to('Roll/config')}}" @if ($nav == '1-2') class="active" @endif >普通奖品池</a></dd>--}}
                {{--<dd><a href="{{URL::to('Roll/dajiang')}}"  @if ($nav == '1-3') class="active" @endif >行列大奖</a></dd>--}}
                {{--<dd><a href="{{URL::to('Roll/log')}}" @if ($nav == '1-4') class="active" @endif >日志列表</a></dd>--}}
                {{--<dd><a href="{{URL::to('Roll/prizelog')}}" @if ($nav == '1-5') class="active" @endif >获奖日志</a></dd>--}}
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
                <dd><a href="{{URL::to('admin/userlog')}}" @if ($nav == '4-2') class="active" @endif >用户修改操作日志</a></dd>
            </dl>
        </li>

        <li>
            <dl>
                <dt>订单管理</dt>
                <dd><a href="{{URL::to('admin/artwork')}}" @if ($nav == '5-1') class="active" @endif >拍品行为</a></dd>
                <dd><a href="{{URL::to('admin/artwork')}}" @if ($nav == '5-1') class="active" @endif >充值记录</a></dd>
                <dd><a href="{{URL::to('admin/artwork')}}" @if ($nav == '5-1') class="active" @endif >起拍记录</a></dd>
            </dl>
        </li>

        <li>
            <dl>
                <dt>退款管理</dt>
                <dd><a href="{{URL::to('admin/artwork')}}" @if ($nav == '6-1') class="active" @endif >退款列表</a></dd>
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

@yield('footer')