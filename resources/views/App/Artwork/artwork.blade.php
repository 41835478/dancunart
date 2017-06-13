@extends('App.common')
@section('content')
    <link type="text/css" rel="stylesheet" href="{{asset('AppStatic/css')}}/mzp-packed.css"/>
    <template>
        <el-carousel  trigger="click"  :interval="8000" arrow="always">

            @foreach ($banner as $key=>$rs)
                <el-carousel-item>
                    <img src="{{asset('/')}}{{$rs->img}}"/>
                </el-carousel-item>
            @endforeach

        </el-carousel>
    </template>
    {!! $position !!}
    <h1>{{$data->name}}</h1>
    <p>发布时间：{{$data->updated_at}}</p>
    <p>视频<br/>
        <img @click="OpenVideo('{{$data->video}}')" class="lc_content_left_img" src="{{asset('/')}}{{$data->img_thumb}}" alt="{{$data->name}}"/>
    </p>


    <a href="{{asset('/')}}{{$data->img}}" id="zoom1" class="MagicZoom MagicThumb">
        <img src="{{asset('/')}}{{$data->img_thumb}}" id="main_img" class="main_img" style="max-width:200px;" />
    </a>


    {!! $data->content !!}

    <div>
        <ul>
            <li></li>
        </ul>
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

    <script src="{{asset('AppStatic/js')}}/mzp-packed.js"></script>
    <script>

        var app = new Vue({
            el: '#app',
            data: function() {
                return {
                    activeIndex: '1',
                    login_name:'{{$user_name}}',
                    search:'',
                    select: '',
                    playVideo:0,
                    videojs:0,
                    video_left:0,
                    video_top:0,
                    video_url:'',
                    auction_list:'',
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
            },
            mounted:function(){
                setInterval(function(){
                    axios.post('{{url('/Auction')}}',{
                        id     : '{{$data->id}}',
                        _token : '{{csrf_token()}}'
                    }).then(function(result) {
                        console.log(result);
                    })
                },3000);
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