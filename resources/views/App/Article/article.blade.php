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
    <h1>{{$data->title}}</h1>
    <p>浏览次数：{{$data->view_count}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;发布时间：{{$data->updated_at}}</p>
    {!! $data->content !!}

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
                }
            }
        })
    </script>
@endsection