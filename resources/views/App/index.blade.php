@extends('App.common')
@section('content')

    <b-carousel controls indicators :interval="3000"  height="300px" class="lc_banner">

        <!-- Text slides -->
        <b-carousel-slide height="300px" background="gray" img="{{asset('AppStatic/images')}}/banner.jpg">
        </b-carousel-slide>

        <!-- Slides with custom text -->
        <b-carousel-slide height="300px" background="red" img="{{asset('AppStatic/images')}}/banner.jpg">
            Hello world
        </b-carousel-slide>

        <!-- Slides with image -->
        <b-carousel-slide height="300px" background="green" img="{{asset('AppStatic/images')}}/banner.jpg">
        </b-carousel-slide>

    </b-carousel>

@endsection
@section('footer')
    <script>
        window.app = new Vue({
            el: '#app',
            data:{
                nav: 1,
                login_status:1,
            },
        })
    </script>
@endsection