<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>{{$title}}</title>

    <!-- 引入样式 -->
    <link rel="stylesheet" href="{{asset('AppStatic/css')}}/index.css">

    <link type="text/css" rel="stylesheet" href="{{asset('AppStatic/css')}}/add.css"/>
    {{--<!-- Add this after vue.js -->--}}
    <script src="{{asset('AppStatic/js')}}/vue.js"></script>
    <!-- 引入组件库 -->
    <script src="{{asset('AppStatic/js')}}/index.js"></script>

</head>
<body>
<div id="app">
    <div class="padding5">
    <el-dropdown v-if="islogin" v-cloak>
      <span class="el-dropdown-link">
        您好：admin<i class="el-icon-caret-bottom el-icon--right"></i>
      </span>
        <el-dropdown-menu slot="dropdown">
            <el-dropdown-item >个人中心</el-dropdown-item>
            <el-dropdown-item >登出</el-dropdown-item>
        </el-dropdown-menu>
    </el-dropdown>

    <el-button v-else icon="setting" v-cloak>登录/注册</el-button>

    <el-button  icon="information" style="float:right" v-cloak>帮助中心</el-button>
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

        <el-menu-item-group  class="leftnavul">
            <div class="leftnavtitle"><a href="#">分组1</a></div>
            <div class="leftnavitem"><a href="#">导航一</a><a href="#">导航一</a><a href="#">导航一</a><a href="#">导航一</a><a href="#">导航一</a></div>
        </el-menu-item-group>

        <el-menu-item-group class="leftnavul">
            <div class="leftnavtitle"><a href="#">分组2</a></div>
            <div class="leftnavitem"><a href="#">导航二</a><a href="#">导航二</a><a href="#">导航二</a><a href="#">导航二</a><a href="#">导航二</a></div>
        </el-menu-item-group>

    </el-submenu>

    <el-menu-item index="3"><a href="https://www.ele.me" target="_blank">在线拍卖</a></el-menu-item>
    <el-menu-item index="3"><a href="https://www.ele.me" target="_blank">艺术品</a></el-menu-item>


    </el-menu>



@yield('content')
</div>
</body>
@yield('footer')
</html>