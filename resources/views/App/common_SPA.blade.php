<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>{{$site->title}}</title>
    <meta name="keywords" content="{{$site->keywords}}"/>
    <meta name="description" content="{{$site->description}}"/>

    <link rel="stylesheet" href="{{asset('AppStatic/css')}}/index.css">
    <link type="text/css" rel="stylesheet" href="{{asset('AppStatic/css')}}/add.css"/>


    <script src="{{asset('AppStatic/js')}}/vue.js"></script>
    <script src="{{asset('AppStatic/js')}}/index.js"></script>

    <!--[if lt IE 9]>
    <div class="topframe">你的浏览器 <strong>太旧了</strong> ,请升级获得更好的体验
        <a target="_blank" class="alert-link" href="http://browsehappy.com">立即升级</a>
    </div>
    <![endif]-->
</head>
<body>
<div id="app_SPA" v-cloak>

    @yield('content')
    <div class="lc_footer lc_footer_SPA">
        <el-row :gutter="10"  class="lc_footer_nav">

            @foreach ($footer_nav as $key=>$rs)
                <el-col :xs="24" :sm="4" :md="4" :lg="4">
                    {{$rs->page_name}}
                    @if(isset($rs->son))
                        <ul>
                            @foreach ($rs->son as $key2=>$rs2)
                                <li><a href="#">{{$rs2->page_name}}</a></li>
                            @endforeach
                        </ul>
                    @endif
                </el-col>
            @endforeach

        </el-row>

        <div class="lc_footer_copyright">
            {!! $site->copyright !!}
        </div>
    </div>
</div>
</body>
<script src="{{asset('AppStatic/js')}}/axios.min.js"></script>
<script src="{{asset('AppStatic/js')}}/add.js"></script>
@yield('footer')
<script>
    function jump(url){
        window.location.href="{{asset('/')}}"+url;
    }
</script>
</html>