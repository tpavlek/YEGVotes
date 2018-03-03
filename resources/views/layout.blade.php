@extends('root')

@section('body')


<header>
    <nav class="bg-black flex">
            <a href="{{ URL::to('/') }}" class="no-underline text-grey-light text-xl font-bold hover:bg-grey-darkest p-4">YEGVotes</a>
            <span class="flex-grow"></span>
        <!--
            <a href="{{ URL::route('meetings.list') }}" class="no-underline text-grey-light hover:bg-grey-darkest p-4">Meetings</a>
            <a href="{{ URL::route('about') }}" class="no-underline text-grey-light hover:bg-grey-darkest p-4">About</a>
            <a href="{{ URL::route('stats') }}" class="no-underline text-grey-light hover:bg-grey-darkest p-4">Stats</a>
            <a href="https://basketofyegs.com" class="no-underline text-grey-light hover:bg-grey-darkest p-4 mr-8">Podcast</a>
            -->
            @yield('additional_nav', '')
    </nav>
</header>
<div class="body-wrapper">
    @yield('content')
</div>
<footer class="p-8 bg-black text-grey-light">
    &copy; <a class="text-grey-light no-underline font-bold" href="http://tpavlek.me">Troy Pavlek</a> {{ \Carbon\Carbon::now()->year }}.
    Data provided by <a class="text-grey-light no-underline font-bold" href="https://data.edmonton.ca">Edmonton Open Data Catalogue</a>
</footer>


@stop

@section('root_scripts')
    @include('javascript')
    @yield('scripts', "")
    <div id="fb-root"></div>
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '1103500426336483',
                xfbml      : true,
                version    : 'v2.5'
            });
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-69189501-1', 'auto');
        ga('send', 'pageview');

    </script>
@stop
