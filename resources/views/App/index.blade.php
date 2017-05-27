@extends('App.common')
@section('content')
    <template>
        <el-carousel :interval="5000" arrow="always">
            <el-carousel-item>
                <img src="{{asset('AppStatic/images')}}/banner.jpg"/>
            </el-carousel-item>
            <el-carousel-item>
                <img src="{{asset('AppStatic/images')}}/banner.jpg"/>
            </el-carousel-item>
            <el-carousel-item>
                <img src="{{asset('AppStatic/images')}}/banner.jpg"/>
            </el-carousel-item>
        </el-carousel>
    </template>

    <template>
        <div class="block" style="width:400px;">
            <el-carousel trigger="click" height="150px;">
                <el-carousel-item v-for="item in 4" :key="item">
                    <h3>@{{ item }}</h3>
                </el-carousel-item>
            </el-carousel>
        </div>
    </template>
    </template>

@endsection
@section('footer')
    <script>
        var app = new Vue({
            el: '#app',
            data: function() {
                return {
                    activeIndex: '1',
                    islogin:0,
                    select: '',
                    search:''
                }
            }
        })
    </script>
@endsection