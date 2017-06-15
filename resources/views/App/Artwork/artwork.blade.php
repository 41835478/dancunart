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

    <p v-if="!isNaN(show_time) && show_time>0">
        距结束：@{{show_time | moment_hms}}
    </p>
    <p v-else-if="!isNaN(show_time) && show_time<0">
        距开始：@{{show_time | moment_hms}}
    </p>
    <p v-else>
        @{{show_time}}
    </p>

    <a href="{{asset('/')}}{{$data->img}}" id="zoom1" class="MagicZoom MagicThumb">
        <img src="{{asset('/')}}{{$data->img_thumb}}" id="main_img" class="main_img" style="max-width:200px;" />
    </a>

    {!! $data->content !!}

    <div>
        <ul>
            <li v-for="list in auction_list">
               <span v-if="list.status=='true'">领先</span>
               <span v-else>出局</span>
                ￥@{{(list.old_price + list.price_increase)/100}}
                &nbsp;
                &nbsp;
                @{{list.nick}}
                &nbsp;
                &nbsp;
                @{{list.created_at}}
            </li>
        </ul>
    </div>


    <p v-if="auction_status==1">
        @if($data->margin > $user_cash)
            <button @click="pay">缴纳保证金</button>
        @else
            <button>参拍</button>
        @endif
    </p>


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

    @if($user_name!='')
    <el-dialog title="交纳保证金" :visible.sync="dialogVisible" size="small">
        （保证金可用余额仅可用作交纳保证金，不可用来支付货款。）
        <hr/>

        <el-form :model="payForm" ref="payForm" :rules="rules" label-width="120px">

            <el-form-item label="参拍保证金">
                ￥{{$data->margin/100}}
            </el-form-item>

            <el-form-item label="保证金余额">
                ￥{{$user_cash/100}}
            </el-form-item>

            <el-form-item label="缴纳金额" prop="pay_money">
                <el-input style="width:150px;" v-model="payForm.pay_money" auto-complete="off"></el-input><br />
                保证金可用余额￥{{$user_cash/100}}，至少再交纳￥{{$data->margin/100 - $user_cash/100}}即可参拍。
            </el-form-item>

            <el-form-item label="" prop="agreement">
                <el-checkbox-group v-model="payForm.agreement">
                    <el-checkbox v-model="checked" >我已阅读并同意《<a href="http://www.baidu.com" target="_blank">淡村艺术网用户须知</a>》</el-checkbox>

                </el-checkbox-group>
            </el-form-item>

            <div class="lc_pay_footer">
                <el-button @click="dialogVisible = false">取 消</el-button>
                <el-button type="primary" @click="pay_submit" :disabled="reg_status">确 定</el-button>
            </div>

        </el-form>

    </el-dialog>
    @endif

@endsection
@section('footer')
    <!-- 图片放大插件 -->
    <script src="{{asset('AppStatic/js')}}/mzp-packed.js"></script>
    <!-- 图片放大插件 -->
    <script src="{{asset('AppStatic/js')}}/moment.min.js"></script>
    <script>
        function Appendzero(obj)
        {
            if(obj<10) return "0" +""+ obj;
            else return obj;
        }

        //moment 过滤器
        Vue.filter('moment', function (value) {
            return moment(value*1000).format('YYYY-MM-DD HH:mm:ss');
        });
        Vue.filter('moment_hms', function (value) {
            value = Math.abs(value);
            var h=Math.floor(value/3600);
            var m=Math.floor((value-h*3600)/60);
            var s=value-h*3600-m*60;
            return Appendzero(h)+'时 '+Appendzero(m)+'分 '+Appendzero(s)+'秒';
        });

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
                    start_time:'{{$data->start_time}}',
                    end_time:'{{$data->end_time}}',
                    show_time:'',
                    auction_status:0,<!--默认0 拍卖未开始，1拍卖中，2拍卖完毕，3已关闭-->
                    dialogVisible:false,
                    reg_status:false,
                    payForm:{
                        pay_money:'',
                        agreement:[],
                    },
                    checked:false,
                    rules: {
                        pay_money: [
                            {required: true, message: '请输入支付金额', trigger: 'change'},
                            {pattern: /^(\d)*[.]?(\d)*$/, message: '不是正确的数字'}
                        ],
                        agreement:[
                            { type: 'array', required: true, message: '请阅读并同意协议须知', trigger: 'change' }
                        ]
                    }
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
                },
                pay:function(){
                    if('{{$user_name}}'=='')
                        window.location.href="{{asset('/')}}"+'Passport?redirect='+window.location.href;
                    else
                        this.dialogVisible=true;
                },
                pay_submit:function(){
                    this.$refs['payForm'].validate(function(valid) {
                        if (valid) {
                            alert('掉起支付界面');
                        }
                    })
                }
            },
            mounted:function(){
                setInterval(function(){
                    axios.post('{{url('/Auction')}}',{
                        id     : '{{$data->id}}',
                        _token : '{{csrf_token()}}'
                    }).then(function(result) {
                       app.auction_list=result.data;
                    })
                },5000);

                var timer = setInterval(function(){
                    var start_time = moment(app.start_time).format('X');
                    var end_time = moment(app.end_time).format('X');
                    var now_time = moment().format('X');

                    if(now_time < start_time) {
                        app.show_time = now_time - start_time;
                    }
                    else if( now_time < end_time ){
                        app.auction_status=1;
                        app.show_time = end_time - now_time;
                    }
                    else{
                       app.auction_status=2;
                       app.show_time='拍卖结束';
                       clearInterval(timer);
                    }
                },1000);

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