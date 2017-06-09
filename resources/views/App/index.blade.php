@extends('App.common')
@section('content')
    <template>
        <el-carousel  trigger="click"  :interval="8000" arrow="always">

            @foreach ($banner as $key=>$rs)
                <el-carousel-item>
                    <img src="{{asset('/')}}{{$rs->img}}"/>
                </el-carousel-item>
            @endforeach

        </el-carousel>
    </template>

    <div class="lc_content" >
        <el-row :gutter="25">
            <el-col :xs="24" :sm="8" :md="8" :lg="8">
                <p>视频 /</p>
                <el-row :gutter="20">

                    @foreach($art_work_list as $key=>$vo)
                    <el-col :xs="12" :sm="12" :md="12" :lg="12">
                        <img @click="OpenVideo('{{$vo->video}}')" class="lc_content_left_img" src="{{asset('/')}}{{$vo->img_thumb}}" alt="{{$vo->name}}"/>
                    </el-col>
                    @endforeach

                </el-row>
            </el-col>

            <el-col :xs="24" :sm="8" :md="8" :lg="8">
                <p>新闻 /</p>
                    <ul class="lc_news_ul">
                        @foreach($article as $key=>$vo)
                        <li><a href="{{url('/')}}/Article/{{$vo->article_class}}/{{$vo->id}}">{{str_limit($vo->title,20)}}</a><span>{{$vo->updated_at}}</span></li>
                        @endforeach
                    </ul>
            </el-col>

            <el-col :xs="24" :sm="8" :md="8" :lg="8">
                <p>结果 /</p>
                <ul class="lc_result_ul">
                    <li><a href="#">asdfasdfasdf</a><span>10000</span></li>
                    <li><a href="#">asdfasdfasdf</a><span>88000</span></li>
                </ul>
            </el-col>
        </el-row>

    </div>
    <div class="lc_friendlink">
        @foreach ($friend_link as $key=>$rs)
            <a href="{{$rs->link_url}}" target="_blank">
                <img src="{{asset('/')}}{{$rs->link_img}}" alt="{{$rs->link_name}}"/>
            </a>
        @endforeach
    </div>
    <div class="lc_video" v-show="playVideo" v-cloak>
        <div class="lc_video_center" :style="[{left: video_left + 'px'},{top: video_top + 'px'}]">
            <el-button class="lc_video_close" icon="close" @click="VideoClose"></el-button>
            <video
                    id="my-player"
                    class="video-js vjs-default-skin vjs-big-play-centered"
                    width="960" height="400"
                    controls preload="auto"
            >
                <source src="" type="video/mp4">
                {{--<source src="" type='video/webm'>--}}
                <p class="vjs-no-js">
                    To view this video please enable JavaScript, and consider upgrading to a
                    web browser that
                    <a href="http://videojs.com/html5-video-support/" target="_blank">
                        supports HTML5 video
                    </a>
                </p>
            </video>
        </div>
    </div>

@endsection
@section('footer')

    <script>

        var app = new Vue({
            el: '#app',
            data: function() {
                return {
                    activeIndex: '1',
                    login_name:'{{$user_name}}',
                    playVideo:0,
                    select: '',
                    search:'',
                    videojs:0,
                    video_left:0,
                    video_top:0,
                    video_url:'',
                }
            },
            methods:{
                VideoClose :function(){
                    this.playVideo=0;
                    this.videojs.pause();
                },
                OpenVideo:function(url){
                    this.playVideo=1;
                    this.video_url=url;
                }
            }
        })

        app.$watch('playVideo', function () {
            if(app.playVideo){
                app.videojs = videojs('my-player',{});
                app.videojs.play();
            var video = document.getElementById('my-player');
            var v_width = video.clientWidth;
            var v_height = video.clientHeight;
            app.video_left = (window.innerWidth - v_width)/2;
            app.video_top = (window.innerHeight - v_height)/2;
            }
        });

        app.$watch('video_url',function(){
            var video = document.getElementById('my-player_html5_api');
            video.src= app.video_url;
            app.videojs.play();
        });

    </script>
@endsection