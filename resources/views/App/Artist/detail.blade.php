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
    {!! $position !!}

    <template>
        <el-tabs v-model="active" type="border-card">

            <el-tab-pane label="艺术家信息" name="first">
                {{$base_info->name}}
                {{$base_info->nick}}
            </el-tab-pane>
            <el-tab-pane label="艺术家博客" name="second">
                {!! $base_info->blog !!}
            </el-tab-pane>
            <el-tab-pane label="艺术家作品" name="third">
                <ul>
                @foreach($art_info as $key=>$vo)
                    <li>
                        <a href="{{url('/')}}/Artwork/{{$vo->single_art_class}}/{{$vo->id}}">
                        <img src="{{asset('/')}}{{$vo->img_thumb}}"/>
                        <p>{{$vo->name}}</p>
                        </a>
                    </li>
                @endforeach
                </ul>
            </el-tab-pane>

        </el-tabs>
    </template>




@endsection
@section('footer')

    <script>

        var app = new Vue({
            el: '#app',
            data: function() {
                return {
                    activeIndex: '1',
                    login_name:'{{$user_name}}',
                    search:'',
                    select: '',
                    active: 'first'
                }
            }
        })
    </script>
@endsection