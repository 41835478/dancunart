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
    <h1>{{$data->page_name}}</h1>
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