<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>{{$title}}</title>
    <!-- Add this to <head> -->
    <link type="text/css" rel="stylesheet" href="{{asset('AppStatic/css')}}/bootstrap.min.css"/>
    <link type="text/css" rel="stylesheet" href="{{asset('AppStatic/css')}}/bootstrap-vue.css"/>
    <link type="text/css" rel="stylesheet" href="{{asset('AppStatic/css')}}/style.css"/>
    <!-- Add this after vue.js -->
    <script src="{{asset('AppStatic/js')}}/vue.js"></script>
    <script src="{{asset('AppStatic/js')}}/polyfill.min.js"></script>
    <script src="{{asset('AppStatic/js')}}/tether.min.js"></script>
    <script src="{{asset('AppStatic/js')}}/bootstrap-vue.js"></script>
</head>
<body>
<div id="app">

    <b-navbar toggleable >

        <b-nav-toggle target="nav_collapse"></b-nav-toggle>

        <b-link class="navbar-brand" to="#">
            <span>淡村书画院</span>
        </b-link>

        <b-collapse is-nav id="nav_collapse">

            <b-nav is-nav-bar>
                <b-nav-item :class="{active : nav==1 }" >艺术家</b-nav-item>
                <b-nav-item :class="{active : nav==2 }" >艺术品</b-nav-item>
                <b-nav-item :class="{active : nav==3 }" >关于淡村书画院</b-nav-item>
            </b-nav>

            <b-nav is-nav-bar class="ml-auto">

                <b-nav-item-dropdown right v-if="login_status">
                    <template slot="text">
                        <span style="font-weight: bold;">admin</span>
                    </template>
                    <b-dropdown-item to="#">我的</b-dropdown-item>
                    <b-dropdown-item to="#">登出</b-dropdown-item>
                </b-nav-item-dropdown>

                <template secondary v-if="!login_status">
                        <b-button  href="">登录</b-button>
                </template>

            </b-nav>
        </b-collapse>
    </b-navbar>
@yield('content')
</div>
</body>
@yield('footer')
</html>