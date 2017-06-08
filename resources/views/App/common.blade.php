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
<div id="app" v-cloak>


    <div class="padding5">
    <el-dropdown v-if="login_name!=''" v-cloak>
      <span class="el-dropdown-link">
        您好：@{{login_name}}<i class="el-icon-caret-bottom el-icon--right"></i>
      </span>
        <el-dropdown-menu slot="dropdown">
            <el-dropdown-item >个人中心</el-dropdown-item>
            <el-dropdown-item onclick="jump('Passport/loginOut')">登出</el-dropdown-item>
        </el-dropdown-menu>
    </el-dropdown>

    <el-button v-else icon="setting" onclick="jump('Passport')" v-cloak>登录/注册</el-button>

    <el-button  icon="information" style="float:right" onclick="jump('Helper')" v-cloak>帮助中心</el-button>
    </div>
    <hr />

    <div class="search">
        <div class="logo"><img src="{{asset('AppStatic/images')}}/logo.png"/></div>
        <div class="search_input">
            <el-input placeholder="请输入内容" v-model="search">
                <el-select v-model="select" slot="prepend" placeholder="请选择">
                    <el-option label="艺术家" value="1"></el-option>
                    <el-option label="艺术品" value="2"></el-option>
                </el-select>
                <el-button slot="append" icon="search"></el-button>
            </el-input>
        </div>
    </div>
    <hr />

    <el-menu :default-active="activeIndex" class="el-menu-demo" mode="horizontal" v-cloak>

    <el-submenu index="1">
        <template slot="title">拍品分类</template>

        @foreach ($artwork_nav as $key=>$rs)
        <el-menu-item-group  class="leftnavul">
            <div class="leftnavtitle"><a href="#">{{$rs->class_name}}</a></div>
            @if(isset($rs->son))
            <div class="leftnavitem">
                @foreach ($rs->son as $key2=>$rs2)
                <a href="#">{{$rs2->class_name}}</a>
                @endforeach
            </div>
            @endif
        </el-menu-item-group>
        @endforeach

    </el-submenu>

    <el-menu-item index="3"><a href="https://www.ele.me" target="_blank">在线拍卖</a></el-menu-item>
    <el-menu-item index="3"><a href="https://www.ele.me" target="_blank">艺术品</a></el-menu-item>


    </el-menu>

@yield('content')
    <div class="lc_footer">
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
<!--video-->
<link href="{{asset('AppStatic/css')}}/video-js.min.css" rel="stylesheet">
<script src="{{asset('AppStatic/js')}}/video.min.js"></script>
<script src="{{asset('AppStatic/js')}}/add.js"></script>
@yield('footer')
<script>
    function jump(url){
        window.location.href="{{asset('/')}}"+url+'?redirect='+window.location.href;
    }
</script>
</html>